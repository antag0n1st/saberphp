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
        'permalink',
        'ia_errors',
        'cs_errors',
        'cs_data',
        'updated_at'
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
        /** Instant Articles Errors JSON*/
        public $ia_errors;
        /** CopyScape Errors JSON  */
        public $cs_data;
        public $cs_errors;
        public $enabled = 1;
        public $permalink;
        public $updated_at;
        public $can_delete = true;
        public $can_edit = true;
        
        
    public static function find_all_by_category($category_id, $paginator = false,$private = false) {
        $query = "SELECT * FROM " . static::$table_name." WHERE blog_categories_id ='".Model::db()->prep($category_id)."' ";
        $query .= $private ? '' : " AND release_date <= '".TimeHelper::DateTimeAdjusted()."' "; 
        $query .= " AND enabled = 1 ORDER BY release_date DESC ,id DESC ";
        if($paginator){
            /* @var $paginator Paginator */
            $query = $paginator->prep_query($query);
        }
        return static::find_by_sql($query);
    }
    
    public static function add_count($id){
        $query = " UPDATE blog_posts ";
        $query .= " SET click_count = (click_count + 1) ";
        $query .= " WHERE id = '".Model::db()->prep($id)."' ";
        Model::db()->query($query);
    }
    
    public static function find_top_by_category($category_id,$limit = 5,$private = false,$not_in = array()){
        
        $query = " SELECT * FROM " . static::$table_name." WHERE blog_categories_id ='".Model::db()->prep($category_id)."' ";
        $query .= $private ? '' : " AND release_date <= '".TimeHelper::DateTimeAdjusted()."' "; 
        $query .= " AND enabled = 1 ";
        
        if(!empty($not_in)){
            $query .= " AND id not in('".  implode("','", $not_in)."') ";
        }
        
        $query .= " ORDER BY release_date DESC ,id DESC ";
        $query .= " LIMIT ".Model::db()->prep($limit);
        
        return static::find_by_sql($query);
        
    }
    
    public static function find_related($category_id,$limit = 5,$private = false,$not_in = array()){
        
        $query = " SELECT * FROM " . static::$table_name." WHERE blog_categories_id ='".Model::db()->prep($category_id)."' ";
        $query .= $private ? '' : " AND release_date <= '".TimeHelper::DateTimeAdjusted()."' "; 
        $query .= " AND enabled = 1 ";
        
        if(!empty($not_in)){
            $query .= " AND id not in('".  implode("','", $not_in)."') ";
        }
        
        $query .= " ORDER BY release_date DESC ,id DESC ";
        $query .= " LIMIT 20 ";
        
        $query  = " SELECT * FROM (".$query.") as t ORDER BY RAND() ";
        $query .= " LIMIT ".((int)$limit)." ";
        
        return static::find_by_sql($query);
        
    }
    
    /**
     * 
     * $interval = -0 DAY | -7 DAY | -1 MONTH | -1 YEAR
     * 
     * @param type $limit
     * @param type $interval
     * @return type
     */
    public static function find_top_posts($limit = 5,$interval='-1 DAY',$category_ids=array(),$not_in = array()){
        
        $query  = " SELECT * FROM " . static::$table_name." ";
        $query .= " WHERE release_date >= DATE_ADD('".TimeHelper::DateTimeAdjusted()."',INTERVAL ".$interval.") ";
        $query .= " AND release_date <'".TimeHelper::DateTimeAdjusted()."'  ";
        $query .= " AND enabled = 1 ";
        if(!empty($category_ids)){
            $query .= " AND blog_categories_id IN('".  implode("','", $category_ids)."') ";
        }
        $query .= " ORDER BY click_count DESC , release_date ";
        $query .= " LIMIT ".((int)$limit)." ";
        
        $p = static::find_by_sql($query);
        
        $c = count($p);
        if($c < $limit){
            $d = $limit - $c;
            $not_in = array();
            foreach($p as $pp){
                $not_in[] = $pp->id;
            }
            $_p = self::find_top_posts($d, '-7 DAY', array(), $not_in);
            $p = array_merge($p,$_p);
        }
        
        return $p;
    }
    
    public static function find_unpublished(){
        $query  = " SELECT * FROM " . static::$table_name." ";
        $query .= " WHERE release_date >= DATE_ADD('".TimeHelper::DateTimeAdjusted()."',INTERVAL -7 DAY) ";
        
        $query .= " AND enabled < 2 ";
        
        return static::find_by_sql($query);
    }
    
    public static function count_by_category($in = array() , $not_in = array(),$private = false){
        
        $query  = " SELECT count(*) as c FROM " . static::$table_name." WHERE ";
        
        $query .= $private ? " enabled in(0,1) " : " enabled = 1 ";
        
        if(!empty ($not_in)){
            $query .= " AND blog_categories_id NOT IN ('".  implode("','", $not_in)."') ";
        }
        
        if(!empty ($in)){
            $query .= " AND blog_categories_id IN ('".  implode("','", $in)."') ";
        }
        
        $query .= $private ? '' : " AND release_date <= '".TimeHelper::DateTimeAdjusted()."' ";
        
        $result_set = Model::db()->query($query);
        $row = Model::db()->fetch_array($result_set);
        return array_shift($row);
        
    }
    
    public static function find_all($paginator = false , $not_in = array() , $in = array(), $private = true , $id_not_in = array() ) {
        
        $query  = " SELECT * FROM " . static::$table_name ." WHERE ";
        
        $query .= $private ? " enabled in(0,1) " : " enabled = 1 ";
        
        if(!empty ($not_in)){
            $query .= " AND blog_categories_id NOT IN ('".  implode("','", $not_in)."') ";
        }
        
        if(!empty ($in)){
            $query .= " AND blog_categories_id IN ('".  implode("','", $in)."') ";
        }
        
        if(!empty ($id_not_in)){
            $query .= " AND id NOT IN ('".  implode("','", $id_not_in)."') ";
        }
        
        $query .= $private ? '' : " AND release_date <= '".TimeHelper::DateTimeAdjusted()."' AND is_released = 1 ";
        
        $query .= " ORDER BY release_date DESC , id DESC ";
        if($paginator){
            /* @var $paginator Paginator */
            $query = $paginator->prep_query($query);
        }
        return static::find_by_sql($query);
    }
    
    public static function find_by_tag($tag,$paginator){
        /* @var $tag Tag */
        /* @var $paginator Paginator */
        
        $query  = " SELECT b.* FROM blog_posts as b ";
        $query .= " JOIN blog_post_tags as t ON b.id = t.post_id AND b.enabled = 1 ";
        $query .= " WHERE t.tag_id = '".Model::db()->prep($tag->id)."' ";
        $query .= " AND b.release_date <= '".TimeHelper::DateTimeAdjusted()."' ";
        
        
        $query = $paginator->prep_query($query);
        
        return self::find_by_sql($query);
        
    }
    
    public static function count_by_tag($tag){
        /* @var $tag Tag */
        
        $query = " SELECT count(*) as count FROM blog_post_tags ";
        $query .= " WHERE tag_id = '".Model::db()->prep($tag->id)."' ";
        $result = Model::db()->query($query);
        $row = Model::db()->fetch_assoc($result);
        
        return $row['count'];
        
    }


    public static function count_all() {
        
        $sql = "SELECT COUNT(*) FROM " . static::$table_name." WHERE enabled = 1 ";
        $result_set = Model::db()->query($sql);
        $row = Model::db()->fetch_array($result_set);
        return array_shift($row);
    }
    
    
    public static function search($word){
        
        $query  = " ( SELECT * FROM " . static::$table_name." WHERE title like'%".Model::db()->prep($word)."%' AND release_date <= '".TimeHelper::DateTimeAdjusted()."' ORDER BY date_created DESC ) UNION ( ";
        $query .= " SELECT * FROM " . static::$table_name." WHERE post like'%".Model::db()->prep($word)."%' AND release_date <= '".TimeHelper::DateTimeAdjusted()."' ORDER BY date_created DESC ) ";
        $query .= " LIMIT 30 ";
        
        return static::find_by_sql($query);
        
    }
    

    
    
    }