<?php
include('Functions.php');

const DIR_SEP = DIRECTORY_SEPARATOR;

// 設定読み込み
if (!($option = fetch_option())) {
    die;
}
// Issue 一覧取得
$issues = request_api_issue($option);
// 保存先のパス
$path_dir_issue_md   = fetch_path_dir_issue('issues');
$path_dir_issue_json = fetch_path_dir_issue('issues_json');
// 進捗表示用
$count_issues  = count($issues);
$count_current = 1;
$name_repo_issue = $option['name_repo'];
// 出力済み Issue の一覧のヘッダ
$name_file_list     = 'Issue list of ' . $name_repo_issue;
$string_list_issue  = '# ' . $name_file_list . PHP_EOL . PHP_EOL;
$string_list_issue .= "これは ${name_repo_issue} リポジトリの issue を";
$string_list_issue .= 'アーカイブしたものです。' . PHP_EOL;

// Issue 毎のファイル出力
foreach ($issues as $issue) {
    // Issue 一覧の情報取得
    $issue_title     = fetch_value($issue, 'title');
    $issue_number    = fetch_value($issue, 'number');
    $name_file_issue = "${name_repo_issue} Issue ${issue_number}";
    $link_file_issue = str_replace(' ', '-', $name_file_issue);
    $string_list_issue .= "- Issue ${issue_number}: [${issue_title}](${link_file_issue})";
    $string_list_issue .= PHP_EOL;

    // Issue 内のコメント取得
    if (fetch_value($issue, 'comments')) {
        $option['url_request'] = fetch_value($issue, 'comments_url');
        $issue['comments']     = request_api($option);
    }

    // 各 Issue の Markdown ファイル
    $path_file_md = $path_dir_issue_md . DIR_SEP . $name_file_issue . '.md';
    $issue_md     = format_md($issue);

    // 各 Issue の JSON ファイル
    $path_file_json = $path_dir_issue_json . DIR_SEP . $name_file_issue . '.json';
    $issue_json = json_encode($issue, JSON_PRETTY_PRINT);

    // Markdown/JSON ファイルの保存と Issue 一覧の追記
    if (file_put_contents($path_file_md, $issue_md)
        && file_put_contents($path_file_json, $issue_json)
    ) {
        echo $name_file_issue;
        echo ' ', $count_current, '/',  $count_issues, PHP_EOL;
    }

    // 進捗のカウント
    ++$count_current;
}

// Issue 一覧のファイル出力
$path_file_list = $path_dir_issue_md . DIR_SEP . $name_file_list . '.md';
if (! file_put_contents($path_file_list, $string_list_issue)) {
    echo 'Fail save file: ' . $path_file_list;
    die;
}

// 完了通知
echo 'Issue list exported.' . PHP_EOL;
echo 'Done.' . PHP_EOL;
