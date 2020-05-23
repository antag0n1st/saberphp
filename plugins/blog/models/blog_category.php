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
    
    public static function find_all(){
        $query = " SELECT * FROM blog_categories ORDER by placement ";
        return self::find_by_sql($query);
    }

    public static function find_by_name($name) {
        if(empty(self::$categories)){
            $categories = self::find_all();
            foreach($categories as $cat){
                self::$categories[$cat->id] = $cat;
            }
        }
        
        foreach(self::$categories as $cat){
            if($cat->latin_name == $name){
                return $cat;
            }
        }
        return null;
    }
    public static function find_grouped ($cat_id){
        $query = " SELECT * FROM blog_categories WHERE ";
    //    $query .= " parrent_id = '".Model::db()->prep($cat_id)."' ";
        $query .= " id = '".Model::db()->prep($cat_id)."' ";
        return self::find_by_sql($query);
    }


    public static function find_subcategories(){
        $query = " SELECT * FROM blog_categories WHERE parrent_id != 0 ";
        return self::find_by_sql($query);
    }
    
    public static function get_category_by_id($id){
        if(empty(self::$categories)){
            $categories = self::find_all();
            foreach($categories as $cat){
                self::$categories[$cat->id] = $cat;
            }
        }
        return isset (self::$categories[$id]) ? self::$categories[$id] : null;
    }
    
    public static function get_hierarchy(){
        
        $items = array();
        
        $query  = " SELECT * from blog_categories where parrent_id = 0; ";
        $parrent_items = self::find_by_sql($query);
        
        $query  = " SELECT a.category_name as parrent_name , a.latin_name as perrent_latin , b.*  ";
        $query .= " FROM blog_categories as a ";
        $query .= " JOIN blog_categories as b ON a.id = b.parrent_id";
        
        
        $result = Model::db()->query($query);
        $title = '';
        
        while($row = Model::db()->fetch_assoc($result)){
            $item = self::instantiate($row);
            foreach($parrent_items as &$parrent){
                if($parrent->latin_name == $row['perrent_latin']){
                    if(!isset($parrent->childs)){$parrent->childs = array();}
                    $parrent->childs[] = $item;
                    
                }
            }
            
            
        }
        return $parrent_items;
    }
    

}
