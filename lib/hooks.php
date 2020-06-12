<?php
class Hooks {

    private static $actions = array(
        'user_created' => array() , 
        'user_logged' => array() , 
        'user_logout' => array()
    );

    public static function apply($hook, $args = array()) {
        if (!empty(self::$actions[$hook])) {
            foreach (self::$actions[$hook] as $f) {
                $f($args);
            }
        }
    }

    public static function add_action($hook, $function) {
        self::$actions[$hook][] = $function;
    }
    
    public static function add_hook($hook_name) {
        self::$actions[$hook_name] = [];
    }

}