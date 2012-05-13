<?php

class Dbtest extends Model{
    
    public static $table_name = 'test';
    public static $id_name    = 'id';
    public static $db_fields = array('id','value');
    public $id;
    public $value;
    
}
?>