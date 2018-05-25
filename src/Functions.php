<?php

/** * @SuppressWarnings(PHPMD) */
function die_exit($msg)
{
    file_put_contents('php://stderr', $msg . PHP_EOL);
}

/* ---------------------------------------------------------------------- [E] */

function echo_as_its_archive($link='')
{
    $link = (string) $link;
    $str  = ' issue をアーカイブ';

    if(! empty($link)){
        $str = "[{$str}]({$link_file_list})";
    }

    return "これは ${name_repo_issue} リポジトリの{$str}したものです。" . PHP_EOL;
}

/* ---------------------------------------------------------------------- [F] */

function fetch_endpoint_issues($option)
{
    $name_repo_owner = fetch_value($option, 'name_repo_owner', 'NAME_OWNER');
    $name_repo       = fetch_value($option, 'name_repo', 'NAME_REPO');
    $url  = "https://api.github.com/repos/";
    $url .= $name_repo_owner . '/' . $name_repo . '/';
    $url .= 'issues';

    return $url;
}

function fetch_option($name_file_option = 'option_settings.json')
{
    $name_file_option = basename($name_file_option);
    $path_dir_curr    = dirname(__FILE__);
    $path_file_option = $path_dir_curr . DIR_SEP . $name_file_option;

    if (file_exists($path_file_option)) {
        $option_json = file_get_contents($path_file_option);

        echo "- オプションを読み込みました。（{$name_file_option}）", PHP_EOL;

        return json_decode($option_json, JSON_OBJECT_AS_ARRAY);
    }

    $option_array = fetch_option_default();
    $option_json  = json_encode($option_array, JSON_PRETTY_PRINT);

    if (file_put_contents($path_file_option, $option_json)) {
        $msg  = '設定ファイルを作成しました。';
        $msg .= '必要事項を記入し再実行してください。' . PHP_EOL;
        $msg .= '保存先： ' . $path_file_option . PHP_EOL;
        die_exit($msg);
    }

    $msg  = '設定ファイルの作成ができません。';
    $msg .= 'フォルダのアクセス権を確認してください。' . PHP_EOL;
    die_exit($msg);
}

function fetch_option_default()
{
    $option = [
        'access_token'    => '',
        'name_repo_owner' => '',
        'name_repo'       => '',
    ];

    return $option;
}

function fetch_path_dir_issue($name_dir_issue = 'issues')
{
    $path_dir_curr  = dirname(__FILE__);
    $path_dir_issue = $path_dir_curr . DIR_SEP . $name_dir_issue;

    if (! file_exists($path_dir_issue)) {
        mkdir($path_dir_issue);
    }

    return $path_dir_issue;
}

function fetch_url_request($option)
{
    $page         = fetch_value($option, 'page', null);
    $state        = fetch_value($option, 'state', 'all');
    $sort         = fetch_value($option, 'sort', 'created');
    $direction    = fetch_value($option, 'direction', 'asc');
    $access_token = fetch_value($option, 'access_token');

    $query = [
         'page'         => $page,
         'state'        => $state,
         'sort'         => $sort,
         'direction'    => $direction,
         'access_token' => $access_token,
    ];

    if (empty($page)) {
        unset($query['page']);
    }

    if (empty($access_token)) {
        unset($query['access_token']);
    }

    $url  = fetch_endpoint_issues($option);
    $url .= '?' . http_build_query($query);

    return $url;
}

function fetch_value($array, $key, $default_value = '')
{
    $result = $default_value ?: false;

    if (is_array($array) && isset($array[$key]) && ! empty($array[$key])) {
        $result = $array[$key];
    }

    return $result;
}

function fetch_version_app(){
    return VER_APP;
}

function format_comment($comments)
{
    if (! count($comments) || ! is_array($comments)) {
        return '';
    }

    $result = '';

    foreach ($comments as $comment) {
        $timestamp    = strtotime($comment['created_at']);
        $date_created = date("Y/m/d H:i", $timestamp);
        $name_user    = $comment['user']['login'];
        $msg_comment  = $comment['body'];

        $result      .= PHP_EOL . '-----' . PHP_EOL;
        $result      .= PHP_EOL . "{$date_created} by {$name_user}" . PHP_EOL;
        $result      .= PHP_EOL . $msg_comment . PHP_EOL;
    }

    return $result;
}

