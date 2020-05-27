<?php

Load::script('controllers/admin');

class HomeController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function main() {

        $this->set_menu('home');
        
//        $this->no_layout();
        
//        $r = Student::select()->where('counter','<',2)->execute();
//        
//        var_dump($r);
        
    }

}
