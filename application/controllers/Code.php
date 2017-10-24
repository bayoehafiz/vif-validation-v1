<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Code extends MY_Controller {

	function __construct()
	{
	    parent::__construct();

	    $this->is_logged_in();

	    $this->load->model('Crud');
	    $this->load->helper('form');
	    $this->load->library('form_validation');
	}

	public function index(){
		$result['all'] = $this->Crud->Get('code');

		$header['title'] = 'Cost Code Management';
		$this->load->view('includes/header', $header);
	    $this->load->view('code_list',$result);
	    $this->load->view('includes/footer');
	}

	public function add(){
		$header['title'] = 'Add Code';

		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
		        'name' => $this->input->post('code'),
		        'description' => $this->input->post('description'),
		        'created_on' => time()
		    );

		    $data = $this->Crud->Insert('code', $data);
		 	if ($data) {
		        $this->session->set_flashdata('success_msg', 'New code has been added.');
		        redirect('/code');
		    }
		}

		$this->load->view('includes/header', $header);
	    $this->load->view('new_code');
	    $this->load->view('includes/footer');
	}

	public function edit($id){
		$header['title'] = 'Edit Code';

		$data = $this->Crud->GetWhere('code', array('id' => $id));

		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
		        'name' => $this->input->post('code'),
		        'description' => $this->input->post('description')
		    );

		   	$where = array(
		        'id' => $id,
		    );

		    $res = $this->Crud->Update('code', $data, $where);

		    if ($res>0) {
		        $this->session->set_flashdata('success_msg', 'A code has been updated.');
		        redirect('/code');
		    }
		}

		$this->load->view('includes/header',$header);
		$this->load->view('edit_code', $data[0]);
	    $this->load->view('includes/footer');
	}

	public function delete($id){
		$where = array(
		    'id' => $id,
		);

		$data = $this->Crud->Delete('code', $where);

		if ($data>0) {
		    $this->session->set_flashdata('success_msg', 'A code has been updated.');
		   	redirect('/code');
		}
	}
}