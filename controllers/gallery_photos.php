<?php

Load::script('controllers/admin');

class GalleryPhotosController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function main($page_id = 1) {
        $this->listing($page_id);
    }

    public function listing($page_id = 1) {

        $this->set_view('list');
        $this->set_menu('gallery_photos');

        Load::model('gallery_photo');

        $paginator = new Paginator(0, $page_id, 30, 'gallery_photos/listing/');
        $gallery_photos = GalleryPhoto::find_all($paginator);

        Load::assign('gallery_photos', $gallery_photos);
        Load::assign('paginator', $paginator);
    }

    public function add() {

        $this->set_view('add');
        $this->set_menu('gallery_photos');
        
        $uploadify = new Uploadify();
        $uploadify->set_size(600, 600, Uploadify::SCALE_MODE_FIL);
        $uploadify->set_thumbnail();
        Load::assign('uploadify', $uploadify);

        if (isset($_POST) and $_POST) {

            Load::model('gallery_photo');

            $gallery_photo = new GalleryPhoto();

            $gallery_photo->image = $this->get_post('image');
            $gallery_photo->title = $this->get_post('title');
            $gallery_photo->comment = $this->get_post('comment');

            $gallery_photo->save();

            $this->set_confirmation('New Entity Created');

            URL::redirect('gallery_photos');
        }
    }

    public function edit($id) {

        $this->set_view('add');
        $this->set_menu('gallery_photos');

        Load::model('gallery_photo');

        $gallery_photo = GalleryPhoto::find_by_id($id);
        
        $uploadify = new Uploadify();
      
        $uploadify->set_data($gallery_photo->image);
        Load::assign('uploadify', $uploadify);
        

        if (isset($_POST) and $_POST) {

            $gallery_photo->image = $this->get_post('image');
            $gallery_photo->title = $this->get_post('title');
            $gallery_photo->comment = $this->get_post('comment');


            $gallery_photo->save();

            $this->set_confirmation('Updated');

            URL::redirect('gallery_photos');
        }

        Load::assign('gallery_photo', $gallery_photo);
    }

    public function delete($id) {

        $this->no_layout();

        Load::model('gallery_photo');

        $gallery_photo = new GalleryPhoto();
        $gallery_photo->id = $id;

        $gallery_photo->delete();

        URL::redirect_to_refferer();
    }

}
