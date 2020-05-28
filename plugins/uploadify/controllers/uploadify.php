<?php

class UploadifyController extends Controller {

    public function upload_file() {

        $this->no_layout();

        $error_message = json_encode(["error" => ""]);

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


            // CONTENT_DIR

            $width = $this->get_post('to_width');
            $height = $this->get_post('to_height');
            $scale_mode = $this->get_post('scale_mode');
            $thumbnails = json_decode($this->get_post('thumbnails'));



            $sub_folders = 'images' . DS . date('Y') . DS . date('M');

            $image_name = 'image' . '-' . $hash . '.' . $extension;

            $image_path = $sub_folders . DS . $image_name;

            $goal_path = CONTENT_DIR . $image_path;

            $sub = rtrim($sub_folders, DS);
            $this->create_folders($sub);
            $this->create_folders($sub . DS . "thumbs");



            $image = $this->saveImage($tempFile, $width, $height, $scale_mode, $goal_path);

            $response['scale_mode'] = $scale_mode;
            $response['to_size'] = [
                'width' => $width,
                'height' => $height
            ];
            $response['size'] = [
                'width' => $image->getWidth(),
                'height' => $image->getHeight()
            ];

            $image_path = str_replace('\\', '/', $image_path);
            $response['url'] = $image_path;

            // make thumbnails

            foreach ($thumbnails as &$thumb_data) {
                $t_image_path = $sub_folders . DS . 'thumbs' . DS . $thumb_data->key . '-' . $image_name;
                $t_goal_path = CONTENT_DIR . $t_image_path;
                $t_image = $this->saveImage($tempFile, $thumb_data->to_width, $thumb_data->to_height, $thumb_data->scale_mode, $t_goal_path);
                $thumb_data->width = $t_image->getWidth();
                $thumb_data->height = $t_image->getHeight();
            }

            $response['thumbnails'] = $thumbnails;

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

    private function saveImage($tempFile, $width, $height, $scale_mode, $goal_path) {

        $image = new ImageData();
        $image->load($tempFile);

        $_s = 1;

        if ($scale_mode === Uploadify::SCALE_MODE_FIT) {
            $_s = min($width / $image->getWidth(), $height / $image->getHeight());
        } else if ($scale_mode === Uploadify::SCALE_MODE_FIL) {
            $_s = max($width / $image->getWidth(), $height / $image->getHeight());
        }

        $image->scale($_s);
        $image->save($goal_path);

        return $image;
    }

}

?>
