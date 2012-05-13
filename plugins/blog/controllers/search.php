<?php

class SearchController extends Controller{
    public function main(){
        
    }
    public function prebaruvanje(){
        
        $word = isset($_POST['word']) ? $_POST['word'] : '';
        
        Load::plugin_model('blog', 'blog_post');
        Load::plugin_model('blog', 'blog_category');
        
        $posts = $word ? BlogPost::search($word) : array();
        
        Load::assign('posts', $posts);
        Load::assign('word', $word);
        
    }
}
?>