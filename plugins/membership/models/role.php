<?php

class Role extends Model {
    
    public static $table_name = 'roles';
    public static $id_name = 'id';
    public static $db_fields = array('id', 'name','display_name','description','created_at','updated_at');

    public $id;
    public $name;
    public $display_name;
    public $description;
    public $created_at;
    public $updated_at;    

    public static function match($role_id,$roles){
        foreach ($roles as $role) {
            if($role->id == $role_id){
                return $role->name;
            }
        }
        return 'NONE';
    }

}
