<div class="container">
   
    <h2>Автори</h2>
    <table class="table">
        <thead>
            <tr>                
                <th>Слика</th>
                <th>Автор</th>    
                <th>Ниво на привилегии</th>    
                <th>Објавени статии</th>    
            </tr>
        </thead>
        <tbody>
            <?php foreach($avtori as $avtor): ?>
            <tr>
                <td><img src="<?php echo $avtor['image_url']; ?>" /></td>
                <td><?php echo $avtor['full_name']; ?></td>
                <td><?php
               
                if($avtor['user_level'] == 9){
                    echo 'Администратор';
                }else if($avtor['user_level'] == 4){
                    echo 'Автор';
                }else if($avtor['user_level'] == 3){
                    echo 'Дописник';
                }else{
                    echo '-';
                }
                ?></td>
                <td><?php echo $avtor['c']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
        <h2>Измена на Автор</h2>
    
  
    <table id="browse-posts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Слика</th>
                <th>Наслов</th>
                <th>Категорија</th>
                <th>Автор</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $key => $post) { /* @var $post BlogPost */ ?>
                <tr>
                    <td><?php echo $post->id; ?><input class="post-id" type="hidden" value="<?php echo $post->id; ?>" /></td>
                    <td>
                        <img alt="" src="<?php echo URL::abs('public/uploads/thumbnails/' . $post->thumbnail_image_url); ?>" style="width:50px;height: 50px;" />
                    </td>
                    <td><?php echo $post->title; ?></td>
                    <td><?php
            foreach ($categories as $category) { /* @var $category BlogCategory */
                echo $post->blog_categories_id == $category->id ? $category->category_name : '';
            }
            ?>
                    </td>
                    <td><?php echo $post->author_name; ?></td>
                </tr>
<?php } ?>
        </tbody>
    </table>

    <div id="choose_author" style="display: none; position: fixed; width: 300px; left: 50%;top: 30%; margin-left: -150px; background: white; border: 1px solid black; padding: 10px;">
        <h2>Измена на Автор</h2>
        <div>
            <div id="close_avtori" style=" position: absolute; right: 0; top: 0; padding: 5px;cursor: pointer;
                 border-left: 1px solid black; 
                 border-bottom: 1px solid black; 
                 ">
                X
            </div>
            <input type="hidden" name="statija_id" id="statija_id" />
            <select id="avtor_id">
                <?php foreach ($writers as $writer): ?>
                    <option value="<?php echo $writer['user_id']; ?>"><?php echo $writer['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input id="save_author_changes" type="button" value="Зачувај" />
        </div>
    </div>

<?php /* @var $paginator Paginator */ $paginator->display(); ?>

</div>
<script type="text/javascript">
    
    var author_field;
    
    $(document).ready(function(){
        $("#close_avtori").click(function(){
            $("#choose_author").hide();
        });
        $("#browse-posts-table tbody tr").click(function(){            
            $("#choose_author").show();
            $("#statija_id").val($(this).find('input').val());
            author_field = $(this);
        });
        
        $("#save_author_changes").click(function(){
            var statija_id = $("#statija_id").val();
            var author_id  = $("#avtor_id").val();
            var author_full_name = $('#avtor_id>option:selected').text();
              // author_full_name
              author_field.find('td:nth-child(5)').html('<img src="<?php echo URL::image('preloader.gif'); ?>" />');
            $.post(base_url+'admin-posts/change-avtor',{post_id:statija_id,writer_id:author_id,full_name:author_full_name},function(){
                $("#choose_author").hide();
                author_field.find('td:nth-child(5)').html(author_full_name);
            });     
        });
    });
    
</script>