<div class="container">
    <?php
    Load::script('plugins/ckeditor/ckeditor');
    Load::script('plugins/ckfinder/ckfinder');
    /* @var $post BlogPost */
    ?>
    <form method="post" action="" >

        <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" />

        <div class="write-post" >

            <div class="left o" style="width: 320px;" > 
                <div id="datepicker"></div>
                <input type="hidden" id="publish_date" name="publish_date" value="<?php echo $post->release_date; ?>" />
                <script type="text/javascript">
           
                    var date_picked = function(dateText, inst){
                        
                        // check in date changes
                        var last_date = $("#publish_date").val();
                        var new_date  = dateText;
                        
                        var l_date = last_date.split(' ')[0];
                        var n_date = new_date.split(' ')[0];
                        
                        if(l_date !== n_date){
                            new_date =  n_date + ' 07:00';  
                            $.datepicker._setTime(inst,new Date(new_date));                          
                        }
                   
                        $("#publish_date").val(new_date);
                    };
                    
                  //  $( "#datepicker" ).datetimepicker();
                   
                    $(function() {
                        
                        
                        the_picker = $( "#datepicker" ).datetimepicker({
                            onSelect: date_picked , 
                            dateFormat: 'yy-mm-d' ,
                            defaultDate : '<?php echo TimeHelper::to_date($post->release_date); ?>',
                            hour : '<?php echo TimeHelper::extract_hour($post->release_date); ?>',
                            minute : '<?php echo TimeHelper::extract_minute($post->release_date); ?>'
                        });
                        
                        
                        $('#myULTags').tagit({
			    allowSpaces : true ,
			    itemName: 'item',
			    fieldName: 'tags' , 
                            tagSource : function(search, showChoices) {
                            
                                  $.getJSON(base_url+'search/tags', {term:search.term}, function(data){
                                  
                                          showChoices(data);
                                    });

                              
                            } ,
                            onTagAdded: function(event, tag) {
                                    $("#keywords").val($("#myULTags").tagit("assignedTags").toString()+','+$(tag).find('span[class="tagit-label"]').html());
                            },
                            onTagRemoved: function(event, tag) {
                               var result = $("#myULTags").tagit("assignedTags");
                               removeByValue(result,$(tag).find('span[class="tagit-label"]').html());
                                    $("#keywords").val(result.toString());
                            }
                      });
                        
                    });
        
        function removeByValue(arr, val) {
            for(var i=0; i<arr.length; i++) {
                if(arr[i] == val) {
                    arr.splice(i, 1);
                    break;
                }
            }
        }
        
                </script>
            </div>

            <div class="left o" style="width: 220px; text-align: center;">
                <?php
              
                Uploadify::$FIELD_NAME = 'thumbnail_url';
                
                Uploadify::$HEIGHT = 250;
                Uploadify::$WIDTH = 350;
                Uploadify::$PATH = 'public/uploads';
                Uploadify::$DEFAULT_IMAGE = $post->thumbnail_image_url;
                Uploadify::push_values();
                
                Uploadify::$PATH = 'public/uploads/thumbnails';
                Uploadify::$HEIGHT = 30;
                Uploadify::$WIDTH = 42;
                Uploadify::$DEFAULT_IMAGE = $post->thumbnail_image_url;
                Uploadify::push_values();
                
                Uploadify::$PATH = 'public/uploads/large-thumbnails';
                Uploadify::$HEIGHT = 100;
                Uploadify::$WIDTH = 140;
                Uploadify::$DEFAULT_IMAGE = $post->thumbnail_image_url;
                Uploadify::push_values();
                
                
                                
                Uploadify::display();
                ?>
            </div>



            <div class="left o" style="width: 400px;" > 
                <input id="title" type="text" name="title" value="<?php echo $post->title; ?>" />

                <br />

                <textarea id="description" name="description"><?php echo $post->description; ?></textarea>

                <br />

                <input type="hidden" id="keywords" name="keywords" value="<?php echo $post->keywords; ?>" />
                <ul id="myULTags">
                    <?php $tags = preg_split("/[,-]+/", $post->keywords); ?>
                    <?php foreach($tags as $tag){
                        echo "<li>".$tag."</li>";
                    } ?>
	        </ul>

                <br />



            </div>




        </div>


        <br />
        <div style="overflow: hidden;">
            <div style="width: 720px; overflow: hidden; float: left;">


                <?php
                $ckeditor = new CKEditor();
                $ckeditor->config['height'] = 600;
                $ckeditor->config['width'] = 720;
                $ckeditor->basePath = BASE_URL . 'plugins/ckeditor/';
                CKFinder::SetupCKEditor($ckeditor, '../../plugins/ckfinder/');

                $ckeditor->editor('post', $post->post);
                ?>
            </div>
            
            
            <div class="o l" id="blog_categories" style="width: 270px; padding-left: 10px; margin-bottom: 10px;">
                <h2 style="float: left;">категорија:</h2> <br /><br />
                <div style="float: left;">
                    <?php $br = 0; /* @var $category BlogCategory */ foreach ($categories as $category) { ?>

                        <input <?php
                    if ($category->id == $post->blog_categories_id) {
                        echo 'checked="checked"';
                    }
                    ?> id="cat-<?php echo $category->id; ?>" style="float:left; cursor: pointer;" type="radio" name="category" value="<?php echo $category->id; ?>" />
                        <label style="float: left; cursor: pointer;" for="cat-<?php echo $category->id; ?>"><?php echo$category->category_name; ?></label> 
                        <br />
                <?php } ?>
                </div>
                <br />
                
                <h2 style="float: left;margin-top: 20px;">Таг:</h2> <br /><br />
                <div style="float: left; margin-top: 10px; width: 100%;">
                    <input id="post-none-tag" type="radio" value="none" name="thumbnail-tag" <?php echo ($post->thumbnail_tag == 'none') ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
                    <label for="post-none-tag" style="float: left; cursor: pointer;" >Без Таг</label>
                    <br />
                    <input id="post-photo-tag" type="radio" value="photo" name="thumbnail-tag" <?php echo ($post->thumbnail_tag == 'photo') ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
                    <label for="post-photo-tag" style="float: left; cursor: pointer;" >Фото</label>
                    <br />
                    <input id="post-video-tag" type="radio" value="video" name="thumbnail-tag" <?php echo ($post->thumbnail_tag == 'video') ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
                    <label for="post-video-tag" style="float: left; cursor: pointer;" >Видео</label>
                </div>
                <br />
                <br />

                <h2 style="float: left;margin-top: 20px;"> Начин на објава:</h2> <br /><br />
                <div style="float: left; margin-top: 10px; width: 100%;">
                    <input id="post-enabled" type="radio" value="1" name="enabled" <?php echo ($post->enabled == 1) ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
                    <label for="post-enabled" style="float: left; cursor: pointer;" >Јавно Достапно</label>
                    <br />
                    <input id="post-disabled" type="radio" value="0" name="enabled" <?php echo ($post->enabled == 0) ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
                    <label for="post-disabled" style="float: left; cursor: pointer;" >Скриено</label>
                </div>
                
                <?php if(Membership::instance()->user->user_level >=9): ?>
                
                    <br />
                    <br />
                    <h2 style="float: left;margin-top: 20px;"> Автор:</h2> <br />
                    <select name="user_id" id="user_id" >
                        <?php foreach ($writers as $writer): ?>
                        <option <?php if($writer['user_id']==$post->author){ echo 'selected="selected"';} ?>  value="<?php echo $writer['user_id']; ?>"><?php echo $writer['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br />
                    <input <?php echo $post->is_author_visible ? 'checked="checked"' : ''; ?> style="cursor: pointer;" id="is_author_visible" name="is_author_visible" type="checkbox" />
                    <label style="cursor: pointer;" for="is_author_visible">Јавно Видлив</label>
                        
                                 
                <?php endif; ?>
                
                <br />
                <br />
                
                <div style="float: left; margin-top: 10px;">
                    <input   type="submit" value="Зачувај" class="button round" />
                    <input id="delete-post" type="button" value="Избриши" class="button round red" />
                </div>

            </div>
<a target="_blank" href="<?php echo URL::abs($post->permalink.'/'.$post->id); ?>" id="preview" style="margin-left: 10px; ">Види како ќе изгледа</a>
        </div>







    </form>

    <script type="text/javascript" >
        $(document).ready(function(){
            $("#delete-post").click(function(){
            
                confirmation();
            
            
            });
        });
        
     
    
        function confirmation() {
            var answer = confirm("Сигурно ли сакаш да ја избришеш статијата ?")
            if (answer){
                $("#delete-form").submit();
                return true;
            }
            else{
                return false;
            }
        }

    </script>

    <form id="delete-form" method="post" action="<?php echo URL::abs('admin-posts/delete-post'); ?>">
        <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" />
    </form>
</div>