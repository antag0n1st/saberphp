<?php

/**
 * Description of Membership
 * @property Facebook $facebook
 * @property User $user
 * @property string $fb_user
 * @author Antagonist
 */
Load::plugin_model('membership', 'user');
Load::plugin_model('membership', 'role');
Load::plugin_model('membership', 'permission');

class Membership {

    //put your code here
    private static $instance = false;
    public $loginUrl = '';
    public $logoutUrl = '';

    /**
     *
     * @var User 
     */
    public $user = null;
    public $redirect_url = null;

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

        $this->start_session();

        $timeout = 60 * 60 * 1; // 1 hour
        $now = time();

        if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
            // this session has worn out its welcome; kill it and start a brand new one
            session_unset();
            session_destroy();
            session_start();
        }

        $_SESSION['discard_after'] = $now + $timeout;
    }

    public static function is_allowed() {

        $user = Membership::instance()->user;
        global $_roles;

        if ($_roles & $user->user_level) {
            return true;
        } else {
            return false;
        }
    }

    public static function allowed_for($roles) {
        $user = Membership::instance()->user;
        if ($roles & $user->user_level) {
            return true;
        } else {
            return false;
        }
    }

    public function masterLoginCheck() {

        $this->user = $this->getUserFromSession();
        
       

        if ($this->user and $this->user->user_id) {
            // if there is an id , make sure we have the user id the database
            $permissions = $this->user->permissions;
            
            $u = User::find_by_id($this->user->user_id);

            if ($u and $u->session_id and $u->session_id == $this->user->session_id) {
                $u->permissions = $permissions;
                $this->user = $u;
                $this->user->password_2 = null;
                $this->store_user_to_cookie($this->user);
                $this->storeUserToSession($this->user);
                $this->user->is_logged = true;
                
            } else {
                $this->user = new User();
            }
        } else {

            $this->user = $this->get_user_from_cookie();

            if ($this->user) {

                $u = User::find_user(null, null, $this->user->session_id);

                $this->user->password_2 = null;

                if ($u) {
                    $this->store_user_to_cookie($this->user);
                    $this->storeUserToSession($this->user);

                    $this->user->is_logged = true;

                    $u->last_logged_at = date("Y-m-d H:i:s");
                    $u->save();
                }
            } else {
                $this->user = new User();
            }
        }

        return $this->user;
    }

    private function start_session() {
        if (session_status() == PHP_SESSION_NONE) {
            @session_start();
        }
    }

    public function getUserFromSession() {

        if (isset($_SESSION['logged_user'])) {
            return $this->user = json_decode($_SESSION['logged_user']);
        } else {
            return null;
        }
    }

    public function get_user_from_cookie() {
        if (isset($_COOKIE['logged_user'])) {
            return $this->user = json_decode($_COOKIE['logged_user']);
        } else {
            return null;
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
        setcookie($cookie_name, $cookie_value, time() + MEMBERSHIP_COOKIE_DURATION, "/"); // sec * min * hours
    }

    public function storeUserToSession($user) {
        $_SESSION['logged_user'] = json_encode($user);
    }
    
    public static function has($permission){
        return in_array($permission, Membership::instance()->user->permissions);
    }

}

?>
