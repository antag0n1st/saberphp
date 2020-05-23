<?php

/**
 * the array that contains the filenames and classes 
 * that should be loaded for the plugin to work
 */
$conf = array(
            'css' => '', // name of the files
            'js'  => '' , // name of the files
            'controllers' => array('blog','admin_posts','search','avtori') , 
            'onload' => '' // the file name in the plugin root that needs to be called on every page load
);