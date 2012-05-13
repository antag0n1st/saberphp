<?php
/**
 * ======================================================
 *                    ERROR HANDLING
 * ======================================================
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');
set_error_handler('custom_errror_handler');

function custom_errror_handler($severity, $message, $filepath, $line) {

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
        Load::view('oops/error');
    }
    return false;
}

register_shutdown_function(function () {
                $error = error_get_last();
                if($error !== NULL){
                  
                    if($error['type'] == 1){
                            $info = "[FATAL ERROR] <br /><br /> <b>file</b>:".$error['file']." <br /> <b>line</b>:".$error['line']." <br /> <b>msg</b>:".$error['message'] .PHP_EOL;
                            if(HOST_ID > 0){
                                Load::assign('_error_message', $info);
                                Load::view('oops/fatal_error');
                            }
                    }
                    
                }
});

?>