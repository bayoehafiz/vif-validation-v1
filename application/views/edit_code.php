<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?= base_url('code'); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
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
			<div class="row">
				<div class="col-xs-12">
					<h2><?= $title;?></h2>
					<hr>					
				</div>
				<div class="col-sm-10 col-md-8">
					<?php echo form_open(); ?>

						<?php $error = form_error('branch', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-2 control-label" for="form-field-1"> Code</label>
							<div class="col-sm-1">:</div>
							<div class="col-sm-9">
								<input name="code" type="text" id="form-field-1-1" placeholder="Code" class="form-control" value="<?php echo $name; ?>" maxlength="4" style="text-transform:uppercase"/>
								<?php echo $error;?>
							</div>
						</div>

						<?php $error = form_error('code', '<p class="text-danger">', '</p>');?>
						<div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
							<label class="col-sm-2 control-label" for="form-field-1"> Description </label>
							<div class="col-sm-1">:</div>
							<div class="col-sm-9">
								<input name="description" type="text" id="form-field-1-1" placeholder="Description" class="form-control" value="<?php echo $description; ?>"/>
								<?php echo $error;?>
							</div>
						</div>
						<div class="form-group row ">
							<div class="col-sm-12">
								<br/>
								<a href="<?php echo base_url('code')?>" class="btn btn-danger btn-md">Cancel</a>
								<button type="submit" class="btn btn-success btn-md">Submit</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>