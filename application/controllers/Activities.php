<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

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
	    $this->load->model('Crud');
	    $this->load->helper('form');
	}

	public function index()
	{

		$header['title'] = 'Activities';
		
		$this->load->view('includes/header', $header);
	    $this->load->view('activities');
	    $this->load->view('includes/footer');
	}

}
