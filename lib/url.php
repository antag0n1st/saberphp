<?php
/**
 * Class used to maintain URLs 
 * @author Antagonist
 */
class URL{
    /**
     * coverts relative to absoulte URL
     * @param type $url
     * @return type 
     */
    public static function abs($url){
        return BASE_URL.''.$url;
    }
    /**
     * absolute path pointing to /public/images/
     * @param type $name_
     * @return type 
     */
    public static function image($name_){
        return BASE_URL.'images/'.$name_;
    }
    /**
     * get the base url
     * @return string 
     */
    public static function get_base_url(){
        return BASE_URL;
    }
    /**
     * redirect to RELATIVE URL
     * @param type $url 
     */
    public static function redirect($url){
        header('Location: '.BASE_URL.$url);
        exit;
    }
    /**
     * gets the IP address of user requesting a page
     * @return type 
     */
    public static function get_real_ip_addr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    /**
     * gets the current page URL
     * @return string 
     */
    public static function current_page_url(){
        
         $pageURL = 'http';
         if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
         }
         return $pageURL;
        
    }
}

?>