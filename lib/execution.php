<?php
/**
 * Description of ExecutionTime
 *
 * @author Antagonist
 */
class Execution{

    private static $script_start = 0;
    private static $script_end = 0;

    private static function microtime_float() {
        list($utime, $time) = explode(" ", microtime());
        return ((float) $utime + (float) $time);
    }
    /**
     * Call this funciton form the place where you want to start mesuring the 
     * execution time.
     * 
     * Then Call the showExectionTime() Function to show you the results
     */
    public static function startExecution() {
        self::$script_start = self::microtime_float();
    }

    private static function endExecution() {
        self::$script_end = self::microtime_float();
    }
    
    /**
     * Call this function After startExecution() to show you the results 
     * for the time passed executing the script
     */
    public static function showExecutionTime($echo = true){
        self::endExecution();
        if(self::$script_start == 0){
           $msg =  "Execution::startExecution() Has To Be Called First "; 

        }else {
           $msg =  "Script executed in <b>".bcsub(self::$script_end, self::$script_start, 4)."</b> seconds. \n <br />";
        }

        if($echo){echo $msg;}
        
        return $msg;
    }

}

?>