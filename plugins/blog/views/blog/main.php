<div class="container o">
    
    <div class="left" >
    <h2>
        <a href="<?php /* @var $category BlogCategory */ echo URL::abs($category->latin_name); ?>">
        <?php echo $category->category_name; ?>
        </a>
    </h2>
        
    <div class="separator"></div>
    <div id="popular_items_c" style="position: relative;">
            <h2 style="margin-bottom: 10px;">Најпопуларни статии:</h2>
            
            <div class="f-tabs" style="top: 0px;">
                <div class="active" onclick="tab_click_c(this,'week-c');" >Последната недела</div>
                <div onclick="tab_click_c(this,'month-c');">Последниот месец</div>
                <div onclick="tab_click_c(this,'year-c');">Последната година</div>
            </div>
            <script>
                
                function tab_click_c(o,name){
                    $("#popular_items_c .f-tabs div").removeClass('active');
                    $(o).addClass('active');
                    $("#popular_items_c .related-items").css('display', 'none');
                    $("#"+name).css('display','block');
                }
            
            </script>
            
            <div class="separator"></div>
            
            <?php foreach($most_popular_category as $type => $top_posts): ?>
            <div style="<?php if($type!='week'){ echo "display:none;"; } ?>" id="<?php echo $type.'-c'; ?>" class="related-items">
                <?php foreach($top_posts as $p): ?>
                <div class="item">
                    <div class="frame">
                        <a href="<?php echo URL::abs($p->permalink.'/'.$p->id); ?>">
                            <img style="<?php echo $p->thumbnail_attribute; ?>" alt="" src="<?php echo URL::abs('public/uploads/large-thumbnails/'.$p->thumbnail_image_url); ?>" />
                        </a>
                    </div>
                    <h3>
                        <a href="<?php echo URL::abs($p->permalink.'/'.$p->id); ?>">
                        <?php echo $p->title; ?>
                        </a>
                    </h3>
                </div>
                <?php endforeach; ?>
                
            </div>
            <?php endforeach; ?>
            
        </div>
    <div class="separator"></div>
    <div class="home-items-container">
        <h2 style="margin-bottom: 10px;">Останати статии:</h2>
            <?php foreach($posts as $post):  /* @var $post BlogPost */ ?>
                <div class="item">
                    <div class="frame">
                        <a href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>">
                            <img alt="" src="<?php echo URL::abs('public/uploads/large-thumbnails/'.$post->thumbnail_image_url); ?>" />
                        </a>
                    </div>
                    <h3>
                        <a href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>">
                        <?php echo $post->title; ?>
                        </a>
                    </h3>
                    <p><?php echo String::smart_short($post->description); ?></p>
                </div>        
            <?php endforeach; ?>
     </div>
    
    <?php /* @var $paginator Paginator */ $paginator->display(); ?>
    
</div>

<div class="right">
    <?php Load::view('elements/side_panel'); ?>
</div>
    
</div>
