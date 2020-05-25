<?php

Load::script('controllers/admin');

class StudentsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function main($page_id = 1) {
        $this->listing($page_id);
    }

    public function listing($page_id = 1) {

        $this->set_view('list');
        $this->set_menu('students');

        Load::model('student');

        $paginator = new Paginator(0, $page_id, 30, 'students/listing/');
        $students = Student::find_all($paginator);

        Load::assign('students', $students);
        Load::assign('paginator', $paginator);
    }

    public function add() {

        $this->set_view('add');
        $this->set_menu('students');

        if (isset($_POST) and $_POST) {

            Load::model('student');

            $student = new Student();
            
            		$student->counter = $this->get_post('counter');
		$student->name = $this->get_post('name');
		$student->email = $this->get_post('email');


            $student->save();

            $this->set_confirmation('New Entity Created');

            URL::redirect('students');
        }
    }

    public function edit($id) {

        $this->set_view('add');
        $this->set_menu('students');

        Load::model('student');

        $student = Student::find_by_id($id);

        if (isset($_POST) and $_POST) {

            		$student->counter = $this->get_post('counter');
		$student->name = $this->get_post('name');
		$student->email = $this->get_post('email');


            $student->save();

            $this->set_confirmation('Updated');

            URL::redirect('students');
        }

        Load::assign('student', $student);
        
    }

    public function delete($id) {

        $this->no_layout();

        Load::model('student');

        $student = new Student();
        $student->id = $id;

        $student->delete();

        URL::redirect_to_refferer();
    }

}

