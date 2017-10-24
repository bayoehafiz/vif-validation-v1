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
							<div class="row">
                                <div class="col-xs-12 col-sm-6">
                                	<h1>Unvalidate Form</h1>
                                </div>
                                <div class="col-xs-12 col-sm-6">
								    <ul class="filter-by-currency">
								        <li>Filter By Currency :</li>
								        <li>
								            <select class="by_currency" style="width: 100%">
								                <option value="1" selected="selected">IDR</option>
								                <option value="2">USD</option>
								            </select>
								        </li>
								    </ul>
								</div>
							</div>
						</div><!-- /.page-header -->
							<?php //print_r($data);?>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="form-table" class="table table-hover simple-table">
											<thead>
												<tr>
													<th width="6%" class="text-center">No</th>
													<th>Branch</th>
													<th class="hidden-480">Subject</th>
													<?php
													if($_SESSION['branch']==1){
														echo '<th class="hidden-480">Verified On (Branch Head)</th>';
													}
													else{
														echo '<th class="hidden-480">Create On</th>';	
													}?>	
													<th>
														Stage
													</th>
													<th class="hidden-480">Amount</th>
												</tr>
											</thead>
											<tfoot>
									            <tr>
									                <th colspan="5" style="text-align:right">Total:</th>
									                <th id="total"></th>
									            </tr>
									            <tr>
									                <th colspan="5" style="text-align:right" id="grand-total-title">Grand Total:</th>
									                <th id="grand-total"></th>
									            </tr>
									        </tfoot>
											<tbody>
												
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
