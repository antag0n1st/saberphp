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
            <input type="hidden" id="publish_date" name="publish_date" value="<?php echo $post->date_created; ?>" />
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
        
        
        
            </script>
        </div>
    
    <div class="left o" style="width: 220px; text-align: center;">        
        <input id="thumnail_url" name="thumnail_url" type="hidden" value="<?php echo $post->thumbnail_image_url; ?>"  />        
        <img id="thumbnail_image_preview" src="<?php echo $post->thumbnail_image_url; ?>" />
        <input type="button" value="Галерија" onclick="BrowseServer();" style="width: 80px; float: left; margin-left: 15px;" class="buttonBlue"  />
        <label for="xFilePath" style="float: left; margin-left: 5px;">Одбери Слика</label>
    </div>
        
    
    
    <div class="left o" style="width: 400px;" > 
        <input id="title" type="text" name="title" value="<?php echo $post->title; ?>" />
       
        <br />

        <textarea id="description" name="description"><?php echo $post->description; ?></textarea>
       
        <br />

        <input id="keywords" type="text" name="keywords" value="<?php echo $post->keywords; ?>" />
       
        <br />
        <script type="text/javascript" src="<?php echo BASE_URL ?>plugins/ckfinder/ckfinder.js"></script>
  
        
        	<script type="text/javascript">

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
        <div style="width: 690px; overflow: hidden; float: left;">
            
        
        <?php
        $ckeditor = new CKEditor();
        $ckeditor->config['height'] = 500;
        $ckeditor->config['width'] = 690;
        $ckeditor->basePath = BASE_URL . 'plugins/ckeditor/';
        CKFinder::SetupCKEditor($ckeditor, '../../plugins/ckfinder/');

        $ckeditor->editor('post',$post->post);
        ?>
</div>
        <div class="o left" id="blog_categories" style="width: 230px; padding-left: 10px;">
            <h2 style="float: left;">категорија:</h2> <br /><br />
            <div style="float: left;">
            <?php $br = 0; /* @var $category BlogCategory */ foreach ($categories as $category) { ?>

                <input <?php if($category->id == $post->blog_categories_id){ echo 'checked="checked"'; } ?> id="cat-<?php echo $category->id; ?>" style="float:left; cursor: pointer;" type="radio" name="category" value="<?php echo $category->id; ?>" />
                <label style="float: left; cursor: pointer;" for="cat-<?php echo $category->id; ?>"><?php echo$category->category_name; ?></label> 
                <br />
                        <?php } ?>
           </div>
<br />

<h2 style="float: left;margin-top: 20px;"> Начин на објава:</h2> <br /><br />
<div style="float: left; margin-top: 10px;">
<input id="post-enabled" type="radio" value="1" name="enabled" <?php echo ($post->enabled == 1) ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
<label for="post-enabled" style="float: left; cursor: pointer;" >Јавно Достапно</label>
<br />
<input id="post-disabled" type="radio" value="0" name="enabled" <?php echo ($post->enabled == 0) ? ' checked="checked" ' : ''; ?> style="float:left; cursor: pointer;" />
<label for="post-disabled" style="float: left; cursor: pointer;" >Скриено</label>
</div>
<br />
<br />
<div style="float: left; margin-top: 10px;">
    <input type="submit" value="Зачувај" class="buttonBlue" />
                    <input id="delete-post" type="button" value="Избриши" class="buttonRed" />
</div>
                    
        </div>
        <a target="_blank" href="<?php echo URL::abs($post->permalink.'/'.BlogCategory::get_category_by_id($post->blog_categories_id).'/'.$post->id); ?>" id="preview" style="margin-left: 10px; ">Види како ќе изгледа</a>
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