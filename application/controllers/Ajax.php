<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

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
		// Nothing todo here
	}

	// Populate datas for datatable
	public function table_ajax($currency, $route) {
			$branchHead = '';
			$filter = "";

			// get the BA uuid
			foreach ($_SESSION['cloud_users'] as $val) {
				// print_r(json_encode($val) . '<br/><br/>');
				if($val['position'] == 3){
					$branchHead = $val['uuid'];
				};
			}
			// Decide the filter
			if ($route == 'unvalidated-forms') { // waiting-validation
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status IN ('Open', 'Verified') AND a.stage = '".$_SESSION['position']."'";
			} else if ($route == 'verified-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status IN ('Verified', 'Waiting', 'Paid') AND a.stage != '".$_SESSION['position']."'";
			} else if ($route == 'rejected-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status = 'Rejected' ";
			} else if ($route == 'unpaid-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status='Waiting'";
			} else if ($route == 'paid-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status = 'Paid' ";
			} else if ($route == 'unclosed-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status = 'Paid' ";
			} else if ($route == 'closed-forms') {
				$filter = " WHERE a.currency = '" . $currency . "' AND a.status = 'Close' ";
			} else {
				$filter = "WHERE a.currency = '" . $currency . "'";
			}

			// Querying
			if ($_SESSION['branch'] == 1) { // Central Branch
				$q = "SELECT a.*, b.branch_name, IFNULL(count(c.url), 0) as attachments
						FROM form a
							LEFT JOIN branch b on a.branch = b.id 
						    LEFT JOIN form_upload c ON a.id=c.form_id
						" . $filter . "
						GROUP BY a.id
						ORDER BY create_date DESC";
			}
			else { // Branch
				if ($_SESSION['position'] == 3) { // BH
					$q = "SELECT a.*, b.branch_name, IFNULL(count(c.url), 0) as attachments
						FROM form a
							LEFT JOIN branch b on a.branch = b.id
						    LEFT JOIN form_upload c ON a.id=c.form_id
						" . $filter . " AND a.branch = '" . $_SESSION['branch'] . "'
						GROUP BY a.id
						ORDER BY create_date DESC";
				} else { // BA
					$q = "SELECT a.*, b.branch_name, IFNULL(count(c.url), 0) as attachments 
						FROM form a 
							LEFT JOIN branch b on a.branch = b.id
							LEFT JOIN form_upload c ON a.id=c.form_id
						" . $filter . " AND a.branch = '" . $_SESSION['branch'] . "'
						GROUP BY a.id 
						ORDER BY create_date DESC";
				}
					
			}

			$data["data"] = $this->Crud->specialQuery($q);

			// print_r($_SESSION['uuid']); return;

			if (count($data["data"]) > 0) {
				// Get 'verified by BH' datetime
				for ($i=0; $i < sizeof($data['data']); $i++) {
					if($_SESSION['branch']==1){
						if($data["data"][$i]['modified_date']==0){
							$data["data"][$i]['create_dates'] = '-';
							$data["data"][$i]['timestamp'] = '-';
						}
						else{
							$data["data"][$i]['create_dates'] = date('d-M-Y H:i', $data["data"][$i]['modified_date']);
							$data["data"][$i]['timestamp'] = $data["data"][$i]['modified_date'];
						}
					}
					else{
						$data["data"][$i]['create_dates'] = date('d-M-Y H:i', $data["data"][$i]['create_date']);
						$data["data"][$i]['timestamp'] = $data["data"][$i]['create_date'];
					}				
				}
			} else {
				$data["data"] = [];
			}

			print_r(json_encode($data));
	}

	public function chart_ajax($currency, $route) {
			$branch = $_SESSION['uuid'];
			
			// get current user's branch
			if ($_SESSION['branch'] == 1)
				$filter = "currency = " . $currency;
			else 
				$filter = "currency = " . $currency . " AND branch = '".$_SESSION['branch'] . "'";

			// variable initiation
			$data = array(
				'label' => array(),
				'verified' => array(),
				'rejected' => array(),
				'ongoing' => array()
			);
			$pie = false;
			$pie_data = [];

			if ($route == 'branch') {
				// Get VERIFIED FORMS
				$q1 = "select b.branch_name as label, COALESCE(countb.total,0) as total from branch b left join (select fc.total, bc.branch_name, bc.id from (SELECT sum(amount) as total, branch FROM form WHERE " . $filter . " and (status = 'Waiting' or status = 'Close' or status = 'Paid') group by branch) as fc, branch as bc where fc.branch = bc.id) countb on countb.id = b.id";
				$data_verified = $this->Crud->specialQuery($q1);

				// Get REJECTED FORMS
				$q2 = "select b.branch_name as label, COALESCE(countb.total,0) as total from branch b left join (select fc.total, bc.branch_name, bc.id from (SELECT sum(amount) as total, branch FROM form WHERE " . $filter . " and status = 'Rejected' group by branch) as fc, branch as bc where fc.branch = bc.id) countb on countb.id = b.id";
				$data_rejected = $this->Crud->specialQuery($q2);
						
				// Get ONGOING FORMS
				$q3 = "select b.branch_name as label, COALESCE(countb.total,0) as total from branch b left join (select fc.total, bc.branch_name, bc.id from (SELECT sum(amount) as total, branch FROM form WHERE " . $filter . " and (status = 'Open' or status = 'Verifies') group by branch) as fc, branch as bc where fc.branch = bc.id) countb on countb.id = b.id";
				$data_ongoing = $this->Crud->specialQuery($q3);

			} else if ($route == 'month') {
				// Get VERIFIED FORMS
				$q1 = "select COALESCE(tamount.total,0) as total, tmonth.month as label 
				from (
					SELECT sum(tbl.amount) as total, tbl.crdate as month 
					FROM (
						SELECT MONTH(from_unixtime(f.create_date,'%Y-%m-%d')) as crdate, f.amount 
						from form f 
						WHERE " . $filter . " and (status = 'Waiting' or status = 'Close' or status = 'Paid') and from_unixtime(f.create_date,'%Y-%m-%d') >=  DATE_ADD(NOW(), INTERVAL -3 MONTH)) tbl 
						group by month
					) tamount
						right join (
							select mtable.MONTH from (
								SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH
							) mtable
							where mtable.MONTH BETWEEN month(CURRENT_TIMESTAMP)-2 and month(CURRENT_TIMESTAMP)
						) tmonth
					on tamount.month = tmonth.month";
				$data_verified = $this->Crud->specialQuery($q1);

				// Get REJECTED FORMS
				$q2 = "select COALESCE(tamount.total,0) as total, tmonth.month as label 
				from (
					SELECT sum(tbl.amount) as total, tbl.crdate as month 
					FROM (
						SELECT MONTH(from_unixtime(f.create_date,'%Y-%m-%d')) as crdate, f.amount 
						from form f 
						WHERE " . $filter . " and status = 'Rejected' and from_unixtime(f.create_date,'%Y-%m-%d') >=  DATE_ADD(NOW(), INTERVAL -3 MONTH)) tbl 
						group by month
					) tamount
						right join (
							select mtable.MONTH from (
								SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH
							) mtable
							where mtable.MONTH BETWEEN month(CURRENT_TIMESTAMP)-2 and month(CURRENT_TIMESTAMP)
						) tmonth
					on tamount.month = tmonth.month";
				$data_rejected = $this->Crud->specialQuery($q2);
						
				// Get ONGOING FORMS
				$q3 = "select COALESCE(tamount.total,0) as total, tmonth.month as label 
				from (
					SELECT sum(tbl.amount) as total, tbl.crdate as month 
					FROM (
						SELECT MONTH(from_unixtime(f.create_date,'%Y-%m-%d')) as crdate, f.amount 
						from form f 
						WHERE " . $filter . " and (status = 'Open' or status = 'Verifies') and from_unixtime(f.create_date,'%Y-%m-%d') >=  DATE_ADD(NOW(), INTERVAL -3 MONTH)) tbl 
						group by month
					) tamount
						right join (
							select mtable.MONTH from (
								SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH
							) mtable
							where mtable.MONTH BETWEEN month(CURRENT_TIMESTAMP)-2 and month(CURRENT_TIMESTAMP)
						) tmonth
					on tamount.month = tmonth.month";
				$data_ongoing = $this->Crud->specialQuery($q3);

			} else if ($route == 'type') {
				if ($_SESSION['branch'] == 1) {
					$q = "SELECT c.description as label, SUM(fd.amount) as total FROM form_detail fd LEFT JOIN code c ON c.id = fd.code GROUP BY c.description";
				} else {
					// filter the branch first
					$pre_q = "select id from form where branch = '" . $_SESSION['branch'] . "'";
					$pre = $this->Crud->specialQuery($pre_q);
					$sfilter = "WHERE ";

					if (count($pre) > 0) {
						foreach ($pre as $key => $p) {
							if ($key == count($pre) - 1)
								$sfilter .= "fd.id_form = '" . $p['id'] . "' ";
							else 
								$sfilter .= "fd.id_form = '" . $p['id'] . "' OR ";
						}
					} else {
						$sfilter .= "fd.id_form = '0'";
					}

					$q = "SELECT c.description as label, SUM(fd.amount) as total FROM form_detail fd LEFT JOIN code c ON c.id = fd.code " . $sfilter . " GROUP BY c.description";
				}

				// echo $q; return;
				$all_data = $this->Crud->specialQuery($q);
				$pie = true;
			}
			

			// Compile the datas
			if (!$pie) { // if other than PIE CHART
				foreach ($data_verified as $value_verified) {
					foreach ($data_rejected as $value_rejected) {
						foreach ($data_ongoing as $value_ongoing) {
							if ($value_verified['label'] == $value_rejected['label'] && $value_rejected['label'] == $value_ongoing['label'] && $value_verified['label'] == $value_ongoing['label']) {
								// if ($value_verified['total'] !== '0.00' || $value_rejected['total'] !== '0.00' || $value_ongoing['total'] !== '0.00') {
									array_push($data['label'], $value_verified['label']);
									array_push($data['verified'], array(
										'y' => floatval($value_verified['total']),
										'color' => '#16a085'
									));
									array_push($data['rejected'], array(
										'y' => floatval($value_rejected['total']),
										'color' => '#c0392b'
									));
									array_push($data['ongoing'], array(
										'y' => floatval($value_ongoing['total']),
										'color' => '#f1c40f'
									));
								// }
							}
						}
					}
				};

				// send 'em
				print_r(json_encode($data));

			} else { // if it is PIE CHART
				if (count($all_data) > 0) {
					foreach ($all_data as $value) {
						array_push($pie_data, array(
							'name' => $value['label'],
							'y' => floatval($value['total'])
						));
					}
				}

				// send 'em
				print_r(json_encode($pie_data));
			}
	}

	public function all_forms() {
		$header['title'] = 'All Forms';

		$this->load->view('includes/header', $header);
		$this->load->view('list_forms');
		$this->load->view('includes/footer');
	}

	public function unvalidated_forms(){
		$header['title'] = 'Unvalidate Form List';

		$this->load->view('includes/header', $header);
	    $this->load->view('unvalidate_forms');
	    $this->load->view('includes/footer');
	}

	public function verified_forms() {
		$header['title'] = 'Verified Form';

		$this->load->view('includes/header', $header);
		$this->load->view('verified_forms');
		$this->load->view('includes/footer');
	}

	public function unpaid_forms() {

		$header['title'] = 'Unpaid Form';

		$this->load->view('includes/header', $header);
		$this->load->view('unpaid_form');
		$this->load->view('includes/footer');
	}

	public function unclosed_forms() {

		$header['title'] = 'Paid Form';

		$this->load->view('includes/header', $header);
		$this->load->view('unclose_form');
		$this->load->view('includes/footer');
	}

	/*public function paid_form(){

		$header['title'] = 'Paid Form';

		$this->load->view('includes/header', $header);
		$this->load->view('paid_form');
		$this->load->view('includes/footer');
	}*/

	public function closed_forms(){

		$header['title'] = 'Close Form';

		$this->load->view('includes/header', $header);
		$this->load->view('close_form');
		$this->load->view('includes/footer');
	}

	public function rejected_forms(){

		$header['title'] = 'Rejected Form';

		$this->load->view('includes/header', $header);
		$this->load->view('rejected_forms');
		$this->load->view('includes/footer');
	}

	public function active_forms(){

		$header['title'] = 'Your Active Forms';

		$this->load->view('includes/header', $header);
		$this->load->view('active_forms');
		$this->load->view('includes/footer');
	}

	public function print_form($idform){
		if($this->input->post('print')){
			redirect('/view_report?id='.$idform);
		}
		else if($this->input->post('download')){
			$idform = $this->input->post('id_form');
			redirect('/download-report/'.$idform);
		}
	}

}