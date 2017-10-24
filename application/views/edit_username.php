<div class="main-content">
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
					<span style="text-transform: capitalize;"><?= $name; ?></span>
				</li>
			</ul><!-- /.breadcrumb -->
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
								<button type="submit" class="btn btn-success btn-md">Submit</button>
							</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>