<?php

class Keyword extends Model {

    public static $table_name = 'keywords';
    public static $id_name = 'id';
    public static $db_fields = array('id', 'word', 'count', 'is_ignored', 'created_at');
    public $id;
    public $word;
    public $count = 0;
    public $is_ignored = 0;
    public $created_at;
    
    public static function find_all($paginator = null , $ignored = 'all', $order_by = []) {
        
        $query = " SELECT * FROM keywords ";
        
        if($ignored == 'ignored'){
            $query .= " WHERE is_ignored = 1 ";
        } else if($ignored == 'active'){
            $query .= " WHERE is_ignored = 0 ";
        } else {
            
        }
        
        $order_by[] = "id";
        
        if(count($order_by)){
            $query .= " ORDER BY ". implode(' , ', $order_by);
        }
        
        if($paginator){
            /* @var $paginator Paginator */
            $query = $paginator->prep_query($query);
        }
        return static::find_by_sql($query);
    }
    
    public static function match($words,$limit = 10){
        
        $query = " SELECT * FROM keywords ";
        $query .= " WHERE is_ignored = 0 ";
        $query .= " AND word IN('". implode("','", $words)."') ";
        $query .= " ORDER BY count DESC ";
        $query .= " LIMIT ".$limit;
        
         return static::find_by_sql($query);
    }

}
