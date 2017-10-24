<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Connection extends CI_Controller {
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
	}

	public function index() {
		$curl = curl_init();
		$token = IONIC_API_KEY;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ionic.io/auth/test",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$data['response'] = [];

		if ($err) {
			$data['success'] = false;
			$data['response'] = $err;
		} else {
			// convert to Array
			$Data = json_decode($response, true);

			if (isset($Data['error'])) {
				$data['success'] = false;
				$data['response'] = $Data['error']['type'] . ": " . $Data['error']['message'] 
					. "<br/><br/><small>Status: <strong>" . $Data['meta']['status'] . "</strong></small>"
					. "<br/><small>Request ID: " . $Data['meta']['request_id'] . "</small>"
					. "<br/><small>Version: " . $Data['meta']['version'] . "</small>";
			} else {
				$data['success'] = true;
				$data['response'] = "Success: " . $Data['data']['success']
					. "<br/><br/><small>Status: <strong>" . $Data['meta']['status'] . "</strong></small>"
					. "<br/><small>Request ID: " . $Data['meta']['request_id'] . "</small>"
					. "<br/><small>Version: " . $Data['meta']['version'] . "</small>";
			}
		}

		$header['title'] = 'Checking Cloud Connection...';
		$this->load->view('includes/header', $header);
	    $this->load->view('connection', $data);
	    $this->load->view('includes/footer');
	}


	public function list_users() {
		$response = $this->getUsers();

		// convert to Array
		$Data = json_decode($response, true);

		if (count($Data['data']) > 0) {
			$data['success'] = true;
			$data['response'] = $Data['data'];
		} else {
			$data['success'] = false;
			$data['response'] = "EMPTY: You don't have any user on cloud! Please do SYNC USERS."
				. "<br/><br/><small>Status: <strong>" . $Data['meta']['status'] . "</strong></small>"
				. "<br/><small>Request ID: " . $Data['meta']['request_id'] . "</small>"
				. "<br/><small>Version: " . $Data['meta']['version'] . "</small>";
		}

		$header['title'] = 'Cloud Users List';
		$this->load->view('includes/header', $header);
	    $this->load->view('connection_list', $data);
	    $this->load->view('includes/footer');
	}

	public function del_user($id) {
		$this->removeUser($id);

		$header['title'] = 'User Deletion';
		$this->load->view('includes/header', $header);
	    $this->load->view('connection_delete');
	    $this->load->view('includes/footer');
	}

	public function del_all() {
		$this->removeAll();

		$header['title'] = 'User Deletion';
		$this->load->view('includes/header', $header);
	    $this->load->view('connection_delete_all');
	    $this->load->view('includes/footer');
	}


	public function sync_users() {
		$postData = [];
		$response = $this->getUsers();
		$data['response'] = [];

		// convert to Array
		$Data = json_decode($response, true);

		// if cloud users are NOT empty, then flush them all
		if (count($Data['data']) > 0) {
			$this->removeAll();
		}

		// Push all app users to cloud
		$localUsers = $this->loadLocalUsers();
		foreach ($localUsers as $user) {
			$postData['app_id'] = 'ef3c6497';
			if ($user['id'] == 1) {
				$postData['email'] = 'developer@mss.co.id';
			} else {
				$postData['email'] = $user['username'];
			}
			$postData['name'] = $user['name'];
			$postData['password'] = $user['password'];

			// convert to JSON & send it
			$resData = $this->addUser(json_encode($postData));

			// save it to Array
			array_push($data['response'], $resData);
		}

		$data['success'] = true;

		$header['title'] = 'Sync Cloud Users';
		$this->load->view('includes/header', $header);
	    $this->load->view('connection_sync', $data);
	    $this->load->view('includes/footer');
	}



	public function getUsers() {
		$curl = curl_init();
		$token = IONIC_API_KEY;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ionic.io/auth/users",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			),
		));

		$data = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return $err;
		} else {
			return $data;
		}
	}

	public function addUser($userData) {
		$curl = curl_init();
		$token = IONIC_API_KEY;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ionic.io/auth/users",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $userData,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			),
		));

		$json = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return $err;
		} else {
			// convert to Array
			$data = json_decode($json, true);
			return $data;
		}
	}

	public function removeUser($uuid) {
		$curl = curl_init();
		$token = IONIC_API_KEY;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ionic.io/auth/users/" . $uuid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "DELETE",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			),
		));

		$json = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return $err;
		} else {
			// convert to Array
			$data = json_decode($json, true);
			return $data;
		}
	}

	public function removeAll() {
		$response = $this->getUsers();

		// convert to Array
		$Data = json_decode($response, true);

		foreach ($Data['data'] as $user) {
			$this->removeUser($user['uuid']);
		}
	}

	public function loadLocalUsers() {
		$data['users'] = $this->Crud->Get('user');
		$users = [];

		foreach ($data['users'] as $user) {

				$branch = $this->Crud->GetWhere('branch', array('id' => $user['branch']));
				$position = $this->Crud->GetWhere('position', array('id' => $user['position']));

				$user['branch_name'] = $branch[0]['branch_name'];
				$user['position_name'] = $position[0]['name'];

				array_push($users, $user);
		}

		return $users;
	}

}