<?php
    class IndexController extends Controller {
        public function main(){    
          global $view;
          $view = 'home_page';
        }
        
        private function test(){
            global $view;
            $view = null;
        }
        
        public function _inaccessible_public_method(){}
    }
?>