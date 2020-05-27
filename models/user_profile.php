<?php

class UserProfile extends Model {

    public static $table_name = 'user_profiles';
    public static $id_name = 'id';
    public static $db_fields = array('id','users_user_id','email','date_of_birth','profile_image','contact','created_at');
    
    	public $id;
	public $users_user_id;
	public $email;
	public $date_of_birth;
	public $profile_image;
	public $contact;
	public $created_at;


}


