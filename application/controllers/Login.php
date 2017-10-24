<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login extends CI_Controller
{
 
	function __construct()
	{
		parent::__construct();
		$this->load->model('Crud');
	}

	public function logged_in_check()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}
	}
 
	public function index()
	{	

		$this->logged_in_check();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true) {
			$this->load->model('Auth');

			$status = $this->Auth->validate();
			if ($status == ERR_INVALID_EMAIL) {
				$this->session->set_flashdata('error', 'Email is invalid');
			} else if ($status == ERR_INVALID_PASSWORD) {
				$this->session->set_flashdata('error', 'Password is invalid');
			} else if ($status == ERR_TIMEOUT) {
				$this->session->set_flashdata('error', 'Sorry! Network failure happened. Please try again in 5 minutes.');
			} else {
				$this->session->set_userdata($this->Auth->get_data());
				$this->session->set_userdata('logged_in', true);


				// fetch all forms and find which ones are required attention
				$found = 0;
				$forms = [];
				$q = "select a.*, b.branch_name FROM form a, branch b WHERE a.branch=b.id";
				$all_forms = $this->Crud->specialQuery($q);
				if (count($all_forms) > 0) {
					foreach ($all_forms as $form) {
						if ((($form['stage'] == $_SESSION['position'] && $form['branch'] == $_SESSION['branch'])
								|| ($form['stage'] == $_SESSION['position'] && $_SESSION['branch'] == '1')) 
								|| ($form['status'] == 'Rejected' && $form['branch'] == $_SESSION['branch'] && $form['stage'] == intval($_SESSION['position']) + 1) ) {
							$found++;
							array_push($forms, array(
								'id' => $form['id'],
								'subject' => $form['subject'],
								'branch_name' => $form['branch_name'],
								'status' => $form['status']
							));
						}
					}
				}

				if ($found > 0) {
					$this->session->set_userdata('active_forms_total', $found);
					$this->session->set_userdata('active_forms_ids', $forms);
				} 
			
				redirect('/');
			}

		}

		$this->load->view('login');
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login');
	}

}