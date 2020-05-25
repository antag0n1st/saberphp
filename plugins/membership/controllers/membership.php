<?php



class MembershipController extends Controller {

    function __construct() {
        global $view;
        $view = null;
    }

    public function logout() {

        Membership::instance()->clear_user_data();

        if( isset($_SERVER['HTTP_REFERER']) )
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        else
            header('Location: /api/admin');
        exit;
    }

    public function login($lt = 'standard') {
        if ($lt == 'standard') {
            if (isset($_POST) and $_POST) {
                /* @var $user User */
                $user = User::find_user($this->get_post('username'), $this->get_post('password'));

                if ($user) {

               
                    $user->session_id = Strings::GUID();
                    $user->last_logged_at = TimeHelper::DateTimeAdjusted();
                    $user->login_count++;
                    $user->save();

                    // safly remove the password so that it is not stored
                    $user->password_2 = null;

                    //Membership::instance()->storeUserToSession($user);
                   // Membership::instance()->store_user_to_cookie($user);
                } else {
                    
                    $error_message = urlencode('Authentication Failed');
                    echo $_SERVER['HTTP_REFERER']."?_error=".$error_message;
                    exit;
                    header('Location:  ' . $_SERVER['HTTP_REFERER']."?_error=".$error_message);
                    exit;
                }
                
            }
            
            header('Location:  ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    

}

?>
