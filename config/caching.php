<?php

    $_cached_file_name = $_SERVER["REQUEST_URI"];
    $_cached_file_name = str_replace(array('\\','/',"'",'"'), '', $_cached_file_name);
    $_cached_file_name .= '.tmp';
                
    if(file_exists(BASE_DIR.'cache/'.$_cached_file_name)){
        
        if (filemtime(BASE_DIR.'cache/'.$_cached_file_name) < (time() - CACHING_EXPIRATION_TIME))  {
            unlink(BASE_DIR.'cache/'.$_cached_file_name);
        }else{
            echo file_get_contents(BASE_DIR.'cache/'.$_cached_file_name);
            echo (HOST_ID > 0) ? 'READING FROM CACHE!' : '';
            exit;
        }
        
    }

    $_controllers_to_cache = array();
    
    $_controllers_not_to_cashe = array();


?>
