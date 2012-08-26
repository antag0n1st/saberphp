<?php
/**
 * ======================================================
 *        Swith between production and development
 * ======================================================
 * 
 * HOST_ID
 * 0 - (  production mode ) www.example.com
 * 1 - ( development mode ) localhost
 */
define('HOST_ID',1);

/**
 * ======================================================
 *                     CONSTANTS
 * ======================================================
 * set BASE_URL and BASE_DIR for different environments
 */

define('BASE_DIR', dirname(dirname(__FILE__)).'/');
// define('BASE_URL', "http://".$_SERVER['HTTP_HOST'].preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/');
if (HOST_ID == 0) {
    define('BASE_URL', "http://example.com/");
} else if (HOST_ID == 1) {
    define('BASE_URL', "http://localhost/mvc/");
} else if (HOST_ID == 2) {
    define('BASE_URL', "http://test.example.com/");
}

date_default_timezone_set('Europe/Skopje');

$_controller_default_name   = 'index';
$_controller_default_action = 'main';

/**
 * ======================================================
 *                 DATABASE CONNECTION
 * ======================================================
 */
if(HOST_ID == 1){
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "mvc");
}else if(HOST_ID == 0){
    // define connection in production mode
}
/**
 * ======================================================
 *                TURN CACHE ON/OFF
 * ======================================================
 */
define('CACHING',false);
define('CACHING_EXPIRATION_TIME', 10); // in secound
/**
 * ======================================================
 *                      AUTOLOAD
 * ======================================================
 * Paths where to look for a missing class
 */
$_autoload_paths = array('helpers','models','classes');

/**
 * ======================================================
 *                      PLUGINS 
 * ======================================================
 * tell the system which plugins should be 
 * included in the project
 */
$plugins = array(
   'membership'
   , 'comments'
   ,'blog'
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

/**
 * ======================================================
 *               Active menu items/links
 * ======================================================
 * Helps when building menus to tell the system which 
 * page is currently active
 */
$_active_page_ = '';

/**
 * ======================================================
 *                GOOGLE TRACKING CODE
 * ======================================================
 */
$google_tracking_code_ = "";


define('MAIL_INFO', 'info@example.com');
define('MAIL_ADMIN','trbogazov@gmail.com');

/**
 * 
 */
if(HOST_ID > 0){
        define('FACEBOOK_APP_ID', '212980188770505');
        define('FACEBOOK_APP_SECRET', '26b3ca35b2cf0c7954ae64ef6918177c');
}else{
        define('FACEBOOK_APP_ID', '');
        define('FACEBOOK_APP_SECRET', '');
}
    
?>