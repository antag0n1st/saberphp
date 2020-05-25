<?php

Load::plugin_model('membership', 'user');
Load::plugin_model('membership', 'role');
Load::plugin_model('membership', 'permission');

class Membership {

    //put your code here
    private static $instance = false;

    /**
     *
     * @var User 
     */
    public $user = null;

    /**
     *
     * @return Membership 
     */
    public static function instance() {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new Membership();
        return self::$instance;
    }

    public function __construct() {

        if (!$this->session_started()) {

            session_start();

            $timeout = MEMBERSHIP_COOKIE_DURATION;
            $now = time();

            if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
                // this session has worn out its welcome; kill it and start a brand new one
                session_unset();
                session_destroy();
                session_start();
            }

            $_SESSION['discard_after'] = $now + $timeout;
        }
        Load::plugin_model('membership', 'user');
    }

    public function html_login_menu() {
        Load::plugin_view('membership', 'login_menu');
    }

    public function masterLoginCheck() {

        $this->user = $this->getUserFromSession();

        if ($this->user->user_id) {
            // if there is an id , make sure we have the user id the database
            $u = User::find_by_id($this->user->user_id);

            if ($u and $u->session_id and $u->session_id == $this->user->session_id) {
                $permissions = $this->user->permissions;
                $this->user = $u;
                $this->user->password_2 = null;
                $this->user->is_logged = true;
                $this->user->permissions = $permissions;
            } else {
                $this->user = new User();
            }
            
        } else {

            $this->user = $this->get_user_from_cookie();
            
            if($this->user){
                
                $u = User::find_user(null, null, $this->user->session_id);

                $permissions = $this->user->permissions;

                $this->user = $u ? $u : new User();
                $this->user->password_2 = null;

                if ($u) {
                    $this->user->is_logged = true;
                }
                $this->user->permissions = $permissions;

                //TODO reload the user into a session
                $this->storeUserToSession($this->user);
                
            } else {                
                $this->user = new User();                
            }
            
        }

        return $this->user;
    }

    private function session_started() {

        if (isset($_SESSION)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserFromSession() {

        if (isset($_SESSION['logged_user'])) {

            return $this->user = json_decode($_SESSION['logged_user']);
        } else {
            return new User();
        }
    }

    public function get_user_from_cookie() {
        if (isset($_COOKIE['logged_user'])) {

            $string_to_decrypt = $_COOKIE['logged_user'];
            $password = "my-enc-key-19!";
            $decrypted_string = openssl_decrypt($string_to_decrypt, "AES-128-ECB", $password);

            return $this->user = json_decode($decrypted_string);
        } else {
            return new User();
        }
    }

    public function clear_user_data() {
        unset($_SESSION['logged_user']);
        session_destroy();
        setcookie("logged_user", "", time() - 3600, "/");
    }

    public function store_user_to_cookie($user) {
        $cookie_name = "logged_user";
        $cookie_value = json_encode($user);

        $string_to_encrypt = $cookie_value;
        $password = "my-enc-key-19!";
        $encrypted = openssl_encrypt($string_to_encrypt, "AES-128-ECB", $password);

        setcookie($cookie_name, $encrypted, time() + MEMBERSHIP_COOKIE_DURATION, "/"); // sec * min * hours
    }

    public function storeUserToSession($user) {
        $_SESSION['logged_user'] = json_encode($user);
    }

    public static function has($permission) {
        return in_array($permission, Membership::instance()->user->permissions);
    }

}
