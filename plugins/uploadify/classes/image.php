<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image
 *
 * @author Antagonist
 */
class Image {

    //put your code here

    public $url = '';
    public $size;
    public $to_size;
    public $scale_mode;
    public $thumbnails = [];

    public function __construct($json = null) {

        if ($json) {
            $json_decoded = json_decode($json);

            $this->url = $json_decoded->url;
            $this->to_size = $json_decoded->to_size;

            if (isset($json_decoded->size)) {
                $this->size = $json_decoded->size;
            }

            $this->scale_mode = $json_decoded->scale_mode;
            $this->thumbnails = $json_decoded->thumbnails;
        } else {
            $this->size = new stdClass();
            $this->size->width = 600;
            $this->size->height = 600;

            $this->to_size = new stdClass();
            $this->to_size->width = 600;
            $this->to_size->height = 600;
        }
        
    }

    public function thumbnail($key = 'thumb') {

        if (isset($this->thumbnails->$key)) {

            $tdata = $this->thumbnails->$key;

            $parts = explode('/', $this->url);
            $name = array_pop($parts);
            $path = implode('/', $parts) . '/';

            $thumbnail = new stdClass();
            $thumbnail->url = CONTENT_URL . $path . 'thumbs/' . $key . '-' . $name;

            $thumbnail->size = new stdClass();
            $thumbnail->size->width = $tdata->width;
            $thumbnail->size->height = $tdata->height;

            $thumbnail->to_size = new stdClass();
            $thumbnail->to_size->width = $tdata->to_width;
            $thumbnail->to_size->height = $tdata->to_height;

            return $thumbnail;
        } else {
            $thumbnail = new stdClass();
            $thumbnail->url = $this->url();
            $thumbnail->size = $this->size;
            $thumbnail->to_size = $this->to_size;
            return $thumbnail;
        }
    }

    public function url() {
        return CONTENT_URL . $this->url;
    }

}
