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

class Parents extends CI_Controller {

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

		if($this->session->userdata('parent_login') != 1){
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

	public function class_wise_subject($class_id) {

		// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
		$page_data['class_id'] = $class_id;
		$this->load->view('backend/parent/subject/dropdown', $page_data);
	}
	//END SUBJECT section


	//START SYLLABUS section
	public function syllabus($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/parent/syllabus/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'syllabus';
			$page_data['page_title'] = 'syllabus';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END SYLLABUS section


	//START TEACHER section
	public function teacher($param1 = '', $param2 = '', $param3 = ''){
		$page_data['folder_name'] = 'teacher';
		$page_data['page_title'] = 'techers';
		$this->load->view('backend/index', $page_data);
	}
	//END TEACHER section

	//START CLASS ROUTINE section
	public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/parent/routine/list', $page_data);
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

		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$page_data['student_id'] = $this->input->post('student_id');
			$this->load->view('backend/parent/attendance/list', $page_data);
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
		if($param1 == 'all_events'){
			echo $this->crud_model->all_events();
		}

		if ($param1 == 'list') {
			$this->load->view('backend/parent/event_calendar/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'event_calendar';
			$page_data['page_title'] = 'event_calendar';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EVENT CALENDAR section

	// This function is needed for Ajax calls only
	public function get_student_details_by_id($look_up_value = "", $student_id = "") {
		$student_details = $this->user_model->get_student_details_by_id('student', $student_id);
		echo $student_details[$look_up_value];
	}
	//END STUDENT ADN ADMISSION section


	//START EXAM section
	public function exam($param1 = '', $param2 = ''){
		if ($param1 == 'list') {
			$this->load->view('backend/parent/exam/list');
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
			$page_data['student_id'] = $this->input->post('student_id');
			//$this->crud_model->mark_insert($page_data['class_id'], $page_data['section_id'], $page_data['subject_id'], $page_data['exam_id']);
			$this->load->view('backend/parent/mark/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'mark';
			$page_data['page_title'] = 'marks';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END MARKS sesction

	// GRADE SECTION STARTS
	public function grade($param1 = "", $param2 = "") {
		$page_data['folder_name'] = 'grade';
		$page_data['page_title'] = 'grades';
		$this->load->view('backend/index', $page_data);
	}
	// GRADE SECTION ENDS

	// ACCOUNTING SECTION STARTS
	public function invoice($param1 = "", $param2 = "") {

		// Get the list of student. Here param2 defines classId
		if ($param1 == 'student') {
			$page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
			$this->load->view('backend/parent/student/dropdown', $page_data);
		}

		// showing the list of invoices
		if ($param1 == 'list') {
			$date = explode('-', $this->input->get('date'));
			$page_data['date_from'] = strtotime($date[0].' 00:00:00');
			$page_data['date_to']   = strtotime($date[1].' 23:59:59');
			$this->load->view('backend/parent/invoice/list', $page_data);
		}

		// showing the list of invoices
		if ($param1 == 'invoice') {
			$page_data['invoice_id'] = $param2;
			$page_data['folder_name'] = 'invoice';
			$page_data['page_name'] = 'invoice';
			$page_data['page_title']  = 'invoice';
			$this->load->view('backend/index', $page_data);
		}
		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'invoice';
			$page_data['page_title']  = 'invoice';
			$this->load->view('backend/index', $page_data);
		}
	}

	// PAYPAL CHECKOUT
	public function paypal_checkout() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);

		$page_data['invoice_id']   = $invoice_id;
		$page_data['user_details']    = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
		$page_data['amount_to_pay']   = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		$page_data['folder_name'] = 'paypal';
		$page_data['page_title']  = 'paypal_checkout';
		$this->load->view('backend/parent/paypal/paypal_checkout', $page_data);
	}

	// STRIPE CHECKOUT
	public function stripe_checkout() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);

		$page_data['invoice_id']   = $invoice_id;
		$page_data['user_details']    = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
		$page_data['amount_to_pay']   = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		$page_data['folder_name'] = 'paypal';
		$page_data['page_title']  = 'paypal_checkout';
		$this->load->view('backend/parent/stripe/stripe_checkout', $page_data);
	}

	// THIS FUNCTION WILL BE CALLED AFTER A SUCCESSFULL PAYMENT
	public function payment_success($payment_method = "", $invoice_id = "", $amount_paid = "") {
		if ($payment_method == 'stripe') {
			$token_id = $this->input->post('stripeToken');
			$stripe_test_mode = get_settings('stripe_mode');
            if ($stripe_test_mode == 'on') {
                $public_key = get_settings('stripe_test_public_key');
                $secret_key = get_settings('stripe_test_secret_key');
            } else {
                $public_key = get_settings('stripe_live_public_key');
                $secret_key = get_settings('stripe_live_secret_key');
            }
            $this->payment_model->stripe_payment($token_id, $invoice_id, $amount_paid, $secret_key);
		}

		$data['payment_method'] = $payment_method;
		$data['invoice_id'] = $invoice_id;
		$data['amount_paid'] = $amount_paid;
		$this->crud_model->payment_success($data);

		redirect(route('invoice'), 'refresh');
	}
	// ACCOUNTING SECTION ENDS

	// BACKOFFICE SECTION

	//BOOK LIST MANAGER
	public function book($param1 = "", $param2 = "") {
		// showing the list of book
		if ($param1 == 'list') {
			$this->load->view('backend/parent/book/list');
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

class Parents extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->model('stripe_model');
        $this->load->model('paypal_model');
        $this->load->model(array('Ajaxdataload_model' => 'ajaxload'));
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('parent_login') == 1)
            redirect(site_url('parents/dashboard'), 'refresh');
    }

    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard_wali_murid');
        $this->load->view('backend/index', $page_data);
    }


    /****MANAGE TEACHERS*****/
    function teacher_list($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('kelola_guru');
        $this->load->view('backend/index', $page_data);
    }


    // ACADEMIC SYLLABUS
    function academic_syllabus($student_id = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('silabus_akademik');
        $page_data['student_id']   = $student_id;
        $this->load->view('backend/index', $page_data);
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



    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $parent_profile         = $this->db->get_where('parent', array(
            'parent_id' => $this->session->userdata('parent_id')
        ))->row();
        $parent_class_id        = $parent_profile->class_id;
        $page_data['subjects']   = $this->db->get_where('subject', array(
            'class_id' => $parent_class_id
        ))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }



    /****MANAGE EXAM MARKS*****/
    function marks($param1 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $children_ids       = array();
        $children_of_parent = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->result_array();
        foreach($children_of_parent as $row)
            array_push($children_ids, $row['student_id']);

        if(!in_array($param1, $children_ids)) {
            $this->session->set_flashdata('error_message', get_phrase('no_direct_script_access_allowed'));
            redirect(site_url('parents/dashboard'), 'refresh');
        }

        $page_data['student_id'] = $param1;
        $page_data['page_name']  = 'marks';
        $page_data['page_title'] = get_phrase('kelola_tanda');
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/parent/student_marksheet_print_view', $page_data);
    }


    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['student_id'] = $param1;
        $page_data['page_name']  = 'class_routine';
        $page_data['page_title'] = get_phrase('mengatur_rutinitas_kelas');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/teacher/class_routine_print_view' , $page_data);
    }

    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($student_id = '' , $param1 = '', $param2 = '', $param3 = '')
    {
        //if($this->session->userdata('parent_login')!=1)redirect(base_url() , 'refresh');
        if ($param1 == 'make_payment') {
            $invoice_id      = $this->input->post('invoice_id');
            $system_settings = $this->db->get_where('settings', array(
                'type' => 'paypal_email'
            ))->row();
            $invoice_details = $this->db->get_where('invoice', array(
                'invoice_id' => $invoice_id
            ))->row();

            /****TRANSFERRING USER TO PAYPAL TERMINAL****/
            $this->paypal->add_field('rm', 2);
            $this->paypal->add_field('no_note', 0);
            $this->paypal->add_field('item_name', $invoice_details->title);
            $this->paypal->add_field('amount', $invoice_details->amount);
            $this->paypal->add_field('custom', $invoice_details->invoice_id);
            $this->paypal->add_field('business', $system_settings->description);
            $this->paypal->add_field('notify_url', site_url('parents/invoice/paypal_ipn'));
            $this->paypal->add_field('cancel_return', site_url('parents/invoice/paypal_cancel'));
            $this->paypal->add_field('return', site_url('parents/invoice/paypal_success'));

            $this->paypal->submit_paypal_post();
            // submit the fields to paypal
        }
        if ($param1 == 'paypal_ipn') {
            if ($this->paypal->validate_ipn() == true) {
                $ipn_response = '';
                foreach ($_POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $ipn_response .= "\n$key=$value";
                }
                $data['payment_details']   = $ipn_response;
                $data['payment_timestamp'] = strtotime(date("m/d/Y"));
                $data['payment_method']    = 'paypal';
                $data['status']            = 'paid';
                $invoice_id                = $_POST['custom'];
                $this->db->where('invoice_id', $invoice_id);
                $this->db->update('invoice', $data);

                $data2['method']       =   'paypal';
                $data2['invoice_id']   =   $_POST['custom'];
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->amount;
                $this->db->insert('payment' , $data2);
            }
        }
        if ($param1 == 'paypal_cancel') {
            $this->session->set_flashdata('flash_message', get_phrase('payment_cancelled'));
            redirect(site_url('parents/invoice/'. $student_id), 'refresh');
        }
        if ($param1 == 'paypal_success') {
            $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));
            redirect(site_url('parents/invoice/'. $student_id), 'refresh');
        }
        $parent_profile         = $this->db->get_where('parent', array(
            'parent_id' => $this->session->userdata('parent_id')
        ))->row();
        $page_data['student_id'] = $student_id;
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('mengelola_faktur/pembayaran');
        $this->load->view('backend/index', $page_data);
    }

    function paypal_checkout($student_id = '') {
      if ($this->session->userdata('parent_login') != 1)
          redirect('login', 'refresh');

        $invoice_id = $this->input->post('invoice_id');
        $page_data['student_details'] = $this->db->get_where('student', array('student_id' => $student_id))->row();
        $page_data['invoice_details'] = $this->db->get_where('invoice', array(
            'invoice_id' => $invoice_id
        ))->row();
        $this->load->view('backend/paypal_checkout', $page_data);
    }
    function stripe_checkout($student_id = ''){
      if ($this->session->userdata('parent_login') != 1)
          redirect('login', 'refresh');

          $invoice_id = $this->input->post('invoice_id');
          $page_data['student_details'] = $this->db->get_where('student', array('student_id' => $student_id))->row();
          $page_data['invoice_details'] = $this->db->get_where('invoice', array(
              'invoice_id' => $invoice_id
          ))->row();
          $this->load->view('backend/stripe_checkout', $page_data);
    }
    function pay($gateway = '', $invoice_id = '') {

      if ($gateway == 'stripe') {
            $student_id = $this->input->post('student_id');
            $payment_success = $this->stripe_model->pay($invoice_id);
            if ($payment_success == true) {
                $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));
                redirect(site_url('parents/invoice/'. $student_id), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', get_phrase('payment_failed'));
                redirect(site_url('parents/invoice/'. $student_id), 'refresh');
            }
        }
        else if ($gateway == 'paypal') {
            $this->paypal_model->pay($invoice_id);
            $this->session->set_flashdata('flash_message', get_phrase('package_changed_successfully'));
        }
      $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));
    }
    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('kelola_buku_pustaka');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('kelola_transportasi');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE DORMITORY / HOSTELS / ROOMS ********************/
    function dormitory($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

        $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['page_name']   = 'dormitory';
        $page_data['page_title']  = get_phrase('manage_dormitory');
        $this->load->view('backend/index', $page_data);

    }

    /**********WATCH NOTICEBOARD AND EVENT ********************/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

        $page_data['notices']    = $this->db->get_where('noticeboard',array('status'=>1))->result_array();
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('papan_pengumuman');
        $this->load->view('backend/index', $page_data);

    }

    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/
    function document($do = '', $document_id = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

        $page_data['page_name']  = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $page_data['documents']  = $this->db->get('document')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

        $max_size = 2097152;
        if ($param1 == 'send_new') {

            //folder creation
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                redirect(site_url('parents/message/message_new/'), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('parents/message/message_read/'. $message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {

            //folder creation
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                  redirect(site_url('parents/message/message_read/'. $param2), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('pesan_terkirim!'));
            redirect(site_url('parents/message/message_read/'. $param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('pesan_');
        $this->load->view('backend/index', $page_data);
    }

    //GROUP MESSAGE
    function group_message($param1 = "group_message_home", $param2 = ""){
      if ($this->session->userdata('parent_login') != 1)
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
            $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
              redirect(site_url('parents/group_message/group_message_read/'. $param2), 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
          redirect(site_url('parents/group_message/group_message_read/'. $param2), 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group_message';
      $page_data['page_title']                = get_phrase('pesan_group');
      $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('parent_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = html_escape($this->input->post('name'));
            $data['email']       = html_escape($this->input->post('email'));
            $validation = email_validation_for_edit($data['email'], $this->session->userdata('parent_id'), 'parent');
            if ($validation == 1) {
                $this->db->where('parent_id', $this->session->userdata('parent_id'));
                $this->db->update('parent', $data);
                $this->session->set_flashdata('flash_message', get_phrase('pembaruan_akun'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('parents/manage_profile/'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('parent', array(
                'parent_id' => $this->session->userdata('parent_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('parent_id', $this->session->userdata('parent_id'));
                $this->db->update('parent', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('pembaruan_password'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }
            redirect(site_url('parents/manage_profile/'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('kelola_profil');
        $page_data['edit_data']  = $this->db->get_where('parent', array(
            'parent_id' => $this->session->userdata('parent_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function pay_with_payumoney($param1 = "", $param2 = ""){
        $page_data['page_name']  = 'pay_with_payumoney';
        $page_data['page_title'] = get_phrase('pay_with_payumoney');
        $page_data['student_id'] = $param1;
        $page_data['invoice_id'] = $param2;
        $this->load->view('backend/index', $page_data);
    }

    // Attendance report view
  function attendance_report($student_id = ""){
    if ($student_id != "") {
      $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
      $page_data['student_id']        = $student_id;
      $page_data['month']             = date('m');
      $page_data['page_name']         = 'attendance_report';
      $page_data['page_title']        = get_phrase('laporan_kehadiran_') . ' ' . $student_name . ' : ';
      $this->load->view('backend/index', $page_data);
    }
  }
  function attendance_report_selector($student_id = "")
  {
      if($student_id != ""){
        $running_year 		=   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        $sessional_year_array = explode("-", $running_year);
        $sessional_year = $sessional_year_array[0];
        $array = array(
          'student_id' => $student_id,
          'year'       => $running_year
        );
        $class_id               = $this->db->get_where('enroll', $array)->row()->class_id;
        $section_id             = $this->db->get_where('enroll', $array)->row()->section_id;
        $data['class_id']       = $class_id;
        $data['section_id']     = $section_id;
        $data['month']          = $this->input->post('month');
        $data['sessional_year'] = $sessional_year;
        $data['student_id']     = $student_id;
        //print_r($data);
        redirect(site_url('parents/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'] . '/' . $data['sessional_year'] .'/'.$data['student_id']), 'refresh');
      }
  }
  function attendance_report_view($class_id = '', $section_id = '', $month = '', $sessional_year = '', $student_id = '')
  {
      if($this->session->userdata('parent_login')!=1)
         redirect(base_url() , 'refresh');
     $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
     $class_name                     = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
     $section_name                   = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
     $page_data['student_id']        = $student_id;
     $page_data['class_id']          = $class_id;
     $page_data['section_id']        = $section_id;
     $page_data['month']             = $month;
     $page_data['sessional_year']    = $sessional_year;
     $page_data['page_name']         = 'attendance_report_view';
     $page_data['page_title']        = get_phrase('laporan') . ' '.$student_name;
     $this->load->view('backend/index', $page_data);
  }
  function attendance_report_print_view($class_id ='' , $section_id = '' , $month = '', $sessional_year = '', $student_id = '') {
       if ($this->session->userdata('parent_login') != 1)
         redirect(base_url(), 'refresh');

     $page_data['class_id']          = $class_id;
     $page_data['section_id']        = $section_id;
     $page_data['month']             = $month;
     $page_data['sessional_year']    = $sessional_year;
     $page_data['student_id']        = $student_id;
     $this->load->view('backend/parent/attendance_report_print_view' , $page_data);
 }

    function get_teachers() {
        if ($this->session->userdata('parent_login') != 1)
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

        if(empty($this->input->post('cari')['value'])) {
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
        if ($this->session->userdata('parent_login') != 1)
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
