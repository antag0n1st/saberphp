<div class="container o">
    
    <div class="left">
        <h2>
            <?php /* @var $post BlogPost */ 
            if(Membership::instance()->user->user_level >= 4){
                //echo $post->title; 
                echo '<a href="'.URL::abs('admin-posts/edit-post/'.$post->id).'">';
                echo '<img src="'.URL::image('edit.png').'" style="margin-right:5px;" />';
                echo $post->title.'</a>';
            }else{
                echo $post->title; 
            }
            
            /* @var $category BlogCategory */ ?>
        </h2>
        
        <span class="blog-date">Објавено на: <?php echo Date::format($post->release_date); ?></span>
        <span class="blog-date" style="margin-right: 10px;"> во <a href="<?php echo URL::abs($category ? $category->latin_name : ''); ?>"><?php echo $category ? $category->category_name : ''; ?></a></span>
        
          

            <script type="text/javascript">
                //<![CDATA[    
                document.write('<fb:like href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>" send="true" layout="button_count" width="130" show_faces="false" ></fb:like>');
                //]]>
            </script>
            
            <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(URL::abs($post->permalink.'/'.$post->id)); ?>" target="_blank" rel="nofollow" style="margin-right: 5px;text-decoration: none;border: none;" >
                <img alt="facebook share" src="<?php echo URL::image('share.png'); ?>">
            </a>
            
            
            <a href="https://twitter.com/share" class="twitter-share-button" data-via="ladymk_info">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

       
        <div class="separator dashed"></div>
        <div class="blog-post o"><?php echo $post->post; ?></div>


        <div style="margin-top: 20px; margin-bottom: 20px; position: relative;">
          

            <script type="text/javascript">
                //<![CDATA[    
                document.write('<fb:like href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>" send="true" layout="button_count" width="130" show_faces="false" ></fb:like>');
                //]]>
            </script>
            
            <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(URL::abs($post->permalink.'/'.$post->id)); ?>" target="_blank" rel="nofollow" style="margin-right: 5px;text-decoration: none;border: none;" >
                <img alt="facebook share" src="<?php echo URL::image('share.png'); ?>">
            </a>
            
            
            <a href="https://twitter.com/share" class="twitter-share-button" data-via="ladymk_info">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            <span style="float: right;">
                <script type="text/javascript">
                //<![CDATA[    
                document.write('<fb:like-box href="http://www.facebook.com/pages/Ladymk/137461013013771" width="170" show_faces="false" stream="false" header="false"></fb:like-box>');
                //]]>
            </script>
            </span>
            
            
            
        </div>
        <?php if ($post->is_author_visible): //if(isset($author)): ?>
            <div class="rounded-10 profile">
                <img alt="" src="<?php echo $author->image_url; ?>" />
                <span>Напишано од </span>
                <h2><?php echo $author->full_name; ?></h2>
                <p> <?php echo $author->bio; ?> </p>

            </div>
        <?php endif; ?>
        <div>
            <h2 style="margin-bottom: 10px;">Може да ве интересира и:</h2>
            <div class="separator"></div>
            <div class="related-items">
                <?php foreach($related_posts as $p): ?>
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
            
            
        </div>
        <div class="o" style="margin: 10px auto 10px auto;">
            Тагови:
            <?php $tags = explode(',', $post->keywords);
           
            $tags_data = array();
            foreach($tags as $tag){
                $tags_data[] = " <a href='".URL::abs('tag/'.  urlencode(trim($tag))."'>".trim($tag)."</a>");
            }
            
            echo implode(',', array_values($tags_data));
            ?>
        </div>
        
        <h2 style="margin-bottom: 0px; margin-top: 15px;">Коментари:</h2>
        
        <?php echo $comments; ?>
    </div>
    
    
    <div class="right">
        
        <?php Load::view('elements/side_panel'); ?>

    </div>
    
    
</div>




