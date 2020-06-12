<?php

Load::plugin_model('membership', 'user');
Load::plugin_model('membership', 'role');
Load::plugin_model('membership', 'permission');
Load::plugin_model('membership', 'known_session');

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

    public function masterLoginCheck($session_duration = 0) {

        $this->user = $this->getUserFromSession();
       
                
        if ($this->user->user_id) {
            // if there is an id , make sure we have the user id the database
            $u = User::find_by_id($this->user->user_id);
            
            if ($u) {
                
                $session_id = $this->user->session_id;                
                $validSession = KnownSession::is_valid($this->user->user_id,$session_id , time());
                
                if($validSession){
                    
                    $permissions = $this->user->permissions;
                    $this->user = $u;
                    $this->user->session_id = $session_id;
                    $this->user->password_2 = null;
                    $this->user->is_logged = true;
                    $this->user->permissions = $permissions;
                    
                    KnownSession::update_session($validSession->id,$session_duration ? $session_duration : time() + MEMBERSHIP_COOKIE_DURATION);
                    
                } else {
                     $this->user = new User();
                }
                
            } else {
                $this->user = new User();
            }
            
        } else {

            $this->user = $this->validate_user($this->get_user_from_cookie());
        }

        return $this->user;
    }

    public function validate_user($user , $valid_until = 0) {
        if ($user) {
                        
            $session_id = $user->session_id;

            $u = User::find_user(null, null, $session_id , $valid_until);

            $permissions = $user->permissions;

            $user = $u ? $u : new User();
            $user->password_2 = null;

            if ($u) {
                $user->is_logged = true;
                $user->session_id = $session_id;
            }
            $user->permissions = $permissions;

            $this->storeUserToSession($user);
        } else {
            $user = new User();
        }

        return $user;
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

    public function encript_user($user) {
        $user->valid_until = time() + MEMBERSHIP_COOKIE_DURATION;
        $cookie_value = json_encode($user);
        $string_to_encrypt = $cookie_value;
        $password = "my-enc-key-19!";
        return openssl_encrypt($string_to_encrypt, "AES-128-ECB", $password);
    }

    public function decript_user($string_to_decrypt) {
        $password = "my-enc-key-19!";
        $decrypted_string = openssl_decrypt($string_to_decrypt, "AES-128-ECB", $password);
        return json_decode($decrypted_string);
    }

    public function get_user_from_cookie() {
        if (isset($_COOKIE['logged_user'])) {
            return $this->user = $this->decript_user($_COOKIE['logged_user']); // json_decode($decrypted_string);
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
        $encrypted = $this->encript_user($user);
        setcookie($cookie_name, $encrypted, time() + MEMBERSHIP_COOKIE_DURATION, "/"); // sec * min * hours
    }

    public function storeUserToSession($user) {
        $_SESSION['logged_user'] = json_encode($user);
    }

    public static function has($permission) {
        return in_array($permission, Membership::instance()->user->permissions);
    }

    public function uuid($data) {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
