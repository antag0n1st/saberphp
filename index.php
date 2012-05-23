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

                $_yes_please_procced_with_caching = true;
                //TODO handle the situations when the caching must not take place
                // when the user is logged , or on pages where content changes frequently
                // maybe add , custom exiration time for cirtin pages

if(CACHING and $_yes_please_procced_with_caching){
                
    
                ob_start();
                ob_flush();
                eval(" ?> " . file_get_contents(BASE_DIR .'layouts/'.$layout.'.php') . " <?php ");
                $content = ob_get_contents();
                ob_clean();
                $_cached_file_name = $_SERVER["REQUEST_URI"];
                $_cached_file_name = str_replace(array('\\','/',"'",'"'), '', $_cached_file_name);
                $_cached_file_name .= '.tmp';
                $handle = fopen(BASE_DIR.'cache/'.$_cached_file_name, 'w+');
                fwrite($handle, $content);
                fclose($handle);
                echo $content;
                // $content;
}else{
    $layout ? include BASE_DIR.'layouts/'.$layout.'.php' : null ;
}


?>