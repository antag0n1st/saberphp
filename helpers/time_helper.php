<?php

class TimeHelper
{
    static function DatetimeInGMT() {
        return date("Y-m-d H:i:s", time()-date("Z",time()));
    }

    static function GMTDatetimeToLocal($datetime) {
        $time = strtotime($datetime);
        return date("Y-m-d H:i:s", $time+date("Z",$time));
    }

    static function DateTimeAdjusted()
    {
        return date("Y-m-d H:i:s", strtotime( self::DatetimeInGMT() . " + 2 hours" ) );
    }
    
    static function DateAdjusted()
    {
        return date("Y-m-d", strtotime( self::DatetimeInGMT() . " + 2 hours" ) );
    }
    
    public static function to_date($date_time){
        return date('Y-m-d', strtotime($date_time));
    }
    
    static function DateTime(){
        return date("Y-m-d H:i:s");
    }

    static function DateTimeAdjustedForProviders($date)
    {
        $hours_to_add;
        global $host_name;
        if($host_name == 0 or
           $host_name == 1)
            {
                $hours_to_add = 6;
            }
        else{
                $hours_to_add = 1;
        }
        return date("Y-m-d H:i:s", strtotime( $date . " + $hours_to_add hours" ) );
    }
    
    private static function convert_datetime($str) {

    list($date, $time) = explode(' ', $str);
    list($year, $month, $day) = explode('-', $date);
    list($hour, $minute, $second) = explode(':', $time);

    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

    return $timestamp;
    }
    
    public static function RelativeTime($time, $now = false)
    {       $time1 = $time;
            $time = strtotime($time);//self::convert_datetime($time);
            $time = (int) $time;


            $curr = $now ? $now : self::DateTimeAdjusted();//time();
            $shift = strtotime($curr) - $time;
            $diff = 'пред ';
            if ($shift < 0 ): 
                    $diff = 'пред помалку од';
                    $term = " една минута";
                
            elseif ($shift < 60):
                    $diff .= $shift;
                    $term = "секунди";
            elseif ($shift < 120):
                    $diff .= 'една';
                    $term = "минута";
            elseif ($shift < 3600):
                    $diff .= floor($shift / 60);
                    $term = "минути";
            elseif ($shift < 7200):
                    $diff .= 'еден';
                    $term = "час";
            elseif ($shift < 86400):
                    $diff .= round($shift / 60 / 60);
                    $term = "часa";
            elseif ($shift < 172800):
                    $diff .= 'еден';
                    $term = "ден";
            elseif ($shift < 604800):
                    $diff .= round($shift / 60 / 60 / 24);
                    $term = "денa";
            elseif ($shift < 1209600):
                    $diff .= 'една';
                    $term = "недела";
            elseif ($shift < 2419200):
                    $diff .= round($shift / 60 / 60 / 24/7);
                    $term = "недели";
            else: 
                    $diff = "на ";
                    $term = "".$time1;
            endif;

            if ($diff == 1) $term .= "";
            return "$diff $term ";

    }

}
?>
