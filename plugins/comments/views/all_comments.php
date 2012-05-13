<?php       
  //  $comment_id = empty ($comments)?  0 : $comments[0]->comment_id;
?>
<div id="comments-area-<?php echo $item_id_; ?>">
    
<?php if(empty ($comments)): ?>

   Нема коментари , биди прв што ќе искоментира.
    
<?php endif; ?>
    
<?php foreach($comments as $comment): /* @var $comment Comment */ ?>
   <div id="comment-<?php echo $comment->id; ?>" class="comment"  >
    
    <?php if(Membership::instance()->user->user_level == 9): ?>
    <div style="float: right;">
        <a href="#" onclick="return delete_comment('<?php echo $comment->id; ?>');">X</a> 
    </div>
    <?php endif; ?>
       
    <input type="hidden" value="<?php echo $comment->id; ?>" />
    <div class="comment-avatar">
        <img alt="<?php echo $comment->username; ?>" title="<?php echo $comment->username; ?> avatar" src="<?php 
        echo $comment->username_avatar?$comment->username_avatar:URL::abs('plugins/comments/images/default-avatar.gif'); 
        ?>" />
    </div>
    <div class="comment-content">
        <span class="comment-username" ><?php echo $comment->username; ?></span>
        <?php if(Membership::instance()->user->user_level == 9): ?>
        <textarea id="comment-content-<?php echo $comment->id; ?>" class="comment-comment" style="width: 98%; height: auto;"><?php echo $comment->comment; ?></textarea> 
        <?php else: ?>
        <span class="comment-comment"><?php echo $comment->comment; ?></span> 
        <?php endif; ?>
        <br />
        <span class="comment-date"> <?php echo TimeHelper::RelativeTime($comment->date_created); ?></span> 
        
        
        <img alt="like button" title="like button" id="like-<?php echo $comment->id; ?>" src="<?php echo URL::abs('plugins/comments/images/like.gif'); ?>" style="margin-top: 2px;" />
        <span>(<span id="num-likes-<?php echo $comment->id; ?>" ><?php echo $comment->likes; ?></span>)</span>
        <?php if(Membership::instance()->user->user_level == 9): ?>
        <span> <a href="#" onclick=" return save_changes('<?php echo $comment->id; ?>',this);" >Зачувај ги промените</a> </span>
        <?php endif; ?>
    </div>
<script type="text/javascript" >
//<![CDATA[
        $(document).ready(function(){
            
            $("#like-<?php echo $comment->id; ?>").click(function(){
                $("#like-<?php echo $comment->id; ?>").attr('src', '<?php echo URL::abs('plugins/comments/images/ajax-loader.gif'); ?>');
                
                $.post(base_url+'comments/send-like', {
                    id : '<?php echo $comment->id; ?>'
                }, function(data){
                 
                 data = parseInt(data);
                 var num_likes =  $("#num-likes-<?php echo $comment->id; ?>").html();
                 num_likes = parseInt(num_likes);
                 $("#num-likes-<?php echo $comment->id; ?>").html(num_likes + data);
                 $("#like-<?php echo $comment->id; ?>").attr('src', '<?php echo URL::abs('plugins/comments/images/like.gif'); ?>');
                });
                
            });
            
            
            
            
        });
        
        function delete_comment(id){
            
            $.get(base_url+'comments/delete-comment/'+id,{},function(data){
               $("#comment-"+id).remove();
            });
            
            return false;
        }
        function save_changes(comment_id , tthis){
            var content = $("#comment-content-"+comment_id).val();
            
            $.post(base_url+'comments/edit-comment',{id : comment_id ,comment : content},function(data){
       
               $("#comment-content-"+comment_id).replaceWith($('<span class="comment-comment">' + content + '</span>'));
               $(tthis).remove();
            });
            
           
            return false;
        }
//]]>
</script>
    
</div>   
<?php endforeach; ?>
    
</div>
<?php if(Membership::instance()->user->id): ?>
<div class="comment-textarea" >    
    <textarea rows="0" cols="0" id="comments-textarea-<?php echo $item_id_; ?>" >коментирај...</textarea>    
</div>   




<script type="text/javascript">
//<![CDATA[         
              $(document).ready(function(){
               //   console.log($(".comment-comment"));
                   $.each($(".comment-comment"),function(index,data){ FitToContent(data, document.documentElement.clientHeight); })
            
                
                  $("#comments-textarea-<?php echo $item_id_; ?>").click(function(){
                      if($(this).val() == 'коментирај...'){
                          $(this).css('color', 'black');
                          $(this).val('');
                      }
                  });
                  
                  
                  $("#comments-textarea-<?php echo $item_id_; ?>").blur(function(){
                      if($(this).val() == ''){
                          $(this).css('color', '#636363');
                          $(this).val('коментирај...');
                      }
                  });
                  
                  $("#comments-textarea-<?php echo $item_id_; ?>").keyup(function(e) 
                    { 
                      FitToContent(this, document.documentElement.clientHeight);
                      if(e.keyCode == 13) { 
                          
                          // post the comment
                          var content = $(this).val();
                          console.log(content);
                          if(content == "\n\r" || content == "\r" || content == "\n" || content == ""){ return false; }
                          $(this).remove();
                          $(".comment-textarea").html("<img alt='ajax' src='<?php echo URL::abs('plugins/comments/images/ajax-loader.gif'); ?>' />");
                          
                               
                        
                        $.post(base_url+'comments/add-comment',{
                            comment: content,
                            item_id : '<?php echo $item_id_; ?>',
                            url : '<?php echo URL::current_page_url(); ?>'
                        },function(data){
                            
                            
                            var c = '<div class="comment" >';
    
                            c += '<div class="comment-avatar">';
                            c += '<img alt="<?php echo Membership::instance()->user->username; ?>" src="<?php echo Membership::instance()->user->image_url; ?>" style="height: 40px;" />'; 
                            c += '</div>'; 
                            c += '<div class="comment-content">'; 
                                c += '<span class="comment-username" > <?php echo Membership::instance()->user->username; ?> </span>'; 
                                c += '<span class="comment-comment"> '+data+'</span> '; 
                            c += '</div>'; 

                        c += '</div>'; 
                            
                            
                            
                        <?php if(empty ($comments)): ?>
                            $("#comments-area-<?php echo $item_id_; ?>").html(c);
                        <?php else: ?>
                            $("#comments-area-<?php echo $item_id_; ?>").append(c);
                        <?php endif; ?>
                            
                            $(".comment-textarea").html('');
                            
                            
                        });
                        
                       
                        
                      }
                    });
              });
//]]>
</script>
<?php endif; ?>
<div><?php echo Membership::instance()->pleseLoginMessage('за да оставите коментар'); ?></div>