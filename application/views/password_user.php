<?php
	$id = $this->uri->segment(4);
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-user user-icon"></i>
					<a href="<?= base_url('user'); ?>" style="text-transform: capitalize;">Users</a>
				</li>
				<li>
					<a href="<?= base_url('user/edit/'.$id); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(2);?></a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(3);?></span>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $name; ?></span>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<h2><?= $title;?></h2>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8 form-horizontal">
					<?php echo form_open(); ?>

						<?php $error = form_error('password', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1"> New Password </label>
							<div class="col-sm-8">
								<input name="password" type="password" id="form-field-1-1" placeholder="Password" class="form-control" value="<?php set_value('password'); ?>"/>
								<?php echo $error;?>
							</div>
						</div>

						<?php $error = form_error('confirm_password', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-3 control-label" for="form-field-1">Confirm New Password </label>
							<div class="col-sm-8">
								<input name="confirm_password" type="password" id="form-field-1-1" placeholder="Confirm Password" class="form-control" value="<?php set_value('confirm_password'); ?>"/>
								<?php echo $error;?>
							</div>
						</div>

						<div class="form-group row ">
							<div class="col-md-6 col-md-offset-3">
								<br/>
								<a href="<?php echo base_url('user/edit/'.$id)?>" class="btn btn-danger btn-lg btn-white btn-round">CANCEL</a>
								<button type="submit" class="btn btn-success btn-lg btn-white btn-round"><i class="ace-icon fa fa-save"></i> SAVE</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>