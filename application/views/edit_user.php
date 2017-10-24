<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-user user-icon"></i>
					<a href="<?= base_url('user'); ?>" style="text-transform: capitalize;">Users</a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(2);?></span>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $name; ?></span>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<?php echo form_open(); ?>
			<div class="row">
				<div class="col-xs-12">
					<h2>
						<?= $title; ?>
						<div class="pull-right">
							<a href="<?php echo base_url('user/edit/password/').$user_id;?>" class="btn btn-warning btn-white btn-round"><i class="ace-icon fa fa-lock"></i> CHANGE PASSWORD</a>
							<?php if($position != '1') { ?>
								<a href="<?php echo base_url('delete-user/').$user_id;?>" class="btn btn-danger btn-white btn-round" onclick="return confirm('Do you want to delete this user?')"><i class="ace-icon fa fa-trash"></i> DEACTIVATE ACCOUNT</a>
							<?php } ?>
						</div>
					</h2>
					<div class="clearfix"></div>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8 form-horizontal">
					<?php if($position != '1') { ?>
					<div class="form-group row">
						<label class="col-sm-2 control-label" for="form-field-1"> User ID</label>
						<div class="col-sm-9">
							<span class="label label-info"><?= $user_id ?></span>
						</div>
					</div>
					<?php } ?>

					<?php $error = form_error('name', '<p class="text-danger">', '</p>');?>
					<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1"> Name</label>
						<div class="col-sm-9">
							<input name="name" type="text" id="form-field-1-1" class="form-control" value="<?php echo $name; ?>"/>
							<?php echo $error;?>
						</div>
					</div>

					<?php //$error = form_error('username', '<p class="text-danger">', '</p>');?>
					<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1"> Email</label>
						<div class="col-sm-9">
							<input name="email" type="email" id="form-field-1-1" class="form-control" value="<?php echo $email;?>"  />
							<?php //echo $error;?>
						</div>
					</div>

					<?php //$error = form_error('username', '<p class="text-danger">', '</p>');?>
					<!-- <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1"> Username</label>
						<div class="col-sm-9">
							<input name="username" type="text" id="form-field-1-1" class="form-control" value="<?php echo $username;?>"  />
							<?php //echo $error;?>
						</div>
					</div> -->

					<?php //print_r($custom);
					$error = form_error('branch', '<p class="text-danger">', '</p>');?>
					<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
						<div class="col-sm-9">
							<select name="branch" class="form-control" id="user-branch">
								<?php
									foreach ($branch_list as $value) {
								?>
									<option value='<?= $value["id"];?>' <?= $branch == $value["id"] ? 'selected="selected"' : '';?>><?= $value['branch_name'];?></option>";
								<?php
									}
								?>
							</select>
							<?php echo $error;?>
						</div>
					</div>

					<?php $error = form_error('position', '<p class="text-danger">', '</p>');?>
					<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
						<label class="col-sm-2 control-label" for="form-field-1"> Position </label>
						<div class="col-sm-9">
							<select name="position" class="form-control" id="user-position1">
								<?php
									foreach ($position_list as $val) {
								?>
									<option value='<?= $val["id"];?>' <?= $position == $val["id"] ? 'selected="selected"' : '';?>><?= $val['name'];?></option>";
								<?php
									}
								?>
							</select>
							<?php echo $error;?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group row ">
								<div class="col-md-6 col-md-offset-2">
									<br/>
									<a href="<?php echo base_url('user')?>" class="btn btn-danger btn-white btn-round btn-lg">CLOSE</a>
									<button type="submit" class="btn btn-success btn-white btn-round btn-lg"><i class="ace-icon fa fa-save"></i> SAVE CHANGES</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
				<div class="col-sm-6">
				  	<h5>Page Permissions:</h5>
				  	<?php
				  		if ($user_acl['pages'] == 'all') {
							$data = $page_acl_list;
							foreach ($data as $value) {?>
								<span class="label label-info" style="margin: 5px;"><i class="fa fa-check"></i> <?= $value['name'];?></span>
							<?php }
						} else {
							foreach ($user_acl['pages'] as $value) {?>
								<span class="label label-info" style="margin: 5px;"><i class="fa fa-check"></i> <?= $value?></span>
							<?php }
						}
					?>
				</div>
				<div class="col-sm-6">
				    <h5 style="margin-top:20px;">Action Permissions:</h5>
				    <?php
						if ($user_acl['actions'] == 'all') {
							$data = $action_acl_list;
							foreach ($data as $value) {?>
								<span class="label label-info" style="margin: 5px;"><i class="fa fa-check"></i> <?= $value['name'] ?></span>
							<?php }
						} else {
							foreach ($user_acl['actions'] as $value) {?>
								<span class="label label-info" style="margin: 5px;"><i class="fa fa-check"></i> <?= $value?></span>
							<?php }
						}
					?>
				</div>
				<div class="col-xs-12">
					<?php if($custom['position'] != '1'){?>
						<div style="margin-top: 30px;"><a href="<?php echo base_url('user/edit/permissions/').$user_id;?>" class="btn btn-info btn-md">Edit Permissions</a></div>
					<?php } ?>
				</div>
			</div> -->
			<?php echo form_close(); ?>
		</div>
	</div>
</div>