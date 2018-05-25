<?php
const DIR_SEP = DIRECTORY_SEPARATOR;
const VER_APP = 'v20180525.0959 beta';

include('Functions.php');

// 設定読み込み
if (!($option = fetch_option())) {
    die_exit('設定ファイル（option_settings.json）の読み込みに失敗しました。');
}

// Issue 一覧取得
$issues = request_api_issue($option);

// Issue 一覧の初期化
$list_issues_titles = '';

// 保存先のパス
$path_dir_issue_md   = fetch_path_dir_issue('issues');
$path_dir_issue_json = fetch_path_dir_issue('issues_json');

// 進捗表示用
$count_issues    = count($issues);
$count_current   = 1;
$name_repo_issue = $option['name_repo'];

// Issue 一覧のファイル名
$name_file_list = 'Issue list of ' . $name_repo_issue;
$link_file_list = str_replace(' ', '-', $name_file_list);

// アーカイブである旨の文言（各 Issue 用）
$string_its_archive = echo_as_its_archive($link_file_list);

// アーカイブである旨の文言（Issue 一覧用）
$string_archived_by = echo_as_its_archive();

// Issue 一覧内のヘッダ
$list_issues_header = '# ' . $name_repo_issue . ' リポジトリのアーカイブ'
                      . PHP_EOL . PHP_EOL
                      . $string_its_archive . PHP_EOL;

// Issue 一覧内のフッタ
$name_archiver      = 'Issue downloader as markdown';
$url_archiver       = 'https://github.com/KEINOS/Issue_downloader_as_markdown';
$list_issues_footer = PHP_EOL
                      . '-----' . PHP_EOL
                      . "このアーカイブは'[{$name_archiver}]({$url_archiver})'"
                      . '（' . VER_APP . '）'
                      . 'によって生成されました。' . PHP_EOL;


// ファイル出力
foreach ($issues as $issue) {
    // Issue 毎の記述内容取得
    $issue_title        = fetch_value($issue, 'title');
    $issue_number       = fetch_value($issue, 'number');

    // Issue 毎のファイル名
    $name_file_issue    = "{$name_repo_issue} Issue {$issue_number}";

    // 各 Issue へのリンク
    $link_file_issue     = str_replace(' ', '-', $name_file_issue);
    $list_issues_titles .= "- Issue {$issue_number}: [{$issue_title}]"
                           . "({$link_file_issue})"
                           . PHP_EOL;

    // Issue 毎のコメント取得
    if (fetch_value($issue, 'comments')) {
        $option['url_request'] = fetch_value($issue, 'comments_url');
        $issue['comments']     = request_api($option);
    }

    // 各 Issue の Markdown ファイル内容
    $path_file_md = $path_dir_issue_md . DIR_SEP . $name_file_issue . '.md';
    $issue_md     = $string_its_archive . PHP_EOL . format_md($issue);

    // 各 Issue の JSON ファイル内容
    $path_file_json = $path_dir_issue_json . DIR_SEP . $name_file_issue . '.json';
    $issue_json     = json_encode($issue, JSON_PRETTY_PRINT);

    // Markdown / JSON ファイルの保存
    $result_put_md   = file_put_contents($path_file_md, $issue_md);
    $result_put_json = file_put_contents($path_file_json, $issue_json);
    if ($result_put_md && $result_put_json) {
        echo $name_file_issue;
        echo ' ', $count_current, '/',  $count_issues, "\r";
    }

    // 進捗のカウント
    ++$count_current;
}

echo PHP_EOL;

// Issue 一覧のファイル出力
$path_file_list    = $path_dir_issue_md . DIR_SEP . $name_file_list . '.md';

$list_issues = $list_issues_header . $list_issues_titles . $list_issues_footer;

if (! file_put_contents($path_file_list, $list_issues)) {
    echo 'Fail save file: ' . $path_file_list;
    die;
}

// 完了通知
echo 'Issue list exported.' . PHP_EOL;
echo 'Done.' . PHP_EOL;
