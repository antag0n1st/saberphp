<?php

class BlogCategory extends Model {

    public static $table_name = 'blog_categories';
    public static $id_name = 'id';
    public static $db_fields = array(
        'id',
        'category_name',
        'latin_name',
        'title',
        'description',
        'keywords'
    );
    public $id;
    public $category_name;
    public $latin_name;
    public $title;
    public $description;
    public $keywords;
    
    private static $categories = array();

    public static function find_by_name($name) {
        $obj = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE latin_name = '".Model::db()->prep($name)."' LIMIT 1 ");
        return $obj ? array_shift($obj) : null;
    }
    
    public static function get_category_by_id($id){
        if(empty(self::$categories)){
            $categories = self::find_all();
            foreach($categories as $cat){
                self::$categories[$cat->id] = $cat->latin_name;
            }
        }
        return isset (self::$categories[$id]) ? self::$categories[$id] : null;
    }
    

}

?>