<div class="container">
    

<div>
    <a href="<?php echo URL::abs('admin-posts/write-post'); ?>">+ ДОДАДИ НОВ НАПИС</a>   
</div>
    <br />
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
        <?php foreach($posts as $key => $post){ /* @var $post BlogPost */ ?>
        <tr>
            <td><?php echo $post->id; ?><input class="post-id" type="hidden" value="<?php echo $post->id; ?>" /></td>
            <td>
                <img alt="" src="<?php echo $post->thumbnail_image_url; ?>" style="width:50px;height: 50px;" />
            </td>
            <td><a href="<?php echo URL::abs('admin-posts/edit-post/'.$post->id); ?>"><?php echo $post->title; ?></a></td>
            <td><?php foreach($categories as $category){ /* @var $category BlogCategory */
                      echo  $post->blog_categories_id == $category->id ? $category->category_name : '';
                } ?>
            </td>
            <td><?php echo $post->author_name; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
    
    <?php /* @var $paginator Paginator */ $paginator->build_pagination_html(); ?>
    
    </div>
<script type="text/javascript">
    
        $(document).ready(function(){
            $("#browse-posts-table tbody tr").click(function(){
               // window.open(base_url+'admin-posts/edit-post/'+$(this).find('input').val(),'_blank');
                document.location = base_url+'admin-posts/edit-post/'+$(this).find('input').val();
            });
        });
    
</script>