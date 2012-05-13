<?php

class Comments{
    
    
    public static function get_recent_comments_by_id($id){
        
        Load::plugin_model('comments', 'comment');
        Load::helper('time_helper');
        
        $result_array = Comment::get_recent_comments_by_id($id);
        Load::assign('comments', $result_array);
        Load::assign('item_id_', $id);
        return Load::plugin_view('comments', 'all_comments',true);
        
        
    }
    
    public static function get_recent_comments($limit = 5 , $width = 300){
        
        Load::helper('time_helper');
        Load::plugin_model('comments', 'comment');
        
        $result_array = Comment::get_recent_comments($limit);
        
        Load::assign('comments', $result_array);
        Load::assign('width', $width);
        return Load::plugin_view('comments', 'recent_comments',true);
    }
    
}
?>
