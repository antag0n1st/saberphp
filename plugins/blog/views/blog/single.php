<div class="container o" style="padding-top: 30px;" >
<div class="left-container o">
    <h2><?php /* @var $post BlogPost */ echo $post->title; ?></h2>
    <div class="separator"></div>
    <span class="blog-date">Објавено на: <?php echo Date::format($post->date_created); ?></span>
    <div class="blog-post"><?php echo $post->post; ?></div>
    

    <div style="margin-top: 20px; margin-bottom: 20px;">
        <div id="fb-root"></div>
            
                <script type="text/javascript">
                    //<![CDATA[    
                    document.write('<fb:like href="<?php echo URL::current_page_url(); ?>" send="false" width="450" show_faces="true" font="arial"></fb:like>');
                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {return;}
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/mk_MK/all.js#xfbml=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                    //]]>
                </script>

    </div>
    <?php if(isset($author)): ?>
    <div class="rounded-10 profile">
        <img alt="" src="<?php echo $author->image_url; ?>" />
        <span>Напишано од </span>
        <h2><?php echo $author->full_name; ?></h2>
        <p> <?php echo $author->bio; ?> </p>
        
    </div>
    <?php endif; ?>
    <h2>Коментари:</h2>
    <br />
    <?php echo $comments; ?>
    <br />
</div>

    <div class="right-container">
    <?php Load::view('elements/side_panel'); ?>
    <h2><?php echo $category->category_name; ?></h2>
    <div class="separator"></div>
    <?php foreach ($posts as $post): ?>
        <div class="latest-post">
            <a href="<?php echo URL::abs( $post->permalink . '/'.$category->latin_name . '/' . $post->id); ?>">
                <img style="width: 50px;" alt="" src="<?php echo $post->thumbnail_image_url; ?>" />
            </a>
            <h3>
                <a href="<?php echo URL::abs( $post->permalink . '/'.$category->latin_name . '/' . $post->id); ?>">
                    <?php echo $post->title; ?>
                </a>
            </h3>
        </div>
        <div class="separator"></div>
    <?php endforeach; ?>
    
</div>
    </div>