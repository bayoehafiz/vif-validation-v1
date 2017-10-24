<?php 
	$stage = $this->uri->segment(1);
	$position = $_SESSION['position'];
	$branch = $_SESSION['branch'];

	function show_buttons($arr, $fid) {
		foreach ($arr as $type) {
			if ($type == 'revision') echo '<a href="' . base_url() . 'submission/edit_form/'. $fid . '" class="btn btn-white btn-warning btn-bold btn-lg" style="margin-right:10px;"><i class="ace-icon fa fa-edit"></i> REVISE</a>';
			else if ($type == 'verify') echo '<button type="submit" name="verify" value="verify" class="btn btn-white btn-success btn-bold btn-lg" onclick="validation()" style="margin-right:10px;"><i class="ace-icon fa fa-floppy-o bigger-120"></i> VERIFY</button>';
			else if ($type == 'reject') echo '<button  type="submit" name="reject" value="reject" class="btn btn-white btn-danger btn-bold btn-lg" onclick="validation()" style="margin-right:10px;"><i class="ace-icon fa fa-times bigger-120"></i>REJECT</button>';
			else if ($type == 'verify_to_andi') echo '<button type="submit" name="verify_to_andi" value="verify_to_andi" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;">VERIFY TO MR. ANDI <i class="ace-icon fa fa-arrow-right"></i></button>';
			else if ($type == 'verify_to_wahyudi') echo '<button type="submit" name="verify_to_wahyudi" value="verify_to_wahyudi" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;">VERIFY TO MR. WAHYUDI <i class="ace-icon fa fa-arrow-right"></i></button>';
			else if ($type == 'verify_to_michael') echo '<button type="submit" name="verify_to_michael" value="verify_to_michael" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;">VERIFY TO MR. MICHAEL <i class="ace-icon fa fa-arrow-right"></i></button>';
			else if ($type == 'verify_to_central') echo '<button type="submit" name="verify_to_central" value="verify_to_central" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;">VERIFY TO CR. ACCOUNTING <i class="ace-icon fa fa-arrow-right"></i></button>';
			// UNDO buttons
			else if ($type == 'cancel_paid') echo '<button type="submit" name="cancel_paid" value="cancel_paid" class="btn btn-white btn-danger btn-bold btn-lg" style="margin-right:10px;"><i class="fa fa-undo"></i> UNDO PAID</button>';
			else if ($type == 'cancel_closed') echo '<button type="submit" name="cancel_closed" value="cancel_closed" class="btn btn-white btn-danger btn-bold btn-lg" style="margin-right:10px;"><i class="fa fa-undo"></i> UNDO CLOSED</button>';

			else if ($type == 'paid') echo '<button type="submit" name="paid" value="paid" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;"><i class="fa fa-money"></i> SET AS PAID</button>';
			else if ($type == 'close') echo '<button type="submit" name="close" value="close" class="btn btn-white btn-success btn-bold btn-lg" style="margin-right:10px;"><i class="ace-icon fa fa-check-square-o"></i> SET AS CLOSED</button>';
			else if ($type == 'print') echo '<a href="' . base_url() . 'print-form/'. $fid . '" class="btn btn-white btn-info btn-bold btn-lg" style="margin-right:10px;" target="_blank"><i class="fa fa-print"></i> PRINT</a>';
			else if ($type == 'waiting') echo '<div class="alert alert-info">You have validated / rejected this form or the form is in undergoing process.</div>';
			else if ($type == 'ongoing') echo '<div class="alert alert-info">This form is in undergoing process.</div>';
			else echo '<div class="alert alert-info">You have validated / rejected this form or the form is in undergoing process.</div>';
		}
	}

	function show_note_field($form_stage, $form_status) {
		$user_level = $_SESSION['position']; // get logged in user's level (position)
		if ($form_status == 'Open' || $form_status == 'Verified' || $form_status == 'Waiting') {
			if ($form_stage == $user_level) {
				echo '<div class="form-group">
					<label class="control-label no-padding-right">Notes</label>
					<textarea name="notes" style="width: 100%;min-height: 100px"></textarea>
				</div>';
			}
		}
	}

	function decide_permission($form_stage, $form_status, $form_id) {
		$user_level = $_SESSION['position']; // get logged in user's level (position)
		$permission = [];

		if ($form_status != 'Rejected') { // while form IS not REJECTED
			if ($user_level == 2) { // BA
				if ($form_status == 'Open') {
					switch ($form_stage) {
						case 3: $permission = ['revision']; break;
						default: $permission = ['ongoing']; break;
					}
				} else if ($form_status == 'Verified') {
					switch ($form_stage) {
						default: $permission = ['ongoing']; break;
					}
				}
			} else if ($user_level == 3) { // BH
				if ($form_status == 'Verified') {
					switch ($form_stage) {
						case 3: $permission = ['verify', 'reject']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Open') {
					switch ($form_stage) {
						case 3: $permission = ['verify', 'reject']; break;
						case 4: $permission = ['revision']; break;
						default: $permission = ['ongoing']; break;
					}
				}
			} else if ($user_level == 4) { // CA
				if ($form_status == 'Verified') {
					switch ($form_stage) {
						case 3: $permission = ['waiting']; break;
						case 4: $permission = ['verify', 'reject']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Waiting') {
					switch ($form_stage) {
						case 3: $permission = ['waiting']; break;
						case 4: $permission = ['reject', 'paid', 'print']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Paid') {
					switch ($form_stage) {
						case 3: $permission = ['waiting']; break;
						case 4: $permission = ['cancel_paid', 'close']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Close') {
					switch ($form_stage) {
						case 4: $permission = ['cancel_closed', 'print']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Open') {
					switch ($form_stage) {
						case 4: $permission = ['verify', 'reject']; break;
						case 5: $permission = ['revision']; break;
						default: $permission = ['none']; break;
					}
				} else if ($form_status == 'Rejected') {
					switch ($form_stage) {
						case 5: $permission = ['revision']; break;
						default: $permission = ['none']; break;
					}
				}
			} else if ($user_level == 5) { // MA
				switch ($form_stage) {
					case 2: $permission = ['waiting']; break;
					case 3: $permission = ['waiting']; break;
					case 4: $permission = ['print']; break;
					case 5: $permission = ['verify_to_andi', 'verify_to_wahyudi','verify_to_michael', 'reject']; break;
					default: $permission = ['print']; break;
				}
			} else if ($user_level == 6) { // WD2
				switch ($form_stage) {
					case 3: $permission = ['waiting']; break;
					case 4: $permission = ['waiting']; break;
					case 5: $permission = ['waiting']; break;
					case 6: $permission = ['verify_to_central', 'verify_to_michael', 'reject']; break;
					default: $permission = ['none']; break;
				}
			} else if ($user_level == 7) { // WD1
				switch ($form_stage) {
					case 3: $permission = ['waiting']; break;
					case 4: $permission = ['waiting']; break;
					case 5: $permission = ['waiting']; break;
					case 7: $permission = ['verify_to_michael', 'reject']; break;
					default: $permission = ['none']; break;
				}
			} else if ($user_level == 8) { // DU
				switch ($form_stage) {
					case 3: $permission = ['waiting']; break;
					case 4: $permission = ['waiting']; break;
					case 5: $permission = ['waiting']; break;
					case 6: $permission = ['waiting']; break;
					case 7: $permission = ['waiting']; break;
					case 8: $permission = ['verify_to_central', 'reject']; break;
					default: $permission = ['none']; break;
				}
			}
		} else {
			// Form is REJECTED
			if ($user_level == 2) { // BA
				switch ($form_stage) {
					case 2: $permission = ['revision']; break;
					default: $permission = ['none']; break;
				}
			} else if ($user_level == 3) { // BH
				switch ($form_stage) {
					case 3: $permission = ['revision']; break;
					default: $permission = ['none']; break;
				}
			} else if ($user_level == 4) { // CA
				switch ($form_stage) {
					case 4: $permission = ['revision']; break;
					default: $permission = ['none']; break;
				}
			} else {
				$permission = ['none'];
			}
		}

		show_buttons($permission, $form_id);
	}
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<?php 

				if ($stage == 'all-form') {
					$newState = 'All Form';
				} else if ($stage == 'verified-forms') {
					$newState = 'Verified Form';
				} else if ($stage == 'rejected-forms') {
					$newState = 'Rejected Form';
				} else if ($stage == 'unvalidate-list') {
					$newState = 'Unvalidate List';
				} else if ($stage == 'waiting-payment') {
					$newState = 'Waiting Payment';
				} else if ($stage == 'history') {
					$newState = 'Form History';
				} else if ($stage == 'unpaid-form') {
					$newState = 'Unpaid Form';
				} else if ($stage == 'unclose-form') {
					$newState = 'Unclose Form';
				} else if ($stage == 'paid-form') {
					$newState = 'Paid Form';
				} else if ($stage == 'close-form') {
					$newState = 'Close Form';
				}
			?>
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?= base_url($stage)?>" style="text-transform: capitalize;">
						<!-- <?= $newState;?> -->
						<?php echo ucwords(str_replace("-", " ", $this->uri->segment(1))); ?>
					</a>
				</li>
				<li>
					Form Detail
				</li>
			</ul>
			<!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<!-- <pre><?php echo 'Your UID: ' . $_SESSION['uuid'] . ' - Form created_by: ' . $result['created_by']; ?></pre> -->
			<div class="row">
				<div class="col-xs-12 text-right">
					<a class="btn btn-white btn-round btn-danger" href="<?= base_url("".$stage);?>">
						<i class="ace-icon fa fa-close"></i> CLOSE
					</a>
				</div>
				<div class="col-sm-10 col-md-8 form-horizontal">
					<h3 class="text-info">
						<i class="fa fa-coffee"></i> Details
					</h3>
					<hr>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Submission Status </label>
						<div class="col-sm-8">
							<span class="submission-status">
							<?php
								if ($result['status'] == 'Open'|| $result['status'] == 'Verified') { $color = 'success'; $text = 'On Progress'; }
								else if ($result['status'] == 'Waiting') { $color = 'warning'; $text = 'Waiting Payment'; }
								else if ($result['status'] == 'Paid') { $color = 'success'; $text = 'Paid'; }
								else if ($result['status'] == 'Close') { $color = 'info'; $text = 'Closed'; }
								else { $color = 'danger'; $text = $result['status']; }
								echo "<span class='label label-lg label-" . $color . " arrowed-right'>" . $text . '</span>';
							?>
							</span>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch </label>
						<div class="col-sm-8">
							<input name="branch" type="text" id="form-field-1-1" class="form-control" value="<?php echo $result['branch_name'];?>" readonly/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Subject </label>
						<div class="col-sm-8">
							<input name="subject" type="text" id="form-field-1-1" class="form-control" value="<?php echo $result['subject'];?>" readonly/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="description"> Description </label>
						<div class="col-sm-8">
							<textarea id="description" class="form-control" rows="3" readonly><?php echo $result['description'];?></textarea>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Amount </label>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-1 text-right">
									<span class="form-control submission-status">
										<?php
											if ($result['currency'] == 1) {
												echo "IDR";
											} else if ($result['currency'] == 2) {
												echo "USD";
											}
										?>
									</span>
								</div>
								<div class="col-sm-11">
									<input type="text" class="form-control" value="<?php echo number_format($result['amount'],2,'.',',');?>" readonly/>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Amount In Word</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $result['amountinword'];?>" readonly/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $result['bank'];?>" readonly/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Number </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $result['accountnumber'];?>" readonly/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $result['accountname'];?>" readonly/>
						</div>
					</div>
				</div>
				<div class="col-sm-10 col-md-4">
					<h3 class="text-info"><i class="fa fa-history"></i> History</h3>
					<hr>
					<?php
							if(!empty($data)){
								$temp = []; $chunked = []; $prev = '';
								foreach ($data as $row) {
									// coloring	
									if ($row['status'] == 'Verified') {
										$color = "#16a085";
									}
									else if ($row['status'] == 'Paid') {
										if ($prev == 'Close')
											$color = "#c0392b";
										else
											$color = "#16a085";
									}
									else if ($row['status'] == 'Waiting') {
										if ($prev == 'Paid')
											$color = "#c0392b";
										else
											$color = "#16a085";
									}
									else if ($row['status'] == 'Open') {
										$color = "#2c3e50";
									}
									else if ($row['status'] == 'Rejected') {
										$color = "#c0392b";
									}
									else if ($row['status'] == 'Revised') {
										$color = "#f39c12";
									}
									else {
										$color = "#2c3e50";
									}
									// }
						?>
						<div class="histories" style="margin-bottom: 5px;">
							<div class="active item">
								<div class="carousel-info">
									<img alt="<?php echo $name;?>'s Photo" data-src="<?php echo $row['image']; ?>" class="lazy pull-left">
									<div class="pull-left">
										<span class="histories-name" style="font-size:1.1em; color:<?php echo $color; ?>">
										  <?php 
											if ($row['status'] == 'Open') {
												echo "Created ";
											}
											else if ($row['status'] == 'Waiting') {
												if ($prev == 'Paid')
													echo "Payment Cancelled ";
												else
													echo "Verified ";
											}
											else if ($row['status'] == 'Paid') {
												if ($prev == 'Close')
													echo "Closing Cancelled ";
												else
													echo "Set as Paid ";
											}
											else if ($row['status'] == 'Close') {
												echo "Set as Closed ";
											}
											else {
												echo "<strong>" . $row['status'] . "</strong>";
											}
										  ?> 
										  by <strong><?= $row['user_id'] == $_SESSION['uuid'] ? "You" : $row['name']; ?></strong>
										  </span>
										<span class="histories-post">
											on <?php echo date("d M Y, H:i", $row['exec_date']);?>
											<?php if ($row['notes'] !== '') {
												if ($row['status'] == 'Rejected') {
											?>
												<span class="bg-danger truncate">Note: <strong><?= $row['notes']; ?></strong></span>
											<?php } else { ?>
												<span class="bg-info truncate">Note: <strong><?= $row['notes']; ?></strong></span>
											<?php 
												}
											} 
											?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php	
									$prev = $row['status'];
								}
							}
						?>
				</div>
				<div class="col-xs-12">
					<h3 class="text-info">
						<i class="fa fa-list-alt"></i> Amounts
					</h3>
					<hr>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="4%" class="text-center">No</th>
								<th>Name</th>
								<th width="40%">Description</th>
								<th align="center">Due Date</th>
								<th align="right">Amount (
									<?= $currency ?>)</th>
							</tr>
						</thead>
						<tbody>
							<?php
									$no = 1;
									$totalAmount = 0;
									foreach ($amount_detail as $val) {
										$que = "select C.* FROM code C WHERE C.id = '".$val['code']."'";
										$code = $this->Crud->specialQuery($que);
										$totalAmount += $val['amount'];
								?>
								<tr>
									<td class="text-center">
										<?= $no;?>
									</td>
									<td>
										<?= $code[0]['name'];?> --
											<?= $code[0]['description'];?>
									</td>
									<td>
										<?= $val['description'];?>
									</td>
									<td align="center">
										<?= date("d M Y", strtotime($val['use_date']));?>
									</td>
									<td align="right" width="150">
										<?= number_format($val['amount'],2,'.',',');?>
									</td>
								</tr>
								<?php
									$no++;
									}
								?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4" class="text-right"><b>Total Amount :<b></td>
									<td align="right"><?= number_format($totalAmount,2,'.',',');?></td>
								</tr>
							</tfoot>
						</table>
					</div>


				<div class="col-xs-12">
					<h3 class="text-info"><i class="fa fa-paperclip"></i> Attachments</h3>
					<hr>
					<div id="lightgallery">
						<?php
							if(count($path) > 0) {
								foreach($path as $file) {
						?>		
							<a href="<?php echo base_url($file); ?>" style="width: 20%; float: left; padding: 15px; margin:15px; width: 200px; border: 1px solid;">
								<img src="<?php echo base_url($file); ?>" style="width: 100%">
							</a>
						<?php
								}
							} else {
								echo "No Files uploaded";
							}
						?>
					</div>
				</div>

				<!-- VALIDATION SECTIONS -->
				<?php if($_SESSION['position'] != 1) { ?>
				<div class="col-xs-12" style="margin-top: 25px;">
					<h3 class="text-info"><i class="fa fa-cog"></i> Validation Actions</h3>
					<hr>
					<?php echo form_open('event-form'); ?>
						<input type="hidden" name="stages" value="<?php echo $stage;?>">
						<input type="hidden" name="id_user" value="<?php echo $_SESSION['uuid'];?>">
						<input type="hidden" name="id_form" value="<?php echo $result['id'];?>">
						<input type="hidden" name="stage" value="<?php echo $result['stage'];?>">
						<input type="hidden" name="position" value="<?php echo $position;?>">
						<input type="hidden" name="form_creator" value="<?php echo $result['created_by'];?>">
						<div class="row">
							<div class="col-md-6">
								<?php show_note_field($result['stage'], $result['status']); ?>
							</div>
							<div class="col-md-12">
								<p><?php decide_permission($result['stage'], $result['status'], $result['id']); ?></p>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
function validate(a)
{
	var id= a.value;
	swal({
		title: 'Notes',
		input: 'textarea'
	}).then(function(text) {
		if (text) {
			swal(text);
		}
	})
}

// Images Lazyload
$('.lazy').Lazy({
	scrollDirection: 'vertical',
	effect: 'fadeIn',
	visibleOnly: true,
	onError: function(element) {
		console.log('error loading ' + element.data('src'));
	}
});


</script>
<style type="text/css">

/* Content */
.content {
	padding-top: 30px;
}

/* Histories */
.histories .carousel-info img {
	border: 1px solid #f5f5f5;
	border-radius: 150px !important;
	height: 60px;
	padding: 3px;
	width: 60px;
}
.histories .carousel-info {
	overflow: hidden;
}
.histories .carousel-info img {
	margin-right: 15px;
}

.histories .carousel-info span {
	display: block;
}
.histories span.histories-name {
	margin: 10px 0 0;
}
.histories span.histories-post {
	color: #656565;
	font-size: 12px;
	font-weight: 300;
	margin-bottom: 10px;
}

.submission-status {
	border: 0;
	outline: 0;
	background: #FFFFFF!important;
}

input[readonly], #description {
	font-size: 1.1em;
	font-weight: bold!important;
	color: #2c3e50;
	border: 0;
	outline: 0;
	border-bottom: .5px solid #bdc3c7;
	background: #FFFFFF!important;
}

label {
	color: #7f8c8d;
}

.truncate {
  width: 250px;
  word-wrap: break-word;
  padding: 0 5px 0 5px;
}
</style>