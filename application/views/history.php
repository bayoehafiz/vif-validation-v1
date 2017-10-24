			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#"><?= $title;?></a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								<?= $title;?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<table id="form-submission-history" class="table table-striped simple-table">
											<thead>
												<tr>
													<th width="6%" class="text-center">No</th>
													<th>Branch</th>
													<th class="hidden-480">Subject</th>
													<th class="hidden-480">Created On</th>
													<th>
														<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
														Stage
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$no = 1;
													if(count($forms) > 0) {
														foreach($forms as $form) {
											    ?> 
													    <tr>
													    	<td class="text-center"><?= $no; ?></td>

															<td> <?php echo $form['branch_name']; ?> </td>
															<td class="hidden-480"> <a href="<?php echo base_url('history/view-form/'.$form['id']);?>"><?php echo $form['subject']; ?></a></td>
															<td><?php echo date('d-M-Y H:i:s', $form['create_date']); ?></td>
															<td class="hidden-480">
																
																<?php 
																	$stage = $form['stage']; 
																	if($stage==1) echo "<span class='label label-sm label-danger'>Administrator</span>";
																	else if($stage==2) echo "<span class='label label-sm label-danger'>Branch Admin</span>";
																	else if($stage==3 || $stage==9) echo "<span class='label label-sm label-warning'>Branch Head</span>";
																	else if($stage==4) echo "<span class='label label-sm label-success'>Central Accounting</span>";
																	else if($stage==5) echo "<span class='label label-sm label-primary'>Bu Funnyati</span>";
																	else if($stage==6) echo "<span clcentrass='label label-sm label-primary'>Andy</span>";
																	else if($stage==7) echo "<span class='label label-sm label-primary'>Wahyudi</span>";
																	else if($stage==8) echo "<span class='label label-sm label-primary'>Michael</span>";
																?>
															</td>
														</tr>
												<?php 
															$no++;
														}
													}
												?>
											</tbody>
										</table>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
