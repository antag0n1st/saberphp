<?php

Load::script('controllers/admin');

class HomeController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function main() {

      

        $this->set_menu('home');
        
//          $this->no_layout();
//        
//        // create a new mysql query builder
//        $h = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) {
//
//            $queryString = preg_replace_callback('/\?/', function( $match) use( &$queryParameters) {
//                $param = array_shift($queryParameters);
//                //TODO , db escape the string here
//                return  '\''.$param. '\'';
//            }, $queryString);
//
//            return $queryString;
//            
//        });
//
//        $r = $h->table('keywords')->insert(['word' => 'ABC', 'count' => 1, 'is_ignored' => 0, 'created_at' => '2020/06/05 12:00:00'])->execute();
//
//        var_dump($r);
    }

    public function about() {
        
    }

    public function contact() {
        
    }

}
