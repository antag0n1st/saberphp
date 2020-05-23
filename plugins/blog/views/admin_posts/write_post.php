<div class="container">
    <?php
    Load::script('plugins/ckeditor/ckeditor');
    Load::script('plugins/ckfinder/ckfinder');
    ?>
    <form method="post" action="" >
        <div class="write-post" >

            <div class="left o" style="width: 320px;" > 
                <div id="datepicker"></div>
                <input type="hidden" id="publish_date" name="publish_date" value="<?php echo TimeHelper::DateTimeAdjusted(); ?>" />
                <input type="hidden" id="auto_save_id" name="auto_save_id" value="0" />
                <script type="text/javascript" src="<?php echo BASE_URL ?>plugins/ckfinder/ckfinder.js"></script>
                
            </div>

            <div class="left o" style="width: 220px; text-align: center;">
                <?php
                Uploadify::$FIELD_NAME = 'thumbnail_url';
                
                Uploadify::$HEIGHT = 250;
                Uploadify::$WIDTH = 350;
                Uploadify::$PATH = 'public/uploads';
                Uploadify::push_values();
                
                Uploadify::$PATH = 'public/uploads/thumbnails';
                Uploadify::$HEIGHT = 30;
                Uploadify::$WIDTH = 42;
                Uploadify::push_values();
                
                Uploadify::$PATH = 'public/uploads/large-thumbnails';
                Uploadify::$HEIGHT = 100;
                Uploadify::$WIDTH = 140;
                Uploadify::push_values();
                
                
                
                Uploadify::display();
                ?>
            </div>



            <div class="left o" style="width: 400px;" > 
                <input id="title" type="text" name="title" value="Наслов" style="color: #666" />

                <br />

                <textarea id="description" name="description" style="color: #666" >Опис</textarea>

                <br />

                <input id="keywords" type="hidden" name="keywords" value="" style="color: #666" />
                <ul id="myULTags">
	        </ul>

                <br />
                <script type="text/javascript" src="<?php echo BASE_URL ?>plugins/ckfinder/ckfinder.js"></script>

                <script type="text/javascript">
                
                    $(document).ready(function(){
                    
                        $("#title").focus(function(){
                            if($(this).val() == 'Наслов'){
                                $(this).val('');
                                $(this).css('color', 'black');
                            }
                        });
                    
                        $("#description").focus(function(){
                            if($(this).val() == 'Опис'){
                                $(this).val('');
                                $(this).css('color', 'black');
                            }
                        });
                    
                        $("#keywords").focus(function(){
                            if($(this).val() == 'Клучни Зборови'){
                                $(this).val('');
                                $(this).css('color', 'black');
                            }
                        });
                    
                        $("#title").blur(function(){
                            if($(this).val() == ''){
                                $(this).val('Наслов');
                                $(this).css('color', '#666');
                            }
                        });
                
                        $("#description").blur(function(){
                            if($(this).val() == ''){
                                $(this).val('Опис');
                                $(this).css('color', '#666');
                            }
                        });
                    
                        $("#keywords").blur(function(){
                            if($(this).val() == ''){
                                $(this).val('Клучни Зборови');
                                $(this).css('color', '#666');
                            }
                        });
                    
                    
                    });

               
                </script>



            </div>


        </div>


        <br />
        <div style="overflow: hidden;">
            <div id="the_post" style="width: 720px; overflow: hidden; float: left;">


                <?php
                $ckeditor = new CKEditor();
                $ckeditor->config['height'] = 600;
                $ckeditor->config['width'] = 720;
                $ckeditor->basePath = BASE_URL . 'plugins/ckeditor/';
                CKFinder::SetupCKEditor($ckeditor, '../plugins/ckfinder/');

                $ckeditor->editor('post');
                ?>
            </div>
            
            
            <div class="o l" id="blog_categories" style="width: 270px; padding-left: 10px; margin-bottom: 10px;">
                <h2 style="float: left;">категорија:</h2> <br /><br />
                <div style="float: left;">
                    <?php $br = 0; /* @var $category BlogCategory */ foreach ($categories as $category) { ?>

                    <input onclick="select_category('<?php echo $category->id; ?>');"  id="cat-<?php echo $category->id; ?>" style="float:left; cursor: pointer;" checked="checked" type="radio" name="category" value="<?php echo $category->id; ?>" />
                        <label onclick="select_category('<?php echo $category->id; ?>');" style="float: left; cursor: pointer;" for="cat-<?php echo $category->id; ?>"><?php echo $category->category_name; ?></label> 
                        <br />
                <?php } ?>
                        <input type="hidden" id='selected-category' value='1' />
                </div>
               
                <br />
                <h2 style="float: left;margin-top: 20px;"> Таг:</h2> <br />
                <div style="float: left; width: 100%;">
                    <input id="post-none-tag" type="radio" value="none" name="thumbnail-tag" checked="checked"  style="float:left; cursor: pointer;" />
                    <label for="post-none-tag" style="float: left; cursor: pointer;" >Без Таг</label>
                    <br />
                    <input id="post-photo-tag" type="radio" value="photo" name="thumbnail-tag" style="float:left; cursor: pointer;" />
                    <label for="post-photo-tag" style="float: left; cursor: pointer;" >Фото</label>
                    <br />
                    <input id="post-video-tag" type="radio" value="video" name="thumbnail-tag"  style="float:left; cursor: pointer;" />
                    <label for="post-video-tag" style="float: left; cursor: pointer;" >Видео</label>
                </div>
                 <br />
                <br />
                <h2 style="float: left;margin-top: 20px;"> Начин на објава:</h2> <br />
                <div style="float: left;  width: 100%;">
                    <input id="post-enabled" type="radio" value="1" name="enabled" checked="checked"  style="float:left; cursor: pointer;" />
                    <label for="post-enabled" style="float: left; cursor: pointer;" >Јавно Достапно</label>
                    <br />
                    <input id="post-disabled" type="radio" value="0" name="enabled"  style="float:left; cursor: pointer;" />
                    <label for="post-disabled" style="float: left; cursor: pointer;" >Скриено</label>
                </div>
                
                <?php if(Membership::instance()->user->user_level >=9): ?>
                
                    <br />
                    <br />
                    <h2 style="float: left;margin-top: 20px;"> Автор:</h2> <br />
                    <select name="user_id" id="user_id" >
                        <?php foreach ($writers as $writer): ?>
                            <option <?php echo (Membership::instance()->user->id == $writer['user_id']) ? ' selected="selected" ' : ''; ?> value="<?php echo $writer['user_id']; ?>"><?php echo $writer['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br />
                    <input style="cursor: pointer;" id="is_author_visible" name="is_author_visible" type="checkbox" />
                    <label style="cursor: pointer;" for="is_author_visible">Јавно Видлив</label>
                        
                <?php endif; ?>
                    
                  <br />
                  <br />
               
                <div style="float: left; margin-top: 10px;">
                    <input type="submit" value="Зачувај" class="button round" />
                </div>
                <br />
                <br />
                
            </div>
            
            

        </div>


    </form>
    
</div>
<div class="container o">
    <a target="_blank" href="#" style="float: right; margin-right: 50px;" id="preview" >Види како ќе изгледа</a>
</div>


<script type="text/javascript">
           
//                    var date_picked = function(dateText, inst){
//                        $("#publish_date").val(dateText);
//                    };
                    
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
                 
                    $(function() {
                      
                        
                         $( "#datepicker" ).datetimepicker({
                            onSelect: date_picked , 
                            dateFormat: 'yy-mm-d' ,                        
                            hour : '<?php echo TimeHelper::extract_hour(TimeHelper::DateTimeAdjusted()); ?>',
                            minute : '<?php echo TimeHelper::extract_minute(TimeHelper::DateTimeAdjusted()); ?>'
                        });
                        
                        
                          $('#myULTags').tagit({
			  
			    // configure the name of the input field (will be submitted with form), default: item[tags]
			    itemName: 'item',
			    fieldName: 'tags' , 
                            allowSpaces : true ,
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
                    
                    function select_category(cat_id){
                      $("#selected-category").val(cat_id);
                    };
                
                    function auto_save_post(){
                    
                        setTimeout(function(){
                           
                            $.post(base_url+'admin-posts/auto-save-post',{
                                auto_save_id : $("#auto_save_id").val() ,
                                title : $("#title").val() ,
                                description : $("#description").val() , 
                                post : CKEDITOR.instances.post.getData() ,
                                category : $("#selected-category").val() , 
                                keywords : $("#keywords").val() , 
                                publish_date : $("#publish_date").val() , 
                                thumbnail_url : $("#thumbnail_url<?php echo Uploadify::$RAND_ID; ?>").val() ,
                                thumbnail_tag : 'none',
                                user_id : $("#user_id").val()
                            },function(data){
                                $("#auto_save_id").val(data);
                                
                                $("#preview").attr('href', '<?php echo URL::abs('preview-naslov/'); ?>'+data);
                                
                                auto_save_post();

                            });
                           
                        },1000*5); // auto save every 5 seconds
                        
                    }
                
                    auto_save_post();
        
        
        
                </script>