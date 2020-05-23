<?php

Load::script('controllers/admin');

class HomeController extends AdminController {

    public function __construct() {
        parent::__construct();
        
    }

    public function main() {
      $this->set_menu('home');
    }

    public function about() {
       
    }

    public function contact() {
        
    }

}
