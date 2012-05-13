<?php

class FbUser {
    
    public $id;
    
    public $username = "";
    public $fb_id = "";
    public $first_name;
    public $last_name;
    public $fb_link;
    public $email;
    public $user_id;
    public $image_url;
    
    
    
    
    public function __construct($username = "", $fb_id = "" , $first_name = '', $last_name = '' , $email ='', $fb_link ='') {
        
        $this->username   = $username;
        $this->fb_id      = $fb_id;
        $this->first_name = $first_name;
        $this->last_name  = $last_name;
        $this->email      = $email;
        $this->fb_link    = $fb_link;
    }
    
    public function checkUserExists(){
        
        $query  = " SELECT * from facebook_users ";
        $query .= " WHERE ";
        $query .= " fb_id = '".Model::db()->prep($this->fb_id)."' ";
        
        $result = Model::db()->query($query);
        
         if(Model::db()->affected_rows_count() == 1){            
            
           $this->dbToObject($result);
           
           return true;
            
        } else {
           return false;
        }
        
        
    }
    
    public function saveFbUser(){
        
        $query  = " INSERT INTO facebook_users";
           $query .= " (`id`, `fb_id`, `username`, `first_name`, `last_name`, `email`, `fb_link`, `shared`, `date_logged_in` , `user_id_fk` , `image_url`) ";
           $query .= " VALUES ";
           $query .= " ( NULL,";
           $query .= " '".Model::db()->prep($this->fb_id)."' , ";
           $query .= " '".Model::db()->prep($this->username)."' , ";
           $query .= " '".Model::db()->prep($this->first_name)."' , ";
           $query .= " '".Model::db()->prep($this->last_name)."' , ";
           $query .= " '".Model::db()->prep($this->email)."' , ";
           $query .= " '".Model::db()->prep($this->fb_link)."' , ";
           $query .= " 0 , ";
           $query .= " NOW() , ";
           $query .= " '".Model::db()->prep($this->user_id)."' , ";
           $query .= " '".Model::db()->prep('https://graph.facebook.com/'.$this->fb_id.'/picture')."'  ";
           $query .= " ) ";
           // 
           Model::db()->query($query);
        
    }
    
    private function dbToObject($result){
        
            $row = mysql_fetch_array($result);
            
            $this->id                   = $row['id'];
            $this->fb_id                = $row['fb_id'];
            $this->username             = $row['username'];
            $this->first_name           = $row['first_name'];
            $this->last_name            = $row['last_name'];
            $this->email                = $row['email'];
            $this->fb_link              = $row['fb_link'];
            $this->share                = $row['shared'];
            $this->user_id              = $row['user_id_fk'];
            $this->image_url            = $row['image_url'];
        
        
    }
    
    
}

?>
