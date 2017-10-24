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
					<? if ($success) { ?>
					<div class="alert alert-success">
						<div class="row">
							<div class="col-xs-12">
								<table id="simple-table" class="table table-striped">
									<thead>
										<tr>
											<th width="6%" class="text-center"></th>
											<th>Name</th>
											<th>Email</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($response as $value) {
										?>
										<tr>
											<td class="text-center"><?= $no;?></td>
											<td><a href=""><?= $value['details']['name'];?></a><br/><small class="text-muted"><?= $value['uuid'];?></small></td>
											<td><?= $value['details']['email'];?></td>
											<td class="text-center">
												<a href="<?php echo base_url('connection/delete/').$value['uuid'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user from cloud? He/she won\'t be able to login from mobile anymore!)"><i class="fa fa-trash"></i></a>
											</td>
										</tr>

										<?php
												$no++;
											}
										?>
									</tbody>
									<?php
										if (count($response) > 0) {
									?>
									<tfoot>
										<th width="6%" class="text-center"></th>
										<th></th>
										<th></th>
										<th class="text-center">
											<a href="<?php echo base_url('connection/delete/all');?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete all users from cloud? this action cannot be undone!)"><i class="fa fa-trash"></i> Remove All</a>
										</th>
									</tfoot>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
					<? } else { ?>
					<div class="alert alert-danger"><?= $response; ?></div>
					<? } ?>
				</div>
				<div class="col-sm-112 col-md-12" style="margin-top: 10px;">
					Next things to do:<br/><br/>
					<a href="<?php echo base_url('connection')?>" class="btn btn-default btn-md"><i class="ace-icon fa fa-plug plug-icon"></i> Check Connection</a>
					<a href="<?php echo base_url('connection/sync')?>" class="btn btn-primary btn-md"><i class="ace-icon fa fa-refresh refresh-icon"></i> Sync Users</a>
				</div>
			</div>
		</div>
	</div>
</div>