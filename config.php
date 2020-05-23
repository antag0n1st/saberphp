<?php

/**
 * BASIC DATA
 */
define('TITLE', 'Saber PHP');
define('DESCRIPTION', 'Code the easy way');
define('KEYWORDS', 'php framework');

/**
 * ======================================================
 *        Swith between production and development
 * ======================================================
 * 
 * HOST_ID
 * 0 - (  production mode ) www.example.com
 * 1 - ( development mode ) localhost
 */
define('HOST_ID', 1);

/**
 * ======================================================
 *                     CONSTANTS
 * ======================================================
 * set BASE_URL and BASE_DIR for different environments
 */
define('CONTENT_DIR', realpath(BASE_DIR . 'public/uploads/') . DS);

if (HOST_ID == 0) {
    define('BASE_URL', "http://example.com/");
} else if (HOST_ID == 1) {
    define('BASE_URL', "http://localhost/saberphp/");
}

date_default_timezone_set('Europe/Skopje');

$_controller_default_name = 'home';
$_controller_default_action = 'main';

/**
 * ======================================================
 *                 DATABASE CONNECTION
 * ======================================================
 */
if (HOST_ID == 0) {
    // define connection in production mode
    define("DB_SERVER", "localhost");
    define("DB_NAME", "");
    define("DB_USER", "");
    define("DB_PASS", "");
} else if (HOST_ID == 1) {
    define("DB_SERVER", "localhost");
    define("DB_NAME", "saberphp");
    define("DB_USER", "root");
    define("DB_PASS", "");    
}
/**
 * ======================================================
 *                TURN CACHE ON/OFF
 * ======================================================
 */
define('CACHING', false);

define('CACHING_EXPIRATION_TIME', 5); // in secound
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

define('MEMBERSHIP_COOKIE_DURATION', 60 * 60 * 24 * 7); // sec * min * hours

/**
 * ======================================================
 *               Active menu items/links
 * ======================================================
 * Helps when building menus to tell the system which 
 * page is currently active
 */
/**
 * ======================================================
 *                GOOGLE TRACKING CODE
 * ======================================================
 */
$google_tracking_code_ = "";


define('MAIL_INFO', 'trbogazov@gmail.com');
define('MAIL_ADMIN', 'trbogazov@gmail.com');
define('MAIL_BOUNCE', 'bounce@gmail.com');

/**
 * 
 */
if (HOST_ID == 0) {
    define('FACEBOOK_APP_ID', '');
    define('FACEBOOK_APP_SECRET', '');
} else if (HOST_ID == 1) {
    define('FACEBOOK_APP_ID', '');
    define('FACEBOOK_APP_SECRET', '');
}
