<div class="container o" style="padding-top: 30px;" >
    
    <div class="left-container">
    <h2><?php echo $category->category_name; ?></h2>
    <div class="separator"></div>
    <br />
    <?php foreach($posts as $post): /* @var $post BlogPost */ /* @var $category BlogCategory */ ?>    

    <div class="item-wrapper">
            <h2>
                <a href="<?php echo URL::abs($post->permalink.'/'.$category->latin_name.'/'.$post->id); ?>">
                <?php echo $post->title; ?>
                </a>
            </h2>
            <div class="separator"></div>
            <div class="thumbnail-image">
                <a href="<?php echo URL::abs($post->permalink.'/'.$category->latin_name.'/'.$post->id); ?>">
                    <img style="width: 250px;" alt="" src="<?php echo $post->thumbnail_image_url; ?>" />
                </a> 
            </div>
            <p>
                <?php echo $post->description; ?>
            </p>
            <div class="button-link">
                <a href="<?php echo URL::abs($post->permalink.'/'.$category->latin_name.'/'.$post->id); ?>">Прочитај Повеќе</a>
            </div>


    </div>
    <div class="light-serparator"></div>
    <?php endforeach; ?>
    
    <?php /* @var $paginator Paginator */ $paginator->build_pagination_html(); ?>
    
</div>

<div class="right-container">
    <?php Load::view('elements/side-panel'); ?>
</div>
    
</div>
