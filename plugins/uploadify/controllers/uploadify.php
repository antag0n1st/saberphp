<?php

class UploadifyController extends Controller {

    public function upload_file() {

        $this->no_layout();

        $error_message = json_encode(["error" => ""]);

        $directory = '';

        $response = [];

        if (!empty($_FILES)) {

            $tempFile = $_FILES['file_upload']['tmp_name'];

            $mime_type = $_FILES['file_upload']['type'];

            if (strpos($mime_type, 'image') === false) {
                $this->json_response(['error' => 'not supported']);
                return;
            }

            $supported_extensions = [
                'image/jpeg' => 'jpeg',
                'image/jpg' => 'jpg',
                'image/png' => 'png'
            ];

            $extension = $supported_extensions[$mime_type];

            $hash = md5(time() . $tempFile);

            Load::helper('image');

            // CONTENT_DIR

            $height = $this->get_post('height');
            $width = $this->get_post('width');
            $scale_mode = $this->get_post('scale_mode');
            $aspekt_ratio = $width / $height;

            $sub_folders = 'images' . DS . date('Y') . DS . date('M');

            $image_name = 'image' . '-' . $hash . '.' . $extension;

            $image_path = $sub_folders . DS . $image_name;

            $goal_path = CONTENT_DIR . $image_path;

            $sub = rtrim($sub_folders, DS);
            $this->create_folders($sub);
            // $this->create_folders($sub.DS."thumb");

            $image = new Image();
            $image->load($tempFile);

            // $fb_goal_path = $this->CONTENT_DIR . $sub_folders . DS . 'image' . '-' . $hash . '_fb.' . end($_parts);
            // FB 600 x 315

            $_s = 1;

            if ($scale_mode === "fit") {
                $_s = min($width / $image->getWidth(), $height / $image->getHeight());
            } else if ($scale_mode === "fil") {
                $_s = max($width / $image->getWidth(), $height / $image->getHeight());
            }

            $image->scale($_s);
            $image->save($goal_path);
            $response['scale_mode'] = $scale_mode;



            // $goal_path
            // $this->makeThumb($image_name, CONTENT_DIR . $sub_folders . DS, 112);

            $image_path = str_replace('\\', '/', $image_path);
            $response['path'] = $image_path;
            $this->json_response($response);
        } else {
            echo $error_message;
        }
    }

    private function create_folders($path) {
        $subfolders = explode(DS, $path);
        $breadcrumb = CONTENT_DIR;

        foreach ($subfolders as $key => $dir) {
            $breadcrumb .= DS . $dir;
            if (!file_exists($breadcrumb)) {
                mkdir($breadcrumb, 0777, true);
            }
        }
    }

    private function makeThumb($filename, $path, $thumbSize = 100) {
        $max_width = 112;
        $max_height = 112;

        /* Set Filenames */
        $srcFile = $path . $filename;
        $thumbFile = $srcFile; // $path . 'thumb/' . $filename;

        /* Determine the File Type */
        $type = substr($filename, strrpos($filename, '.') + 1);
        /* Create the Source Image */
        switch ($type) {
            case 'jpg' : case 'jpeg' :
                $src = imagecreatefromjpeg($srcFile);
                break;
            case 'png' :
                $src = imagecreatefrompng($srcFile);
                break;
            case 'gif' :
                $src = imagecreatefromgif($srcFile);
                break;
        }
        /* Determine the Image Dimensions */
        $oldW = imagesx($src);
        $oldH = imagesy($src);

        $limiting_dim = 0;
        if ($oldH > $oldW) {
            /* Portrait */
            $limiting_dim = $oldW;
        } else {
            /* Landscape */
            $limiting_dim = $oldH;
        }
        /* Create the New Image */
        $new = imagecreatetruecolor($thumbSize, $thumbSize);
        /* Transcribe the Source Image into the New (Square) Image */
        imagecopyresampled($new, $src, 0, 0, ($oldW - $limiting_dim ) / 2, ( $oldH - $limiting_dim ) / 2, $thumbSize, $thumbSize, $limiting_dim, $limiting_dim);

        switch ($type) {
            case 'jpg' : case 'jpeg' :
                $src = imagejpeg($new, $thumbFile);
                break;
            case 'png' :
                $src = imagepng($new, $thumbFile);
                break;
            case 'gif' :
                $src = imagegif($new, $thumbFile);
                break;
        }
        imagedestroy($new);
//        imagedestroy($src);
    }

}

?>
