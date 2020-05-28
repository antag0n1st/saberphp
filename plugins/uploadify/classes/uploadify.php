<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uploadify
 *
 * @author Antagonist
 */
class Uploadify {

    //put your code here
    /**
     *
     * @var type 
     */
    private $size;
    private $scale_mode;
    private $thumbnails = [];
    private $template = '../plugins/uploadify/views/uploadify_template';
    private $image = null;

    const SCALE_MODE_FIT = 0;
    const SCALE_MODE_FIL = 1;

    public function __construct() {
        $this->size = new stdClass();
        $this->size->width = 300;
        $this->size->height = 300;
    }

    public function display($field_name, $image_url, $template = null) {

        // when editing an image , you will call set data first , 
        // and this will be skipped , and it will go smoothly as the $image_url will be ignored in this case
        if ($this->image === null) {
            $data = [
                'url' => $image_url ? $image_url : 'placeholder.png',
                'scale_mode' => $this->scale_mode,
                'to_size' => [
                    'width' => $this->size->width,
                    'height' => $this->size->height
                ],
                'size' => [
                    'width' => $this->size->width,
                    'height' => $this->size->height
                ],
                'thumbnails' => $this->thumbnails
            ];

            $json = json_encode($data);

            $this->image = new Image($json);
        }
        
        Load::assign('image', $this->image);
        Load::assign('field_name', $field_name);


        Load::view($template ? $template : $this->template);
    }

    public function set_size($width, $height, $scale_mode = Uploadify::SCALE_MODE_FIL) {
        $this->size->width = $width;
        $this->size->height = $height;
        $this->scale_mode = $scale_mode;
    }

    /**
     * 
     * @param type $key The name identifier
     * @param type $width resize to width
     * @param type $height resize to height
     * @param type $scale_mode scale mode
     */
    public function set_thumbnail($key = 'thumb', $width = 100, $height = 100, $scale_mode = Uploadify::SCALE_MODE_FIL) {

        $thumbnail = new stdClass();
        $thumbnail->key = $key;
        $thumbnail->to_width = $width;
        $thumbnail->to_height = $height;
        $thumbnail->width = $width;
        $thumbnail->height = $height;
        $thumbnail->scale_mode = $scale_mode;

        $this->thumbnails[$key] = $thumbnail;
    }

    /**
     * Set a custom template to use , you can copy and paste it from the plugin 
     * then just edit the template to fit your needs
     * @param type $template_path
     */
    public function set_template($template_path) {
        $this->template = $template_path;
    }

    public function set_data($json) {
        $this->image = new Image($json);
    }

}
