<?php

class Date{
    public static function format($date,$format = 'd.m.Y'){
        return date($format , strtotime($date));
    }
}
?>
