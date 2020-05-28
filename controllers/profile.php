<?php

Load::controller('admin');

class ProfileController extends AdminController {

    public function main() {

        $this->set_menu('profile');
        $this->set_view('profile');

        Head::instance()->load_css('../flatlab/assets/bootstrap-datepicker/css/datepicker');
        Head::instance()->load_js('../flatlab/assets/bootstrap-datepicker/js/bootstrap-datepicker');
        
        $uploadify = new Uploadify();
        $uploadify->set_size(300, 300 , Uploadify::SCALE_MODE_FIL);
        $uploadify->set_thumbnail('thumb',32,32);
        Load::assign('uploadify', $uploadify);

        if (isset($_POST) and $_POST) {
            if ($this->get_post('form') == "profile") {
                $this->update_profile();
            } else if ($this->get_post('form') == "password") {
                $this->update_password();
            }
        }
    }

    private function update_profile() {
        
        $id = Membership::instance()->user->user_id;
        
        User::query()->update([
            'full_name' => $this->get_post('full_name'),
            'email' => $this->get_post('email')
        ])->where('user_id', $id)->execute();

        $profile = UserProfile::select()->where('users_user_id', $id)->execute()[0];
        $profile->date_of_birth = TimeHelper::prep_for_db($this->get_post('birthday'));
        $profile->contact = $this->get_post('contact');
        $profile->profile_image = $this->get_post('profile_image');
        $profile->save();

        $this->set_confirmation("Updated!");

        URL::redirect_to_refferer();
    }

    private function update_password() {

        $old_password = $this->get_post('old_password');
        $new_password = $this->get_post('new_password');
        $new_password_repeat = $this->get_post('new_password_repeat');

        if (!$new_password || !$old_password) {
            $this->set_error("Password must not be empty!");
        } else if ($new_password != $new_password_repeat) {
            $this->set_error("Passwords must match");
        } else {
            if (User::update_password(Membership::instance()->user->user_id, $old_password, $new_password)) {
                $this->set_confirmation('Success!');
            } else {
                $this->set_error('Invalid password');
            }
        }

        URL::redirect_to_refferer();
    }

}
