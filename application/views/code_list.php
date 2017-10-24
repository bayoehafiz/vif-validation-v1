			<div class="main-content">
				<div class="main-content-inner">
					<?php $error = $this->session->flashdata('error'); ?>
						<?php if($error){ ?>
						<div class="alert alert-<?php echo $error ? 'danger' : 'info' ?> text-center">
							<?php echo $error ?>
						</div>
					<?php } ?>
					<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<div class="row">
								<div class="col-xs-6">
									<h1>
										<?= $title;?>
									</h1>
								</div>
								<div class="col-xs-6 text-right">
									<a href="<?php echo base_url().'code/add'?>" class="btn btn-success btn-white btn-round"><i class="fa fa-plus"></i> &nbsp;ADD CODE</a>
									<!--<a href="<?php echo base_url().'code/import-data'?>" class="btn btn-primary btn-md"><i class="fa fa-upload"></i> &nbsp;IMPORT</a>-->
								</div>
							</div>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="user" class="table table-striped simple-table">
											<thead>
												<tr>
													<th width="6%" class="text-center">No</th>
													<th>Code</th>
													<th>Description</th>
													<th>Created On</th>
													<th width="15%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$no = 1;
													foreach ($all as $value) {

												?>
												<tr>
													<td class="text-center"><?= $no;?></td>
													<td><a href="<?php echo base_url('code/edit/').$value['id'];?>"><?= $value['name'];?></a></td>
													<td><?= $value['description'];?></td>
													<td><?= date('d-M-Y H:i:s', $value['created_on']);?></td>
													<td>
														<a href="<?php echo base_url('code/edit/').$value['id'];?>" class="btn btn-warning btn-sm btn-white btn-round"><i class="fa fa-pencil"></i></a>
														<a href="<?php echo base_url('code/delete/').$value['id'];?>" class="btn btn-danger btn-sm btn-white btn-round" onclick="return confirm('Want to delete?')"><i class="fa fa-trash"></i></a>
													</td>
												</tr>

												<?php
													$no++;
													}
												?>


											</tbody>
										</table>
									</div><!-- /.span -->
								</div><!-- /.row -->
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
