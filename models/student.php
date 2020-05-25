<?php

class Student extends Model {

    public static $table_name = 'students';
    public static $id_name = 'id';
    public static $db_fields = array('id','counter','name','email','created_at');
    
    	public $id;
	public $counter;
	public $name;
	public $email;
	public $created_at;

    //public $email;

}


