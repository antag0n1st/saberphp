

<a data-toggle="modal" href="#myModal_<?php echo $uploader_id; ?>" id="show_modal<?php echo $uploader_id; ?>">
    <button type="button" class="btn btn-info ">
        <i class="fa fa-plus"></i> Add Audio
    </button>
</a>
<!-- Modal -->
<div class="modal fade " id="myModal_<?php echo $uploader_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Audio File</h4>
            </div>
            <div class="modal-body">

                <div class="panel-body">

                    <div class="controls col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <span class="btn btn-white btn-file">

                                <span class="fileupload-exists"><i class="fa fa-undo"></i>Change</span>

                                <input id="<?php echo $uploadify_name; ?>" type="hidden" name="<?php echo $uploadify_name; ?>" value="<?php echo $uploadify_value; ?>" />
                                <input id="uploadify_<?php echo $uploader_id; ?>" name="file_upload" type="file" />

                            </span>
                            <span class="fileupload-preview" style="margin-left:5px;"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                        </div>
                    </div>

                </div>

                <div  class="radios">
                    <label class="label_radio" for="radio-01">
                        <input name="sample-radio<?php echo $uploadify_name; ?>" id="radio-01" value="1" type="radio" checked=""> Male Voice
                    </label>
                    <label  class="label_radio" for="radio-02">
                        <input name="sample-radio<?php echo $uploadify_name; ?>" id="radio-02" value="0" type="radio"> Female Voice
                    </label>
                </div>

            </div>

            <div class="modal-footer">
                <button id="<?php echo $uploader_id; ?>close_audio" data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button id="save_audio_<?php echo $uploader_id; ?>" class="btn btn-success" type="button">Save changes</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">



    $(document).ready(function () {

        var form_data = {
            district: '<?php echo $district_id; ?>',
            chapter: '<?php echo $chapter_id; ?>',
            lesson: '<?php echo $collection_id; ?>',
            question: '<?php echo $question_id; ?>',
            type: '<?php echo $type; ?>',
            file_name: '',
            is_male: false
        };

        $("#save_audio_<?php echo $uploader_id; ?>").click(function (d) {

            var file_name = $("#<?php echo $uploadify_name; ?>").val();

            var radios = document.getElementsByName('sample-radio<?php echo $uploadify_name; ?>');
            for (var i = 0; i < radios.length; i++) {
                var radio = radios[i];
                if (radio.checked) {
                    form_data.is_male = radio.value == "1" ? 1 : 0;
                }
            }


            if (file_name !== "") {

                $.post(base_url + 'question/add-audio', form_data, function (success) {
                    if(success){
                        success = JSON.parse(success);
                        var audio_id = success.audio_id;
                        //TODO add row to the table
                        
                        add_audio('<?php echo $uploadify_name; ?>',audio_id,form_data);
                        
                    }
                    $("#<?php echo $uploader_id; ?>close_audio").click();
                });


            }



        });

        $("#show_modal<?php echo $uploader_id; ?>").click(function () {
            $("#<?php echo $uploadify_name; ?>").val("");
        });

          
           
        $('#uploadify_<?php echo $uploader_id; ?>').uploadify({
            'formData': form_data,
            'swf': '<?php echo URL::abs('plugins/uploadify/flash/uploadify.swf'); ?>',
            'uploader': '<?php echo URL::abs('uploadify/upload-audio'); ?>',
            'onUploadError': function (file, errorCode, errorMsg, errorString) {

            },
            'onUploadSuccess': function (file, data, response) {                
                var d = JSON.parse(data);
                form_data.file_name = d.file_url;
                $("#<?php echo $uploadify_name; ?>").val(d.file_url);
                //TODO set a preview here
               
            },
            width: '150px',
            height: '40px',
            buttonText: 'Choose Audio'
        });

    });

</script>

<style>

    .swfupload{
        left: 0;
        top: 0;
        cursor: pointer;
    }
</style>