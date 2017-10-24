<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Community Auth - Examples Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Force SSL
		//$this->force_ssl();

		// Form and URL helpers always loaded (just for convenience)
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('Crud');
	}

	// -----------------------------------------------------------------------

	private $table = 'users';

	/**
	 * Demonstrate being redirected to login.
	 * If you are logged in and request this method,
	 * you'll see the message, otherwise you will be
	 * shown the login form. Once login is achieved,
	 * you will be redirected back to this method.
	 */
	public function index()
	{
		if (!$this->require_min_level(1)) {
			redirect('login', 'refresh');
			$this->session->set_flashdata('info_msg', 'You need to login to access this page.');
		} else {
			// Set USER data to $_SESSION
			$this->db->where('user_id', $this->auth_user_id);
			$query = $this->db->get($this->table);
			$row = $query->row_array();
			$user_data = array(
				'uuid' => $this->auth_user_id,
				'username' => $this->auth_username,
				'email' => $this->auth_email,
				'name' => $row['name'],
				'image' => $row['image'],
				'position' => $row['position'],
				'branch' => $row['branch']
			);

			$this->session->set_userdata($user_data);

			// Set ALL USERS data to $_SESSION
			$cloud_users = [];
			$query = $this->db->get('users');
			$row = $query->result_array();
			foreach ($row as $u) {
				array_push($cloud_users, array(
					'uuid' => $u['user_id'],
					'username' => $u['username'],
					'email' => $u['email'],
					'name' => $u['name'],
					'image' => $u['image'],
					'position' => $u['position'],
					'branch' => $u['branch']
				));
			}

			$this->session->set_userdata('cloud_users', $cloud_users);

			// fetch all forms and find which ones are required attention
			$found = 0;
			$forms = [];
			$q = "select a.*, b.branch_name FROM form a, branch b WHERE a.branch=b.id";
			$all_forms = $this->Crud->specialQuery($q);
			if (count($all_forms) > 0) {
				foreach ($all_forms as $form) {
					if ((($form['stage'] == $_SESSION['position'] && $form['branch'] == $_SESSION['branch']) // on branch
							|| ($form['stage'] == $_SESSION['position'] && $_SESSION['branch'] == '1')) // on central
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

			echo $this->load->view('includes/header', '', TRUE);
			echo $this->load->view('dashboard', '', TRUE);
			echo $this->load->view('includes/footer', '', TRUE);	
		}
	}
	
	
	// -----------------------------------------------------------------------

	/**
	 * Most minimal user creation. You will of course make your
	 * own interface for adding users, and you may even let users
	 * register and create their own accounts.
	 *
	 * The password used in the $user_data array needs to meet the
	 * following default strength requirements:
	 *   - Must be at least 8 characters long
	 *   - Must be at less than 72 characters long
	 *   - Must have at least one digit
	 *   - Must have at least one lower case letter
	 *   - Must have at least one upper case letter
	 *   - Must not have any space, tab, or other whitespace characters
	 *   - No backslash, apostrophe or quote chars are allowed
	 */
	public function create_admin()
	{
		// Customize this array for your user
		$user_data = [
			'username'   => 'admin',
			'email'      => 'developer@mss.co.id',
			'name'		 => 'Super Admin',
			'branch'	 => 1,
			'position'	 => 1,	
			'passwd'     => 'Hello123#',
			'auth_level' => '9', // 9 if you want to login @ auth/index.
		];

		$this->is_logged_in();

		echo $this->load->view('auth/page_header', '', TRUE);

		// Load resources
		$this->load->helper('auth');
		$this->load->model('auth/examples_model');
		$this->load->model('auth/validation_callables');
		$this->load->library('form_validation');

		$this->form_validation->set_data( $user_data );

		$validation_rules = [
			[
				'field' => 'username',
				'label' => 'username',
				'rules' => 'max_length[12]|is_unique[' . db_table('user_table') . '.username]',
				'errors' => [
					'is_unique' => 'Username already in use.'
				]
			],
			[
				'field' => 'passwd',
				'label' => 'passwd',
				'rules' => [
					'trim',
					'required',
					[ 
						'_check_password_strength', 
						[ $this->validation_callables, '_check_password_strength' ] 
					]
				],
				'errors' => [
					'required' => 'The password field is required.'
				]
			],
			[
				'field'  => 'email',
				'label'  => 'email',
				'rules'  => 'trim|required|valid_email|is_unique[' . db_table('user_table') . '.email]',
				'errors' => [
					'is_unique' => 'Email address already in use.'
				]
			],
			[
				'field' => 'auth_level',
				'label' => 'auth_level',
				'rules' => 'required|integer|in_list[1,6,9]'
			]
		];

		$this->form_validation->set_rules( $validation_rules );

		if( $this->form_validation->run() )
		{
			$user_data['passwd']     = $this->authentication->hash_passwd($user_data['passwd']);
			$user_data['user_id']    = $this->examples_model->get_unused_id();
			$user_data['created_at'] = date('Y-m-d H:i:s');

			// If username is not used, it must be entered into the record as NULL
			if( empty( $user_data['username'] ) )
			{
				$user_data['username'] = NULL;
			}

			$this->db->set($user_data)
				->insert(db_table('user_table'));

			if( $this->db->affected_rows() == 1 )
				echo '<h1>Congratulations</h1>' . '<p>User ' . $user_data['username'] . ' was created.</p>';
		}
		else
		{
			echo '<h1>User Creation Error(s)</h1>' . validation_errors();
		}

		echo $this->load->view('auth/page_footer', '', TRUE);
	}
	
	// -----------------------------------------------------------------------

	/**
	 * This login method only serves to redirect a user to a 
	 * location once they have successfully logged in. It does
	 * not attempt to confirm that the user has permission to 
	 * be on the page they are being redirected to.
	 */
	public function login()
	{
		// Method should not be directly accessible
		if( $this->uri->uri_string() == 'auth/login')
			show_404();

		if($this->require_min_level(6) == 1)
			redirect('');

		if(strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post')
			$this->require_min_level(1);

		$this->setup_login_form();

		$html = $this->load->view('auth/page_header', '', TRUE);
		$html .= $this->load->view('auth/login_form', '', TRUE);
		$html .= $this->load->view('auth/page_footer', '', TRUE);

		echo $html;
	}

	// --------------------------------------------------------------

	/**
	 * Log out
	 */
	public function logout()
	{
		$this->authentication->logout();

		// clear all $_SESSION
		$this->session->sess_destroy();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
	}

	// --------------------------------------------------------------

	/**
	 * User recovery form
	 */
	public function recover()
	{
		// Load resources
		$this->load->model('auth/examples_model');

		/// If IP or posted email is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// If the form post looks good
			if( $this->tokens->match && $this->input->post('email') )
			{
				if( $user_data = $this->examples_model->get_recovery_data( $this->input->post('email') ) )
				{
					// Check if user is banned
					if( $user_data->banned == '1' )
					{
						// Log an error if banned
						$this->authentication->log_error( $this->input->post('email', TRUE ) );

						// Show special message for banned user
						$view_data['banned'] = 1;
					}
					else
					{
						/**
						 * Use the authentication libraries salt generator for a random string
						 * that will be hashed and stored as the password recovery key.
						 * Method is called 4 times for a 88 character string, and then
						 * trimmed to 72 characters
						 */
						$recovery_code = substr( $this->authentication->random_salt() 
							. $this->authentication->random_salt() 
							. $this->authentication->random_salt() 
							. $this->authentication->random_salt(), 0, 72 );

						// Update user record with recovery code and time
						$this->examples_model->update_user_raw_data(
							$user_data->user_id,
							[
								'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
								'passwd_recovery_date' => date('Y-m-d H:i:s')
							]
						);

						// Set the link protocol
						$link_protocol = USE_SSL ? 'https' : NULL;

						// Set URI of link
						$link_uri = 'auth/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;

						$view_data['special_link'] = anchor( 
							site_url( $link_uri, $link_protocol ), 
							site_url( $link_uri, $link_protocol ), 
							'target ="_blank"' 
						);

						$view_data['confirmation'] = 1;
					}
				}

				// There was no match, log an error, and display a message
				else
				{
					// Log the error
					$this->authentication->log_error( $this->input->post('email', TRUE ) );

					$view_data['no_match'] = 1;
				}
			}
		}

		echo $this->load->view('auth/page_header', '', TRUE);

		echo $this->load->view('auth/recover_form', ( isset( $view_data ) ) ? $view_data : '', TRUE );

		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	// --------------------------------------------------------------

	/**
	 * Verification of a user by email for recovery
	 * 
	 * @param  int     the user ID
	 * @param  string  the passwd recovery code
	 */
	public function recovery_verification( $user_id = '', $recovery_code = '' )
	{
		/// If IP is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// Load resources
			$this->load->model('auth/examples_model');

			if( 
				/**
				 * Make sure that $user_id is a number and less 
				 * than or equal to 10 characters long
				 */
				is_numeric( $user_id ) && strlen( $user_id ) <= 10 &&

				/**
				 * Make sure that $recovery code is exactly 72 characters long
				 */
				strlen( $recovery_code ) == 72 &&

				/**
				 * Try to get a hashed password recovery 
				 * code and user salt for the user.
				 */
				$recovery_data = $this->examples_model->get_recovery_verification_data( $user_id ) )
			{
				/**
				 * Check that the recovery code from the 
				 * email matches the hashed recovery code.
				 */
				if( $recovery_data->passwd_recovery_code == $this->authentication->check_passwd( $recovery_data->passwd_recovery_code, $recovery_code ) )
				{
					$view_data['user_id']       = $user_id;
					$view_data['username']     = $recovery_data->username;
					$view_data['recovery_code'] = $recovery_data->passwd_recovery_code;
				}

				// Link is bad so show message
				else
				{
					$view_data['recovery_error'] = 1;

					// Log an error
					$this->authentication->log_error('');
				}
			}

			// Link is bad so show message
			else
			{
				$view_data['recovery_error'] = 1;

				// Log an error
				$this->authentication->log_error('');
			}

			/**
			 * If form submission is attempting to change password 
			 */
			if( $this->tokens->match )
			{
				$this->examples_model->recovery_password_change();
			}
		}

		echo $this->load->view('auth/page_header', '', TRUE);

		echo $this->load->view( 'auth/choose_password_form', $view_data, TRUE );

		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	// --------------------------------------------------------------

}
