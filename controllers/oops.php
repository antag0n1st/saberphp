<?php

    class OopsController extends Controller{
        
        public function main(){
            global $layout;
            $layout = null;
        }
        
        public function error_404(){
            global $layout;
            $layout = null;
            
            Load::view('oops/error_404');
            
        }
        public function no_privileges(){
            global $layout;
            $layout = null;
            
            Load::view('oops/no_privileges');
        }
        
    }
?>