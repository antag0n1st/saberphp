<?php if($image_container): ?>
<?php else: ?>
<img id="uploadify_preview_image" alt="" src="<?php echo URL::abs(str_replace('\\', '/', $preview_path).'/'.$default_image); ?>" />
<?php endif; ?>

<input id="<?php echo $field_name; ?>" type="hidden" name="<?php echo $field_name; ?>" value="<?php echo $default_image; ?>" />
<input id="uploadify_file_upload" name="file_upload" type="file" />
<div id="out" style="color: red;"></div>
<script type="text/javascript">


$(function() {
    $('#uploadify_file_upload').uploadify({
        'swf'      : '<?php echo URL::abs('plugins/uploadify/flash/uploadify.swf'); ?>',
        'uploader' : '<?php echo URL::abs('uploadify/upload'); ?>' , 
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            $("#out").html('The file ' + file.name + ' could not be uploaded: ' + errorString);
           
        } , 
        'onUploadSuccess' : function(file, data, response) {
            $("#<?php echo $image_container ?  $image_container : 'uploadify_preview_image'; ?>").attr('src','<?php echo URL::abs(str_replace('\\', '/', $preview_path)); ?>/'+data);
            $("#<?php echo $field_name; ?>").val(data);
            if(data == 'Invalid file type.'){
                $("#out").html('Invalid file type.');
            }
           // $("#out").html('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
        } , 
        'formData' : <?php echo $uploadify_data; ?>
    });
    
    <?php if($image_container): ?>
    $("#<?php echo $image_container; ?>").attr('src', '<?php echo URL::abs(str_replace('\\', '/', $preview_path).'/'.$default_image); ?>');
    <?php endif; ?>
    
});
</script>