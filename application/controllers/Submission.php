<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(APPPATH.'libraries/Fileuploader.php');

class Submission extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Crud');
		$this->load->helper('form');

		if (!$this->require_min_level(1)) {
			redirect('login', 'refresh');
			$this->session->set_flashdata('info_msg', 'You need to login to access this page.');
		}
	}

	public function index() {

		$header['title'] = 'Dashboard';

		$this->load->view('includes/header', $header);
		$this->load->view('dashboard');
		$this->load->view('includes/footer');
	}

	public function send_email($to, $subject, $message) {
		$this->load->library('email');

		$config = Array(
			'protocol' => 'sendmail',
			'mailtype' => 'html', 
			'charset' => 'utf-8',
			'wordwrap' => TRUE

		);
		$this->email->initialize($config);

		$this->email->to($to);
		$this->email->from('mailer@validation.vifx.co', 'VIF Validation App [Do not reply!]');
	
		$this->email->subject($subject);
		$this->email->message($message);

		if ($this->email->send())
		{
			return true;
		} else {
			return false;
		}
	}

	public function get_cloud_data($str, $id) {
		$q = $this->Crud->GetWhere('users', array('user_id' => $id));
		$cloud_user = [];

		if (count($q) > 0) {
			// print_r(json_encode($q) . '<br/>'); return;
			$cloud_user = $q[0];
		}

		if ($str == 'get_branch') return $cloud_user['branch'];
		else if ($str == 'get_position') return $cloud_user['position'];
		else if ($str == 'get_name') return $cloud_user['name'];
		else if ($str == 'get_email') return $cloud_user['email'];
		else if ($str == 'get_image') return str_replace('/\\\\/', '', $cloud_user['image']);
		else if ($str == 'get_uuid') return $cloud_user['user_id'];
	}

	public function submit_form() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('amountInWords', 'Amount In Words', 'trim|required');
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required');
		$this->form_validation->set_rules('accountNumber', 'Account Number', 'trim|required');
		$this->form_validation->set_rules('accountName', 'Account Name', 'trim|required');

		if ($this->form_validation->run() == true) {
			// File upload handler
			$FileUploader = new FileUploader('files', array());
			$upload = $FileUploader->upload();
			$files = $upload['files'];
			$fileupload = [];
			if($files != 'null' || $files != '') {
				if($upload['isSuccess']) {
					foreach ($files as $file => $value) {
						array_push($fileupload, $value['file']);
					}
				}
				if($upload['hasWarnings']) {
					$warnings = $upload['warnings'];
					echo "<script>alert(".$warnings.");</script>";
				};
			};

			$m = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
			// Form Data handler
			$amount = $this->input->post('amount');
			$amount = str_replace( ',', '', $amount );
			
			if($_SESSION['position'] == 3 || $_SESSION['position'] == 4) $stage = $_SESSION['position'] + 1;
			else $stage = 3;

		
			$data = array(
				'branch' => $this->input->post('branch'),
				'subject' => $this->input->post('subject'),
				'description' => $this->input->post('description'),
				'currency' => $this->input->post('currency'),
				'amount' => $amount,
				'amountinword' => $this->input->post('amountInWords'),
				'bank' => $this->input->post('bank'),
				'accountnumber' => $this->input->post('accountNumber'),
				'accountname' => $this->input->post('accountName'),
				'status' => 'Open',
				'stage' => $stage,
				'create_date' => time(),
				'created_by' => $_SESSION['uuid']
			);

			$data = $this->Crud->Insert('form', $data);
			$id_form = $this->db->insert_id();

			$data_detail = [];
			$name_amount = $this->input->post('name_amount');
			$desc_amount = $this->input->post('desc_amount');
			$amounts = $this->input->post('amounts');
			$amounts_decimal = $this->input->post('amountsDec');
			$amounts = str_replace( ',', '', $amounts);

			
			for ($i=0; $i < sizeof($name_amount); $i++) { 
				$user_date_amount = explode(' ',$this->input->post('user_date_amount')[$i]);

				$user_date_d = $user_date_amount[0];
				$user_date_m = 0;
				$user_date_y = $user_date_amount[2];
				for ($j=0; $j < sizeof($m); $j++) { 
					if ($m[$j] == $user_date_amount[1]) {
						$user_date_m = $j+1;
					}
				}

				$new_data = array(
					'code' => $name_amount[$i],
					'description' => $desc_amount[$i],
					'use_date' => $user_date_y . '-' . $user_date_m . '-' . $user_date_d,
					'amount' => floatval($amounts[$i] . '.' . $amounts_decimal[$i]),
					'id_form' => $id_form,
					'created_on' => time()
				);

				array_push($data_detail, $new_data);
			}


			if ($data) {
				foreach ($data_detail as $value) {
					$this->Crud->Insert('form_detail', $value);
				}

				$dataFormRecord = array(
					'id_form' => $id_form,
					'id_user' => $_SESSION['uuid'],
					'status' => 'Open',
					'exec_date' => time(),
					'notes' => ''
				);

				// create record
				$insertFormRecord = $this->Crud->Insert('form_record', $dataFormRecord);
				if ($insertFormRecord) {

					// save file to DB
					if (count($fileupload) > 0) {
						foreach ($fileupload as $file) {
							$insertFile = $this->Crud->Insert('form_upload', array(
								'form_id' => $id_form,
								'url' => $file
							));
						}
					}

					if ($insertFormRecord) {
						// Get the destination email address
						$dest_pos = $_SESSION['position'] + 1;
						$dest_bra = $_SESSION['branch'];
						$dest_email = '';
						foreach ($_SESSION['cloud_users'] as $cuser) {
							if ($cuser['position'] == $dest_pos && $cuser['branch'] == $dest_bra) {
								$dest_email = $cuser['email'];
							}
						}

						if ($dest_email != '') {
							// set the currency String
							if ($this->input->post('currency') == '1') $currency_string = 'IDR ';
							else $currency_string = 'USD ';

							// Send email notification
							$message = 'This form needs your review:<br/><br/>Subject: ' . $this->input->post('subject') . '<br/>Created by: ' . $_SESSION['name'] . ' (' . $_SESSION['email'] . ')<br>Proposed Amount: ' . $currency_string . number_format($this->input->post('amount'), 2, '.', ',') . '<br/><br/>Please <a href="' . base_url() . 'all-forms/view/' . $id_form . '" target="_blank">click here</a> to open it.<br/><br/><br/>Thank you.';

							if ($this->send_email($dest_email, 'Form "' . $this->input->post('subject', TRUE) . '" needs your review', $message)) {
								$this->session->set_flashdata('success_msg', 'Success sending email to ' . $dest_email . '.');
							} else {
								$this->session->set_flashdata('error_msg','Failed sending notification email to the supervisor.');
							}
						}

						// Done!!!
						$this->session->set_flashdata('success_msg', 'Form successfully submitted and is now under review of your supervisor(s)');
						redirect('/all-forms');
						
					}
					
				}
			}
			
		}

		// Get current user's branch data
		$b = $this->Crud->GetWhere('branch', array('id' => $_SESSION['branch']));
		$data['user']['branch'] = $b[0]['id'];
		$data['user']['branch_name'] = $b[0]['branch_name'];
		// $data['user']['code'] = $b[0]['code'];

		// Get datacode list
		$data['datacode'] = $this->Crud->Get('code');
		
		$header['title'] = 'New Submission';

		$this->load->view('includes/header', $header);
		$this->load->view('submit_form',$data);
		$this->load->view('includes/footer');
	}

	public function view_form($id) {
		$header['title'] = 'View form detail';

		$sql = "select F.*, B.branch_name FROM form F, users U, branch B WHERE F.created_by = U.user_id AND F.branch = B.id AND F.id = '" . $id ."'";

		$res = $this->Crud->specialQuery($sql);
		$result['result'] = $res[0];
		// get form creator's branch
		// $result['result']['branch'] = $this->get_cloud_data("get_branch",$result['result']['created_by']);
		// $result['result']['position'] = $this->get_cloud_data("get_position",$result['result']['created_by']);

		$result['currency'] = '';
		$currency = $result['result']['currency'];

		if ($currency == 1) {
			$result['currency'] = 'IDR';
		} else if ($currency == 2) {
			$result['currency'] = 'USD';
		}

		// get form uploads
		$q = "select fu.url FROM form_upload fu WHERE fu.form_id ='$id'";
		$result['path'] = [];
		$fu = $this->Crud->specialQuery($q);
		if (count($fu) > 0) {
			foreach ($fu as $value) {
				array_push($result['path'], $value['url']);
			}
		}

		// Get form records
		$q = "select f.*, u.* FROM form_record f, users u WHERE f.id_user = u.user_id and f.id_form = '$id' ORDER BY exec_date ASC ";
		$result['data'] = [];
		$fr = $this->Crud->specialQuery($q);

		if (count($fr) > 0) {
			foreach ($fr as $value) {
				$value['name'] = $value['name'];
				$value['branch'] = $value['branch'];
				$value['image'] = $value['image'];
				array_push($result['data'], $value);
			}
		}

		$arrnew = [];
		foreach ($result['data'] as $arr) {
			if($arr['branch'] == 1){

				array_push($arrnew, $arr);
			}
		}
		$result['count'] = count($arrnew);
		 // print_r($result['data']);
		
		// Get form details
		$result['amount_detail'] = $this->Crud->GetWhere('form_detail', array('id_form' => $id));

		$sql_status = "SELECT FR.status, FR.id_user, U.* FROM form_record FR, form F, users U WHERE FR.exec_date = (select MAX(FR.exec_date) from form_record FR) and F.id = $id and FR.id_user=U.user_id";
		$res = $this->Crud->specialQuery($sql_status);
		$status = $res[0];

		$result['id_user'] = $status['id_user'];
		$result['status'] = $status['status'];
		$result['name'] = $status['name'];
		$result['branch'] = $status['branch'];
		$result['position'] = $status['position'];
	
		$this->load->view('includes/header', $header);
		$this->load->view('view_form',$result);
		$this->load->view('includes/footer');
	}

	public function edit_form($id) {

		$q = "select F.*, B.branch_name FROM form F, users U, branch B WHERE F.created_by = U.user_id AND F.branch = B.id AND F.id = '$id'";
		$result['form'] = $this->Crud->specialQuery($q);

		// 1. get form uploads
		$q = "select * FROM form_upload fu WHERE fu.form_id ='$id'";
		$result['path'] = [];
		$fu = $this->Crud->specialQuery($q);
		if (count($fu) > 0) {
			foreach ($fu as $value) {
				array_push($result['path'], array('id' =>$value['id'] , 'url' => $value['url'] ));
			}
		}

		// 2. Get form records
		$q = "select f.*, u.* FROM form_record f, users u WHERE f.id_user = u.user_id and f.id_form = '$id' ORDER BY exec_date ASC ";
		$result['data'] = [];
		$fr = $this->Crud->specialQuery($q);
		if (count($fr) > 0) {
			foreach ($fr as $value) {
				$value['name'] = $value['name'];
				array_push($result['data'], $value);
			}
		}

		// 3. Get form details
		$result['amount_detail'] = $this->Crud->GetWhere('form_detail', array('id_form' => $id));

		$result['currency'] = '';
		$currency = $result['form'][0]['currency'];
		if ($currency == 1) {
			$result['currency'] = 'IDR';
		} else if ($currency == 2) {
			$result['currency'] = 'USD';
		}

		$name = $this->get_cloud_data('get_name', $result['form'][0]['created_by']);
		$result['name'] = $name;
		
		$result['datacode'] = $this->Crud->Get('code');

		$position = $this->get_cloud_data('get_position', $result['form'][0]['created_by']);
		$result['position'] = $position;
	
		if($this->input->post('save')){
			$fid = $id;
			$m = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

			$amount = str_replace( ',', '', $this->input->post('amount'));

			$data = array(
				'branch' => $this->input->post('branch'),
				'subject' => $this->input->post('subject'),
				'description' => $this->input->post('description'),
				'currency' => $currency,
				'amount' => $amount,
				'amountinword' => $this->input->post('amountinword'),
				'bank' => $this->input->post('bank'),
				'accountnumber' => $this->input->post('accountnumber'),
				'accountname' => $this->input->post('accountname'),
				'stage' => $_SESSION['position']+1,
				'status' => 'Open'
			);

			$name_amount = $this->input->post('name_amount');
			$desc_amount = $this->input->post('desc_amount');

			$amounts = $this->input->post('amounts');
			$amounts = str_replace( ',', '', $amounts );


			$attachFiles = $this->input->post('attachFiles');

			$amount_details = [];

			for ($i=0; $i < sizeof($name_amount); $i++) { 
				$user_date_amount = explode(' ',$this->input->post('user_date_amount')[$i]);

				$user_date_d = $user_date_amount[0];
				$user_date_m = 0;
				$user_date_y = $user_date_amount[2];
				for ($j=0; $j < sizeof($m); $j++) { 
					if ($m[$j] == $user_date_amount[1]) {
						$user_date_m = $j+1;
					}
				}

				if (isset($name_amount[$i])) {
					$new_data = array(
						'code' => $name_amount[$i],
						'description' => $desc_amount[$i],
						'use_date' => $user_date_y.'-'.$user_date_m.'-'.$user_date_d,
						'amount' => $amounts[$i].'.'.$this->input->post('amountsDec')[$i],
						'id_form' => $fid
					);
					array_push($amount_details, $new_data);
				}
				
			}

			$res = $this->Crud->Update('form', $data, array('id' => $fid));

			if ($res){
				$this->Crud->Insert('form_record', array('id_form' => $fid, 'id_user' => $_SESSION['uuid'], 'status' => 'Revised', 'notes' => '', 'exec_date' => time()));

				$delFormDetail = $this->Crud->Delete('form_detail', array('id_form' =>  $fid));

				if ($delFormDetail) {
					if (sizeof($amount_details) > 0) { // unchanged data
						foreach ($amount_details as $data) { // data on form
							$this->Crud->Insert('form_detail', $data);
						}
					
					}
				}

				$FileUploader = new FileUploader('files', array());
				$upload = $FileUploader->upload();
				
				$fileupload = [];
				$files = $upload['files'];

				if($files != 'null' || $files != '') {
					if($upload['isSuccess']) {
						foreach ($files as $file => $value) {
							array_push($fileupload, $value['file']);
						}
					}
					if($upload['hasWarnings']) {
						$warnings = $upload['warnings'];
						echo "<script>alert(".$warnings.");</script>";
					};
				};


				if (sizeof($attachFiles) > 0) {
					$fileupload = array_merge($fileupload, $attachFiles);
				}
				

				$delAttach = $this->Crud->Delete('form_upload', array('form_id' =>  $fid));

				if($delAttach){
					if (sizeof($fileupload) > 0) {
						foreach ($fileupload as $data) {
							$this->Crud->Insert('form_upload', array('form_id' => $fid, 'url' => $data));
						}
					}
				}

				// Update notification (if applied)
				if (isset($_SESSION['active_forms_total'])) {
					$new_session = [];
					$total = 0;
					foreach ($_SESSION['active_forms_ids'] as $value) {
						if ($value['id'] != $this->input->post('id_form')) {
							$total++;
							array_push($new_session, array(
								'id' => $value['id'],
								'subject' => $value['subject'],
								'branch_name' => $value['branch_name'],
								'status' => $value['status']
							));
						}
					}
					// set it back to $_SESSION
					if ($total == 0) {
						$this->session->unset_userdata('active_forms_total');
						$this->session->unset_userdata('active_forms_ids');
					} else {
						$this->session->set_userdata('active_forms_total', $total);
						$this->session->set_userdata('active_forms_ids', $new_session);
					}
				}

				$this->session->set_flashdata('success_msg', 'You have successfully revised this form and is now under review of your supervisor(s)');

				redirect('/all-forms/view/' . $fid);
			} 
		}

		$header['title'] = 'Revise Form';

		$this->load->view('includes/header', $header);
		$this->load->view('edit_form',$result);
		$this->load->view('includes/footer');
	}

	public function get_code_ajax() {
		$data['datacode'] = $this->Crud->Get('code');
		print_r(json_encode($data));
	}

	public function submissions() {
		$this->load->view('includes/header');
		$this->load->view('submission');
		$this->load->view('includes/footer');
	}

	public function event_form() {
		// Set the form's status & stage
		if ($this->input->post('print')) {
			$idform = $this->input->post('id_form');
			redirect('/view_report?id='.$idform);
		} else {
			if($this->input->post('verify')) {
				$status = 'Verified';
				$notes = $this->input->post('notes');
				$stage = $this->input->post('stage') + 1;
			} else if ($this->input->post('verify_to_andi')) {
				$status = 'Verified';
				$notes = $this->input->post('notes');
				$stage = 6;
			} else if ($this->input->post('verify_to_wahyudi')) {
				$status = 'Verified';
				$notes = $this->input->post('notes');
				$stage = 7;
			} else if ($this->input->post('verify_to_michael')) {
				$status = 'Verified';
				$notes = $this->input->post('notes');
				$stage = 8;
			} else if($this->input->post('paid')) {
				$status = 'Paid';
				$notes = '';
				$stage = 4;
			} else if($this->input->post('close')) {
				$status = 'Close';
				$notes = '';
				$stage = 4;
			} else if ($this->input->post('verify_to_central')) {
				$status = 'Waiting';
				$notes = $this->input->post('notes');
				$stage = 4;
			} else if ($this->input->post('reject')) {
				$status = 'Rejected';
				$notes = $this->input->post('notes');
				// get the creator's position
				$stage = $this->get_cloud_data('get_position', $this->input->post('form_creator'));
			} else if ($this->input->post('cancel_paid')) {
				$status = 'Waiting';
				$notes = '';
				$stage = 4;
			} else if ($this->input->post('cancel_closed')) {
				$status = 'Paid';
				$notes = '';
				$stage = 4;
			}

			$id_form = $this->input->post('id_form');
			$id_user = $this->input->post('id_user');
			$stages = $this->input->post('stages');
			$data = array(
				'id_form' => $id_form,
				'id_user' => $id_user,
				'status' => $status,
				'exec_date' => time(),
				'notes' => $notes
			);

			/* INSERT into FORM_RECORD table */
			if ($this->Crud->Insert('form_record', $data)) {
				// Log verification time by BH
				if (!empty($this->input->post('stage'))) {
					if ($_SESSION['position']==3){
						$update = array(
							'stage' => $stage,
							'status' => $status,
							'modified_date' => time()
						);
					} else if ($status=='Rejected') {
						$update = array(
							'stage' => $stage,
							'status' => $status,
							'modified_date' => 0
						);
					} else {
						$update = array(
							'stage' => $stage,
							'status' => $status
						);					
					}

					/* UPDATE to FORM table */
					$updateForm = $this->Crud->Update('form', $update, array(
						'id' => $id_form
					));

					if ($updateForm) {
						// GET the form details and PUT it inside the email's body
						$sq = "SELECT f.subject, u.name, u.email, f.currency, f.amount FROM form f LEFT JOIN users u ON u.user_id = f.created_by WHERE f.id = '" . $id_form . "'";
						$res = $this->Crud->specialQuery($sq);
						$form_data = $res[0];

						// Get the destination EMAIL address
						$dest_bra = $_SESSION['branch'];
						$dest_emails = [];
						if ($status == 'Verified') {
							foreach ($_SESSION['cloud_users'] as $cuser) {
								if ($stage == 3) {
									// get the correct branch
									if ($cuser['position'] == $stage && $cuser['branch'] == $dest_bra) {
										array_push($dest_emails, $cuser['email']);
									}
								} else {
									if ($cuser['position'] == $stage) {
										array_push($dest_emails, $cuser['email']);
									}
								}
							}
							$status = 'Waiting Verification';
						} else if ($status == 'Waiting') {
							foreach ($_SESSION['cloud_users'] as $cuser) {
								if ($cuser['position'] == $stage) {
									array_push($dest_emails, $cuser['email']);
								}
							}
							$status = 'Waiting Payment';
							$status2 = 'Congratulate the creator, Bro!';
						} else if ($status == 'Rejected') {
							array_push($dest_emails, $form_data['email']);
						}
						

						if (count($dest_emails) > 0) {
							// set the currency String
							if ($form_data['currency'] == '1') $currency_string = 'IDR ';
							else $currency_string = 'USD ';

							if (isset($status2)) {
								$message = 'Nice, the following form has been approved and now is waiting payment:<br/><br/>Subject: ' . $form_data['subject'] . '<br/>Proposed Amount: ' . $currency_string . number_format($form_data['amount'] , 2, '.', ',') . '<br><br/>Current status: <strong>' . $status . '</strong><br>Notes: ' . $notes . '<br/><br/>Please <a href="' . base_url() . 'all-forms/view/' . $id_form . '" target="_blank">click here</a> to view it.<br/><br/><br/>Thank you.';
								$this->send_email($form_data['email'], 'Your form has been verified!', $message);
							}

							$message = 'This form needs your review:<br/><br/>Subject: ' . $form_data['subject'] . '<br/>Created by: ' . $form_data['name']  . ' (' . $form_data['email']  . ')<br>Proposed Amount: ' . $currency_string . number_format($form_data['amount'] , 2, '.', ',') . '<br><br/>Current status: <strong>' . $status . '</strong><br>Notes: ' . $notes . '<br/><br/>Please <a href="' . base_url() . 'all-forms/view/' . $id_form . '" target="_blank">click here</a> to view it.<br/><br/><br/>Thank you.';

							// Send email notification
							if ($this->send_email($dest_emails, 'A form needs your immediate review!', $message)) {
								$this->session->set_flashdata('success_msg', 'Success sending email to ' . json_encode($dest_emails) . '.');
							} else {
								$this->session->set_flashdata('error_msg','Failed sending notification email.');
							}
						}

						// Update NOTIFICATION (if applied)
						if (isset($_SESSION['active_forms_total'])) {
							$new_session = [];
							$total = 0;
							foreach ($_SESSION['active_forms_ids'] as $value) {
								if ($value['id'] != $this->input->post('id_form')) {
									$total++;
									array_push($new_session, array(
										'id' => $value['id'],
										'subject' => $value['subject'],
										'branch_name' => $value['branch_name'],
										'status' => $value['status']
									));
								}
							}
							// set it back to $_SESSION
							if ($total == 0) {
								$this->session->unset_userdata('active_forms_total');
								$this->session->unset_userdata('active_forms_ids');
							} else {
								$this->session->set_userdata('active_forms_total', $total);
								$this->session->set_userdata('active_forms_ids', $new_session);
							}
						}
					}
				}

				redirect('/'.$stages.'/view/'.$id_form);
			}
		}
	}

	public function bulk_action(){
		if($this->input->post('bulkpaid')){
			$paid = $this->input->post('checked');
			$data = [];
			$record = [];
			for ($i=0; $i < sizeof($paid) ; $i++) { 
				$data[] = array(
					'id' => $paid[$i],
					'status' => 'Paid'
				);
			}
			for ($j=0; $j < sizeof($paid) ; $j++) { 
				$record[] = array(
					'id_form' => $paid[$j],
					'id_user' => $_SESSION['uuid'],
					'status' => 'Paid',
					'notes' => ' ',
					'exec_date' => time()
				);
			}
			$update = $this->db->update_batch('form', $data, 'id');
			$insert = $this->db->insert_batch('form_record', $record); 
			if($update && $insert) {
				redirect('/all-forms');
			} 

		} elseif ($this->input->post('bulkclose')) {
			$paid = $this->input->post('checked');
			$data = [];
			$record = [];
			for ($i=0; $i < sizeof($paid) ; $i++) { 
				$data[] = array(
					'id' => $paid[$i],
					'status' => 'Close'
				);
			}
			for ($j=0; $j < sizeof($paid) ; $j++) { 
				$record[] = array(
					'id_form' => $paid[$j],
					'id_user' => $_SESSION['uuid'],
					'status' => 'Close',
					'notes' => ' ',
					'exec_date' => time()
				);
			}
			$update = $this->db->update_batch('form', $data, 'id');
			$insert = $this->db->insert_batch('form_record', $record); 
			if($update && $insert) {
				redirect('/all-forms');
			} 
		}
	}
	
}