<style>

    .filedrag{
        height: 150px;
        background: #fafafa;
        border: 2px solid #ceced1;
        color: white;
        text-align: center;
        cursor: pointer;
        position: relative;
        font-size: 30px;
        color: #c7c7ca;
        display: inline-block;
        margin-bottom: 20px;
    }

    .filedrag p{
        display: grid;
        height: calc(100%);
        width: 100%;
        padding: 0;
        margin: 0;
        align-items: center;
    }

    .filedrag:hover{
        color: #a8a8aa;
    }

    .filedrag.hover
    {
        border-color: #17ca85;
        background-color: #50d88d;
        border-style: solid;
    }

    .fileselect{
        width: 100%;
        height: 100%;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        left: 0;
        top: 0;
        cursor: pointer;

    }

    .control-label{
        text-align: right !important;
    }

    .uplodify-preview{
        display: inline-block;
        line-height: 150px;
        height: 150px;
        text-align: center;
        margin-bottom: 20px;
    }

    .uplodify-preview img{
        max-height: 100%;
        max-width: 100%;
    }

</style>

<input id="<?php echo $field_name; ?>" type="hidden" name="<?php echo $field_name; ?>" value="<?php echo $is_blank ? '' : htmlspecialchars(json_encode($image), ENT_COMPAT); ?>" />

<div class="uplodify-preview col-lg-3 col-md-3 col-xs-12">
    <i id="<?php echo $field_name . '_spinner'; ?>" class="fa fa-spinner fa-spin" style="font-size: 30px; display: none;" ></i>
    <img id="<?php echo $field_name . '_preview'; ?>" src="<?php echo URL::abs('public/uploads/' . $image->url); ?>" />
</div>
<div class="filedrag col-lg-9 col-md-9 col-xs-12" id="filedrag">
    <input type="file" id="fileselect" class="fileselect" />
    <p>drop image here or click</p>
</div>

<script>

    $(function () {

        toastr = toastr || {
            warrning: function () {
                console.warn("You need to implement a notification system");
            },
            error: function () {
                console.warn("You need to implement a notification system");
            },
            success: function () {
                console.warn("You need to implement a notification system");
            }
        };

        var width = <?php echo $image->to_size->width; ?>;
        var height = <?php echo $image->to_size->height; ?>;
        var post_url = base_url + 'uploadify/upload-file';
        var image_path = base_url + 'public/uploads/';
        var preview_image_id = '<?php echo $field_name; ?>_preview';
        var image_path_id = '<?php echo $field_name; ?>';
        var spinner_id = '<?php echo $field_name; ?>_spinner';
        var imageScaleMode = <?php echo json_encode($image->scale_mode); ?>;
        var thumbnails = <?php echo json_encode($image->thumbnails); ?>;

        $(document).on("imageResized", function (event) {

            if (event.blob && event.url) {
                UploadFile(event.blob);
            } else {
                toastr.error("Can't upload that!");
            }

        });

        // getElementById
        function $id(id) {
            return document.getElementById(id);
        }


        // file drag hover
        function FileDragHover(e) {
            e.stopPropagation();
            e.preventDefault();

            var target = $id("filedrag");
            target.className = (e.type == "dragover" ? "filedrag hover" : "filedrag");
        }
        /* Utility function to convert a canvas to a BLOB */
        var dataURLToBlob = function (dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = parts[1];

                return new Blob([raw], {type: contentType});
            }

            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;

            var uInt8Array = new Uint8Array(rawLength);

            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {type: contentType});
        };
        /* End Utility function to convert a canvas to a BLOB      */

        function resize(file, MAX_WIDTH, MAX_HEIGHT) {

            // Load the image
            var reader = new FileReader();
            reader.onload = function (readerEvent) {
                var image = new Image();
                image.onload = function (imageEvent) {

                    // Resize the image
                    var canvas = document.createElement('canvas');

                    var width = image.width;
                    var height = image.height;
                    var s = 1;

                    if (imageScaleMode === 0) {
                        s = Math.min(MAX_WIDTH / width, MAX_HEIGHT / height);
                    } else if (imageScaleMode === 1) {
                        s = Math.max(MAX_WIDTH / width, MAX_HEIGHT / height);
                    }

                    height *= s;
                    width *= s;

                    canvas.width = width;
                    canvas.height = height;
                    canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                    var dataUrl = canvas.toDataURL('image/jpeg');
                    var resizedImage = dataURLToBlob(dataUrl);
                    $.event.trigger({
                        type: "imageResized",
                        blob: resizedImage,
                        url: dataUrl
                    });
                };
                image.src = readerEvent.target.result;
            };
            reader.readAsDataURL(file);

        }


        // file selection
        function FileSelectHandler(e) {

            e.stopPropagation();
            e.preventDefault();

            // fetch FileList object
            var files = null;

            if (e.dataTransfer) {
                files = e.dataTransfer.files || e.target.files;
            } else {
                files = e.target.files;
            }

            // process all File objects
            for (var i = 0, f; f = files[i]; i++) {
                if (f.type.match(/image.*/)) {
                    processFile(f);
                    break;
                } else {
                    toastr.error("You must select an Image");
                    break;
                }
            }

        }

        function processFile(file) {
            resize(file, width, height);
        }

        function UploadFile(file) {

            var formData = new FormData();

            formData.set("file_upload", file);
            //var post_data = '{"width":' + width + ',"height":' + height + ',"scale_mode": "' + imageScaleMode + '"}';
            
            var post_data = JSON.stringify({
                to_width: width,
                to_height: height,
                scale_mode: imageScaleMode,
                thumbnails: thumbnails
            });

            if (post_data) {
                var post_array = JSON.parse(post_data);
                for (var property in post_array) {
                    if (post_array.hasOwnProperty(property)) {
                        // do stuff
                        var value = post_array[property];
                        formData.set(property, JSON.stringify(value));
                    }
                }
            }

            var spinner = document.getElementById(spinner_id);
            spinner.style.display = 'inline-block';

            var preview = document.getElementById(preview_image_id);
            preview.style.display = 'none';

            $.ajax({
                url: post_url,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (msg) {
                    
                    // console.log(msg);
                    
                    var spinner = document.getElementById(spinner_id);
                    spinner.style.display = 'none';

                    preview.style.display = 'inline-block';

                    if (msg.url) {

                        preview.src = image_path + msg.url;
                        
                        var inp = document.getElementById(image_path_id);
                        inp.value = JSON.stringify(msg); // set the entire json

                        toastr.success("Image uploaded");

                    }
                }
            });

            //////////////////////////


        }

        // initialize
        function Init() {

            var fileselect = $id("fileselect");
            var filedrag = $id("fileselect");
            //submitbutton = $id("submitbutton");
            ///   filedrag.addEventListener("click", FileSelect, false);

            // file select
            fileselect.addEventListener("change", FileSelectHandler, false);

            // is XHR2 available?
            var xhr = new XMLHttpRequest();
            if (xhr.upload) {

                // file drop
                filedrag.addEventListener("dragover", FileDragHover, false);
                filedrag.addEventListener("dragleave", FileDragHover, false);
                filedrag.addEventListener("drop", FileSelectHandler, false);
                filedrag.style.display = "block";

            }

        }

        // call initialization file
        if (window.File && window.FileList && window.FileReader) {
            Init();
        }

    });

</script>