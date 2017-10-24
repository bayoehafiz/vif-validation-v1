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
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($response as $value) {
										?>
										<tr>
											<td class="text-center"><?= $no;?></td>
											<td><a href=""><?= $value['data']['details']['name'];?></a><br/><small class="text-muted"><?= $value['data']['uuid'];?></small></td>
											<td><?= $value['data']['details']['email'];?></td>
											<td class="text-success"><i class="fa fa-check"></i> Synced</td>
										</tr>

										<?php
												$no++;
											}
										?>

									</tbody>
								</table>
							</div><!-- /.span -->
						</div>
					</div>
					<? } else { ?>
					<div class="alert alert-danger"><?= $response; ?></div>
					<? } ?>
				</div>
				<div class="col-sm-112 col-md-12" style="margin-top: 10px;">
					Next things to do:<br/><br/>
					<a href="<?php echo base_url('connection')?>" class="btn btn-default btn-md"><i class="ace-icon fa fa-plug plug-icon"></i> Check Connection</a>
					<a href="<?php echo base_url('connection/list')?>" class="btn btn-primary btn-md"><i class="ace-icon fa fa-cloud-download cloud-download-icon"></i> Get Cloud Users</a>
				</div>
			</div>
		</div>
	</div>
</div>