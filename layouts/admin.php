<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml"
      >
    <head>
             <?php Head::instance()->display(); ?>
    </head>
    <body>   
             <?php Load::view('elements/header'); ?>
             <?php Load::view('elements/menu'); ?>
             <?php Controller::load_main_view(); ?> 
             <?php Load::view('elements/footer'); ?>
        
             <?php if(HOST_ID == 1){ Load::app('debug'); } ?>
    </body>
</html>