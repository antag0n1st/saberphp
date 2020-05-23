<?php

$_controllers_to_cache = array();
$_controllers_to_cache[] = array(
    'controller' => 'index',
    'action' => '*',
    'time' => 10,
    'userlevel' => '',
);

//$_controllers_to_cache[] = array(
//    'controller' => 'feed',
//    'action' => '*',
//    'time' => 10,
//    'userlevel' => '',
//);


$_yes_please_procced_with_caching = false;

foreach ($_controllers_to_cache as $_c) {
    if ($_c['controller'] == $controller) {
        $_yes_please_procced_with_caching = true;
    }
}


// check the session


if (isset($_COOKIE) and isset($_COOKIE['logged_user']) and $_COOKIE['logged_user']) {
    $_yes_please_procced_with_caching = false;
}

