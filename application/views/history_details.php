<?php
	//print_r($result);
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?= base_url('history')?>">History</a>
				</li>
				<li>
					History Detail
				</li>

			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
			<?php 
				foreach ($result as $key) {
				?>	
				<div class="col-xs-12">
					<h2><a href="javascript:window.history.go(-1);"><i class="fa fa-arrow-left"></i></a> &nbsp; Form History: "<?php echo $key->subject; ?>"</h2>
					<hr>					
				</div>
				<div class="col-sm-7">
					<h4><b>DETAILS :</b></h4>
					<hr>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->branch_name;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Code</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->code;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Subject</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->subject;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->description;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Period Start </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->start_period;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Period End </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->end_period;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Amount </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-1">
									<p style="padding: 5px 0">
										<?php
											if ($key->currency == 1) {
												echo "IDR&nbsp;";
											} else if ($key->currency == 2) {
												echo "USD&nbsp;";
											}
											
											echo $key->amount;
										?>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Amount In Word </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->amountinword;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Due Date </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->duedate;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->bank;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Number </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->accountnumber;?></div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Name </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-8"><?php echo $key->accountname;?></div>
					</div>
				</div>
				<div class="col-sm-5">
					    <h4><b>History :</b></h4>
					    <hr>
					    <ul class="list-group">
							<li class="list-group-item list-group-item-info">
								<span>Created by <?php echo $key->name;?></span>
								<br/>on <?php echo date("d M Y H:i A", $key->create_date);?>
							</li>
						<?php
							if(!empty($data)){
								foreach ($data as $row) {
									if ($row->status=='Verified') { ?>
										<li class="list-group-item list-group-item-success">
											<?php echo $row->status;?>
											by
											<?php
												if($row->id_user == $_SESSION['id']) echo "You ";
												else echo $row->name;
											?>
											<br/>on <?php echo date("d M Y H:i A", $row->exec_date);?>
										</li>
									<?php } else { ?>
										<li class="list-group-item list-group-item-danger">
											<?php echo $row->status;?>
											by 
											<?php 
												if($row->id_user == $_SESSION['id']) echo "You ";
												else echo $row->name;
											?>
											<br/>on <?php echo date("d M Y H:i A", $row->exec_date);?>
										</li>
									<?php } ?>
							<?php	}
							}
						?>
						</ul>

				</div>
					
				</div>

				<div class="row">
					<div class="col-xs-12">
						<h5>AMOUNT DETAIL :</h5>
						<hr>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="6%" class="text-center">No</th>
									<th>Name</th>
									<th>Description</th>
									<th>Use Date</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$no = 1;
									$totalAmount = 0;
									foreach ($amount_detail as $val) {
										$totalAmount += $val['amount'];
								?>
									<tr>
										<td class="text-center"><?= $no;?></td>
										<td><?= $val['name'];?></td>
										<td><?= $val['description'];?></td>
										<td><?= $val['use_date'];?></td>
										<td><?= $currency.' <span class="amount">'.$val['amount'].'</span>';?></td>
									</tr>
								<?php
									$no++;
									}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4" class="text-right"><b>Total Amount :<b></td>
									<td><?= $currency.' <span class="amount">'.$totalAmount.'</span>';?></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<h5>FILES :</h5>
						<hr>
						<div id="lightgallery">
							<?php
							// print_r($key);
								if(!empty($result[0]->path)){
									$arr = $result[0]->path;
									foreach ($arr as $value) {
							?>
									 <a href="<?php echo '../../../'.$value['path']; ?>" style="width: 20%; float: left; padding: 15px; margin:15px; width: 200px; border: 1px solid;">
									        <img src="../../../<?php echo $value['path']; ?>" style="width: 100%">
									    </a>
							<?php
									}
									
								}
								else{
									echo "No file upload found!";
								}
							?>
						</div>
						<hr>
					</div>
				</div>
				
				<div class="row">
					<hr>
					<div class="col-sm-10 col-md-8">
						
						<?php
							if($key->stage == $_SESSION['position'] && $key->stage != $key->position){ ?>
							<h3>Verification</h3>
							<?php echo form_open('verify_form'); ?>
							<div class="form-group row">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Notes</label>
								<div class="col-sm-1">:</div>
						<div class="col-sm-8">
									<textarea name="notes" style="width: 100%"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<br>
									<input type="hidden" name="id_user" value="<?php echo $_SESSION['id'];?>">
									<input type="hidden" name="id_form" value="<?php echo $key->id;?>">
									<input type="hidden" name="stage" value="<?php echo $key->stage;?>">
									<input type="hidden" name="position" value="<?php echo $key->position;?>">
									<input type="submit" name="verify"  value="Verified" class="pull-right btn btn-md btn-primary">
									<input type="submit" name="reject" value="Reject" class="pull-right btn btn-md btn-alert">
								</div>
							</div>
							<?php echo form_close(); ?>
							<?php }
							elseif ($key->stage == $key->position) { ?>
								<div class="col-sm-12">
									<a href="<?php echo base_url().'submission/edit_form/'.$key->id?>" class="btn btn-md btn-normal">
										Edit Revisi
									</a>
								</div>
							<?php }
						?>					
					</div>
				</div>
			<?php  
				}?>
			</div>
		</div>
	</div>
</div>