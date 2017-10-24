<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?= base_url('user'); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
				</li>
				<li>
					<a href="<?php echo base_url('user/edit/'.$this->uri->segment(4))?>" style="text-transform: capitalize;"><?= $this->uri->segment(2);?></a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(3);?></span>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $details['name']; ?></span>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<?php echo form_open(); ?>
			<div class="row">
				<div class="col-xs-12">
					<h2><?= $title1;?></h2>
					<div class="clearfix"></div>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8">
					<?php if($custom['position'] != '1') { ?>
					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> User ID</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9 text-muted"><?= $uuid ?></div>
					</div>
					<?php } //echo $uuid;?>

					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> Name</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9"><?php echo $details['name']; ?></div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> Email</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9"><?php echo $details['email'];?></div>
					</div>

					<?php
						$sql = "select B.branch_name FROM branch B WHERE B.id = '".$custom['branch']."'";
						$que = $this->Crud->specialQuery($sql);
						//print_r($que);
						$squ = "select P.name FROM position P WHERE P.id = '".$custom['position']."'";
						$qur = $this->Crud->specialQuery($squ);
					?>
					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9"><?= $que[0]['branch_name'];?></div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> Position </label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9"><?= $qur[0]['name'];?></div>
					</div>
					<div class="col-sm-6">
						<div class="widget-box">
							<div class="widget-header">
								<h4 class="widget-title">Page Permissions:</h4>
							</div>
							<?php
								$pages = $custom['access_rights']['pages'];
								$newarr = array();
								foreach($pp as $valar){
									$valar['checked'] = false;
								 	foreach($pages as $val){
								 		if($valar['name'] == $val){
								 			$valar['checked'] = true;
								 		} 
								 	};
								 	array_push($newarr, $valar);
								}
								foreach ($newarr as $value) {?>
									<div class="checkbox">
										<label class="block">
												<input name="pagepermission[]"  type="checkbox" class="ace input-lg" value="<?= $value['name'];?>" <?php echo !empty($value['checked']) ? 'checked' : '';?>/>
											<span class="lbl bigger-120"> <?= $value['name'];?></span>
										</label>
									</div>
								<?php } ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="widget-box">
							<div class="widget-header">
								<h4 class="widget-title">Action Permissions:</h4>
							</div>
						  	<?php
						  		$act = $custom['access_rights']['actions'];
								$newact = array();
								foreach($ap as $valac){
									$valac['checked'] = false;
								 	foreach($act as $val){
								 		if($valac['name'] == $val){
								 			$valac['checked'] = true;
								 		} 
								 	}
								 	array_push($newact, $valac);
								}
								foreach ($newact as $value) {?>
									<div class="checkbox">
										<label class="block">
												<input name="actpermission[]"  type="checkbox" class="ace input-lg" value="<?= $value['name'];?>" <?php echo !empty($value['checked']) ? 'checked' : '';?>/>
											<span class="lbl bigger-120"> <?= $value['name'];?></span>
										</label>
									</div>
								<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group row ">
								<div class="col-sm-12">
									<br/>
									<a href="<?php echo base_url('user/edit/'.$this->uri->segment(4))?>" class="btn btn-default btn-md">Cancel</a>
									<button type="submit" class="btn btn-success btn-md">Update</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2 col-md-4">
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>



<!--<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?= base_url('user'); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
				</li>
				<li>
					<a href="<?= base_url('user/edit/'.$id); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(2);?></a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(3);?></span>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $details['name']; ?></span>
				</li>
			</ul>
		</div>
		<div class="page-content">
			<?php echo form_open(); ?>
			<div class="row">
				<div class="col-xs-12">
					<h2>
						<?= $title1;?>
					</h2>
					<div class="clearfix"></div>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8">
					<?php $error = form_error('username', '<p class="text-danger">', '</p>');?>
					<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1">Email</label>
						<div class="col-sm-1">:</div>
						<div class="col-sm-9">
							<input name="username" type="<?php echo $id==1?'text':'email';?>" id="form-field-1-1" placeholder="Email" class="form-control" value="<?php echo $username; ?>"/>
							<?php echo $error;?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group row ">
							<div class="col-sm-12">
								<br/>
								<a href="<?php echo base_url('user/edit/'.$id)?>" class="btn btn-danger btn-md">Cancel</a>
								<button type="submit" class="btn btn-success btn-md">Update</button>
							</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>-->