<?php

// ("/repos/$owner/$repo/issues", 'GET', $data, 200, 'GitHubIssue', true)

function fetch_option_default()
{
    $option = [
        'access_token'    => '',
        'name_repo_owner' => '',
        'name_repo'       => '',
    ];

    return $option;
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

    $url  = fetch_endpoint_issues($option);
    $url .= '?' . http_build_query($query);

    return $url;
}

function fetch_endpoint_issues($option)
{
    $name_repo_owner = fetch_value($option, 'name_repo_owner', 'NAME_OWNER');
    $name_repo       = fetch_value($option, 'name_repo', 'NAME_REPO');
    $url  = "https://api.github.com/repos/";
    $url .= $name_repo_owner . '/' . $name_repo . '/';
    $url .= 'issues';

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
