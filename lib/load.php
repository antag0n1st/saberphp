<?php

/**
 * This class is used to load all the needed classes , and push data to the views
 * @author Antagonist
 */
class Load {

    private static $vars = array();

    /**
     * Assign variables that will be pushed into the views
     * @param string $var_name
     * @param mixed $var_value 
     */
    public static function assign($var_name, $var_value) {
        self::$vars[$var_name] = $var_value;
    }

    /**
     * Loads a view
     * @param type $name_
     * @param type $return_as_string
     * @return type 
     */
    public static function view($name_, $return_as_string = false) {

        foreach (self::$vars as $key => &$value) {
            $$key = &$value;
        }
        if (file_exists(BASE_DIR . "views/" . $name_ . ".php")) {
            if ($return_as_string) {
                ob_start();
                ob_flush();
                eval(" ?> " . file_get_contents(BASE_DIR . "views/" . $name_ . ".php") . " <?php ");
                $content = ob_get_contents();
                ob_clean();
                return $content;
            } else {
                include BASE_DIR . "views/" . $name_ . ".php";
            }
        } else {
           // die('view not found');
            echo 'view <b>'."views/" . $name_.'</b> not found';
        }
    }

    /**
     * loads a helper class from the /helpers folder
     * @param type $name_ 
     */
    public static function helper($name_) {

        if (!include_once BASE_DIR . "helpers/" . $name_ . ".php") {
            die('helper not found');
        }
    }

    /**
     * Loads a class from the /lib folder
     * @param type $name_ 
     */
    public static function lib($name_) {

        if (!include_once BASE_DIR . "lib/" . $name_ . ".php") {
            die('lib not found');
        }
    }
    /**
     * Loads functions files from the /functions folder
     * @param type $name_ 
     */
    public static function functions($name_) {
        if (!include_once BASE_DIR . "functions/" . $name_ . ".php") {
            die('functions not found');
        }
    }

    /**
     * Loads a controller
     * @param type $name_ 
     */
    public static function controller($name_) {

        if (!include_once BASE_DIR . "controllers/" . $name_ . ".php") {
            die('controller not found');
        }
    }

    /**
     * Loads a model class
     * @param type $name_ 
     */
    public static function model($name_) {

        if (!include_once BASE_DIR . "models/" . $name_ . ".php") {
            die('model not found');
        }
    }

    /**
     * Loads from the app folder
     * @param type $name_ 
     */
    public static function app($name_) {
        if (!include_once BASE_DIR . "app/" . $name_ . ".php") {
            die('app not found');
        }
    }

    /**
     * Loads all the plugins included in the config.php
     * @global type $plugins 
     */
    public static function all_plugins() {
        global $plugins;
        foreach ($plugins as $plugin) {
            Load::plugin($plugin);
        }
    }
    /**
     * Loads specific plugin
     * @global type $plugin_controllers
     * @param type $plugin 
     */
    public static function plugin($plugin) {

        global $plugin_controllers;


        $confs = Load::plugin_conf($plugin);

        foreach ($confs as $conf_name => $conf) {

            if (is_array($conf)) {

                if ($conf_name == 'css') {
                    foreach ($conf as $c) {
                        Head::instance()->add('<link rel="stylesheet" href="' . BASE_URL . 'plugins/' . $plugin . '/css/' . $c . '.css" type="text/css" />');
                    }
                } else if ($conf_name == 'js') {
                    foreach ($conf as $c) {
                        Head::instance()->add('<script type="text/javascript" src="' . BASE_URL . 'plugins/' . $plugin . '/js/' . $c . '.js"></script> ');
                    }
                } else if ($conf_name == 'controllers') {
                    foreach ($conf as $c) {
                        //  Load::script('plugins/' . $plugin . '/controllers/' . $c );
                        $plugin_controllers[$c] = $plugin;
                    }
                } else if ($conf_name == 'classes') {
                    foreach ($conf as $c) {
                        Load::script('plugins/' . $plugin . '/classes/' . $c);
                    }
                } else if ($conf_name == 'onload') {
                    foreach ($conf as $c) {
                        include_once BASE_DIR . 'plugins/' . $plugin . '/' . $c . '.php';
                    }
                }
            } else if ($conf) {

                if ($conf_name == 'css') {
                    Head::instance()->add('<link rel="stylesheet" href="' . BASE_URL . 'plugins/' . $plugin . '/css/' . $conf . '.css" type="text/css" />');
                } else if ($conf_name == 'js') {
                    Head::instance()->add('<script type="text/javascript" src="' . BASE_URL . 'plugins/' . $plugin . '/js/' . $conf . '.js"></script> ');
                } else if ($conf_name == 'controllers') {
                    $plugin_controllers[$conf] = $plugin;
                } else if ($conf_name == 'classes') {
                    Load::script('plugins/' . $plugin . '/classes/' . $conf);
                } else if ($conf_name == 'onload') {
                    include_once BASE_DIR . 'plugins/' . $plugin . '/' . $conf . '.php';
                }
            }
        }
    }

    private static function plugin_conf($name_) {

        if (!include_once BASE_DIR . "plugins/" . $name_ . "/manifest.php") {
            die('manifest for the ' . $name_ . ' plugin not found');
        }

        if (is_array($conf)) {
            return $conf;
        } else {
            die('conf not found in ' . $name_ . ' manifest ');
        }
    }
    /**
     * Includes once , a script 
     * @param type $name_ 
     */
    public static function script($name_) {
        if (!include_once BASE_DIR . $name_ . ".php") {
            die('script not found');
        }
    }
    /**
     * Loads a plugins view
     * @param type $plugin_name_ the plugin name
     * @param type $name_ the name of the view
     * @param boolen $return_as_string
     * @return type 
     */
    public static function plugin_view($plugin_name_, $name_, $return_as_string = false) {

        foreach (self::$vars as $key => &$value) {
            $$key = &$value;
        }
        if ($return_as_string) {

            ob_start();
            ob_flush();
            eval(" ?> " . file_get_contents(BASE_DIR . "plugins/" . $plugin_name_ . '/views/' . $name_ . ".php") . " <?php ");
            $content = ob_get_contents();
            ob_clean();
            return $content;
        } else {
            if (!include BASE_DIR . "plugins/" . $plugin_name_ . '/views/' . $name_ . ".php") {
                die('plugin view not found');
            }
        }
    }
    /**
     * Loads a plugin model
     * @param type $plugin_name_ plugin name
     * @param type $name_  the name of the model
     */
    public static function plugin_model($plugin_name_, $name_) {
        if (!include_once BASE_DIR . "plugins/" . $plugin_name_ . '/models/' . $name_ . ".php") {
            die('plugin model not found');
        }
    }
    /**
     * Loads a plugin controller
     * @param type $plugin_name_ plugin name
     * @param type $name_  the name of the controller
     */
    public static function plugin_controller($plugin_name_, $name_) {
        if (!include_once BASE_DIR . "plugins/" . $plugin_name_ . '/controller/' . $name_ . ".php") {
            die('plugin controller not found');
        }
    }

}

?>