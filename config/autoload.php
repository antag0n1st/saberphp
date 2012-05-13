<?php
        function __autoload($class_name){
            global $_autoload_paths;
            $class_name[0] = strtolower($class_name[0]);
            $func = create_function('$c', 'return "_" . strtolower($c[1]);');
            $class_file_name =  preg_replace_callback('/([A-Z])/', $func, $class_name);
            
            foreach($_autoload_paths as $path){
                if(file_exists(BASE_DIR.$path.'/'.$class_file_name.'.php')){                    
                    include_once BASE_DIR.$path.'/'.$class_file_name.'.php';
                    return;
                }                
            }
            die('class "'.$class_name.'" not found');
        }
?>