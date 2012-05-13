<?php
    class BlogPost extends Model{
        
    public static $table_name = 'blog_posts';
    public static $id_name    = 'id';
    public static $db_fields = array(
        'id',
        'title',
        'description',
        'thumbnail_image_url',
        'post',
        'keywords',
        'date_created',
        'author',
        'author_name',
        'release_date',
        'is_released' ,
        'blog_categories_id',
        'enabled' , 
        'permalink'
        );
    
        public $id;
        public $title;
        public $description;
        public $thumbnail_image_url;
        public $post;
        public $keywords;
        public $date_created;
        public $author;
        public $author_name;
        public $release_date;
        public $is_released;
        public $blog_categories_id;
        public $enabled = 1;
        public $permalink;
        
    public static function find_all_by_category($category_id, $paginator = false) {
        $query = "SELECT * FROM " . static::$table_name." WHERE blog_categories_id ='".Model::db()->prep($category_id)."' AND DATE(release_date) <= DATE(NOW()) AND enabled = 1 ORDER BY release_date DESC ,id DESC ";
        if($paginator){
            /* @var $paginator Paginator */
            $query = $paginator->prep_query($query);
        }
        return static::find_by_sql($query);
    }
    
    public static function find_top_by_category($category_id,$limit = 5){
        
        $query = " SELECT * FROM " . static::$table_name." WHERE blog_categories_id ='".Model::db()->prep($category_id)."' "
                ." AND DATE(release_date) <= DATE(NOW()) AND enabled = 1 ORDER BY release_date DESC ,id DESC "
                ." LIMIT ".Model::db()->prep($limit);
        
        return static::find_by_sql($query);
        
    }
    
    public static function count_by_category($in = array() , $not_in = array(),$private = true){
        
        $query  = " SELECT count(*) as c FROM " . static::$table_name." WHERE ";
        
        $query .= $private ? " enabled in(0,1) " : " enabled = 1 ";
        
        if(!empty ($not_in)){
            $query .= " AND blog_categories_id NOT IN ('".  implode("','", $not_in)."') ";
        }
        
        if(!empty ($in)){
            $query .= " AND blog_categories_id IN ('".  implode("','", $in)."') ";
        }
        
        $query .= " AND DATE(release_date) <= DATE(NOW()) ";
        
        $result_set = Model::db()->query($query);
        $row = Model::db()->fetch_array($result_set);
        return array_shift($row);
        
    }
    
    public static function find_all($paginator = false , $not_in = array() , $in = array(), $private = true ) {
        
        $query  = " SELECT * FROM " . static::$table_name ." WHERE ";
        
        $query .= $private ? " enabled in(0,1) " : " enabled = 1 ";
        
        if(!empty ($not_in)){
            $query .= " AND blog_categories_id NOT IN ('".  implode("','", $not_in)."') ";
        }
        
        if(!empty ($in)){
            $query .= " AND blog_categories_id IN ('".  implode("','", $in)."') ";
        }
        
        $query .= " ORDER BY release_date DESC , id DESC ";
        if($paginator){
            /* @var $paginator Paginator */
            $query = $paginator->prep_query($query);
        }
        return static::find_by_sql($query);
    }
    
    public static function count_all() {
        
        $sql = "SELECT COUNT(*) FROM " . static::$table_name." WHERE enabled = 1 ";
        $result_set = Model::db()->query($sql);
        $row = Model::db()->fetch_array($result_set);
        return array_shift($row);
    }
    
    
    public static function search($word){
        
        $query  = " ( SELECT * FROM " . static::$table_name." WHERE title like'%".Model::db()->prep($word)."%' ORDER BY date_created DESC ) UNION ( ";
        $query .= " SELECT * FROM " . static::$table_name." WHERE post like'%".Model::db()->prep($word)."%' ORDER BY date_created DESC )  LIMIT 30 ";
        
        return static::find_by_sql($query);
        
    }
    

    
    
    }
?>