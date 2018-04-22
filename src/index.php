<?php

include('Functions.php');

$option = fetch_option_default();

echo fetch_url_request($option);