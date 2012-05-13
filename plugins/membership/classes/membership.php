<?php

/**
 * Description of Membership
 * @property Facebook $facebook
 * @property User $user
 * @property string $fb_user
 * @author Antagonist
 */
class Membership {

    //put your code here
    private static $instance = false;
    public $fb_user = null;
    public $loginUrl = '';
    public $logoutUrl = '';
    public $facebook = null;
    /**
     *
     * @var User 
     */
    public $user = null;
    public $redirect_url = null;
    private $get_current_url = null;
    private static $DROP_QUERY_PARAMS = array(
        'code',
        'state',
        'signed_request',
    );

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
        }
        Load::plugin_model('membership', 'user');
    }

    public function html_login_menu() {
        Load::plugin_view('membership', 'login_menu');
    }

    public function masterLoginCheck() {
        $this->user = $this->getUserFromSession();
        if ($this->user->id) { // ako ima id
        } else if (isset($_GET['login']) and $_GET['login'] == 'facebook') {
            $this->initFacebook();
            $this->facebookLoginCheck();
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

    public function storeUserToSession($user) {
        $_SESSION['logged_user'] = json_encode($user);
    }

    public function getUserByUsername($username) {
        $user = new User();
        $user->username = $username;

        $user->LoadUserByUsername();

        if (isset($user->id) and
                is_numeric($user->id) and
                $user->id > 0
        ) {
            return $user;
        }
        return null;
    }

    public function checkUsernameAvailability($username) {
        $db = new Database();
        $query = " SELECT * from users ";
        $query .= " WHERE ";
        $query .= " username = '" . $db->prep($username) . "' ";

        $result = $db->query($query);

        return $db->affected_rows_count();
    }

    public function initFacebook() {


        Load::plugin_model('membership', 'facebook/base_facebook');
        Load::plugin_model('membership', 'facebook/facebook');




        $this->facebook = new Facebook(array(
                    'appId' => FACEBOOK_APP_ID,
                    'secret' => FACEBOOK_APP_SECRET,
                    'cookie' => true,
                ));

        $this->fb_user = $this->facebook->getUser();



        if ($this->fb_user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $this->fb_user = null;
            }
        }

        // Login or logout url will be needed depending on current user state.
        if ($this->fb_user) {
            $this->logoutUrl = $this->facebook->getLogoutUrl();
        } else {
            $this->loginUrl = $this->facebook->getLoginUrl(
                    array(
                        'scope' => 'publish_stream,user_likes,offline_access,user_online_presence,friends_online_presence,email,user_about_me,friends_about_me,user_birthday,friends_birthday,friends_likes,user_groups,friends_groups' , 
                        'redirect_uri' => $this->redirect_url
                    )
            );
        }
    }

    /**
     * Returns the Current URL, stripping it of known FB parameters that should
     * not persist.
     *
     * @return string The current URL
     */
    public function getCurrentUrl() {

        if ($this->get_current_url) {
            return $this->get_current_url;
        }

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
                || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = parse_url($currentUrl);

        $query = '';
        if (!empty($parts['query'])) {
            // drop known fb params
            $params = explode('&', $parts['query']);
            $retained_params = array();
            foreach ($params as $param) {
                if ($this->shouldRetainParam($param)) {
                    $retained_params[] = $param;
                }
            }

            if (!empty($retained_params)) {
                $query = '?' . implode($retained_params, '&');
            }
        }

        // use port if non default
        $port =
                isset($parts['port']) &&
                (($protocol === 'http://' && $parts['port'] !== 80) ||
                ($protocol === 'https://' && $parts['port'] !== 443)) ? ':' . $parts['port'] : '';

        // rebuild
        return $this->get_current_url = $protocol . $parts['host'] . $port . $parts['path'] . $query;
    }

    /**
     * Returns true if and only if the key or key/value pair should
     * be retained as part of the query string.  This amounts to
     * a brute-force search of the very small list of Facebook-specific
     * params that should be stripped out.
     *
     * @param string $param A key or key/value pair within a URL's query (e.g.
     *                     'foo=a', 'foo=', or 'foo'.
     *
     * @return boolean
     */
    protected function shouldRetainParam($param) {
        foreach (self::$DROP_QUERY_PARAMS as $drop_query_param) {
            if (strpos($param, $drop_query_param . '=') === 0) {
                return false;
            }
        }

        return true;
    }

    public function facebookLoginCheck(){
        
          if(!$this->fb_user){ return false; }
        
                    $username = "";
                    $fb_id = "";
                    $first_name = "";
                    $last_name = "";
                    $email = "";
                    $fb_link = "";
                    $user_profile = $this->facebook->api('/me');
                    
                    if(isset ($user_profile['name'])){
                        
                        $username = $user_profile['name'];
                    }
                    if(isset ($user_profile['id'])){
                        $fb_id = $user_profile['id'];
                    }
                    if(isset ($user_profile['first_name'])){
                        $first_name = $user_profile['first_name'];
                    }
                    if(isset ($user_profile['last_name'])){
                        $last_name = $user_profile['last_name'];
                    }
                    if(isset ($user_profile['email'])){
                        $email = $user_profile['email'];
                    }
                    if(isset ($user_profile['link'])){
                        $fb_link = $user_profile['link'];
                    }
                    
                    Load::script('plugins/membership/models/fb_user');
                    
                    $fuser = new FbUser();
                    $fuser->fb_id = $fb_id;
                    $fuser->username = $username;
                    $fuser->first_name = $first_name;
                    $fuser->last_name  = $last_name;
                    $fuser->email       = $email;
                    $fuser->image_url = 'https://graph.facebook.com/'.$fuser->fb_id.'/picture';
                    $fuser->fb_link = $fb_link;
                    
                    if($fuser->checkUserExists()){
                        
                        $user = new User();
                        $user->id       = $fuser->user_id;
                        $user->login_type = User::$FACEBOOK;
                        $user->LoadUserFromId();
                        $user->update();
                        $this->storeUserToSession($user);
                        if(isset($_SERVER['HTTP_REFERER'])){
                            header('Location:  '.$_SERVER['HTTP_REFERER']);
                            exit;
                        }else{
                            URL::redirect('');
                        }
                        
                        
                    }else{
                        
                        $user = new User();
                        
                        $howManyUsersWithSameUsername = $this->checkUsernameAvailability($user_profile['name']);
                        
                        if($howManyUsersWithSameUsername == 0)
                        {
                            $user->username = $fuser->username;
                        }
                        else // if there are multiple people with the same username, append a number at the end of the username
                        {
                            $user->username = $fuser->username . $howManyUsersWithSameUsername;
                        }
                        
                        $user->email    = $fuser->email;
                        $user->image_url = $fuser->image_url;
                        $user->login_type = User::$FACEBOOK;
                        $user->save();
                        $this->storeUserToSession($user);
                        $fuser->user_id = $user->id;
                        $fuser->saveFbUser();
                        
                        if(isset($_SERVER['HTTP_REFERER'])){
                            header('Location:  '.$_SERVER['HTTP_REFERER']);
                            exit;
                        }else{
                            URL::redirect('');
                        }
                        
                    }
                    $this->user = $user;
                        
    }

    public function pleseLoginMessage($msg = '') {
        if ($this->user->id) { // you dont need login message if the user is logged.
            return;
        }



        $code = md5(uniqid(rand(), true));

        echo "<span id='login-message-$code'></span>
            <script type=\"text/javascript\">
            //<![CDATA[
                $(document).ready(function(){
                 $('#login-message-$code').html('<a href=\"" . URL::abs('membership/login/facebook?redirect_url=' . urlencode(Membership::instance()->getCurrentUrl()))
        . "\">Најавете се преку Facebook</a> или <a onclick=\"return show_anonymous_login();\" class=\"anonymous-login\" href=\"#\">Анонимно</a> $msg');
                });
                
            //]]>
            </script>";
    }

}

?>
