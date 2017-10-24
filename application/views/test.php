			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#"><?= $title;?></a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<div class="row">
                                <div class="col-xs-12 col-sm-6">
                                	<h1>All Form</h1>
                                </div>
                                <div class="col-xs-12 col-sm-6">
								    <ul class="filter-by-currency">
								        <li>Filter By Currency :</li>
								        <li>
								            <select class="by_currency" style="width: 100%">
								                <option value="1" selected="selected">IDR</option>
								                <option value="2">USD</option>
								            </select>
								        </li>
								    </ul>
								</div>
							</div>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="form-submission-2" class="table table-hover simple-table">
											<thead>
												<tr>
													<th width="6%" class="text-center">No</th>
													<th>Branch</th>
													<th class="hidden-480">Subject</th>
													<?php 
													$print=$_SESSION['cloud_users']['data'];
													print_r($print);
													// foreach ($print as $user) {
													// 	if($user['uuid']){
													// 		echo $user['uuid'];
													// 	}
													// }

													if($_SESSION['branch']==1){
														echo '<th class="hidden-480">Verified On</th>';
													}
													else{
														echo '<th class="hidden-480">Create On</th>';	
													}?>													
													<th>
														Stage
													</th>
													<th class="hidden-480">Amount</th>
												</tr>
											</thead>
											<tfoot>
									            <tr>
									                <th colspan="5" style="text-align:right">Total:</th>
									                <th id="total"></th>
									            </tr>
									            <tr>
									                <th colspan="5" style="text-align:right" id="grand-total-title">Grand Total:</th>
									                <th id="grand-total"></th>
									            </tr>
									        </tfoot>
											<tbody>
												
											</tbody>
										</table>
									</div><!-- /.span -->
								</div><!-- /.row -->
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
<?php 
echo '
SELECT P.no_register, P.nama, P.alamat, P.jk, P.umur, RM.id_supervisor, T.tindakan, T.status_tindakan
FROM pasien P, rm_rekapmedis RM, rm_tindakan T
WHERE P.id_pasien=RM.id_pasien AND RM.id_rekapmedis=T.id_rekammedis

SELECT P.id_pasien, P.no_register, P.nama, P.alamat, P.jk, P.umur, U.nama as supervisor, IF(T.status_tindakan = 'e', 'endo', 'open') as status_tindakan, CONCAT(TS.icopim,' - ',TS.nama) as tindakan
FROM pasien P, rm_rekapmedis RM, mr_user U, rm_tindakan T LEFT JOIN uro_terapi TS ON T.tindakan=TS.id_terapi
WHERE P.id_pasien=RM.id_pasien AND U.id_user=RM.id_supervisor AND RM.id_rekapmedis=T.id_rekammedis


/*----Pasien - Rekapmedis - User - Tindakan----*/
SELECT
	RM.id_rekapmedis, P.no_register, RM.tgl_masukrs, P.nama AS nama_pasien, P.alamat, IF(P.jk = 'l', 'Laki-Laki', 'Perempuan') AS jenis_kelamin, P.umur, U.nama AS nama_dokter,
	T.id_tindakan, T.id_rekammedis, 
	(CASE
		WHEN T.status_tindakan = 'e' THEN 'Endo'
		WHEN T.status_tindakan = 'o' THEN 'Open'
	END) AS status_tindakan
	,CONCAT(TS.icopim,' - ',TS.nama) as tindakan, U1.nama AS nama_operator,
	(CASE
		WHEN OT.status_operator = 'A' THEN 'Asistensi'
		WHEN OT.status_operator = 'M' THEN 'Mandiri'
		WHEN OT.status_operator = 'D' THEN 'Dengan Pendamping'
	END) AS status_operator
	FROM
		pasien P LEFT JOIN rm_rekapmedis RM ON P.id_pasien=RM.id_pasien LEFT JOIN mr_user U ON RM.id_supervisor=U.id_user LEFT JOIN rm_tindakan T ON RM.id_rekapmedis=T.id_rekammedis LEFT JOIN uro_terapi TS ON T.tindakan=TS.id_terapi LEFT JOIN rm_operatortindakan OT ON T.id_tindakan=OT.id_tindakan LEFT JOIN uro_ppd UP ON OT.id_ppd=UP.id_ppd,
		uro_ppd UP1 LEFT JOIN mr_user U1 ON UP1.id_user=U1.id_user


