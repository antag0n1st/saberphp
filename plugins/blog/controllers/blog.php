<?php

/**
 * @property BlogCategory $category 
 */
class BlogController extends Controller {

    private $category;

    function __construct() {
        parent::__construct();

        Load::plugin_model('blog', 'blog_post');
        Load::plugin_model('blog', 'blog_category');

        global $_active_page_;
        $_active_page_ = $_GET['cat'];
        $this->category = BlogCategory::find_by_name($_GET['cat']);
    }

    public function main($page = 1) {

        if ($page == 1 and $_GET['params'] == '1') {
            URL::redirect($_GET['cat']);
        }
        Load::helper('paginator');
        $paginator = new Paginator(BlogPost::count_by_category(array($this->category->id)), $page, 8, $this->category->latin_name . '/');
        $posts = BlogPost::find_all_by_category($this->category->id, $paginator);



        $duplicate_page = '';
        if ($page > 1) {
            $duplicate_page = ' - Страна ' . $page;
        }

        Head::instance()->title = $this->category->title . ' - mojtrener mk' . $duplicate_page;
        Head::instance()->description = $this->category->description . ' - mojtrener mk' . $duplicate_page;
        Head::instance()->keywords = $this->category->keywords;

        Load::assign('posts', $posts);
        Load::assign('category', $this->category);
        Load::assign('paginator', $paginator);
    }

    public function single($id = 1) {
        /* @var $post BlogPost */
        $post = BlogPost::find_by_id($id);

        if (!$post) {
            URL::redirect('access-denied');
        }

        // Load::plugin_model('comments', 'comment');
        // if($this->category->id == 4){
        $user = new User();
        $user->id = $post->author;
        $user->LoadUserFromId();
        Load::assign('author', $user);
        //  }


        $comments = Comments::get_recent_comments_by_id($post->id . '_post');

        $posts = BlogPost::find_top_by_category($this->category->id, 8);

        Head::instance()->title = $post->title . ' - mojtrener.mk';
        Head::instance()->description = str_replace(array('\'', '"'), '', $post->description);
        Head::instance()->keywords = $post->keywords;

        Head::instance()->add_fb_meta_tags($post->title, str_replace(array('\'', '"'), '', $post->description), URL::abs($post->permalink . '/' . $this->category->latin_name . '/' . $post->id), $post->thumbnail_image_url, BASE_URL, 'article');

        Load::assign('post', $post);
        Load::assign('comments', $comments);
        Load::assign('posts', $posts);
        Load::assign('category', $this->category);
    }

}

?>