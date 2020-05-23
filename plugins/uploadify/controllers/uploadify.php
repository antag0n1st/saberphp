<?php

// http://www.uploadify.com/documentation/
class UploadifyController extends Controller {

    public function upload_audio() {
        global $layout;
        $layout = null;

        $error_message = json_encode(["error" => ""]);

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            // Validate the file type
            $fileTypes = array('mp3', 'MP3'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $_parts = explode('.', $_FILES['Filedata']['name']);

            $hash = md5(time());

            if (in_array($fileParts['extension'], $fileTypes)) {

                $district = $_POST['district'];
                $chapter = $_POST['chapter'];
                $lesson = $_POST['lesson'];
                $question = $_POST['question'];
                $type = $_POST['type'];

                $sub_folders = "district_" . $district . DS . "chapter_" . $chapter . DS . "lesson_" . $lesson;

                $goal_path = rtrim(CONTENT_DIR . 'sounds' . DS . $sub_folders, DS) . DS . 'question' . '-' . $hash . '.' . end($_parts);

                $this->create_folders(rtrim('sounds' . DS . $sub_folders, DS));

                if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $goal_path)) {

                    echo json_encode([
                        "message" => "OK",
                        "file_url" => str_replace(DS, '/', str_replace(CONTENT_DIR, '', $goal_path)),
                        "question_id" => $question,
                        "type" => $type
                    ]);
                } else {
                    echo $error_message;
                }
            } else {
                echo $error_message;
            }
        } else {
            echo $error_message;
        }
    }

    private function create_folders($path) {
        $subfolders = explode(DS, $path);
        $breadcrumb = CONTENT_DIR . "";

        foreach ($subfolders as $key => $dir) {
            $breadcrumb .= DS . $dir;
            if (!file_exists($breadcrumb)) {
                mkdir($breadcrumb, 0777, true);
            }
        }
    }

    public function upload() {
        // http://www.uploadify.com/documentation/
        global $layout;
        $layout = false;

        Load::helper('image');


        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $_parts = explode('.', $_FILES['Filedata']['name']);
            $file_name = '';
            $hash = md5(time());

            if (in_array($fileParts['extension'], $fileTypes)) {




                foreach ($_POST as $key => $value) {

                    if (is_numeric($key)) {

                        $image = new Image();
                        $image->load($tempFile);

                        $posted_values = json_decode($value, TRUE);
                        $the_vals = array();
                        foreach ($posted_values as $posted_key => &$posted_value) {
                            $the_vals[str_replace(array('"', '\''), '', $posted_key)] = str_replace(array('"', '\''), '', $posted_value);
                        }
                        extract($the_vals);

                        $aspekt_ratio = $width / $height;

                        if ($aspekt_ratio < $image->getWidth() / $image->getHeight()) {
                            $image->resizeToHeight($height);
                            $image->save(rtrim($path, '\\') . '/' . $image_title . '-' . $hash . '.' . end($_parts));
                        } else {
                            $image->resizeToWidth($width);
                            $image->save(rtrim($path, '\\') . '/' . $image_title . '-' . $hash . '.' . end($_parts));
                        }
                    }
                }

                echo $image_title . '-' . $hash . '.' . end($_parts);
            } else {
                echo 'Invalid file type.';
            }
        }
    }

}

?>
