<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	function __construct() {
		parent::__construct();

		// Load resources
		$this->load->helper('form');
		$this->load->helper('auth');
		$this->load->model('Crud');
		$this->load->model('auth/examples_model');
		$this->load->model('auth/validation_callables');
		$this->load->library('form_validation');
	}

	public function DB_action($act, $data, $id) {
		$table = 'users';

		if ($act == 'add_user') {
			$q = $this->Crud->Insert($table, $data);
		} else if ($act == 'update_user') {
			$q = $this->Crud->Update($table, $data, array('user_id' => $id));
		}else if ($act == 'delete_user') {
			$q = $this->Crud->Delete($table, array('user_id' => $id));
		} else if ($act == 'get_user') {
			$q = $this->Crud->GetWhere($table, array('user_id' => $id));
		} else if ($act == 'check_email') {
			$q = $this->Crud->CheckEmail($data);
		} else if ($act == 'check_username') {
			$q = $this->Crud->CheckUsername($data);
		} else {
			$q = $this->Crud->Get($table);
		}

		return $q;
	}

	public function get_unused_id()
    {
        // Create a random user id between 1200 and 4294967295
        $random_unique_int = 2147483648 + mt_rand( -2147482448, 2147483647 );

        // Make sure the random user_id isn't already in use
        $query = $this->Crud->GetWhere('users', array('user_id' => $random_unique_int));

        if (count($query) > 0)
        {
            // $query->free_result();

            // If the random user_id is already in use, try again
            return $this->get_unused_id();
        }

        return $random_unique_int;
    }

    public function hash_passwd($password, $random_salt = '')
	{
		// If no salt provided for older PHP versions, make one
		if( ! is_php('5.5') && empty( $random_salt ) )
			$random_salt = $this->random_salt();

		// PHP 5.5+ uses new password hashing function
		if( is_php('5.5') ){
			return password_hash( $password, PASSWORD_BCRYPT, ['cost' => 11] );
		}

		// PHP < 5.5 uses crypt
		else
		{
			return crypt( $password, '$2y$10$' . $random_salt );
		}
	}

	public function email_check($str) {
		$response = $this->DB_action('check_email', $str, "");
		$found = false;

		if ($response) {
			$found = true;
		}

		if ($found){
			$this->form_validation->set_message('email_check', 'Email is already exist. Please type another email address.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function username_check($str) {
		$response = $this->DB_action('check_username', $str, "");
		$found = false;

		if ($response) {
			$found = true;
		}

		if ($found){
			$this->form_validation->set_message('email_check', 'Username is already exist. Please pick another username.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function get_position() {
		$position = json_encode($this->Crud->Get('position'));
		print_r($position);
	}

	// LIST all users
	public function index() {
			$header['title'] = 'User Management';

			$data['users'] = [];
		
			// $response = $this->DB_action('list_all', "", "");
			$q = "SELECT * FROM users ORDER BY position DESC";
			$response = $this->Crud->specialQuery($q);

			if (count($response) > 0) {
				foreach ($response as $value) {
					$branch = $this->Crud->GetWhere('branch', array('id' => $value['branch']));

					$value['branch_name'] = $branch[0]['branch_name'];

					$position = $this->Crud->GetWhere('position', array('id' => $value['position']));
					$value['position_name'] = $position[0]['name'];

					array_push($data['users'], $value);
				}
			} else {
				$this->session->set_flashdata('error_msg', 'Failed while fetching users data. Please try again in 10 minutes.');
			}

			$this->load->view('includes/header',$header);
			$this->load->view('user_management', $data);
			$this->load->view('includes/footer');
	}

	// CREATE new user
	public function new_user() {
			$header['title'] = 'New User';

			$data['branch'] = $this->Crud->Get('branch');

			$this->load->view('includes/header',$header);
			$this->load->view('new_user', $data);
			$this->load->view('includes/footer');

			// Form validation rule
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_check');
			// $this->form_validation->set_rules('username', 'Username', 'trim|callback_username_check');
			$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
			$this->form_validation->set_rules('position', 'Position', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

			// Form action
			if ($this->form_validation->run() == true) {
				// Data population
				$user_data = array(
					'user_id' =>  $this->get_unused_id(),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'username' => NULL,
					'branch' => $this->input->post('branch'),
					'position' => $this->input->post('position'),
					'passwd' => $this->hash_passwd($this->input->post('password')),
					'created_at' => date('Y-m-d H:i:s')
				);

				// If username is not used, it must be entered into the record as NULL
				// if (empty($user_data['username'])) {
				// 	$user_data['username'] = NULL;
				// }

				$query = $this->DB_action('add_user', $user_data, "");

				if ($query == 1) {
					$this->session->set_flashdata('success_msg', 'User has been created.');
					redirect('/user');
				} else {
					$this->session->set_flashdata('error_msg', 'Failed creating new user. Please try again later.');
				}
			}
	}


	public function edit_user($id) {
		$header['title'] = 'Edit User';

		$response = $this->DB_action('get_user', "", $id);
		$data = [];

		if (count($response) < 1) {
			$this->session->set_flashdata('error_msg', 'Could not fetch user data.');
		} else {
			$data = $response[0];
			// Get the lists
			$data['branch_list'] = $this->Crud->Get('branch');
			$data['position_list'] = $this->Crud->Get('position');

			// Handling permissions
			// $user_acl = $data['custom']['access_rights'];
			// $data['user_acl']=$user_acl;
			// $data['page_acl_list']= $page_acl_list;
			// $data['action_acl_list']= $action_acl_list;
		}

		$this->load->view('includes/header',$header);
		$this->load->view('edit_user', $data);
		$this->load->view('includes/footer');


		// Saving edit form
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->input->post('email') !== $data['email'])
			$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_check');
		else
			$this->form_validation->set_rules('email', 'Email', 'trim|required');

		// if ($this->input->post('username') !== $data['username'])
		// 	$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
		// else
		// 	$this->form_validation->set_rules('username', 'Username', 'trim|required');

		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
	
		if ($this->form_validation->run() == true) {
			// set auth_level
			if ($this->input->post('branch') == 1 && $this->input->post('position') == 1)
				$data['auth_level'] = 9;
			else
				$data['auth_level'] = 6;

			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				// 'username' => $this->input->post('username'),
				'branch' => $this->input->post('branch'),
				'position' => $this->input->post('position')
			);

			$res = $this->DB_action('update_user', $data, $id);

			if ($res) {
				$this->session->set_flashdata('success_msg', 'User has been successfully updated.');
				redirect('/user');
			} else {
				$this->session->set_flashdata('error_msg', 'Failed updating user. Please try again later.');
			}
		}
	}


	public function delete_user($id) {
		$response = $this->DB_action('delete_user', "", $id);

		if ($response == 1) {
			$this->session->set_flashdata('success_msg', 'User has been deleted.');
		} else {
			$this->session->set_flashdata('error_msg', 'Failed deleting user. Please try again later.');
		}

		redirect('/user');
	}


	public function password_user($id) {
		$header['title'] = 'Change User Password';

		$response = $this->DB_action('get_users', "", $id);

		if ($response == 1) {
			$this->session->set_flashdata('error_msg', $msg);
		} else {
			$data = $response[0];

			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run() == true) {

				$data = array(
					'passwd' => $this->hash_passwd($this->input->post('password'))
				);

				$res = $this->DB_action('update_user', $data, $id);

				if ($res == 1) {
					$this->session->set_flashdata('success_msg', 'Password successfully changed.');
					redirect('/user/edit/' . $id);
				} else {
					$this->session->set_flashdata('error_msg', 'Failed changing password. Please try again later.');
				}
			}
		}

		$this->load->view('includes/header',$header);
		$this->load->view('password_user', $data);
		$this->load->view('includes/footer');
	}

	public function edit_permissions($id) {
		$header['title1'] = 'Edit Permissions';

		$response = $this->DB_action('get_user', "", $id);
		//echo $id;
		$msg = $response['msg'];
		$data = [];
		if ($response['success'] != '1') {
			$this->session->set_flashdata('error_msg', $msg);
		} else {
			$data = $msg['data'];
			//print_r($data);
			$sql = "select AP.* from action_permissions AP";
			$data['ap'] = $this->Crud->specialQuery($sql);
			$sql = "select PP.* from page_permissions PP";
			$data['pp'] = $this->Crud->specialQuery($sql);

			$pageper = $this->input->post('pagepermission');
			$actper = $this->input->post('actpermission');
			if ($pageper != null && $actper != null){
				$data['custom']['access_rights']['pages'] = $pageper;
				$data['custom']['access_rights']['actions'] = $actper;

				$res = $this->DB_action('update_user', json_encode($data), $id);
				if ($res['success'] == '1') {
					$this->session->set_flashdata('success_msg', 'Permissions successfully updated.');
					redirect('/user/edit/' . $id);
				} else {
					$this->session->set_flashdata('error_msg', 'Failed updating permissions. Please try again later.');
				}
			}
			
		}
		//print_r($data);
		$this->load->view('includes/header',$header);
		$this->load->view('edit_permissions', $data);
		$this->load->view('includes/footer');
	}


	// public function edit_username($id)
	// {
	// 	$header['title1'] = 'Change Email';

	// 	$data = $this->Crud->GetWhere('user', array('id' => $id));

	// 	$this->form_validation->set_rules('username', 'Email', 'trim|required|callback_email_check');

	// 	if ($this->form_validation->run() == true) {

	// 		$data = array(
	// 			'username' => $this->input->post('username'),
	// 			'modified_on' => time()
	// 		);

	// 		$where = array(
	// 			'id' => $id,
	// 		);

	// 		$res = $this->Crud->Update('user', $data, $where);

	// 		if ($res>0) {
	// 			$this->session->set_flashdata('success_msg', 'Email has been updated.');
	// 			redirect('/user');
	// 		}
	// 	}

	// 	$this->load->view('includes/header',$header);
	// 	$this->load->view('edit_username', $data[0]);
	// 	$this->load->view('includes/footer');
	// }


	public function position_management() {	

		$header['title'] = 'Position Management';

		$data['data'] = $this->Crud->Get('position');	


		$this->load->view('includes/header',$header);
		$this->load->view('position_management', $data);
		$this->load->view('includes/footer');
	}

	public function new_position() {
		$header['title'] = 'New Position';

		$this->form_validation->set_rules('name', 'Position Name', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
				'name' => $this->input->post('name'),
				'created_on' => time(),
				'modified_on' => time()
			);

			$data = $this->Crud->Insert('position', $data);

			if ($data) {
				$this->session->set_flashdata('success_msg', 'Position has been created.');
				redirect('/position');
			}
		}


		$this->load->view('includes/header',$header);
		$this->load->view('new_position');
		$this->load->view('includes/footer');
	}

	public function edit_position($id) {
		$header['title'] = 'Edit Position';

		$data = $this->Crud->GetWhere('position', array('id' => $id));

		$this->form_validation->set_rules('name', 'Position Name', 'trim|required');

		if ($this->form_validation->run() == true) {
			$data = array(
				'name' => $this->input->post('name'),
				'modified_on' => time()
			);

			$where = array(
				'id' => $id,
			);

			$res = $this->Crud->Update('position', $data, $where);

			if ($res>0) {
				$this->session->set_flashdata('success_msg', 'Position has been updated.');
				redirect('/position');
			}
		}

		$this->load->view('includes/header',$header);
		$this->load->view('edit_position', $data[0]);
		$this->load->view('includes/footer');
	}

	public function delete_position($id) {

		$where = array(
			'id' => $id,
		);

		$data = $this->Crud->Delete('position', $where);

		if ($data>0) {
			$this->session->set_flashdata('success_msg', 'Position has been updated.');
			redirect('/position');
		}
	}

	public function import_data() {
		
		$header['title'] = 'Import Data';
		if(isset($_POST['submit'])){

			if ($_FILES["import_data"]["type"] == "text/csv") {
				$filecsv = $_FILES["import_data"];
				$filename = $filecsv["tmp_name"];

				if ($filecsv["size"] > 0) {
					$file = fopen($filename, "r");
					$key = $this->input->post('import_stage');

					// $emapData = fgetcsv($file, 10000, ",");

					if ($key == 'position') {
						while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
							$data = array(
								'name' => $emapData[0],
								'created_on' => time(),
								'modified_on' => time()
							);

							$data = $this->Crud->Insert('position', $data);
						}

						$this->session->set_flashdata('success_msg', 'Position has been imported.');
						redirect('/position');
					}

					if ($key == 'branch') {
						while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
							$data = array(
								'branch_name' => $emapData[0],
								'created_on' => time(),
								'modified_on' => time()
							);

							$data = $this->Crud->Insert('branch', $data);
						}
						
						$this->session->set_flashdata('success_msg', 'Branch has been imported.');
						redirect('/branch');
					}

					fclose($file);
				}


			} else {
				$this->session->set_flashdata('error_msg', 'File extension must be .csv');
				redirect('position/import-data');
			}

		}

		$this->load->view('includes/header',$header);
		$this->load->view('import_data');
		$this->load->view('includes/footer');
	}

}