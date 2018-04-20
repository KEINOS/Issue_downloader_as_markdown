<?php

// ("/repos/$owner/$repo/issues", 'GET', $data, 200, 'GitHubIssue', true)

function fetch_option_default()
{
    $option = [
        'access_token' => '',
    ];
    
    return $option;
}