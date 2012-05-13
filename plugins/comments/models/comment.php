<?php
    class Comment extends Model{
        
    public static $table_name = 'comments';
    public static $id_name    = 'id';
    public static $db_fields = array(
        'id',
        'item_id',
        'comment',
        'username',
        'username_avatar',
        'likes',
        'dislikes',
        'date_created' ,
        'ip_addresses',
        'url'
        );
    
    public $id;
    public $item_id;
    public $comment;
    public $username;
    public $likes;
    public $dislikes;
    public $date_created;
    public $username_avatar;
    public $ip_addresses;
    public $url;
    
    
    public static function get_recent_comments_by_id($id){        
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE item_id ='{$id}' ORDER BY id  ");   
    }
    
    public static function get_recent_comments($limit = 5){        
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " ORDER BY id DESC LIMIT ".static::db()->prep($limit));
    }
    
    
    public static function edit_comment_by_id($id , $content){
        /* @var $comment Comment */
        $comment = static::find_by_id($id);
        $comment->comment = $content;
        $comment->save();
    }
    public static function delete_comment_by_id($id){
        /* @var $comment Comment */
        $comment = static::find_by_id($id);
        $comment->delete();
    }
    
    
        
        
    }
?>
