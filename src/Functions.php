<?php

// ("/repos/$owner/$repo/issues", 'GET', $data, 200, 'GitHubIssue', true)

function fetch_option_default()
{
    $option = [
        'access_token'    => '',
        'scheme'          => 'https',
        'host'            => 'api.github.com',
        'name_repo_owner' => '',
        'name_repo'       => '',
    ];

    return $option;
}

function fetch_url_endpoint($option)
{
    //
}

function fetch_value($array, $key)
{
    $result = false;

    if (is_array($array) && isset($array[$key]) && ! empty($array[$key])) {
        $result = $array[$key];
    }

    return $result;
}
