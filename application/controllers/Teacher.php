<<<<<<< HEAD
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Teacher extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Payment_model',  'payment_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Addon_model',    'addon_model');
		$this->load->model('Frontend_model', 'frontend_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();
		
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}
	//dashboard
	public function index(){
		redirect(route('dashboard'), 'refresh');
	}

	public function dashboard(){

		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

	//START STUDENT ADN ADMISSION section
	public function student($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'create'){
			//form view
			if($param2 == 'bulk'){
				$page_data['aria_expand'] = 'bulk';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}elseif($param2 == 'excel'){
				$page_data['aria_expand'] = 'excel';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}else{
				$page_data['aria_expand'] = 'single';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}
		}

		//create to database
		if($param1 == 'create_single_student'){
			$response = $this->user_model->single_student_create();
			echo $response;
		}

		if($param1 == 'create_bulk_student'){
			$response = $this->user_model->bulk_student_create();
			echo $response;
		}

		if($param1 == 'create_excel'){
			$response = $this->user_model->excel_create();
			echo $response;
		}

		// form view
		if($param1 == 'edit'){
			$page_data['student_id'] = $param2;
			$page_data['working_page'] = 'edit';
			$page_data['folder_name'] = 'student';
			$page_data['page_title'] = 'update_student_information';
			$this->load->view('backend/index', $page_data);
		}

		//updated to database
		if($param1 == 'updated'){
			$response = $this->user_model->student_update($param2, $param3);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->user_model->delete_student($param2, $param3);
			echo $response;
		}

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/teacher/student/list', $page_data);
		}

		if(empty($param1)){
			$page_data['working_page'] = 'filter';
			$page_data['folder_name'] = 'student';
			$page_data['page_title'] = 'student_list';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END STUDENT ADN ADMISSION section

	//START TEACHER section
	public function teacher($param1 = '', $param2 = '', $param3 = ''){


		if($param1 == 'create'){
			$response = $this->user_model->create_teacher();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->user_model->update_teacher($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$teacher_id = $this->db->get_where('teachers', array('user_id' => $param2))->row('id');
			$response = $this->user_model->delete_teacher($param2, $teacher_id);
			echo $response;
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/teacher/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'teacher';
			$page_data['page_title'] = 'techers';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END TEACHER section

	//START CLASS secion
	public function class($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->class_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->class_delete($param2);
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->class_update($param2);
			echo $response;
		}

		if($param1 == 'section'){
			$response = $this->crud_model->section_update($param2);
			echo $response;
		}

		// show data from database
		if ($param1 == 'list') {
			$this->load->view('backend/teacher/class/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'class';
			$page_data['page_title'] = 'class';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS section

	//	SECTION STARTED
	public function section($action = "", $id = "") {

		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($action == 'list') {
			$page_data['class_id'] = $id;
			$this->load->view('backend/teacher/section/list', $page_data);
		}
	}
	//	SECTION ENDED

	//START SUBJECT section
	public function subject($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->subject_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->subject_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->subject_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$this->load->view('backend/teacher/subject/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'subject';
			$page_data['page_title'] = 'subject';
			$this->load->view('backend/index', $page_data);
		}
	}

	public function class_wise_subject($class_id) {

		// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
		$page_data['class_id'] = $class_id;
		$this->load->view('backend/teacher/subject/dropdown', $page_data);
	}
	//END SUBJECT section

	//START SYLLABUS section
	public function syllabus($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->syllabus_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->syllabus_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/teacher/syllabus/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'syllabus';
			$page_data['page_title'] = 'syllabus';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END SYLLABUS section

	//START CLASS ROUTINE section
	public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->routine_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->routine_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->routine_delete($param2);
			echo $response;
		}

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/teacher/routine/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'routine';
			$page_data['page_title'] = 'routine';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS ROUTINE section


	//START DAILY ATTENDANCE section
	public function attendance($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'take_attendance'){
			$response = $this->crud_model->take_attendance();
			echo $response;
		}

		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$this->load->view('backend/teacher/attendance/list', $page_data);
		}

		if($param1 == 'student'){
			$page_data['attendance_date'] = strtotime($this->input->post('date'));
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$this->load->view('backend/teacher/attendance/student', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'attendance';
			$page_data['page_title'] = 'attendance';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END DAILY ATTENDANCE section


	//START EVENT CALENDAR section
	public function event_calendar($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->event_calendar_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->event_calendar_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->event_calendar_delete($param2);
			echo $response;
		}

		if($param1 == 'all_events'){
			echo $this->crud_model->all_events();
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/event_calendar/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'event_calendar';
			$page_data['page_title'] = 'event_calendar';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EVENT CALENDAR section


	//START EXAM section
	public function exam($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->exam_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->exam_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->exam_delete($param2);
			echo $response;
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/exam/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'exam';
			$page_data['page_title'] = 'exam';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EXAM section

	//START MARKS section
	public function mark($param1 = '', $param2 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['subject_id'] = $this->input->post('subject');
			$page_data['exam_id'] = $this->input->post('exam');
			$this->crud_model->mark_insert($page_data['class_id'], $page_data['section_id'], $page_data['subject_id'], $page_data['exam_id']);
			$this->load->view('backend/teacher/mark/list', $page_data);
		}

		if($param1 == 'mark_update'){
			$this->crud_model->mark_update();
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'mark';
			$page_data['page_title'] = 'marks';
			$this->load->view('backend/index', $page_data);
		}
	}

	// GET THE GRADE ACCORDING TO MARK
	public function get_grade($acquired_mark) {
		echo get_grade($acquired_mark);
	}
	//END MARKS sesction


	// BACKOFFICE SECTION

	//BOOK LIST MANAGER
	public function book($param1 = "", $param2 = "") {
		// adding book
		if ($param1 == 'create') {
			$response = $this->crud_model->create_book();
			echo $response;
		}

		// update book
		if ($param1 == 'update') {
			$response = $this->crud_model->update_book($param2);
			echo $response;
		}

		// deleting book
		if ($param1 == 'delete') {
			$response = $this->crud_model->delete_book($param2);
			echo $response;
		}
		// showing the list of book
		if ($param1 == 'list') {
			$this->load->view('backend/teacher/book/list');
		}

		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'book';
			$page_data['page_title']  = 'books';
			$this->load->view('backend/index', $page_data);
		}
	}

	//MANAGE PROFILE STARTS
	public function profile($param1 = "", $param2 = "") {
		if ($param1 == 'update_profile') {
			$response = $this->user_model->update_profile();
			echo $response;
		}
		if ($param1 == 'update_password') {
			$response = $this->user_model->update_password();
			echo $response;
		}

		// showing the Smtp Settings file
		if(empty($param1)){
			$page_data['folder_name'] = 'profile';
			$page_data['page_title']  = 'manage_profile';
			$this->load->view('backend/index', $page_data);
		}
	}
	//MANAGE PROFILE ENDS
}
=======
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author   : Creativeitem
 *  date    : 14 september, 2017
 *  Ekattor School Management System Pro
 *  http://codecanyon.net/user/Creativeitem
 *  http://support.creativeitem.com
 */

class Teacher extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->model(array('Ajaxdataload_model' => 'ajaxload'));
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    /***default functin, redirects to login page if no teacher logged in yet***/
    public function index()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('teacher_login') == 1)
            redirect(site_url('teacher/dashboard'), 'refresh');
    }

    /***TEACHER DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard_guru');
        $this->load->view('backend/index', $page_data);
    }


    /*ENTRY OF A NEW STUDENT*/


    /****MANAGE STUDENTS CLASSWISE*****/

	function student_information($class_id = '')
	{
		if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= get_phrase('informasi_siswa'). " - ".get_phrase('kelas')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}

  function student_profile($student_id)
  {
    if ($this->session->userdata('teacher_login') != 1) {
      redirect(base_url(), 'refresh');
    }
    $page_data['page_name']  = 'student_profile';
		$page_data['page_title'] = get_phrase('Profil_siswa');
    $page_data['student_id']  = $student_id;
		$this->load->view('backend/index', $page_data);
  }

	function student_marksheet($student_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =   'student_marksheet';
        $page_data['page_title'] =   get_phrase('lembarkerja_untuk') . ' ' . $student_name . ' (' . get_phrase('kelas') . ' ' . $class_name . ')';
        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/teacher/student_marksheet_print_view', $page_data);
    }



    function get_class_section($class_id)
    {
        $sections = $this->db->get_where('section' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_subject($class_id)
    {
        $subject = $this->db->get_where('subject' , array(
            'class_id' => $class_id ,'teacher_id'=>$this->session->userdata('teacher_id')
        ))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    /****MANAGE TEACHERS*****/
    function teacher_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('daftar_guru');
        $this->load->view('backend/index', $page_data);
    }



    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       = html_escape($this->input->post('name'));
            $data['class_id']   = $this->input->post('class_id');

            if ($this->input->post('teacher_id') != null) {
                $data['teacher_id'] = $this->input->post('teacher_id');
            }
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['class_id'] != '') {
                $this->db->insert('subject', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_berhasil_ditambah'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('pilih_kelas'));
            }

            redirect(site_url('teacher/subject/'.$data['class_id']), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = html_escape($this->input->post('name'));
            $data['class_id']   = $this->input->post('class_id');

            if ($this->input->post('teacher_id') != null) {
                $data['teacher_id'] = $this->input->post('teacher_id');
            }
            else{
                $data['teacher_id'] = null;
            }
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['class_id'] != '') {
               $this->db->where('subject_id', $param2);
               $this->db->update('subject', $data);
               $this->session->set_flashdata('flash_message' , get_phrase('data_diperbarui'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('pilih_kelas'));
            }

            redirect(site_url('teacher/subject/'.$data['class_id']), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            redirect(site_url('teacher/subject/'.$param3), 'refresh');
        }
		 $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array(
            'class_id' => $param1,'teacher_id'=>$this->session->userdata('teacher_id'),
            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('mata_pelajaran');
        $this->load->view('backend/index', $page_data);
    }



    /****MANAGE EXAM MARKS*****/
    function marks_manage()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('kelola_nilai_ujian');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('kelola_nilai_ujian');
        $this->load->view('backend/index', $page_data);
    }

    function marks_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
        $query = $this->db->get_where('mark' , array(
                    'exam_id' => $data['exam_id'],
                        'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                                'subject_id' => $data['subject_id'],
                                    'year' => $data['year']
                ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();
            foreach($students as $row) {
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
            }
        }
        redirect(site_url('teacher/marks_manage_view/'. $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']) , 'refresh');

    }
else{
        $this->session->set_flashdata('error_message' , get_phrase('pilih_semua_field'));
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('kelola_nilia_ujian');
        $this->load->view('backend/index', $page_data);
}
}
    function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        if ($class_id != '' && $exam_id != '') {
        $marks_of_students = $this->db->get_where('mark' , array(
            'exam_id' => $exam_id,
                'class_id' => $class_id,
                    'section_id' => $section_id,
                        'year' => $running_year,
                            'subject_id' => $subject_id
        ))->result_array();
        foreach($marks_of_students as $row) {
            $obtained_marks = html_escape($this->input->post('marks_obtained_'.$row['mark_id']));
            $comment = html_escape($this->input->post('comment_'.$row['mark_id']));
            $this->db->where('mark_id' , $row['mark_id']);
            $this->db->update('mark' , array('mark_obtained' => $obtained_marks , 'comment' => $comment));
        }
        $this->session->set_flashdata('flash_message' , get_phrase('nilai_diperbarui'));
        redirect(site_url('teacher/marks_manage_view/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id), 'refresh');
    }
    else{
        $this->session->set_flashdata('error_message' , get_phrase('pilih_semua_field'));
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('kelola_nilai_ujian');
        $this->load->view('backend/index', $page_data);
    }
    }

    function marks_get_subject($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/teacher/marks_get_subject' , $page_data);
    }


    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        // detect the first class
        if ($class_id == '')
            $class_id           =   $this->db->get('class')->first_row()->class_id;

        $page_data['page_name']  = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('silabus_akademik');
        $page_data['class_id']   = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function upload_academic_syllabus()
    {
        $data['academic_syllabus_code'] =   substr(md5(rand(0, 1000000)), 0, 7);
        $data['title']                  =   html_escape($this->input->post('title'));
        $data['description']            =   html_escape($this->input->post('description'));
        $data['class_id']               =   html_escape($this->input->post('class_id'));
        if ($this->input->post('subject_id') != null) {
           $data['subject_id']          =   $this->input->post('subject_id');
        }
        $data['uploader_type']          =   $this->session->userdata('login_type');
        $data['uploader_id']            =   $this->session->userdata('login_user_id');
        $data['year']                   =   $this->db->get_where('settings',array('type'=>'running_year'))->row()->description;
        $data['timestamp']              =   strtotime(date("Y-m-d H:i:s"));
        //uploading file using codeigniter upload library
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path']   =  'uploads/syllabus/';
        $config['allowed_types'] =  '*';
        $_FILES['file_name']['name']     = $files['name'];
        $_FILES['file_name']['type']     = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size']     = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');

        $data['file_name'] = $_FILES['file_name']['name'];

        $this->db->insert('academic_syllabus', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('silabus_diunggah'));
        redirect(site_url('teacher/academic_syllabus/'. $data['class_id']) , 'refresh');

    }

    function download_academic_syllabus($academic_syllabus_code)
    {
        $file_name = $this->db->get_where('academic_syllabus', array(
            'academic_syllabus_code' => $academic_syllabus_code
        ))->row()->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
    }

    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(site_url('teacher/backup_restore'), 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(site_url('teacher/backup_restore'), 'refresh');
        }

        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('kelola backup dan restore');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = html_escape($this->input->post('name'));
            $data['email']       = html_escape($this->input->post('email'));
            $validation = email_validation_for_edit($data['email'], $this->session->userdata('teacher_id'), 'teacher');
            if ($validation == 1) {
                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
                $this->db->update('teacher', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $this->session->userdata('teacher_id') . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('akun_diperbarui'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('email_ini_tidak_tersedia'));
            }
            redirect(site_url('teacher/manage_profile/'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('teacher', array(
                'teacher_id' => $this->session->userdata('teacher_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
                $this->db->update('teacher', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_diperbarui'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_tidak_sesuai'));
            }
            redirect(site_url('teacher/manage_profile/'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('atur_profil');
        $page_data['edit_data']  = $this->db->get_where('teacher', array(
            'teacher_id' => $this->session->userdata('teacher_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($class_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'class_routine';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('pembagian_kelas');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/teacher/class_routine_print_view' , $page_data);
    }

	/****** DAILY ATTENDANCE *****************/
    function manage_attendance($class_id)
    {
        if($this->session->userdata('teacher_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;
        $page_data['page_name']  =  'manage_attendance';
        $page_data['class_id']   =  $class_id;
        $page_data['page_title'] =  get_phrase('kelola_kehadiran_kelas') . ' ' . $class_name;
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $timestamp = '')
    {
        if($this->session->userdata('teacher_login')!=1)
            redirect(base_url() , 'refresh');
        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;
        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'manage_attendance_view';
        $section_name = $this->db->get_where('section' , array(
            'section_id' => $section_id
        ))->row()->name;
        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('kelola_kehadiran_kelas') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
    }

    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['timestamp']  = strtotime($this->input->post('timestamp'));
        $data['section_id'] = $this->input->post('section_id');
        $query = $this->db->get_where('attendance' ,array(
            'class_id'=>$data['class_id'],
                'section_id'=>$data['section_id'],
                    'year'=>$data['year'],
                        'timestamp'=>$data['timestamp']
        ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();
            foreach($students as $row) {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $this->db->insert('attendance' , $attn_data);
            }

        }
        redirect(site_url('teacher/manage_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['timestamp']),'refresh');
    }

    function attendance_update($class_id = '' , $section_id = '' , $timestamp = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
        $attendance_of_students = $this->db->get_where('attendance' , array(
            'class_id'=>$class_id,'section_id'=>$section_id,'year'=>$running_year,'timestamp'=>$timestamp
        ))->result_array();
        foreach($attendance_of_students as $row) {
            $attendance_status = html_escape($this->input->post('status_'.$row['attendance_id']));
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));

            if ($attendance_status == 2) {

                if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                    $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                    $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                    $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                    if($parent_id != null && $parent_id != 0){
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        if($receiver_phone != '' || $receiver_phone != null){
                            //$this->sms_model->send_sms($message,$receiver_phone);
                        }
                        else{
                            $this->session->set_flashdata('error_message' , get_phrase('nomor_telepon_orangtua_tidak_ditemukan'));
                        }
                    }
                    else{
                        $this->session->set_flashdata('error_message' , get_phrase('nomor_telepon_orangtua_tidak_ditemukan'));
                    }
                }
            }
        }
        $this->session->set_flashdata('flash_message' , get_phrase('kehadiran_diperbarui'));
        redirect(site_url('teacher/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$timestamp ), 'refresh');
    }


    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('kelola_buku_pustaka');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('kelola_transportasi');
        $this->load->view('backend/index', $page_data);

    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {
            $data['notice_title']     = html_escape($this->input->post('notice_title'));
            $data['notice']           = html_escape($this->input->post('notice'));
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = html_escape($this->input->post('notice_title'));
            $data['notice']           = html_escape($this->input->post('notice'));
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message', get_phrase('pemberitahuan_diperbarui'));
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('kelola_pengumuman');
        $page_data['notices']    = $this->db->get_where('noticeboard',array('status'=>1))->result_array();
        $this->load->view('backend/index', $page_data);
    }


    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/
    function document($do = '', $document_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        if ($do == 'upload') {
            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/document/" . $_FILES["userfile"]["name"]);
            $data['document_name'] = html_escape($this->input->post('document_name'));
            $data['file_name']     = $_FILES["userfile"]["name"];
            $data['file_size']     = $_FILES["userfile"]["size"];
            $this->db->insert('document', $data);
            redirect(site_url('teacher/manage_document'), 'refresh');
        }
        if ($do == 'delete') {
            $this->db->where('document_id', $document_id);
            $this->db->delete('document');
            redirect(site_url('teacher/manage_document'), 'refresh');
        }
        $page_data['page_name']  = 'manage_document';
        $page_data['page_title'] = get_phrase('kelola_dokument');
        $page_data['documents']  = $this->db->get('document')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*********MANAGE STUDY MATERIAL************/
    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create")
        {
            $this->crud_model->save_study_material_info();
            $this->session->set_flashdata('flash_message' , get_phrase('bahan_pengajaran_berhasil_disimpan'));
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        if ($task == "update")
        {
            $this->crud_model->update_study_material_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('bahan_pengajaran_berhasil_disimpan'));
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        $data['study_material_info']    = $this->crud_model->select_study_material_info_for_teacher();
        $data['page_name']              = 'study_material';
        $data['page_title']             = get_phrase('bahan_pengajaran');
        $this->load->view('backend/index', $data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        $max_size = 2097152;
        if ($param1 == 'send_new') {

            // Folder creation
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('ukuran file tidak boleh lebih dari 2MB'));
                  redirect(site_url('teacher/message/message_new/'), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('pesan_terkirim!'));
            redirect(site_url('teacher/message/message_read/'.$message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {

            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('ukuran file tidak boleh lebih dari 2MB'));
                  redirect(site_url('teacher/message/message_read/'.$param2), 'refresh');

              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('pesan_terkirim!'));
            redirect(site_url('teacher/message/message_read/'.$param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('pesan_pribadi');
        $this->load->view('backend/index', $page_data);
    }

    //GROUP MESSAGE
    function group_message($param1 = "group_message_home", $param2 = ""){
      if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');
      $max_size = 2097152;

      if ($param1 == 'group_message_read') {
        $page_data['current_message_thread_code'] = $param2;
      }
      else if($param1 == 'send_reply'){
        if (!file_exists('uploads/group_messaging_attached_file/')) {
          $oldmask = umask(0);  // helpful when used in linux server
          mkdir ('uploads/group_messaging_attached_file/', 0777);
        }
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
          if($_FILES['attached_file_on_messaging']['size'] > $max_size){
            $this->session->set_flashdata('error_message' , get_phrase('ukuran file tidak boleh lebih dari 2MB'));
              redirect(site_url('teacher/group_message/group_message_read/'.$param2), 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('pesan_terkirim!'));
          redirect(site_url('teacher/group_message/group_message_read/'.$param2), 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group_message';
      $page_data['page_title']                = get_phrase('pesan_group');
      $this->load->view('backend/index', $page_data);
    }

    // MANAGE QUESTION PAPERS
    function question_paper($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == "create")
        {
            $this->crud_model->create_question_paper();
            $this->session->set_flashdata('flash_message', get_phrase('data_berhasil_dibuat'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        if ($param1 == "update")
        {
            $this->crud_model->update_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_berhasil_diperbarui'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        if ($param1 == "delete")
        {
            $this->crud_model->delete_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_berhasil_dihapus'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        $data['page_name']  = 'question_paper';
        $data['page_title'] = get_phrase('question_paper');
        $this->load->view('backend/index', $data);
    }

    // Details of searched student
    function student_details(){
      if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');

      $student_identifier = html_escape($this->input->post('student_identifier'));
      $query_by_code = $this->db->get_where('student', array('student_code' => $student_identifier));

      if ($query_by_code->num_rows() == 0) {
        $this->db->like('name', $student_identifier);
        $query_by_name = $this->db->get('student');
        if ($query_by_name->num_rows() == 0) {
          $this->session->set_flashdata('error_message' , get_phrase('siswa_tidak_ditemukan'));
            redirect(site_url('teacher/dashboard'), 'refresh');
        }
        else{
          $page_data['student_information'] = $query_by_name->result_array();
        }
      }
      else{
        $page_data['student_information'] = $query_by_code->result_array();
      }
      $page_data['page_name']  	= 'search_result';
  		$page_data['page_title'] 	= get_phrase('hasil_pencarian');
  		$this->load->view('backend/index', $page_data);
    }

    function get_teachers() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $columns = array(
            0 => 'teacher_id',
            1 => 'photo',
            2 => 'name',
            3 => 'email',
            4 => 'phone',
            5 => 'teacher_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->ajaxload->all_teachers_count();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {
            $teachers = $this->ajaxload->all_teachers($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];
            $teachers =  $this->ajaxload->teacher_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ajaxload->teacher_search_count($search);
        }

        $data = array();
        if(!empty($teachers)) {
            foreach ($teachers as $row) {

                $photo = '<img src="'.$this->crud_model->get_image_url('teacher', $row->teacher_id).'" class="img-circle" width="30" />';

                $nestedData['teacher_id'] = $row->teacher_id;
                $nestedData['photo'] = $photo;
                $nestedData['name'] = $row->name;
                $nestedData['email'] = $row->email;
                $nestedData['phone'] = $row->phone;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    function get_books() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $columns = array(
            0 => 'book_id',
            1 => 'name',
            2 => 'author',
            3 => 'description',
            4 => 'price',
            5 => 'class',
            6 => 'download',
            7 => 'book_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->ajaxload->all_books_count();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {
            $books = $this->ajaxload->all_books($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];
            $books =  $this->ajaxload->book_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ajaxload->book_search_count($search);
        }

        $data = array();
        if(!empty($books)) {
            foreach ($books as $row) {
                if ($row->file_name == null)
                    $download = '';
                else
                    $download = '<a href="'.site_url("uploads/document/$row->file_name").'" class="btn btn-blue btn-icon icon-left"><i class="entypo-download"></i>'.get_phrase('unduh').'</a>';

                $nestedData['book_id'] = $row->book_id;
                $nestedData['name'] = $row->name;
                $nestedData['author'] = $row->author;
                $nestedData['description'] = $row->description;
                $nestedData['price'] = $row->price;
                $nestedData['class'] = $this->db->get_where('class', array('class_id' => $row->class_id))->row()->name;
                $nestedData['download'] = $download;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }
}
>>>>>>> e5e243259b5018699de5cc135fabe25e8846865a
