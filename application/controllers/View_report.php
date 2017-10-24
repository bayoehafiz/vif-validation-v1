<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class view_report extends MY_Controller{
	function __construct()
	{
	    parent::__construct();
	    $this->load->model('Crud');
	    $this->load->helper('form');
	    $this->load->helper('date');
	    $this->load->library('tcpdf');
	}

	public function print_form($id){
		ob_start();
		$sql = "select F.*, U.user_id, B.branch_name as bn FROM form F, users U, branch B WHERE F.created_by = U.user_id AND F.branch = B.id AND F.id = '$id' ";
		$res = $this->Crud->specialQuery($sql);
		
		$q = "select f.*,u.user_id FROM form_record f, users u WHERE f.id_user = u.user_id and f.id_form = '$id' ORDER BY exec_date ASC ";
		$data = $this->Crud->specialQuery($q);

		$result = $this->Crud->GetWhere('form_detail', array('id_form' => $id));

		// print_r($_SESSION['cloud_users']);
		foreach ($_SESSION['cloud_users'] as $vals) {
			if($vals['uuid'] == $res[0]['created_by']) $res[0]['name'] = $vals['name'];
		}
		foreach ($_SESSION['cloud_users'] as $val) {
			for ($i=0; $i < sizeof($data); $i++) { 
				if($val['uuid'] == $data[$i]['user_id']) $data[$i]['name'] = $val['name'];
			}
		}

		foreach ($res as $ser) {
			$border = 0;
			$widthhis = 0.4;
			$width = 67;
			$width2 = 0;
			$widthcol1 = 15;
			$widthcol2 = 2;
			$widthcol3 = 50;
			$widthcol4 = 0;
			$widthcolsub1 = 8;
			$widthcolsub2 = 0;
			$heightdesc = 2.5;
			$heightaiw = 0.8;
			$height = 1;
			$enter = 1;
			$ln = 0.1;
			$cur = $ser['currency'] == 1 ? 'IDR' : 'USD';
			
			$pdf = new TCPDF('P','cm','A4','true');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->setMargins(1,1,1);

			$pdf->AddPage();
			$pdf->SetHeaderMargin(false);
			$pdf->SetFooterMargin(false);
			$pdf->Ln(1);
			$pdf->Ln(0);


			/*------DETAIL-------*/
			$pdf->SetTitle($ser['subject']);
			$pdf->SetFont('helvetica','B', 10);
			$pdf->Cell(0, 0,strtoupper($ser['subject']), 0, 1,'C');
			$pdf->Ln(0.5);
			$pdf->SetFont('helvetica','', 10);
			$detail = '<table cellspacing="0" cellpadding="3" border="'.$border.'">
				<tr>
			        <td width="'.$width.'%" style="font-weight:bold;border-bottom-style:groove;" colspan="3">Detail</td>
			        <td width="2%"></td>
			        <td width="'.$width2.'%" style="font-weight:bold;border-bottom-style:groove;">History</td>
				</tr>
				<tr>
			        <td width="'.$widthcol1.'%">Branch</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['bn'].'</td>
			        <td width="0%"  rowspan="8">
			        	<table cellspacing="0" cellpadding="3" style="font-size:9px" border="'.$border.'">';
			        		foreach ($data as $row) {
			        			$detail .='
			        			<tr>
				        			<td width="'.$widthcolsub1.'%">-</td>';
				        			if($row['status'] == 'Open'){
				        				$detail .='<td width="'.$widthcolsub2.'%">Created by '.$row['name'].'</td>';
				        			}
				        			else if($row['status']=='Waiting'){
				        				$detail .='<td width="'.$widthcolsub2.'%">Verified by '.$row['name'].'</td>';
				        			}
				        			else if($row['status']=='Paid'){
				        				$detail .='<td width="'.$widthcolsub2.'%">Set as Paid by '.$row['name'].'</td>';
				        			}
				        			else if($row['status']=='Close'){
				        				$detail .='<td width="'.$widthcolsub2.'%">Set as Closed by '.$row['name'].'</td>';
				        			}
				        			else{
				        				$detail .='<td width="'.$widthcolsub2.'%">'.$row['status'].' by '.$row['name'].'</td>';
				        			}
				        	$detail .='</tr>
				        		<tr>
				        			<td width="'.$widthcolsub1.'%"></td>
				        			<td width="'.$widthcolsub2.'%">on '. date("d M Y H:i:s", $row['exec_date']).'</td>
				        		</tr>';
				        		if($row['notes'] != null){
					        		$detail .='<tr>
					        			<td width="'.$widthcolsub1.'%"></td>
					        			<td width="'.$widthcolsub2.'%" style="font-style:italic">Notes: '.$row['notes'].'</td>
					        		</tr>';
				        		}
			        		}
			        	$detail .='</table>
			        </td>
			    </tr>

			    <tr>
			        <td width="'.$widthcol1.'%">Subject</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['subject'].'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Description</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%" align="justify">'.$ser['description'].'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Amount</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$cur.' '.number_format($ser['amount'],2,'.',',').'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Amount in word</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['amountinword'].'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Bank</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['bank'].'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Account Number</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['accountnumber'].'</td>
			        <td width="0%"></td>
			    </tr>
			    <tr>
			        <td width="'.$widthcol1.'%">Account Name</td>
			        <td width="'.$widthcol2.'%">:</td>
			        <td width="'.$widthcol3.'%">'.$ser['accountname'].'</td>
			        <td width="0%"></td>
			    </tr>
			</table>';

			$pdf->writeHTML($detail, true, false, false, false, '');			

			$amountdetail = '
			<style>
				table {
					border-collapse: collapse;
				}
				td {
					border: 1px solid #2E2E2E;
			        padding: 10px 15px 12px;
				}
				tr:nth-child(odd) td {
					background:#000000;
				}
			</style>

			<table cellspacing="0" cellpadding="3" >
				<tr bgcolor="#3D3D3D" color="#FFFFFF">
					<td align="center" width="5%">No</td>
					<td width="30%">Code</td>
					<td width="30%">Description</td>
					<td align="center" width="15%">Due Date</td>
					<td align="right">Amount ('.$cur.')</td>
				</tr>';

				$no = 1;
				$totalAmount = 0;
				foreach ($result as $val) {
					$que = "select C.* FROM code C WHERE C.id = '".$val['code']."'";
					$code = $this->Crud->specialQuery($que);
					$totalAmount += $val['amount'];
				 	$amountdetail .='<tr>
				 		<td align="center" width="5%">'.$no.'</td>
				 		<td width="30%">'.$code[0]['name'].'--'.$code[0]['description'].'</td>
				 		<td width="30%">'.$val['description'].'</td>
				 		<td align="center" width="15%">'.date("d M Y", strtotime($val['use_date'])).'</td>
				 		<td align="right"><span class="amount">'.number_format($val['amount'],2,".",",").'</span>'.'</td>
				 	</tr>';
				 	$no++;
				}
			$amountdetail .='<tr>
					<td colspan="4" align="right" style="font-weight:bold;">Total Amount</td>
					<td align="right">'.number_format($totalAmount,2,".",",").'</td>
				</tr>
			</table>';
			$pdf->SetFont('helvetica','B', 10);
			$pdf->Cell(0, 0,'Amount Detail', 0, 1,'L');
			$pdf->Ln(0.2);
			$pdf->SetFont('helvetica','', 9);
			$pdf->writeHTML($amountdetail, true, false, false, false, '');
			ob_clean();

			$pdf->Output('report.pdf','I');
		}		
	}
}