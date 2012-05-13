<?php       

$item_id_ = 'x782yDS';
?>
<div id="comments-area-<?php echo $item_id_; ?>" style="margin-top: 10px;margin-bottom: 10px;">
    
<?php if(empty ($comments)): ?>

   Нема коментари , биди прв што ќе искоментира.
    
<?php endif; ?>
    
<?php foreach($comments as $comment): /* @var $comment Comment */ ?>
   <div id="comment-<?php echo $comment->id; ?>" class="comment" style="width: <?php echo $width; ?>px;" >
    <input type="hidden" value="<?php echo $comment->id; ?>" />
    <div class="comment-avatar" >
        <img alt="<?php echo $comment->username; ?>" title="<?php echo $comment->username; ?> avatar" src="<?php 
        echo $comment->username_avatar?$comment->username_avatar:URL::abs('plugins/comments/images/default-avatar.gif'); 
        ?>" />
    </div>
    <div class="comment-content" style="width: <?php echo $width - 60; ?>px;">
        <span class="comment-username" ><?php echo $comment->username; ?></span>
        <span class="comment-comment">
            <?php $tmp_comment = strip_tags($comment->comment);
                if (mb_strlen($tmp_comment, 'utf8') > 100) {
                    echo mb_substr($tmp_comment, 0, 100, 'utf8') . '...';
                } else {
                    echo $comment->comment;
                }
            ?>
        </span> 
        <br />
        <span class="comment-date"> <?php echo TimeHelper::RelativeTime($comment->date_created); ?></span> 
       
        <a href="<?php echo $comment->url.'#comment-'.$comment->id; ?>">види го коментарот</a>
        
        
    </div>
    
</div>   
<?php endforeach; ?>
    
</div>

<div><?php echo Membership::instance()->pleseLoginMessage('за да оставите коментар'); ?></div>