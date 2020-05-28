<?php

class GalleryPhoto extends Model {

    public static $table_name = 'gallery_photos';
    public static $id_name = 'id';
    public static $db_fields = array('id','image','title','comment','created_at');
    
    	public $id;
	public $image;
	public $title;
	public $comment;
	public $created_at;


}


