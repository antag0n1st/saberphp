<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Antagonist
 */
class User {
    //put your code here
    public $id;
    public $username;
    public $email;
    public $password;
    public $last_login_date;
    public $login_count;
    public $date_created;
    public $image_url;
    public $login_type;
    public $user_level;
    public $full_name;
    public $bio;
    
    public static $FACEBOOK = 'facebook';
    public static $ANONYMOUS = 'anonymous';
    
 
    
    public $usernameUrl;
    
    public function __construct() {
      
        $this->usernameUrl = "";
    }
    
    public function getUserNameDotSeparated()
    {
        if($this->usernameUrl == "")
        {
            Load::helper('cyrillic_latin');
                $converter = new CyrillicLatin();
                
                
                if(strtolower($this->username) == mb_strtolower($this->username,'UTF-8'))
                {
                    for($i = 0; $i < strlen($this->username); $i++)
                    {
                        if( ctype_alnum($this->username{$i}) )
                        {
                            $this->usernameUrl .= strtolower( $this->username{$i} );
                        }
                        else if($this->username{$i} == " " )
                        {
                            $this->usernameUrl .= ".";
                        }
                    }
                }
                else
                {
                    $this->usernameUrl = $converter->cyrillic2latin(mb_strtolower($this->username,'UTF-8')) ;
                    $this->usernameUrl = str_replace(" ", ".", $this->username);
                }
                
                
                
        }
        
        return $this->usernameUrl;
    }
    
    
    public function LoadUserFromId(){
        
        $query  = " SELECT * from users ";
        $query .= " WHERE ";
        $query .= " user_id = '".Model::db()->prep($this->id)."' ";
         
        $result = Model::db()->query($query);        
       
         if(Model::db()->affected_rows_count() == 1){
            // vekje postoi vakov
             
             $this->dbToObject(mysql_fetch_array($result));            
        }
        
    }
    
    public function LoadUserByUsername(){
        
        $query  = " SELECT * from users ";
        $query .= " WHERE ";
        $query .= " username = '".Model::db()->prep($this->username)."' ";
         
        $result = Model::db()->query($query);        
       
         if(Model::db()->affected_rows_count() == 1){
            // vekje postoi vakov
             $this->dbToObject(mysql_fetch_array($result));            
        }
        
    }
    
    
    public function update(){
        
        $query  = " SELECT * from users ";
        $query .= " WHERE ";
        $query .= " username = '".Model::db()->prep($this->username)."' ";
         
        $result = Model::db()->query($query);        
       
         if(Model::db()->affected_rows_count() == 1){
            // vekje postoi vakov
             $this->dbToObject(mysql_fetch_array($result));
             
             $query  = " UPDATE users SET ";
             $query .= " login_count = ( login_count + 1 ) , ";
             $query .= " last_login_date =  NOW() ,  ";
             $query .= " image_url = '".Model::db()->prep($this->image_url)."'  ";
             $query .= " WHERE ";
             $query .= " username = '".Model::db()->prep($this->username)."' ";
             $query .= " LIMIT 1 ";
             
             Model::db()->query($query);
            
        } 
        
    }
    
    public function save(){
        
        

            
           if($this->isUsernameCyrilic())
           {   Load::helper('cyrillic_latin');
               $converter = new CyrillicLatin();
               $this->username = $converter->cyrillic2latin($this->username);
           }
        
        
           $query  = " INSERT INTO users";
           $query .= " (`user_id`, `username`, `password` , `email`, `date_created` , `last_login_date` , `login_count` , `image_url`) ";
           $query .= " VALUES ";
           $query .= " ( NULL,";
           $query .= " '".Model::db()->prep($this->username)."' , ";
           $query .= " 'fb_account_zx32nj83_zasekojslucaj' , ";
           $query .= " '".Model::db()->prep($this->email)."' , ";
           $query .= " NOW() , ";
           $query .= " NOW() , ";
           $query .= " 0 , ";
           $query .= " '".Model::db()->prep($this->image_url)."'  ";
           $query .= " ) ";
           
           Model::db()->query($query);
           
           $this->id = Model::db()->last_inserted_id();
           
        //   return $this->checkUserExists();
           
      //  }
        
    }
    
    public function loadSettings()
    {
//        $settings = new UserSettings();
//        $settings->loadByUserId($this->id);
        
        return $settings;
    }
    
    
    public function dbToObject($row){
        
         //   $row = mysql_fetch_array($result);
            
            $this->id                   = $row['user_id'];
            $this->username             = $row['username'];
            $this->email                = $row['email'];
            $this->last_login_date      = $row['last_login_date'];
            $this->login_count          = $row['login_count'];
            $this->date_created         = $row['date_created'];
            $this->password             = $row['password'];
            $this->image_url            = $row['image_url'];
            $this->user_level           = $row['user_level'];
            $this->full_name            = $row['full_name'];
            $this->bio                  = $row['bio'];
        
        
    }
    
    public function isUsernameCyrilic()
    {
        return (strtolower($this->username) != mb_strtolower($this->username,'UTF-8'));
    }
    
}

?>
