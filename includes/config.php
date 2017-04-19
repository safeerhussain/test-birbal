<?php
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

$GLOBALS['access_token'] = "EAAEA78n08dcBAAZCnjyO4Cyq1rWYMIZBSh8ZAwpS70EI12cfCfcPddizqXrxOWCePGI1FNswqg9ZAhlaLBF33IZCdICyAQlZBZAZAqaDJZChtgBuwn0tTpUs65dulL5vHcMXyL8ZA2gwkfyxZAePEYzYoQOMmllYEoCpaZCJgj0OseFVTgZDZD";
$verify_token = "FBbotByDE";
$hub_verify_token = null;

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}


if ($hub_verify_token === $verify_token) {
    echo $challenge;
}

?>