<?php

class AuthenticationController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->set_layout('authentication');
        Load::script('public/admin_include');

        Membership::instance();
    }

    public function main() {
        $this->no_layout();
    }

    public function login() {

        $this->set_view('../login');

        if (isset($_POST) and $_POST) {
            /* @var $user User */
            $user = User::find_user($this->get_post('username'), $this->get_post('password'));

            if ($user) {

              //  $user->login_type = User::$STANDARD;
                $session_id = Strings::GUID();
                
                $user->session_id = $session_id;
                $user->last_logged_at = TimeHelper::DateTimeAdjusted();
                $user->login_count++;
                $user->save();
                
                KnownSession::delete_invalid_sessions($user->user_id);
                
                $ks = new KnownSession();
                $ks->session_id = $session_id;
                $ks->user_id = $user->user_id;
                $ks->valid_until = time() + MEMBERSHIP_COOKIE_DURATION;
                $ks->created_at = TimeHelper::DateTimeAdjusted();
                $ks->save();
                

                // safly remove the password so that it is not stored
                $user->password_2 = null;
                Membership::instance()->storeUserToSession($user);
                Membership::instance()->store_user_to_cookie($user);

                Hooks::apply('user_logged', $user);
                
                URL::redirect('admin');
            } else {

                $error_message = 'Authentication Failed';
                $this->set_error($error_message);
            }
        }
    }

    public function logout() {
        
        Hooks::apply('user_logout', isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : null);
      
        $user = Membership::instance()->getUserFromSession();
        if($user){
            if($user->session_id){
                 $knownSession = KnownSession::find_valid(Membership::instance()->user->session_id, time());
                 if($knownSession){
                     $knownSession->delete();
                 }
            }
        }
     
        Membership::instance()->clear_user_data();
                
        URL::redirect('login');
    }

    public function register() {

        $this->set_view('../register');

        if (isset($_POST) and $_POST) {

            Load::plugin_model('membership', 'user');

            $user = new User();
            $user->username = $this->get_post('username');

            $pass = $this->get_post('password');
            $rpass = $this->get_post('repeat_password');

            if (strlen($user->username) < 3) {
                $this->set_error('Username must be at least 3 characters long');
                $this->clear_pass();
                return;
            }

            $u = User::find_by_username($user->username);

            if ($u) {
                $this->set_error("The username <b>" . $u->username . "</b> is already registered!");
                $_POST['username'] = '';
                return;
            }

            if (strlen($pass) < 4) {
                $this->set_error('Password must be at least 4 characters long');
                $this->clear_pass();
                return;
            }

            if ($pass != $rpass) {
                $this->set_error("Passwords do not match");
                $this->clear_pass();
                return;
            }


            $user->user_id = NULL;
            
            $user->password_2 = md5($pass);
          
            $user->created_at = TimeHelper::DateTimeAdjusted();
            $user->last_logged_at = TimeHelper::DateTimeAdjusted();
            $user->user_level = 0;
            $user->login_count = 0;
            $user->email = $this->get_post('email');
            $user->full_name = $this->get_post('first_name').' '.$this->get_post('last_name');
            $user->save();

            if (HOST_ID == 0) {
                Load::helper('mailer');
                $msg = "User with \nusername: " . $user->username . " \n";
                Mailer::send(MAIL_INFO, MAIL_ADMIN, 'new user created', $msg, false);
            }

            $this->set_confirmation('Registered!');
            
            Hooks::apply('user_created', $user);
            
            URL::redirect('login');
        }
    }
    
    public function forgot_password() {

        if (isset($_POST) and $_POST) {
            $email = $this->get_post('email');
            
           // Load::plugin_model('membership', 'user');

            $user = User::find_by_email($email);

            if ($user) {
                /* @var $user User */
                $user->reset_code = Strings::GUID();
                $user->save();
                Load::helper('mailer');
                $message = "Please visit this link \n";
                $message .= "<a href=\"" . URL::abs('authentication/reset-password/' . $user->reset_code) . "\">" . URL::abs('authentication/reset-password/' . $user->reset_code) . "</a>";
                $message .= " It will guide you to restore you'r password";
                Mailer::send(MAIL_ADMIN, $user->email, 'Password reset', $message);
                
                $this->set_confirmation("Your account password was reseted!");
                
                
            } else {
                $this->set_error("This is email is not registered with us!");
            }
        }
        
        URL::redirect_to_refferer();
        
    }

    public function reset_password($uuid = '') {
        
        $this->set_view('../reset_password');
        
        if (isset($_POST) and $_POST) {
            $user = User::find_by_reset_code($uuid);

            $pass = $this->get_post('password');
            $rpass = $this->get_post('password_repeat');

            if ($pass != $rpass) {
                $this->set_error('passwords dont match');
                $this->clear_pass();
                return;
            }
            
            if($pass == ''){
                $this->set_error('Password must not be empty space');
                $this->clear_pass();
                return;
            }

            if ($user) {
                /* @var $user User */
                $user->password_2 = md5($this->get_post('password'));
                $user->reset_code = '';
                $user->save();

                URL::redirect('');
            } else {
                $this->set_error('This link is broken');
            }
        }
        
    }

   

    private function clear_pass() {
        $_POST['password'] = '';
        $_POST['password_repeat'] = '';
    }

}
