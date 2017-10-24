<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller
{
 
	public function index_get()
	{
		$data = $this->query('t');
		$username = $this->query('u');
		$password = $this->query('p');

		if ($data == 'auth') {

			// Login route
			$username = $this->query('u');
			$password = $this->query('p');

			$user_data = $this->db->get_where('user', array('username' => $username))->result();

			if ($user_data[0]->password == $password) {
				$this->response([
					'Success' => true,
					'Message' => $user_data[0]->access_rights
				]);
			} else {
				$this->response([
					'Success' => false,
					'Message' => "Wrong credentials! Please contact admin."
				]);
			}
		} else {

			// Data route
			if ($data != null && $username != null && $password != null) {

					$user_data = $this->db->get_where('user', array('username' => $username))->result();

					if ($user_data[0]->password == $password) {

						// Query type
						$query = $this->query('q');
						if ($query != 'all') {
							$fetch = $this->db->get_where($data, array('id' => $query))->result();
							if ($fetch) {
								$result = $fetch;
							} else {
								$result = 'Data not found';
							}
						} else {
							$result = $this->db->get($data)->result();
						}

						$this->response([
							'Data requested' => $data,
							'Message' => "Valid Request",
							'Data' => $result
						]);
					} else {
						$this->response([
							'Data requested' => $data,
							'Message' => "Unauthorized!"
						]);
					}

				
			} else {
				$this->response([
					'Message' => 'Illegal Request!',
				]);
			}
		} 
	}

}