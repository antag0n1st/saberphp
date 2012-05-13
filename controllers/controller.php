<?php

class Controller {

    function __construct() {
        
    }

    public static function is_active($link_) {
        global $_active_page_;
        return $_active_page_ == $link_ ? 'active' : '';
    }

    public static function load_main_view() {

        global $plugin_dir_;
        global $controller_file_name;
        global $view;
        global $plugin_name_;
        global $controller;

        if ($view) {

            if (strlen(strstr($view, '/')) > 0) {
                $view = str_replace('../', '', $view);

                if (file_exists($plugin_dir_ . 'views/' . $controller_file_name . '/' . $view . '.php')) {
                    if ($plugin_dir_) {
                        Load::plugin_view($plugin_name_, $controller_file_name . '/' . $view);
                    } else {
                        Load::view($controller . '/' . $view);
                    }
                } else {
                    die('missing template ' . $view);
                }
            } else {

                if (file_exists($plugin_dir_ . 'views/' . $controller_file_name . '/' . $view . '.php')) {
                    if ($plugin_dir_) {
                        Load::plugin_view($plugin_name_, $controller_file_name . '/' . $view);
                    } else {
                        Load::view($controller . '/' . $view);
                    }
                } else {
                    die('missing template ' . $view);
                }
            }
        }
    }
}

?>