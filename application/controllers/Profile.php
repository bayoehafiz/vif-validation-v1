<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Crud');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('file');
		$this->load->library('flash');
		$this->load->library('cloudinarylib');

		if (!$this->require_min_level(1)) {
			redirect('login', 'refresh');
			$this->session->set_flashdata('info_msg', 'You need to login to access this page.');
		}
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

	public function get_cusers() {
		$q = $this->Crud->Get('users');
		return $q;
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


	public function index() {
		$header['title'] = 'Update Your Profile';
   		$data['profile'] = array(
   			'uuid' => $_SESSION['uuid'],
   			'name' => $_SESSION['name'],
   			'email' => $_SESSION['email']
   		);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->input->post('email') !== $_SESSION['email'])
			$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_check');
		else
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
	
		if ($this->form_validation->run() == true) {

			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email')
			);

			$res = $this->DB_action('update_user', $data, $_SESSION['uuid']);

			if ($res == 1) {
				// change the sessions
				$this->session->set_userdata('name', $this->input->post('name'));
				$this->session->set_userdata('email', $this->input->post('email'));

				// Reloading the $_SESSION['cloud_users'];
				$this->session->unset_userdata('cloud_users');
				$this->session->set_userdata('cloud_users', $this->get_cusers());

				$this->session->set_flashdata('success_msg', 'Your profile has been updated.');
				redirect($this->uri->uri_string());
			} else {
				$this->session->set_flashdata('error_msg', 'Failed updating user\'s data. Please try again in 10 minutes.');
			}
		}

		$this->flash->setFlashMessages();

        $this->load->view('includes/header',$header);
		$this->load->view('profile', $data);
	    $this->load->view('includes/footer');
	}

	public function update_password(){

		$header['title'] = 'Change Your Password';

		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run() == true) {

				$data = array(
					'passwd' => $this->hash_passwd($this->input->post('password'))
				);

				$res = $this->DB_action('update_user', $data, $_SESSION['uuid']);

				if ($res == 1) {
					// $this->session->set_flashdata('success_msg', 'Your password has been updated. Please re-login using your new password.');
					redirect('logout');
				} else {
					$this->session->set_flashdata('error_msg', 'Error updating the password. Please try again in 10 minutes.');
				}
			}

		$this->flash->setFlashMessages();

        $this->load->view('includes/header',$header);
		$this->load->view('profile_password');
	    $this->load->view('includes/footer');
	}

	public function update_photo(){
		
		$header['title'] = 'Update Your Photo';
		$udata = [];

		// Action!!!
		$this->form_validation->set_rules('photo', 'File', 'trim|required');
		if ($this->form_validation->run() == true) {
			$code = $this->input->post('hidden_base64');
			$name_user = $_SESSION['name'];
			$date = date("Ymd");
			$ava_name = $name_user.'_'.$date.'.png';
			// encode the image
			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $code));
			$save = write_file('./assets/images/avatars/'.$ava_name, $data);

			if ($save) {
				// upload to Cloudinary
				$cloudinary_upload = \Cloudinary\Uploader::upload('./assets/images/avatars/'.$ava_name);
				if (isset($cloudinary_upload['secure_url'])) {

					// update user on Ionic cloud
					$new_data = array('image' => $cloudinary_upload['secure_url']);
					$res = $this->DB_action('update_user', $new_data, $_SESSION['uuid']);

					if ($res == 1) {
						// update the $_SESSION
						$this->session->unset_userdata('image');
						$this->session->set_userdata('image', $cloudinary_upload['secure_url']);

						// Reloading the $_SESSION['cloud_users'];
						$this->session->unset_userdata('cloud_users');
						$this->session->set_userdata('cloud_users', $this->get_cusers());

						// Remove file from local
						unlink('./assets/images/avatars/'.$ava_name);

						$this->session->set_flashdata('success_msg', 'Your photo has been updated.');
						redirect('/profile');

					} else {
						$this->session->set_flashdata('error_msg', 'Failed uploading your photo. Please try again in 10 minutes.');
					}
				} else {
					$this->session->set_flashdata('error_msg', 'Failed uploading your photo. Please try again in 10 minutes.');
				}
			} else {
				$this->session->set_flashdata('error_msg', 'Failed uploading your photo. Please try again in 10 minutes.');
			}
		}

		// fetch current photo
		if ($_SESSION['image'] == 'https://s3.amazonaws.com/ionic-api-auth/users-default-avatar@2x.png') {
			$img = $_SESSION['image'];
		} else {
			$img = cl_image_tag($_SESSION['image'], array( "alt" => $_SESSION['image']));
		}

		$udata['url'] = $img;

        $this->load->view('includes/header',$header);
		$this->load->view('profile_photo', $udata);
	    $this->load->view('includes/footer');
	}

}