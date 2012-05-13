<div class="container">
 <?php
Load::script('plugins/ckeditor/ckeditor');
Load::script('plugins/ckfinder/ckfinder');
?>
<form method="post" action="" >
    <div class="write-post" >

        <div class="left o" style="width: 320px;" > 
            <div id="datepicker"></div>
            <input type="hidden" id="publish_date" name="publish_date" value="<?php echo date("Y-m-d"); ?>" />
            <input type="hidden" id="auto_save_id" name="auto_save_id" value="0" />
            <script type="text/javascript">
           
                var date_picked = function(dateText, inst){
                    $("#publish_date").val(dateText);
                }
                 
                $(function() {
                    $( "#datepicker" ).datepicker({
                        onSelect: date_picked , 
                        dateFormat: 'yy-mm-d' 
                    });
                });
                
                function auto_save_post(){
                    
                       setTimeout(function(){
                           
                           $.post(base_url+'admin-posts/auto-save-post',{
                                auto_save_id : $("#auto_save_id").val() ,
                                title : $("#title").val() ,
                                description : $("#description").val() , 
                                post : CKEDITOR.instances.post.getData() ,
                                category : '1' , 
                                keywords : $("#keywords").val() , 
                                publish_date : $("#publish_date").val() , 
                                thumnail_url : $("#thumnail_url").val() 
                            },function(data){
                                $("#auto_save_id").val(data);
                                
                                $("#preview").attr('href', '<?php echo URL::abs('preview-naslov/joga/'); ?>'+data);
                                
                                
                                
                                auto_save_post();

                            });
                           
                       },1000*20);
                        
                }
                
                auto_save_post();
        
        
        
            </script>
        </div>

        <div class="left o" style="width: 220px; text-align: center;">
            <input id="thumnail_url" name="thumnail_url" type="hidden" value="<?php echo BASE_URL . 'plugins/blog/images/movie_thumbnail.jpg'; ?>"  />
            <img id="thumbnail_image_preview" src="<?php echo BASE_URL . 'plugins/blog/images/movie_thumbnail.jpg'; ?>" />
            <input type="button" value="Галерија" onclick="BrowseServer();" style="width: 80px; float: left; margin-left: 15px;" class="buttonBlue"  />
            <label for="xFilePath" style="float: left; margin-left: 5px;">Одбери Слика</label>
        </div>



        <div class="left o" style="width: 400px;" > 
            <input id="title" type="text" name="title" value="Наслов" style="color: #666" />

            <br />

            <textarea id="description" name="description" style="color: #666" >Опис</textarea>

            <br />

            <input id="keywords" type="text" name="keywords" value="Клучни Зборови" style="color: #666" />

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

                function BrowseServer()
                {
                    var finder = new CKFinder();
                    finder.selectActionFunction = SetFileField;
                    finder.popup();
                }

                function SetFileField( fileUrl )
                { console.log();
                    $("#thumnail_url").val(fileUrl);
                          
                    $("#thumbnail_image_preview").attr('src', fileUrl);
                }

            </script>



        </div>






    </div>


<br />
    <div style="overflow: hidden;">
        <div id="the_post" style="width: 690px; overflow: hidden; float: left;">
            
        
        <?php
        $ckeditor = new CKEditor();
        $ckeditor->config['height'] = 500;
        $ckeditor->config['width'] = 690;
        $ckeditor->basePath = BASE_URL . 'plugins/ckeditor/';
        CKFinder::SetupCKEditor($ckeditor, '../plugins/ckfinder/');

        $ckeditor->editor('post');
        ?>
</div>
        <div class="o left" id="blog_categories" style="width: 240px; padding-left: 10px;">
            <h2 style="float: left;"> Категорија:</h2> <br /><br />
            <?php $br = 0; /* @var $category BlogCategory */ foreach ($categories as $category) { ?>

                <input  <?php  if ($br++ == 0) {  echo 'checked="checked"'; } ?> 
                    id="cat-<?php echo $category->id; ?>" 
                    style="float:left; cursor: pointer;" 
                    type="radio" 
                    name="category" 
                    value="<?php echo $category->id; ?>" />
                
                    <label style="float: left; cursor: pointer;" for="cat-<?php echo $category->id; ?>"><?php echo$category->category_name; ?></label> 
                    <br />
                        <?php } ?>
<br />

<h2 style="float: left;"> Начин на објава:</h2> <br /><br />
<input id="post-enabled" type="radio" value="1" name="enabled" checked="checked" style="float:left; cursor: pointer;" />
<label for="post-enabled" style="float: left; cursor: pointer;" >Јавно Достапно</label>
<br />
<input id="post-disabled" type="radio" value="0" name="enabled" style="float:left; cursor: pointer;" />
<label for="post-disabled" style="float: left; cursor: pointer;" >Скриено</label>

<br />
<br />
                    <input type="submit" value="Објави" class="buttonBlue" />
        </div>
        
        <a target="_blank" href="#" id="preview" style="margin-left: 10px; ">Види како ќе изгледа</a>

    </div>

    
</form>
</div>