<?php
/**
 * ======================================================
 *                    ERROR HANDLING
 * ======================================================
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');
set_error_handler('custom_errror_handler');

$_error_buffer  = "<style type=\"text/css\"> .error-buffer{ width:600px; height:300px;position:fixed;z-index:10000000000; left:50%;top:50%;margin-left:-300px;margin-top:-150px;overflow-y: scroll; overflow-x: hidden;background-color: #252a2e; border:1px solid black; padding:10px;}</style>";
$_error_buffer .= '<div class="error-buffer">';
$_error_buffer .= "<h2 style='color:white;'>There where some Warnings/Errors</h2>";
$_error_happened = false;

function custom_errror_handler($severity, $message, $filepath, $line) {
    global $_error_happened;
    $_error_happened = true;
    $trace = debug_backtrace();
    $output = "<b>message</b> : " . $message . "";
    $output .= "<br /> <b>on line</b> : " . $line;
    $output .= "<br /> <b>in file</b> : " . $filepath;
    $output .= "<br /><br />----------------- STACK TRACE ----------------- <br />";

    foreach ($trace as $t) {

        if (isset($t['function']) and ( $t['function'] == 'custom_errror_handler' or $t['function'] == 'call_user_func_array')) {
            
        } else {

            $output .= "file : " . ( isset($t['file']) ? $t['file'] : '' ) . "<br />";
            $output .= "line : " . ( isset($t['line']) ? $t['line'] : '' ) . "<br />";
            $output .= "class : " . ( isset($t['class']) ? $t['class'] : '' ) . "<br />";
            $output .= "function : " . ( isset($t['function']) ? $t['function'] : '' ) . "<br />";
            $output .= "---------------------------------------------------------- <br />";
        }
    }
    if(HOST_ID > 0){
        Load::assign('_error_message', $output);
        global $_error_buffer;
        $_error_buffer .= Load::view('oops/error',true);
    }
    return false;
}

register_shutdown_function(function () {
                global $_error_buffer ,$_error_happened;;
                $error = error_get_last();
                if($error !== NULL){
                    
                    if($error['type'] == 1 or $error['type'] == 4){
                            
                            $_error_happened = true;
                            $info = "[FATAL ERROR] <br /><br /> <b>file</b>:".$error['file']." <br /> <b>line</b>:".$error['line']." <br /> <b>msg</b>:".$error['message'] .PHP_EOL;
                            if(HOST_ID > 0){
                                Load::assign('_error_message', $info);
                                
                                $_error_buffer .= Load::view('oops/fatal_error',true);
                                
                                
                            }
                    }
                    
                }
                $_error_buffer .= "</div>";
                
                echo $_error_happened ? $_error_buffer : '';
});

?>