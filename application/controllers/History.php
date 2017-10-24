<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	public function logged_in_check()
	{
	    if (!$this->session->userdata('logged_in')) {
	      redirect('/login');
	    }
	}

	function __construct()
	{
	    parent::__construct();

	    $this->logged_in_check();
	}

	public function index(){
		
		$this->load->model("Crud");

		if($_SESSION['branch'] == "1"){ // superadmin
	    	$q = "select F.*, B.branch_name FROM form as F, branch as B where F.branch = B.id order by create_date ASC ";
		}
		elseif ($_SESSION['position'] == '2') {
			$q = "select F.*,B.branch_name FROM form as F,branch as B where F.branch=B.id AND F.created_by = '" . $_SESSION['uuid'] . "' order by create_date ASC ";
		}
		else{
			$q = "select F.*,B.branch_name FROM form as F,branch as B where F.branch=B.id and F.branch='". $_SESSION['branch'] . "' order by create_date ASC ";
		}

		$data["forms"] = $this->Crud->specialQuery($q);

		$header['title'] = 'History';
		$this->load->view('includes/header', $header);
	    $this->load->view('history', $data);
	    $this->load->view('includes/footer');
	}

	public function details($id){
		$this->load->model("Crud");

		$sql = "select F.*, B.branch_name, U.position FROM form F, user U, branch B WHERE F.created_by = U.id AND F.branch = B.id AND F.id = '$id' ";
		$result['result'] = $this->Crud->specialQuery($sql);

		$q = "select f.*,u.name FROM form_record f, user u WHERE f.id_user = u.id and f.id_form = '$id' ORDER BY exec_date ASC ";
		$result['data'] = $this->Crud->specialQuery($q);

		$result['amount_detail'] = $this->Crud->GetWhere('form_detail', array('id_form' => $id));

		$header['title'] = 'Form history details';

		$result['result'][0]->path = stripslashes($result['result'][0]->path);
		$result['result'][0]->path = substr($result['result'][0]->path, 1, -1);
		$result['result'][0]->path = json_decode($result['result'][0]->path, true);

		$result['currency'] = '';
		$currency = $result['result'][0]->currency;

		if ($currency == 1) {
			$result['currency'] = 'IDR';
		} else if ($currency == 2) {
			$result['currency'] = 'USD';
		}

		$this->load->view('includes/header', $header);
	    $this->load->view('history_details',$result);
	    $this->load->view('includes/footer');
	}
}