<?php

class AdminPostsController extends Controller{
    
    function __construct() {
        
        parent::__construct();
        
        if(Membership::instance()->user->user_level < 4){
            URL::redirect('oops/no-privileges');
        }
        
        Load::plugin_model('blog', 'blog_post');
        Load::plugin_model('blog', 'blog_category');
        
        global $_active_page_;
        $_active_page_ = 'admin';
        
        global $layout;
        $layout = 'admin';
        
        Head::instance()->load_css('../../plugins/blog/css/blog');
        Head::instance()->load_css('../../plugins/blog/css/flick/jquery-ui-1.8.16.custom');
        Head::instance()->load_css('../../plugins/blog/css/jquery.tagit');
      
        Head::instance()->add('<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>');
        
      //  Head::instance()->load_css('../../plugins/blog/css/examples');
        Head::instance()->load_css('../../plugins/blog/css/master');
      //  Head::instance()->load_css('../../plugins/blog/css/reset');
     //   Head::instance()->load_css('../../plugins/blog/css/tagit.ui-zendesk');
        
        
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.core.min');
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.datepicker');
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.widget.min');
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.position.min');
        Head::instance()->load_js('../../plugins/blog/js/jquery-ui-timepicker-addon');
        Head::instance()->load_js('../../plugins/blog/js/jquery-ui-sliderAccess');
        
        Head::instance()->load_js('../../plugins/blog/js/tag-it');
        
    }

    
    public function browse_posts($page_id = 1,$paging_url = ''){
        
        global $view;
        $view  = 'browse_posts';
        
        Load::helper('paginator');
        
        $paging_url = $paging_url ? $paging_url : 'admin-posts/browse-posts/';
        
        $paginator = new Paginator(BlogPost::count_all(), $page_id, 30, $paging_url);
        
        $posts = BlogPost::find_all($paginator);
        $categories = BlogCategory::find_all();
        
        Load::assign('posts', $posts);
        Load::assign('categories', $categories);
        Load::assign('paginator', $paginator);
        
        
    }
    
    public function avtori($page_id = 1){
        
        if(Membership::instance()->user->user_level < 9){
            URL::redirect('oops/no-privileges');
        }
        
        $this->browse_posts($page_id,'admin-posts/avtori/');
        
        $query = " SELECT * FROM users where user_level >= 3 ";
        $result = Model::db()->query($query);
        $writers = array();
        while($row = Model::db()->fetch_assoc($result)){
            $writers[] = $row;
        }
        
        $query  = " select u.username , u.full_name ,f.first_name ,f.last_name,f.image_url, u.user_level , count(*) as c";
        $query .= " from blog_posts as p ";
        $query .= " join users as u on p.author = u.user_id";
        $query .= " join facebook_users as f on u.user_id = f.user_id_fk";
        $query .= " where p.enabled IN(0,1)";
        $query .= " group by p.author";
        
        $result = Model::db()->query($query);
        $avtori = array();
        while($row = Model::db()->fetch_assoc($result)){
            $avtori[] = $row;
        }
        
        
        
        Load::assign('writers', $writers);
        Load::assign('avtori', $avtori);
        
        global $view;
        $view = 'avtori';
    }
    public function change_avtor(){
        
        if(Membership::instance()->user->user_level < 9){
            URL::redirect('oops/no-privileges');
        }
        
        global $layout;
        $layout = false;
        /* @var $post BlogPost */
        if(isset($_POST) and $_POST){
            $post = BlogPost::find_by_id($_POST['post_id']);
            $post->author_name = $_POST['full_name'];
            $post->author      = $_POST['writer_id'];
            $post->save();
        }
    }
    
