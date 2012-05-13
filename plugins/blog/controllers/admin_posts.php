<?php
class AdminPostsController extends Controller{
    
    function __construct() {
        
        parent::__construct();
        
        if(Membership::instance()->user->user_level < 9){
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
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.core');
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.datepicker');
        Head::instance()->load_js('../../plugins/blog/js/jquery.ui.widget');
        
    }

    
    public function browse_posts($page_id = 1){
        
        global $view;
        $view  = 'browse_posts';
        
        Load::helper('paginator');
        
        $paginator = new Paginator(BlogPost::count_all(), $page_id, 30, 'admin-posts/browse-posts/');
        
        $posts = BlogPost::find_all($paginator);
        $categories = BlogCategory::find_all();
        
        
        
        Load::assign('posts', $posts);
        Load::assign('categories', $categories);
        Load::assign('paginator', $paginator);
        
        
    }
    
    public function write_post(){
        
        global $view;
        $view  = 'write_post';
        
        if(isset ($_POST) and $_POST){
            
         $post = new BlogPost();
         $post->id = $_POST['auto_save_id'];
         $post->title = $_POST['title'];
         $post->description = $_POST['description'];
         $post->author = Membership::instance()->user->id;
         $post->author_name = Membership::instance()->user->full_name;
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = date("Y-m-d");
         $post->keywords = $_POST['keywords'];
         $post->post = str_replace(array("\r\n","\r","\n") , '', $_POST['post']);
         $post->release_date = $_POST['publish_date'];
         $post->thumbnail_image_url = $_POST['thumnail_url'];
         $post->enabled = $_POST['enabled'];
         $post->permalink = String::clean_for_url($_POST['title'], true);
         
         $post->save();
            
         URL::redirect('admin-posts/browse-posts');
            
        }else{
            
        $categories = BlogCategory::find_all();
      
        Load::assign('categories', $categories);
            
        }
        
    }
    
    public function auto_save_post(){
        global $layout;
        $layout = false;
        
         $post = new BlogPost();
         $post->id = $_POST['auto_save_id'] ? $_POST['auto_save_id'] : null;
         $post->title = $_POST['title'];
         $post->description = $_POST['description'];
         $post->author = Membership::instance()->user->id;
         $post->author_name = Membership::instance()->user->full_name;
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = date("Y-m-d");
         $post->keywords = $_POST['keywords'];
         $post->post = str_replace(array("\r\n","\r","\n") , '', $_POST['post']);
         $post->release_date = $_POST['publish_date'];
         $post->thumbnail_image_url = $_POST['thumnail_url'];
         $post->enabled = 0;
         $post->save();
         
         echo $post->id;
            
       
    }
    
    public function edit_post($id){
        
        global $view;
        $view  = 'edit_post';
        
        
        if(isset ($_POST) and $_POST){
            /* @var $post BlogPost */
         $post = BlogPost::find_by_id($_POST['post_id']);
         $post->title = $_POST['title'];
         $post->description = $_POST['description'];
         $post->blog_categories_id = $_POST['category'];
         $post->date_created = date("Y-m-d");
         $post->keywords = $_POST['keywords'];
         $post->post = str_replace(array("\r\n","\r","\n") , '', $_POST['post']);
         $post->release_date = $_POST['publish_date'];
         $post->thumbnail_image_url = $_POST['thumnail_url'];
         $post->enabled = $_POST['enabled'];
         
         $post->save();
            
         URL::redirect('admin-posts/browse-posts');
            
        }else{
        
            $post = BlogPost::find_by_id($id);
            $categories = BlogCategory::find_all();
            
            
            
            

            usort($categories,function ( $a, $b )
            { 
              //if(  $a->category_name ==  $b->category_name ){ return 0 ; } 
              //mb_strtolower($a->category_name,'UTF-8');
              return (mb_strtolower($a->category_name,'UTF-8') < mb_strtolower($b->category_name,'UTF-8')) ? -1 : 1;
            });
            
       
           

            Load::assign('post', $post);
            Load::assign('categories', $categories);
        }
        
    }
    
   
    
     
    
    public function delete_post(){
        
        if(isset ($_POST) and $_POST){
            $post = BlogPost::find_by_id($_POST['post_id']);
            $post->enabled = 2;
            $post->save();
          //  $post->delete();
            URL::redirect('admin-posts/browse-posts');
        }
        
    }
}
?>