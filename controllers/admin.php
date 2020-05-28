<?php

class AdminController extends Controller {

    //NOTE !!! Do not add methods in here unless they are planned to be shared
    // accross the other controllers for the administration

    public function __construct() {
        parent::__construct();

        $this->no_trackng();
        $this->set_layout('flatlab_layout');

        Membership::instance()->masterLoginCheck();

        global $controller, $action;


        if (!Membership::instance()->user->is_logged and URL::current_page_url() === URL::abs('login')) {
            
        } else if (!Membership::instance()->user->is_logged) {

//            if($controller === "newsletter" and $action === "send_newsletter"){
//                
//            } else if($controller === "remainders" and $action === "send_remainders"){
//                
//            } else if($controller === "events" and $action === "update_recurring_events"){
//                
//            } else {
            URL::redirect('login');
//            }
        } else {

            // load user profile , so that you can show the profile image
            
            Load::model('user_profile');

            $id = Membership::instance()->user->user_id;

            $result = UserProfile::select()->where('users_user_id', $id)->execute();
            if (count($result)) {
                $profile = $result[0];
            } else {
                $profile = new UserProfile();
                $profile->users_user_id = $id;
                $profile->date_of_birth = TimeHelper::DateTimeAdjusted();
                $profile->save();
            }
            
            $profile_image = new Image($profile->profile_image);
            if(!$profile->profile_image){
                $profile_image->url = 'blank_profile.jpg';
            }
//            $profile_image = $profile->profile_image ? $profile->profile_image : 'blank_profile.jpg';
            Load::assign('profile_image', $profile_image);
            
            Load::assign('profile', $profile);
            
        }

        Load::script('public/admin_include');
    }

    /**
     * It will overwrite all the roles
     * that where defined previously
     * 
     * @global type $_roles
     * @param type $roles
     * @param type $check 
     */
    protected function allow($roles, $check = true) {
        global $_roles;
        $_roles = $roles;
        if ($check) {
            $this->check();
        }
    }

    /**
     * It will remove only the specified roles 
     * 
     * @global type $_roles
     * @param type $roles
     * @param type $check
     */
    protected function deny($roles, $check = true) {
        global $_roles;
        $_roles &= (~$roles);
        if ($check) {
            $this->check();
        }
    }

    protected function check() {
        if (!Membership::is_allowed()) {
            $this->set_error('Access is denied!');
            URL::redirect('login');
        }
    }

    //NOTE !!! Do not add methods in here unless they are planned to be shared
    // accross the other controllers for the administration

    public function main() {
        //$this->set_view('dashboard');
        URL::redirect('');
    }

    //NOTE !!! Do not add methods in here unless they are planned to be shared
    // accross the other controllers for the administration
}