/*---DIAGNOSIS---*/
SELECT RM.id_pasien, DS.id_diagnosis, DS.id_rekapmedis, d1.nama diag_awal1, d2.nama diag_awal2, d3.nama diag_awal3 , d4.nama diag_utama, d5.nama diag_sekunder1, d6.nama diag_sekunder2, d7.nama diag_sekunder3, d8.nama diag_komplikasi1, d9.nama diag_komplikasi2, d10.nama diag_komplikasi3
    FROM
    rm_rekapmedis RM LEFT JOIN rm_diagnosis DS ON RM.id_rekapmedis=DS.id_rekapmedis
    LEFT JOIN uro_diagnosa d1 on d1.id_diagnosa = DS.diag_awal1
    LEFT JOIN uro_diagnosa d2 on d2.id_diagnosa = DS.diag_awal2
    LEFT JOIN uro_diagnosa d3 on d3.id_diagnosa = DS.diag_awal3
    LEFT JOIN uro_diagnosa d4 on d4.id_diagnosa = DS.diag_utama
    LEFT JOIN uro_diagnosa d5 on d5.id_diagnosa = DS.diag_sekunder1
    LEFT JOIN uro_diagnosa d6 on d6.id_diagnosa = DS.diag_sekunder2
    LEFT JOIN uro_diagnosa d7 on d7.id_diagnosa = DS.diag_sekunder3
    LEFT JOIN uro_diagnosa d8 on d8.id_diagnosa = DS.diag_komplikasi1
    LEFT JOIN uro_diagnosa d9 on d9.id_diagnosa = DS.diag_komplikasi2
    LEFT JOIN uro_diagnosa d10 on d10.id_diagnosa = DS.diag_komplikasi3


/*---TINDAKAN, OPERATOR TINDAKAN---*/
SELECT T.id_tindakan, T.id_rekammedis, 
	(CASE
		WHEN T.status_tindakan = 'e' THEN 'Endo'
		WHEN T.status_tindakan = 'o' THEN 'Open'
	END) AS status_tindakan
,CONCAT(TS.icopim,' - ',TS.nama) as tindakan, U.nama AS nama_operator,
	(CASE
		WHEN OT.status_operator = 'A' THEN 'Asistensi'
		WHEN OT.status_operator = 'M' THEN 'Mandiri'
		WHEN OT.status_operator = 'D' THEN 'Dengan Pendamping'
	END) AS status_operator
FROM rm_tindakan T LEFT JOIN uro_terapi TS ON T.tindakan=TS.id_terapi LEFT JOIN rm_operatortindakan OT ON T.id_tindakan=OT.id_tindakan LEFT JOIN uro_ppd UP ON OT.id_ppd=UP.id_ppd LEFT JOIN mr_user U ON UP.id_user=U.id_user

/*---OPERATOR TINDAKAN---*/

SELECT OT.id_operator, OT.id_tindakan, U.nama,
	(CASE
		WHEN OT.status_operator = 'A' THEN 'Asistensi'
		WHEN OT.status_operator = 'M' THEN 'Mandiri'
		WHEN OT.status_operator = 'D' THEN 'Dengan Pendamping'
	END) AS status_operator
FROM rm_operatortindakan OT LEFT JOIN uro_ppd UP ON OT.id_ppd=UP.id_ppd LEFT JOIN mr_user U ON UP.id_user=U.id_user
';
?>