    public function write_post(){
        
        global $view;
        $view  = 'write_post';
        
        
        
        if(isset ($_POST) and $_POST){
            
           
         
         $post = BlogPost::find_by_id($_POST['auto_save_id']);
         
         if(!$post){
             
             $post = new BlogPost();
             $post->id = $_POST['auto_save_id'];
             
         }
         
         if(isset($_POST['user_id'])){
             $user = Membership::instance()->getUserById($_POST['user_id']);
         }else{
             $user = Membership::instance()->user;
         }
         
         
         
         $post->title = str_replace(array("\r\n","\r","\n") , '', $_POST['title']);
         $post->description = str_replace(array("\r\n","\r","\n") , '', $_POST['description']);
         $post->author = $user->id;
         $post->author_name = $user->full_name;
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = TimeHelper::DateTimeAdjusted();
         $post->keywords = str_replace(array("\r\n","\r","\n") , '', $_POST['keywords']);
         $post->post = $_POST['post'];
         
         $post->thumbnail_image_url = $_POST['thumbnail_url'];
         $post->enabled = $_POST['enabled'];
         $post->permalink = String::clean_for_url($_POST['title'], true);
         $post->thumbnail_tag = $_POST['thumbnail-tag'];
         $post->is_author_visible = isset($_POST['is_author_visible']) ? 1 : 0;
         
         $post->save();
         
         Load::model('tag');
         $terms = explode(',', $post->keywords);
         foreach ($terms as $term){
             Tag::add_tag($term);
         }
         Tag::asign_tags_to_post($post->id, $terms);
            
         URL::redirect('admin-posts/browse-posts');
            
        }else{
            
        $categories = BlogCategory::find_all();
      
        Load::assign('categories', $categories);
            
        }
        
        $query = " SELECT * FROM users where user_level >= 3 ";
        $result = Model::db()->query($query);
        $writers = array();
        while($row = Model::db()->fetch_assoc($result)){
            $writers[] = $row;
        }
        
        Load::assign('writers', $writers);
        
        
    }
    
    public function auto_save_post(){
        global $layout;
        $layout = false;
        
         if(isset($_POST['user_id'])){
             $user = Membership::instance()->getUserById($_POST['user_id']);
         }else{
             $user = Membership::instance()->user;
         }
        
         $post = new BlogPost();
         $post->id = $_POST['auto_save_id'];
         $post->title = str_replace(array("\r\n","\r","\n") , '', $_POST['title']);
         $post->description = str_replace(array("\r\n","\r","\n") , '', $_POST['description']);
         $post->author = $user->id;
         $post->author_name = $user->full_name;
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = date("Y-m-d");
         $post->keywords = str_replace(array("\r\n","\r","\n") , '', $_POST['keywords']);
         $post->post =  $_POST['post'];
         //$post->release_date = $_POST['publish_date'];
         $post->thumbnail_image_url = $_POST['thumbnail_url'];
         $post->enabled = 0;
         $post->permalink = String::clean_for_url($_POST['title'], true);
         $post->save();
         echo $post->id;
       
    }
    
    public function edit_post($id){
        
        global $view;
        $view  = 'edit_post';        
        
        
        
        if(isset ($_POST) and $_POST){
            /* @var $post BlogPost */
         $post = BlogPost::find_by_id($_POST['post_id']);
         
         if(isset($_POST['user_id'])){
             $user = Membership::instance()->getUserById($_POST['user_id']);
         }else{
             $user = Membership::instance()->user;
         }
         
         if($post->title == '' or $post->title == 'Наслов' or $post->title == ' '){
             $post->permalink = String::clean_for_url($_POST['title'], true);
         }
         
         $post->title = str_replace(array("\r\n","\r","\n") , '', $_POST['title']);
         $post->description =str_replace(array("\r\n","\r","\n") , '',  $_POST['description']);
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = TimeHelper::DateAdjusted();
         $post->keywords = $_POST['keywords'];
         $post->post = $_POST['post'];
         $post->author = $user->id;
         $post->author_name = $user->full_name;
         $post->is_author_visible = isset($_POST['is_author_visible']) ? 1 : 0;
         $post->thumbnail_image_url = $_POST['thumbnail_url'];
         $post->enabled = $_POST['enabled'];
         $post->thumbnail_tag = $_POST['thumbnail-tag'];
         $post->release_date = TimeHelper::DateTimeAdjusted();
         
      
         
         $post->save();
         
         
         Load::model('tag');
         $terms = explode(',', $post->keywords);
         foreach ($terms as $term){
             Tag::add_tag($term,true);
         }
         Tag::asign_tags_to_post($post->id, $terms);
            
         URL::redirect('admin-posts/browse-posts');
            
        }else{
        
            $post = BlogPost::find_by_id($id);
            $categories = BlogCategory::find_all();
            
            usort($categories,function ( $a, $b )
            { 
              return (mb_strtolower($a->category_name,'UTF-8') < mb_strtolower($b->category_name,'UTF-8')) ? -1 : 1;
            });
            
            $query = " SELECT * FROM users where user_level >= 3 ";
            $result = Model::db()->query($query);
            $writers = array();
            while($row = Model::db()->fetch_assoc($result)){
                $writers[] = $row;
            }

            Load::assign('writers', $writers);
            
            Load::assign('post', $post);
            Load::assign('categories', $categories);
        }
        
    }
    
   
    
     
    
    public function delete_post(){
        
        if(isset ($_POST) and $_POST){
            $post = BlogPost::find_by_id($_POST['post_id']);
            $post->enabled = 2;
            $post->save();
      
            URL::redirect('admin-posts/browse-posts');
        }
        
    }
}