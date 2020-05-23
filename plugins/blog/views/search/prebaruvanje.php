<div class="container o" style="background-color: white;" >
    
    <div class="left">
    <h2>Резултати од Пребарувањето</h2>
    <div class="separator"></div>
    
      <div class="home-items-container">

            <?php $br=0; foreach($posts as $post): $br++; /* @var $post BlogPost */ ?>
            
            <?php echo ($br%2==1) ? '<div class="wrap">' : ''; ?>
                <div class="item">
                    <div class="frame">
                        <a href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>">
                            <img style="<?php echo $post->thumbnail_attribute; ?>" alt="" src="<?php echo URL::abs('public/uploads/'.$post->thumbnail_image_url); ?>" />
                        </a>
                    </div>
                    <h3>
                        <a href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>">
                        <?php echo $post->title; ?>
                        </a>
                    </h3>
                    <p><?php echo $post->description; ?></p>
                </div>
            <?php echo ($br%2==0) ? '</div>' : ''; ?>
            <?php endforeach; ?>
        
            <?php echo ($br%2==1) ? '</div>' : ''; ?>
            
     </div>
        <?php if (empty($posts)): ?>
        <h3>Не беа пронајдени резултати за "<b><?php echo $word; ?></b>"</h3>
        <?php endif; ?>
    
</div>

<div class="right">
    <?php Load::view('elements/side_panel'); ?>
</div>
    
</div>
