<?php

/**
 * ======================================================
 *        Swith between production and development
 * ======================================================
 * 
 * HOST_ID
 * 0 - (  production mode ) www.example.com
 * 1 - ( development mode ) localhost
 * 2 - ( test mode) 
 * 3 - ( It's Haroon )
 */
define('HOST_ID', 1);

define('JWT_SECRET_KEY', 'myMathKeyJWTx02p48');

/**
 * ======================================================
 *                     CONSTANTS
 * ======================================================
 * set BASE_URL and BASE_DIR for different environments
 */
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(dirname(__FILE__)) . DS);

if (HOST_ID == 0) {
    define('BASE_URL', "http://mymathcore.com/api/");
    define('CONTENT_URL', 'http://mymathcore.com/content/');
    define('CONTENT_DIR', realpath(BASE_DIR.'../content/'). DS);
} else if (HOST_ID == 1) {
    define('BASE_URL', "http://localhost/mymathcore/api/");
    define('CONTENT_URL', 'http://localhost/mymathcore/content/');
    define('CONTENT_DIR', realpath(BASE_DIR.'../content/'). DS);
} else if (HOST_ID == 2) {
    define('BASE_URL', "http://dev.mymathcore.com/api/");
    define('CONTENT_URL', 'http://dev.mymathcore.com/content/');
    define('CONTENT_DIR', realpath(BASE_DIR.'../content/'). DS);
} else if (HOST_ID == 3) {
    define('BASE_URL', "http://mymathcore.dev/api/");
    define('CONTENT_URL', 'http://mymathcore.dev/content/');
    define('CONTENT_DIR', realpath(BASE_DIR.'../content/'). DS);
}

date_default_timezone_set('Europe/Skopje');

$_controller_default_name = 'index';
$_controller_default_action = 'main';

/**
 * ======================================================
 *                 DATABASE CONNECTION
 * ======================================================
 */
if (HOST_ID == 0) {
    // define connection in production mode
} else if (HOST_ID == 1) {
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "my_math_core_db");
} else if (HOST_ID == 2) {
    // define connection in dev mode
    define("DB_SERVER", "127.0.0.1");
    define("DB_USER", "thewhybu_mymathc");
    define("DB_PASS", "JaQShcQ}LQWI");
    define("DB_NAME", "thewhybu_mymathcore");
} else if (HOST_ID == 3) {
    // define connection in dev mode
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "123");
    define("DB_NAME", "thewhybu_mymathcore");
}
/**
 * ======================================================
 *                TURN CACHE ON/OFF
 * ======================================================
 */
define('CACHING', false);

define('CACHING_EXPIRATION_TIME', 10); // in secound
/**
 * ======================================================
 *                      AUTOLOAD
 * ======================================================
 * Paths where to look for a missing class
 */
$_autoload_paths = array('helpers', 'models', 'classes');

/**
 * ======================================================
 *                      PLUGINS 
 * ======================================================
 * tell the system which plugins should be 
 * included in the project
 */
$plugins = array(
    'membership'
);

// PLUGIN CONTROLLERS , 
// 
// this is the first place where , when the url is parsed , is looked for  a controller ,
// in that way we can enable plugins to work on the same level as the whole appication.
// 
// this array is automaticlly populated if needed from the plugins manifest.
// 
// the scound place is the conrollers folder under the root folder.
$plugin_controllers = array(); // DON'T EDIT THIS LINE

define('MEMBERSHIP_COOKIE_DURATION', 60 * 60 * 1); // sec * min * hours

/**
 * ======================================================
 *               Active menu items/links
 * ======================================================
 * Helps when building menus to tell the system which 
 * page is currently active
 */
$_active_page_ = '';
$_active_page_submenu_ = "";

/**
 * ======================================================
 *                GOOGLE TRACKING CODE
 * ======================================================
 */
$google_tracking_code_ = "";


define('MAIL_INFO', 'info@example.com');
define('MAIL_ADMIN', 'trbogazov@gmail.com');

/**
 * 
 */
if (HOST_ID == 1) {
    define('FACEBOOK_APP_ID', '');
    define('FACEBOOK_APP_SECRET', '');
} else if (HOST_ID == 2) {
    define('FACEBOOK_APP_ID', '');
    define('FACEBOOK_APP_SECRET', '');
} else if (HOST_ID == 0) {
    define('FACEBOOK_APP_ID', '');
    define('FACEBOOK_APP_SECRET', '');
}
