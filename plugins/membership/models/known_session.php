<?php

class KnownSession extends Model {

    public static $table_name = 'known_sessions';
    public static $id_name = 'id';
    public static $db_fields = array('id','user_id','session_id','user_agent','valid_until','created_at');
    
    	public $id;
	public $user_id;
	public $session_id;
	public $user_agent;
	public $valid_until;
	public $created_at;
        
        
    public static function is_valid($user_id , $session_id, $timestamp) {
        
        $query = " SELECT * from known_sessions  ";
        $query .= " WHERE user_id = '" . Model::db()->prep($user_id) . "' ";
        $query .= " AND session_id = '" . Model::db()->prep($session_id) . "'  ";
        $query .= " AND valid_until >= '" . Model::db()->prep($timestamp) . "'  ";
        $query .= " LIMIT 1 ";

        $sessions = static::find_by_sql($query);
        return count($sessions) ? $sessions[0] : false;
        
    }

    public static function find_valid($session_id, $timestamp) {
        
        $query = " SELECT * from known_sessions  ";
        $query .= " WHERE session_id = '" . Model::db()->prep($session_id) . "'  ";
        $query .= " AND valid_until >= '" . Model::db()->prep($timestamp) . "'  ";
        $query .= " LIMIT 1 ";

        $sessions = static::find_by_sql($query);
        return count($sessions) ? $sessions[0] : false;
        
    }    
        
    public static function find_by_user($user_id , $timestamp) {
        
        $query = " SELECT * from known_sessions  ";
        $query .= " WHERE user_id = '" . Model::db()->prep($user_id) . "' ";
        $query .= " AND valid_until >= '" . Model::db()->prep($timestamp) . "'  ";

        return static::find_by_sql($query);
        
    }
    
    public static function update_session($id , $timestamp) {
        
        $query = " UPDATE known_sessions  ";
        $query .= " SET valid_until = '" . Model::db()->prep($timestamp) . "'  ";
        $query .= " WHERE id = '" . Model::db()->prep($id) . "' ";
        
        Model::db()->query($query);
        
    }
    
     public static function delete_invalid_sessions($user_id , $timestamp = 0) {
        
        $query = " DELETE FROM known_sessions  ";
        $query .= " WHERE user_id = '" . Model::db()->prep($user_id) . "' ";
        $query .= " AND valid_until < '" . Model::db()->prep($timestamp ? $timestamp : time()) . "'  ";

        Model::db()->query($query);
        
    }
    
    public static function drop_sessions($user_id ) {
        
        $query = " DELETE FROM known_sessions  ";
        $query .= " WHERE user_id = '" . Model::db()->prep($user_id) . "' ";

         Model::db()->query($query);
        
    }


}


