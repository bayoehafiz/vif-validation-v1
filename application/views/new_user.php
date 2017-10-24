<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-user user-icon"></i>
					<a href="<?= base_url('user'); ?>" style="text-transform: capitalize;">Users</a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(2);?> User</span>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<?php echo form_open(); ?>
			<div class="row">
				<div class="col-xs-12">
					<h2><?= $title;?></h2>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8 form-horizontal">
						<?php $error = form_error('name', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Full Name</label>
							<div class="col-sm-8">
								<input name="name" type="text" id="form-field-1-1" placeholder="Full Name" class="form-control" value="<?php echo set_value('name');?>"/>
								<?php echo $error;?>
							</div>
						</div>
						<?php $error = form_error('branch', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Branch</label>
							<div class="col-sm-8">
								<select name="branch" class="form-control" id="user-branch">
									<?php
										foreach ($branch as $value) {
									?>
										<option value='<?= $value["id"];?>'><?= $value['branch_name'];?></option>";
									<?php
										}
									?>
								</select>
								<?php echo $error;?>
							</div>
						</div>
						<?php $error = form_error('position', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Position</label>
							<div class="col-sm-8">
								<select name="position" class="form-control" id="user-position">
									<option value=''></option>;
								</select>
								<?php echo $error;?>
							</div>
						</div>
						<div class="space-6"></div>
						<div class="space-6"></div>
						<?php $error = form_error('email', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Email</label>
							<div class="col-sm-8">
								<input name="email" type="email" id="form-field-1-1" placeholder="user@email.com" class="form-control" value="<?php echo set_value('email');?>"  />
								<?php echo $error;?>
							</div>
						</div>
						<?php $error = form_error('username', '<p class="text-danger">', '</p>');?>
						<!-- <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Username</label>
							<div class="col-sm-8">
								<input name="username" type="text" id="form-field-1-1" placeholder="Username" class="form-control" value="<?php echo set_value('username');?>"  />
								<?php echo $error;?>
							</div>
						</div> -->
						<?php $error = form_error('password', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> Password</label>
							<div class="col-sm-8">
								<input name="password" type="text" id="form-field-1-1" placeholder="Password" class="form-control" value="<?php echo set_value('password');?>"/>
								<?php echo $error;?>
							</div>
						</div>
						<div class="form-group row ">
							<div class="col-md-6 col-md-offset-3">
								<br/>
								<a href="<?php echo base_url('user')?>" class="btn btn-danger btn-white btn-round btn-lg">CANCEL</a>
								<button type="submit" class="btn btn-success btn-white btn-round btn-lg"><i class="ace-icon fa fa-save"></i> SAVE</button>
							</div>
						</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>