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
    private $data = array();
    public $title = "";
    public $description = '';
    public $keywords = '';
    private $meta_encoding = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    
    public function __construct() {
        $this->title = TITLE;
        $this->description = DESCRIPTION;
        $this->keywords = KEYWORDS;
    }

    /**
     * Get the instance of the Head class
     * @return Head $instance
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new Head();
        }
        return self::$instance;
    }

    /**
     * Add tags that will appear in the head tag
     * @param string $data 
     */
    public function add($data) {
        $this->data[] = $data;
    }

    /**
     * clear all the previous data added 
     */
    public function reset_data() {
        $this->data = array();
    }

    /**
     * name of the .js file that needs to be loaded
     * @param string $js_name only the name without the extension
     */
    public function load_js($js_name, $version = '1.0') {
        $this->add('<script type="text/javascript" src="' . BASE_URL . 'public/js/' . $js_name . '.js?version=' . $version . '"></script> ');
    }

    /**
     * name of the .css file that needs to be loaded
     * @param type $css_name only the name without the extension
     */
    public function load_css($css_name, $version = "1.0") {
        $this->add('<link rel="stylesheet" href="' . BASE_URL . 'public/css/' . $css_name . '.css?version=' . $version . '" type="text/css" /> ');
    }

    /**
     * Add favicon 
     * @param string $image the image name under /public/images
     */
    public function favicon($image) {
        $this->add('<link rel="icon"  type="image/png"  href="' . URL::image($image) . '" />');
    }

    /**
     * Output the data for the head tag
     * @global type $google_tracking_code_ 
     */
    public function display() {

        global $google_tracking_code_;

        array_unshift($this->data, '<link rel="canonical" href="' . URL::current_page_url() . '">');

        array_unshift($this->data, '<title>' . $this->title . '</title>');
        array_unshift($this->data, '<meta name="viewport" content="width=device-width, initial-scale=1.0">');
        array_unshift($this->data, '<meta http-equiv="X-UA-Compatible" content="IE=edge">');
        array_unshift($this->data, '<meta name="description" content="' . $this->description . '">');
        array_unshift($this->data, '<meta name="keyword" content="' . $this->keywords . '">');
        array_unshift($this->data, '<link rel="shortcut icon" href="'.URL::abs('public/images/favicon.png').'">');
        
    
        array_unshift($this->data, $this->meta_encoding);


        echo implode("\n\t\t", $this->data) . "\n";
        echo HOST_ID === 0 ? $google_tracking_code_ : '' . "\n";
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
    public function add_fb_meta_tags($title, $description, $page_url, $image_url, $site_name = '', $type = '', $app_id = '', $width = 600, $height = 315) {
        $this->add('<meta property="og:title" content="' . $title . '" />');
        $this->add('<meta property="og:description" content="' . $description . '" /> ');
        $this->add('<meta property="og:url" content="' . $page_url . '" />');
        $this->add('<meta property="og:image" content="' . $image_url . '" /> ');
        $this->add('<meta property="og:image:width" content="' . $width . '" /> ');
        $this->add('<meta property="og:image:height" content="' . $height . '" /> ');
        $this->add('<meta property="og:site_name" content="' . $site_name . '" />');
        $this->add('<meta property="og:type" content="' . $type . '" />');
        $this->add('<meta property="fb:app_id" content="' . $app_id . '" />');
    }

}

?>