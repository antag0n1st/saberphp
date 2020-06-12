<?php

if (php_sapi_name() != "cli") {
    die("Can't work on the web");
}

// lets go up and pretend
chdir("..");
include_once 'config/boot.php';

function recurseCopy($src, $dst) {
    $dir = opendir($src);

    if (!file_exists($dst)) {
        mkdir($dst, 0777, true);
    }

    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if (is_dir($src . '/' . $file)) {
                recurseCopy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function recursiveRemove($path) {
    if (is_dir($path)) {
        foreach (scandir($path) as $entry) {
            if (!in_array($entry, ['.', '..'])) {
                recursiveRemove($path . DS . $entry);
            }
        }
        rmdir($path);
    } else {
        unlink($path);
    }
}

$dir_name = str_replace('--dir=', '', $argv[1]);
$name = str_replace('--name=', '', $argv[2]);
$db_name = str_replace('--db_name=', '', $argv[3]);
$db_user = str_replace('--db_user=', '', $argv[4]);
$db_pass = str_replace('--db_pass=', '', $argv[5]);
$email = str_replace('--email=', '', $argv[6]);

if (!$name) {
    $name = $dir_name;
}

if (!$db_user) {
    $db_user = 'root';
}

if (!$db_name) {
    $db_name = $dir_name;
}

if (!$email) {
    $email = 'trbogazov@gmail.com';
}

//echo $dir_name . "\n";
//echo $name . "\n";
//echo $db_name . "\n";
//echo $db_user . "\n";
//echo $db_pass . "\n";
//echo $email . "\n";

$content = file_get_contents('tools/config');

$content = str_replace('{name}', $name, $content);
$content = str_replace('{db_name}', $db_name, $content);
$content = str_replace('{db_user}', $db_user, $content);
$content = str_replace('{db_pass}', $db_pass, $content);
$content = str_replace('{email}', $email, $content);
$content = str_replace('{dir_name}', $dir_name, $content);

chdir("..");

if (!file_exists($dir_name)) {

    mkdir($dir_name, 0777, true);
} else {
    echo "The directory already exist\n";
    exit;
}

recurseCopy('saberphp/tools', $dir_name . '/tools');
unlink($dir_name . '/tools/config');
unlink($dir_name . '/tools/install.bat');
unlink($dir_name . '/tools/install.php');
unlink($dir_name . '/tools/saberphp.sql');

recurseCopy('saberphp/app', $dir_name . '/app');
recurseCopy('saberphp/cache', $dir_name . '/cache');
recurseCopy('saberphp/classes', $dir_name . '/classes');
recurseCopy('saberphp/config', $dir_name . '/config');
recurseCopy('saberphp/controllers', $dir_name . '/controllers');
recurseCopy('saberphp/cronjobs', $dir_name . '/cronjobs');
recurseCopy('saberphp/functions', $dir_name . '/functions');
recurseCopy('saberphp/helpers', $dir_name . '/helpers');
recurseCopy('saberphp/layouts', $dir_name . '/layouts');
recurseCopy('saberphp/lib', $dir_name . '/lib');
recurseCopy('saberphp/models', $dir_name . '/models');
recurseCopy('saberphp/plugins', $dir_name . '/plugins');
recurseCopy('saberphp/public', $dir_name . '/public');
recurseCopy('saberphp/views', $dir_name . '/views');

copy('saberphp/.gitignore', $dir_name . '/.gitignore');
copy('saberphp/.htaccess', $dir_name . '/.htaccess');
copy('saberphp/global_data.php', $dir_name . '/global_data.php');
copy('saberphp/index.php', $dir_name . '/index.php');
copy('saberphp/php.ini', $dir_name . '/php.ini');

file_put_contents($dir_name . '/config.php', $content);

// empty models dir
//array_map( 'unlink', array_filter((array) glob($dir_name . '/config/scaffolding/models/*') ) );

// remove images dir
recursiveRemove($dir_name . '/public/uploads/images/');

// lets deploy the database
// 
$query = "CREATE DATABASE IF NOT EXISTS " . $db_name . " CHARACTER SET utf8 COLLATE utf8_general_ci; ";
Model::db()->query($query);
Model::db()->change_db($db_name);

$query = '';
$sqlScript = file('saberphp/tools/saberphp.sql');
foreach ($sqlScript as $line) {

    $startWith = substr(trim($line), 0, 2);
    $endWith = substr(trim($line), -1, 1);

    if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
        continue;
    }

    $query = $query . $line;
    if ($endWith == ';') {
        Model::db()->query($query);
        $query = '';
    }
}
