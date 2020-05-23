<?php

include_once 'config/boot.php';


$plugin_dir_ = '';
$plugin_name_ = '';

$controller = empty($_GET['controller']) ? $_controller_default_name : $_GET['controller'];
$action = empty($_GET['action']) ? $_controller_default_action : preg_replace('/(?!^)-/', "_", $_GET['action']);
$controller_file_name = str_replace("-", "_", $controller);

$layout = 'default';
$view = $action;

if (isset($plugin_controllers[$controller_file_name])) {
    $plugin_name_ = $plugin_controllers[$controller_file_name];
    $plugin_dir_ = 'plugins/' . $plugin_name_ . '/';
}

$_yes_please_procced_with_caching = true;

if (file_exists(BASE_DIR.$plugin_dir_ . 'controllers/' . $controller_file_name . '.php')) {
    include BASE_DIR.$plugin_dir_ . 'controllers/' . $controller_file_name . '.php';

    $names = explode('_', $controller_file_name);
    $controller_class_name = '';
    foreach ($names as $name) {
        $controller_class_name .= ucfirst($name);
    }
    $controller_class_name .= 'Controller';

    class_exists($controller_class_name) ?
                    $controller_object = new $controller_class_name :
                    die($controller_class_name . 'Invalid Controller');

    if (is_callable(array($controller_object, $action))) {
        $ar = isset($_GET['params']) ? explode('/', $_GET['params']) : array();
        call_user_func_array(array($controller_object, $action), $ar);
    } else {
        URL::redirect('oops/error-404');
    }
} else {
    URL::redirect('oops/error-404');
}


include_once BASE_DIR . 'config/caching_rules.php';
//TODO handle the situations when the caching must not take place
// when the user is logged , or on pages where content changes frequently
// maybe add , custom exiration time for cirtin pages


if (CACHING and $_yes_please_procced_with_caching and !error_get_last()) {

    if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
        ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^
                PHP_OUTPUT_HANDLER_REMOVABLE);
    } else {
        ob_start(null, 0, false);
    }

    ob_flush();
    eval(" ?> " . file_get_contents(BASE_DIR . 'layouts/' . $layout . '.php') . " <?php ");
    $content = ob_get_contents();
    ob_clean();
    $_cached_file_name = $_SERVER["REQUEST_URI"];
    $_cached_file_name = str_replace(array('\\', '/', "'", '"'), '', $_cached_file_name);
    $_cached_file_name .= '.tmp';
    $handle = fopen(BASE_DIR . 'cache/' . $_cached_file_name, 'w+');
    fwrite($handle, $content);
    fclose($handle);
    echo $content;
    
} else {
    $layout ? include BASE_DIR . 'layouts/' . $layout . '.php' : null;
}