<?php
    class Tag extends Model{
        public static $table_name = 'tags';
        public static $id_name    = 'id';
        public static $db_fields = array('id','tag','importance');
        public $id;
        public $tag;
        public $importance;
        
        public static function find_tags($term,$limit=5){
            
            $query  = " SELECT * FROM tags  ";
            $query .= " WHERE tag like '".Model::db()->prep($term)."%' ";
            $query .= " ORDER BY importance DESC ";
            $query .= " LIMIT ".((int)$limit);
             
            $result = Model::db()->query($query);
            $return = array();
            while($row = Model::db()->fetch_assoc($result)){
                $return[] = $row['tag'];
            }
            return array_values($return);
        }
        
        public static function add_tag($term,$ignore = false){
            if($term){
                
                $query = " insert ".($ignore ? 'ignore' : '')." into tags (id,tag,importance) values ";
                $query .= " (null,'".Model::db()->prep($term)."',0) ";
                $query .= $ignore ? '' : " ON DUPLICATE KEY UPDATE importance = importance + 1 ";


                Model::db()->query($query);
            }
             
        }
        
        public static function find_by_term($term){
            
            $query  = " SELECT * FROM tags  ";
            $query .= " WHERE tag like '".Model::db()->prep($term)."' ";
            
            $result_array = self::find_by_sql($query);
            return!empty($result_array) ? array_shift($result_array) : false;
        }
        
        public static function find_all_tags($terms = array()){
            
            foreach($terms as &$term){
                $term = Model::db()->prep($term);
            }
            
            $query  = " SELECT * FROM tags  ";
            $query .= " WHERE tag IN('".  implode("','", array_values($terms))."') ";
          //  $query .= " ORDER BY importance DESC ";
          //  $query .= " LIMIT ".((int)$limit);
             
            return self::find_by_sql($query);
        }
        
        public static function asign_tags_to_post($post_id,$terms = array()){
            
            $tags = self::find_all_tags($terms);
            
            $query = " DELETE FROM blog_post_tags WHERE post_id = '".Model::db()->prep($post_id)."' ";
            Model::db()->query($query);
            
            $query = " INSERT IGNORE INTO blog_post_tags (post_id,tag_id) VALUES ";
            $values = array();
            foreach($tags as $tag){ /* @var $tag Tag */
                $values[] = " ('".Model::db()->prep($post_id)."','".Model::db()->prep($tag->id)."') ";
            }
            
            if(!empty($values)){
                $query .= implode(',', $values);
                Model::db()->query($query);
            }
            
        }
        
    }
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
