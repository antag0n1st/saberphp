<?php

class OopsController extends Controller {


    public function main() {
        global $layout;
        $layout = null;
    }

    public function error_404() {

        $this->set_layout(NULL);
        
        Load::view('oops/error_404_flatlab');
    }

    public function no_privileges() {
         $this->set_layout(NULL);
        
        Load::view('oops/error_403_flatlab');
    }

}

?>