function format_md($issue)
{
    $title   = fetch_value($issue, 'title');
    $body    = fetch_value($issue, 'body');
    $state   = fetch_value($issue, 'state');
    $url_repository = fetch_value($issue, 'repository_url');
    $timestamp      = strtotime($issue['created_at']);
    $date_created   = date("Y/m/d H:i", $timestamp);
    $name_user      = $issue['user']['login'];

    $result  = '';
    $result .= '# ' . $title . PHP_EOL;
    $result .= PHP_EOL;
    $result .= "- {$date_created} by {$name_user}" . PHP_EOL;
    $result .= "- State: {$state}" . PHP_EOL;
    $result .= "- Archive of {$url_repository}" . PHP_EOL;
    $result .= PHP_EOL . '## 本文' . PHP_EOL;
    $result .= PHP_EOL . $body . PHP_EOL;
    $result .= PHP_EOL . '-----' . PHP_EOL;
    $result .= PHP_EOL . '## コメント' . PHP_EOL;
    $result .= format_comment(fetch_value($issue, 'comments'));

    return $result;
}

/* ---------------------------------------------------------------------- [P] */

function parse_headers($headers)
{
    $result  = array();
    $headers = (array) $headers;

    foreach ($headers as $value) {
        $tmp = explode(':', $value, 2);

        if (isset($tmp[1])) {
            $key = trim($tmp[0]);
            if ('Link' === $key) {
                $tmp[1] = parse_header_link($tmp[1]);
            }
            $result[$key] = $tmp[1];
        } else {
            $result[] = $value;
            if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $value, $matches)) {
                $result['reponse_code'] = intval($matches[1]);
            }
        }
    }
    return $result;
}

function parse_header_link($link_header)
{
    /*
        Format of $link_header
            <https://〜>; rel="next",<https://〜>; rel="last"
    */
    $header = (string) $link_header;
    $links  = explode(',', $header);
    $result = array();

    foreach ($links as $link) {
        $tmp = explode(';', $link);
        $url = trim_url($tmp[0]);
        $rel = trim_rel($tmp[1]); // trim: rel="last" -> last

        $result[] = [
            'url' => $url,
            'rel' => $rel,
        ];
    }

    return $result;
}

/* ---------------------------------------------------------------------- [R] */

function request_api($option, &$response_header = array())
{
    $url_request  = fetch_value($option, 'url_request');
    $access_token = fetch_value($option, 'access_token');

    if(empty($access_token)){
        return array();
    }

    if ($url_request) {
        $request_api_v3 = 'Accept: application/vnd.github.v3+json';
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: Qithub-BOT',
                    "Authorization: token {$access_token}",
                    $request_api_v3,
                ],
            ],
        ]);
        if ($result = @file_get_contents($url_request, false, $context)) {
            $response_header = $http_response_header;
            sleep(1);

            return json_decode($result, JSON_OBJECT_AS_ARRAY);
        }
    }

    return array();
}

function request_api_issue($option)
{
    $response_header  = array();
    $result           = array();

    $option['url_request'] = fetch_url_request($option);

    echo 'Fetching issues list ';

    while (true) {
        echo '.';

        $responce = request_api($option, $http_response_header);

        if(empty($responce)){
            return array();
        }

        $result   = array_merge($result, $responce);

        $tmp         = parse_headers($http_response_header);
        $tmp['Link'] = fetch_value($tmp, 'Link', array());

        if (! count($tmp['Link'])) {
            echo PHP_EOL;
            echo 'There is NO next pages to read.', PHP_EOL;
            break;
        }

        foreach ($tmp['Link'] as $link) {
            $found_next = false;

            if ('next' === $link['rel']) {
                echo '.';
                $option['url_request'] = $link['url'];
                $found_next = true;
                break;
            }
        }

        if (! $found_next) {
            echo PHP_EOL;
            break;
        }
    }

    return $result;
}

/* ---------------------------------------------------------------------- [T] */

function trim_rel($string)
{
    return trim(str_replace(['rel=','"'], '', trim($string)));
}

function trim_url($string)
{
    return trim(str_replace(['<','>'], '', trim($string)));
}
