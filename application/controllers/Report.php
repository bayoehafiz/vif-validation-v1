<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller{
	function __construct()
	{
	    parent::__construct();
	    $this->load->model('Crud');
	    $this->load->helper('form');
	    $this->load->helper('date');
	}

	public function download($id){
		// $id = $_GET['id'];
		$sql = "SELECT F.*, U.name, B.branch_name as bn, U.position FROM form F, user U, branch B WHERE F.created_by = U.id AND F.branch = B.id AND F.id = '$id' ";
		$res = $this->Crud->specialQuery($sql);
		$q = "select f.*,u.name FROM form_record f, user u WHERE f.id_user = u.id and f.id_form = '$id' ORDER BY exec_date ASC ";
		$data = $this->Crud->specialQuery($q);
		//print_r($result);
		foreach ($res as $ser) {
			$border = 0;
			$widthhis = 0.4;
			$widthcol1 = 4;
			$widthcol2 = 0.3;
			$widthcol3 = 0;
			$heightdesc = 3;
			$heightaiw = 1;
			$height = 1;
			$enter = 1;
			$ln = 0.1;
			$sp = $ser->start_period;
			$cur = $ser->currency == 1 ? 'IDR' : 'USD';
			$path = $ser->path;
			
			$pdf = new TCPDF('P','cm','A4','true');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->setMargins(2,2,2);

			$pdf->AddPage();
			$pdf->SetHeaderMargin(false);
			$pdf->SetFooterMargin(false);
			$pdf->Ln(1);
			$pdf->Ln(0);


			/*------DETAIL-------*/
			$pdf->SetFont('helvetica','B', 10);
			$pdf->Cell(0, 0,$ser->subject, 0, 1,'L');

			$pdf->Ln(0.5);
			$pdf->SetFont('helvetica','', 10);
			$pdf->MultiCell($widthcol1, 0,'Branch', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->bn , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);

			$pdf->MultiCell($widthcol1, 0,'Code', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->code , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Subject', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->subject , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, $heightdesc,'Description', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, $heightdesc,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, $heightdesc, $ser->description , $border, 'J', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Period', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $sp.' - '.$ser->end_period , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Amount', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $cur.' '.number_format($ser->amount,0,',','.') , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, $heightaiw,'Amount in word', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, $heightaiw,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, $heightaiw, $ser->amountinword , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Due Date', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->duedate , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Bank', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->bank , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Account Number', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->accountnumber , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
			$pdf->Ln($ln);
			
			$pdf->MultiCell($widthcol1, 0,'Account Name', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol2, 0,':', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell($widthcol3, 0, $ser->accountname , $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);
			$pdf->Ln(0.5);

			/* ------HISTORY------*/
			$pdf->SetFont('helvetica','B', 8);
			$pdf->Write(0, 'History', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln($ln);

			$pdf->SetFont('helvetica','', 8);
			$pdf->MultiCell($widthhis, 0,'-', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell(0, 0,'Created by', $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
			$pdf->Ln($ln);

			$pdf->MultiCell($widthhis, 0,'', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$pdf->MultiCell(0, 0,$ser->name.' on '. date("d-M-Y H:i:s", $ser->create_date), $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
			$pdf->Ln($ln);

			foreach ($data as $row) {
				$pdf->SetFont('helvetica','', 8);
				$pdf->MultiCell($widthhis, 0,'-', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(0, 0,$row->status, $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
				$pdf->Ln($ln);

				$pdf->MultiCell($widthhis, 0,'', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(0, 0,$row->name.' on '. date("d-M-Y H:i:s", $row->exec_date), $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
				$pdf->Ln($ln);

				$pdf->SetFont('helvetica','I', 8);
				$pdf->MultiCell($widthhis, 0,'', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(0, 0,'Note : '.$row->notes, $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
				$pdf->Ln($ln);
			}
			
			$pdf->AddPage();
			$pdf->SetFont('helvetica','B', 10);
			$pdf->Write(0, 'Attach Files', '', 0, 'L', true, 0, false, false, 0);
			
			if($path != '"[]"'){
				$path = stripslashes(stripslashes($ser->path));
				$path = json_decode("[".explode(']"', explode('"[',$path)[1])[0]."]");
				$h=2.7;
				for ($i=0; $i < sizeof($path); $i++) {
					$pdf->Image(base_url().''.$path[$i]->path, 2, $h, 18, 8, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
					$h=$h*4.2;
				}
			} else {
				$pdf->SetFont('helvetica','I', 10);
				$pdf->MultiCell($widthhis, 0,'', $border, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(0, 0,'No Files uploaded', $border, 'L', 0, $enter, '', '', true, 0, false, true, 0);		
				$pdf->Ln($ln);
			}
			$pdf->Output('report.pdf','I');
		}		
	}
}