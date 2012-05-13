<div class="container o" style="padding-top: 30px;" >
    
    <div class="left-container">
    <h2>Резултати од Пребарувањето</h2>
    <div class="separator"></div>
    <br />
    <?php foreach($posts as $post): /* @var $post BlogPost */ ?>
        <div class="item-wrapper">
            <h2>
                <a href="<?php echo URL::abs($post->permalink.'/'.BlogCategory::get_category_by_id($post->blog_categories_id).'/'.$post->id); ?>"><?php echo $post->title; ?></a>
            </h2>
            <div class="separator w"></div>
            
            
            <div class="thumbnail-wraper" >
                <div class="thumbnail-image" style="height: 150px;">
                    <a style="height: 145px;" href="<?php echo URL::abs($post->permalink.'/'.BlogCategory::get_category_by_id($post->blog_categories_id).'/'.$post->id); ?>">
                    <img style="width: 220px;" alt="" src="<?php echo $post->thumbnail_image_url; ?>" /></a> 
            </div>
            </div>
            <p>
                <?php echo $post->description; ?>
            </p>
            <div class="button-link">
                <a href="<?php echo URL::abs($post->permalink.'/'.BlogCategory::get_category_by_id($post->blog_categories_id).'/'.$post->id); ?>">Прочитај Повеќе</a>
            </div>
        </div>
        <div class="separator w"></div>
<?php endforeach; ?> 
        <?php if (empty($posts)): ?>
        <h3>Не беа пронајдени резултати за "<b><?php echo $word; ?></b>"</h3>
        <?php endif; ?>
    
</div>

<div class="right-container">
    <?php Load::view('elements/side-panel'); ?>
</div>
    
</div>
