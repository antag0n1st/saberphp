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

        if ($view) {

            if (strlen(strstr($view, '/')) > 0) {
                $view = str_replace('../', '', $view);

                if (file_exists($plugin_dir_ . 'views/' . $view . '.php')) {
                    if ($plugin_dir_) {
                        Load::plugin_view($plugin_name_, $view);
                    } else {
                        Load::view($view);
                    }
                } else {
                    if (HOST_ID > 0) {
                        die($plugin_dir_ . 'views/' . $controller_file_name . '/' . $view . '.php');
                    } else {
                        die('missing template ' . $view);
                    }
                }
            } else {

                if (file_exists($plugin_dir_ . 'views/' . $controller_file_name . '/' . $view . '.php')) {
                    if ($plugin_dir_) {
                        Load::plugin_view($plugin_name_, $controller_file_name . '/' . $view);
                    } else {
                        Load::view($controller_file_name . '/' . $view);
                    }
                } else {
                    if (HOST_ID > 0) {
                        die($plugin_dir_ . 'views/' . $controller_file_name . '/' . $view . '.php');
                    } else {
                        die('missing template ' . $view);
                    }
                }
            }
        }
    }

    protected function get_post($value) {
        return isset($_POST[$value]) ? $_POST[$value] : "";
    }
    
    protected function get_session($value) {
        return isset($_SESSION[$value]) ? $_SESSION[$value] : "";
    }

    protected function get($value) {
        return isset($_GET[$value]) ? $_GET[$value] : "";
    }

    protected function no_layout() {
        global $layout;
        $layout = null;
    }

    public function no_trackng() {
        global $google_tracking_code_;
        $google_tracking_code_ = '';
    }

    protected function json_response($data) {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    protected function set_layout($name) {
        global $layout;
        $layout = $name;
    }

    protected function set_view($name) {
        global $view;
        $view = $name;
    }

    protected function set_error($error) {
        if (isset($_SESSION)) {
            $_SESSION['_error'] = $error;
        }
    }

    protected function set_confirmation($confirmation) {
        if (isset($_SESSION)) {
            $_SESSION['_confirmation'] = $confirmation;
        }
    }

    protected function set_menu($main, $sub = '') {
        global $_active_page_, $_active_page_submenu_;

        $_active_page_ = $main;
        $_active_page_submenu_ = $sub;
    }
    
    public function need($permission){
        if(!Membership::instance()->has($permission)){
            Membership::instance()->clear_user_data();
            URL::redirect('oops/no-privileges');
        }
    }

}

?>