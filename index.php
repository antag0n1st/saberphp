<?php include_once 'config/boot.php';

$controller = empty($_GET['controller']) ? $_controller_default_name : $_GET['controller'];
$action     = empty($_GET['action']) ? $_controller_default_action : preg_replace('/(?!^)-/', "_", $_GET['action']);
$layout     = 'default';
$view       = $action;
$controller_file_name = str_replace("-", "_", $controller);

$plugin_dir_ = '';
$plugin_name_ = '';

if( isset ($plugin_controllers[$controller_file_name])){   
    $plugin_name_ = $plugin_controllers[$controller_file_name];
    $plugin_dir_ = 'plugins/'.$plugin_name_.'/';
}

if(file_exists($plugin_dir_.'controllers/'.$controller_file_name.'.php')){
    include $plugin_dir_.'controllers/'.$controller_file_name.'.php';
    
    $names = explode('_', $controller_file_name);
    $controller_class_name = '';    
    foreach($names as $name){
        $controller_class_name .= ucfirst($name);
    }
    $controller_class_name .= 'Controller';
    
    class_exists($controller_class_name)?
    $controller_object = new $controller_class_name :
    die($controller_class_name.' not found ,<br />
        controllers should be named with "Controller" at the end <br />
        Example: file: myclass.php should contain class MyclassController extends Controller{} ');
     
         if(is_callable(array($controller_object, $action))){
             $ar = isset ($_GET['params']) ? explode('/', $_GET['params']) : array();
             call_user_func_array(array($controller_object, $action ), $ar);
         }else{
             URL::redirect('oops/error-404');
         } 
    
}else{    
   URL::redirect('oops/error-404');
}

$layout ? include 'layouts/'.$layout.'.php' : null ;

?>