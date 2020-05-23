<?php

class RegisterController extends Controller {

    public function main() {

        $this->no_layout();

        URL::redirect('');
    }

    

    private function clear_pass() {
        $_POST['pass'] = '';
        $_POST['rpass'] = '';
    }

}
