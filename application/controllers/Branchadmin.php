<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branchadmin extends MY_Controller {

	function __construct()
	{
	    parent::__construct();

	    $this->is_logged_in();

	    $this->load->model('Crud');
	    $this->load->helper('form');
	    $this->load->library('form_validation');
	}

	public function index(){

		$this->load->model("form_model"); 
    	$data["forms"]=$this->form_model->getforms();

		$this->load->view('includes/header');

		$this->load->view('list_forms',$data);
	    $this->load->view('includes/footer');
	}

	public function view_form(){
		$header['title'] = 'View Form';
		

		$this->load->view('includes/header',$header);
		$this->load->view('view_form');
	    $this->load->view('includes/footer');
	}

	public function new_branch()
	{
		$header['title'] = 'New Branch';

		$this->form_validation->set_rules('branch', 'Branch Name', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
		        'branch_name' => $this->input->post('branch'),
		        'created_on' => time(),
		        'modified_on' => time()
		    );

		    $data = $this->Crud->Insert('branch', $data);
		 	if ($data) {
		        $this->session->set_flashdata('success_msg', 'Branch has been created.');
		        redirect('/branch');
		    }
		}

		$this->load->view('includes/header',$header);
		$this->load->view('new_branch');
	    $this->load->view('includes/footer');
	}

	public function edit_branch($id)
	{
		$header['title'] = 'Edit Branch';


		$data = $this->Crud->GetWhere('branch', array('id' => $id));

		$this->form_validation->set_rules('branch', 'Branch Name', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
		        'branch_name' => $this->input->post('branch'),
		        'modified_on' => time()
		    );

		   	$where = array(
		        'id' => $id,
		    );

		    $res = $this->Crud->Update('branch', $data, $where);

		    if ($res>0) {
		        $this->session->set_flashdata('success_msg', 'Branch has been updated.');
		        redirect('/branch');
		    }
		}

		$this->load->view('includes/header',$header);
		$this->load->view('edit_branch', $data[0]);
	    $this->load->view('includes/footer');
	}

	public function delete_branch($id)
	{

		$where = array(
		    'id' => $id,
		);

		$data = $this->Crud->Delete('branch', $where);

		if ($data>0) {
		    $this->session->set_flashdata('success_msg', 'Branch has been updated.');
		   	redirect('/branch');
		}
	}

	public function branch_management()
	{
		$header['title'] = 'Branch Management';
		
		$data['data'] = $this->Crud->Get('branch');

		$this->load->view('includes/header',$header);
		$this->load->view('branch_management', $data);
	    $this->load->view('includes/footer');
	}



}
