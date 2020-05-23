<?php
/**
 * @property BlogCategory $category 
 */
class BlogController extends Controller{
    
    private $category;
    
    function __construct() {
        parent::__construct();
       
       Load::plugin_model('blog', 'blog_post');
       Load::plugin_model('blog', 'blog_category');
               
    }
        
    public function main($page = 1){
        
        if($page == 1 and $_GET['params'] == '1'){
            URL::redirect($_GET['cat']);
        }
        
        global $_active_page_;
        $_active_page_ = $_GET['cat'];
        $category =  BlogCategory::find_by_name($_GET['cat']);
        
        $category = $category ? $category : new BlogCategory();
        /* @var $category BlogCategory */
        
        
        
        $grouped = BlogCategory::find_grouped($category->id);
        $grouped_ids = array();
        foreach($grouped as $catt){
            $grouped_ids[] = $catt->id;
        }
        
        $most_popular_category = array();
        $most_popular_category['week']= array(); // BlogPost::find_top_posts(5,'-7 DAY',$grouped_ids);
        $most_popular_category['month']= array(); // BlogPost::find_top_posts(5,'-1 MONTH',$grouped_ids);
        $most_popular_category['year']= array(); // BlogPost::find_top_posts(5,'-1 YEAR',$grouped_ids);
        
        
        Load::helper('paginator');
        $paginator = new Paginator(BlogPost::count_by_category($grouped_ids), $page, 16,$category->latin_name.'/');
        
        
        $posts = BlogPost::find_all($paginator, array(), $grouped_ids, false);
        
      
        
        $duplicate_page = '';
            if($page > 1){
                $duplicate_page = ' - Страна '.$page;
            }
        
        Head::instance()->title = $category->title.' | Lady.mk '.$duplicate_page;
        Head::instance()->description = $category->description.' '.$duplicate_page;
        Head::instance()->keywords = $category->keywords;
        
        Load::assign('most_popular_category', $most_popular_category);
        Load::assign('posts', $posts);
        Load::assign('category',$category);
        Load::assign('paginator', $paginator);
    }
    
    
    public function single($id = 1){
        /* @var $post BlogPost */
        $post = BlogPost::find_by_id($id);
        
        
        
        if(!$post){
            URL::redirect('access-denied');
        }
        
        $post->add_count($id);
        
       // Load::plugin_model('comments', 'comment');
        
       // if($this->category->id == 4){
            $user = new User();
            $user->id = $post->author;
            $user->LoadUserFromId();
            Load::assign('author', $user);
      //  }
        
        
        $comments = Comments::get_recent_comments_by_id($post->id.'_post');
        
       
        $related_posts = BlogPost::find_related($post->blog_categories_id,5,false,array($post->id));
        
        Head::instance()->title = $post->title . " | Lady.mk";
        Head::instance()->description = str_replace(array('\'','"'), '', $post->description);
        Head::instance()->keywords = $post->keywords;
        
        $category =  BlogCategory::find_by_id($post->blog_categories_id);
        
        $fb_title = isset($_GET['title']) ? $_GET['title'].' | '.$post->title : $post->title;
        $fb_desc = isset($_GET['desc']) ? $_GET['desc'] : str_replace(array('\'','"'), '', $post->description);
        $fb_image = isset($_GET['src']) ? URL::abs(ltrim($_GET['src'],'/') ) : URL::abs('public/uploads/'.$post->thumbnail_image_url);
        
        $image_number = '';
        if(isset($_GET['title'])){
            $pt = $_GET['title'];
            $ptt = explode(' ', $pt);
            $n = (int)end($ptt);
            $n = $n -1;
            
            
            $image_number  = "?title=".$_GET['title'];
            $image_number .= "&src=".$_GET['src'];
            $image_number .= "&desc=".$_GET['desc'];
            $image_number .= "#image".$n;
            
            // http://lady.mk/10-parchinja-obleka-koi-sekoja-zhena-treba-da-gi-ima-vo-zima/571
          //  ?title=Слика 8&
          //  src=%2Fpublic%2Fuploads%2Fstatii%2Fimages%2F8jessica-chastain-printed-scarf-h724.jpg&
         //   desc=
          //  #image7
        }
        
//        if($post->title != $fb_title){
//            $fb_page_url = URL::abs($post->permalink.'/'.$post->id).'?title='.$fb_title.'&desc='.$fb_desc.'&src='.$fb_image;
//        }else{
//            $fb_page_url = URL::abs($post->permalink.'/'.$post->id);
//        }
       
        
        Head::instance()->add_fb_meta_tags($fb_title,
                    $fb_desc,
                    URL::abs($post->permalink.'/'.$post->id).$image_number,
                    $fb_image,BASE_URL,'article');
        
        Load::assign('related_posts', $related_posts);
        Load::assign('post', $post);
        Load::assign('comments', $comments);
        Load::assign('category', $category);
        
        global $_active_page_;
        $_active_page_ = $category ? $category->latin_name : null;
        
    }
}

//http%3A%2F%2Flady.mk%2F5-kombinacii-za-na-rabota-inspirirani-od-miranda-ker%2F570%3Ftitle%3D%D0%A1%D0%BB%D0%B8%D0%BA%D0%B0%204%26src%3D%252Fpublic%252Fuploads%252Fstatii%252Fimages%252F10-miranda-kerr-street-style-personal-style-white-jeans-h724.jpg%26desc%3D%23image3&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=25&amp;appId=232912440164227" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:25px; padding:0; margin:0;" allowtransparency="true"></iframe>