<?php

/**
 * the array that contains the filenames and classes 
 * that should be loaded for the plugin to work
 */
$conf = array(
            'css' => 'dd', // name of the files
            'js'  => array('membership','jquery.dd') , // name of the files    
            'classes' => array('membership') ,
            'controllers' => 'membership',
            'onload' => 'onload' // the file name in the plugin root that needs to be called on every page load
);

?>
