<?php

class CommentsController extends Controller{
    
    function __construct() {
        global $layout;
        global $view;
        
        $layout = null;        
        $view = null;
    }

    
    public function send_like(){
        
        Load::plugin_model('comments', 'comment');
        
       if(isset ($_POST['id'])){
         
         $comment_id = $_POST['id'];
         
         $comment = Comment::find_by_id($comment_id);
         /* @var $comment Comment */
         
         if(!preg_match('/'.URL::get_real_ip_addr().'/', $comment->ip_addresses)){
             $comment->likes += 1;
             $comment->ip_addresses = "|".URL::get_real_ip_addr();
             $comment->save();
             echo 1;
         }else{
             echo 0;
         }
         
       }
        
    }
    
    public function add_comment(){
        Load::plugin_model('comments', 'comment');
        Load::helper('time_helper');
        
        if(isset ($_POST['comment']) and isset ($_POST['item_id']) and Membership::instance()->user){
            
            $comment = new Comment();
            $comment->comment = String::url_to_anchor(String::plain_text($_POST['comment']));
            $comment->item_id = $_POST['item_id'];
            $comment->url = $_POST['url'];
            $comment->likes = 0;
            $comment->username = Membership::instance()->user->username;
            $comment->username_avatar = Membership::instance()->user->image_url;
            $comment->date_created = TimeHelper::DateTimeAdjusted();
            
         
            
            if($comment->comment and $comment->comment != ' '){
                $comment->save();
                echo $comment->comment;
            }else{
                echo "you'r comment was not saved";
            }
            
        } else {
            echo 'please login to send comments';
        }
        
        
    }
    
    public function edit_comment(){
        Load::plugin_model('comments', 'comment');
        Comment::edit_comment_by_id($_POST['id'], $_POST['comment']);
    }
    public function delete_comment($id){
        Load::plugin_model('comments', 'comment');
        Comment::delete_comment_by_id($id);
    }
    
    
    
    
}
?>
