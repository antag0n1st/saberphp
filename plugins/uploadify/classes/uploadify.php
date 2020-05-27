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
    private $template = '../plugins/uploadify/views/uploadify_template';

    const SCALE_MODE_FIT = 0;
    const SCALE_MODE_FIL = 1;

    public function __construct() {
        $this->size = new stdClass();
        $this->size->width = 300;
        $this->size->height = 300;
    }

    public function display($field_name , $image_url , $template = null) {
        $image_url = $image_url ? $image_url : 'placeholder.png';
        Load::assign('image_url', $image_url);
        Load::assign('image_width', $this->size->width);
        Load::assign('image_height', $this->size->height);
        Load::assign('image_scale_mode', $this->scale_mode);
        Load::assign('field_name', $field_name);
        Load::view($template ? $template : $this->template);
    }

    public function set_size($width, $height, $scale_mode = Uploadify::SCALE_MODE_FIL) {
        $this->size->width = $width;
        $this->size->height = $height;
        $this->scale_mode = $scale_mode;
    }
    
    public function set_template($template_path) {
        $this->template = $template_path;
    }

}
