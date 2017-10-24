<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-plug plug-icon"></i>
					<a href="<?= base_url('connection'); ?>" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
				</li>
				<li>
					<span style="text-transform: capitalize;"><?= $this->uri->segment(2);?></span>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<h2><?= $title; ?></h2>
					<hr>					
				</div>
				<div class="col-sm-112 col-md-12">
					Cloud response:<br/><br/>
					<div class="alert alert-success">
						<div class="row">
							<div class="col-xs-12">
								<i class="ace-icon fa fa-check"></i> All users on cloud are successfully deleted.<br/>
								<small>You may want to sync this app since there is no single user on the cloud. To do this, just hit the SYNC USERS button on the bottom.<br/><a href="">Why?</a></small>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-112 col-md-12" style="margin-top: 10px;">
					Next things to do:<br/><br/>
					<a href="<?php echo base_url('connection/list')?>" class="btn btn-default btn-md"><i class="ace-icon fa fa-arrow-left arrow-left-icon"></i> Back to User List</a>
					<a href="<?php echo base_url('connection/sync')?>" class="btn btn-primary btn-md"><i class="ace-icon fa fa-plug plug-icon"></i> Sync Users</a>
				</div>
			</div>
		</div>
	</div>
</div>