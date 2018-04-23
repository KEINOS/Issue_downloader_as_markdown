<?php

/* -------------------------------------------------------------- [F] */

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
        return json_decode($option_json, JSON_OBJECT_AS_ARRAY);
    }

    $option_array = fetch_option_default();
    $option_json  = json_encode($option_array, JSON_PRETTY_PRINT);

    if( file_put_contents($path_file_option, $option_json) ){
        $msg  = '設定ファイルを作成しました。';
        $msg .= '必要事項を記入し再実行してください。' . PHP_EOL;
        $msg .= '保存先： ' . $path_file_option . PHP_EOL;
        die($msg);
    }

    $msg  = '設定ファイルの作成ができません。';
    $msg .= 'フォルダのアクセス権を確認してください。' . PHP_EOL;
    die($msg);    
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
    $page         = fetch_value($option, 'page', 1);
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
        $result .= PHP_EOL . '-----' . PHP_EOL;
        $result .= PHP_EOL . "${date_created} by ${name_user}" . PHP_EOL;
        $result .= PHP_EOL . $msg_comment . PHP_EOL;
    }

    return $result;
}

function format_md($issue)
{
    $title   = fetch_value($issue, 'title');
    $body    = fetch_value($issue, 'body');
    $state   = fetch_value($issue, 'state');
    $url_repository = fetch_value($issue, 'repository_url');
    $timestamp    = strtotime($issue['created_at']);
    $date_created = date("Y/m/d H:i", $timestamp);
    $name_user    = $issue['user']['login'];
    $msg_comment  = $issue['body'];

    $result  = '';
    $result .= '# ' . $title . PHP_EOL;
    $result .= PHP_EOL;
    $result .= "- ${date_created} by ${name_user}" . PHP_EOL;
    $result .= "- State: ${state}" . PHP_EOL;
    $result .= "- Archive of ${url_repository}" . PHP_EOL;
    $result .= PHP_EOL . '## 本文' . PHP_EOL;
    $result .= PHP_EOL . $body . PHP_EOL;
    $result .= PHP_EOL . '-----' . PHP_EOL;
    $result .= PHP_EOL . '## コメント' . PHP_EOL;
    $result .= format_comment(fetch_value($issue, 'comments'));

    return $result;
}

/* -------------------------------------------------------------- [R] */

function request_api($option)
{
    $url_request  = fetch_value($option, 'url_request');
    $access_token = fetch_value($option, 'access_token');
    if ($url_request) {
        $request_api_v3 = 'Accept: application/vnd.github.v3+json';
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: Qithub-BOT',
                    "Authorization: token ${access_token}",
                    $request_api_v3,
                ],
            ],
        ]);
        if( $result = @file_get_contents($url_request, false, $context)){
            sleep(1);
            return json_decode($result, JSON_OBJECT_AS_ARRAY);
        }
    }

    return array();
}

function request_api_issue($option)
{
    $option['url_request'] = fetch_url_request($option);
    return request_api($option);
}

/* -------------------------------------------------------------- [S] */
