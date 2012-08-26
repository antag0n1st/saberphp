<?php
/**
 * This class which implements the Singleton Design Pattern 
 * lets you manage the data that stays in the <head> tag. 
 * Including javascripts and css files.
 *
 * @author Antagonist
 */
class Head {
    
    private static $instance = false;
    private $data          = array();
    public  $title         = 'saberPHP | Framework ';
    public  $description   = 'this is the description of my framework that is inside a meta tag ';
    public  $keywords      = 'and some key words like , framework mvc architecture';
    private $meta_encoding = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    
    
    /**
     * Get the instance of the Head class
     * @return Head $instance
     */
    public static function instance(){
        if(!self::$instance){
            self::$instance = new Head();
        }
        return self::$instance;
    }
    /**
     * Add tags that will appear in the head tag
     * @param string $data 
     */
    public function add($data){
        $this->data[] = $data;
    }
    /**
     * clear all the previous data added 
     */
    public function reset_data(){
        $this->data = array();
    }
    /**
     * name of the .js file that needs to be loaded
     * @param string $js_name only the name without the extension
     */
    public function load_js($js_name,$version='1.0'){
        $this->add('<script type="text/javascript" src="'.BASE_URL.'public/js/'.$js_name.'.js?version='.$version.'"></script> ');        
    }
    /**
     * name of the .css file that needs to be loaded
     * @param type $css_name only the name without the extension
     */
    public function load_css($css_name,$version='1.0'){
        $this->add('<link rel="stylesheet" href="'.BASE_URL.'public/css/'.$css_name.'.css?version='.$version.'" type="text/css" /> ');        
    } 
    /**
     * Add favicon 
     * @param string $image the image name under /public/images
     */
    public function favicon($image){
        $this->add('<link rel="icon"  type="image/ico"  href="'.URL::image($image).'" />');        
    }
    /**
     * Output the data for the head tag
     * @global type $google_tracking_code_ 
     */
    public function display(){     
        global $google_tracking_code_;
        array_unshift($this->data, '<script type="text/javascript" > var base_url = "'.BASE_URL.'"; </script>');
        array_unshift($this->data, '<meta name="keywords" content="'.$this->keywords.'" />');
        array_unshift($this->data, '<meta name="description" content="'.$this->description.'" /> ');
        array_unshift($this->data, '<meta name="title" content="'.$this->title.'" /> ');
        array_unshift($this->data, $this->meta_encoding);
        array_unshift($this->data, '<title>'. $this->title.'</title>');
        
        echo implode("\n\t\t", $this->data)."\n";
        echo HOST_ID ? '' : $google_tracking_code_."\n";        
    }
    /**
     * Add FB tags for better view in the facebook wall/timeline
     * @param type $title
     * @param type $description
     * @param type $page_url
     * @param type $image_url
     * @param type $site_name
     * @param type $type ex:article,post,movie,song,album,image
     */
    public function add_fb_meta_tags($title,$description,$page_url,$image_url,$site_name = '' , $type = ''){        
        $this->add('<meta property="og:title" content="'.$title.'" />'); 
        $this->add('<meta property="og:description" content="'.$description.'" /> '); 
        $this->add('<meta property="og:url" content="'.$page_url.'" />'); 
        $this->add('<meta property="og:image" content="'.$image_url.'" /> '); 
        $this->add('<meta property="og:site_name" content="'.$site_name.'" />'); 
        $this->add('<meta property="og:type" content="'.$type.'" />');        
    }
}

?>