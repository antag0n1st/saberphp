<?php

Load::controller('admin');

class ErrorsController extends AdminController{
    
    
    public function main(){
        
        Load::model('error_logger');
        
        $errors = ErrorLogger::get_last_errors(20);
        
        Load::assign('errors', $errors);
        
    }
    
}
