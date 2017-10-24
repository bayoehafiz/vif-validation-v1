<?php
	$route = $this->uri->segment(1);
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#" style="text-transform: capitalize;"><?= $this->uri->segment(1);?></a>
                </li>
            </ul>
            <!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <div class="page-header">
            	<?php $messages = $this->session->flashdata('error_msg'); 
					if($messages){ ?>
						<div class="alert alert-danger text-center">
							<?php echo $messages; ?>
						</div>
				<?php } ?>
                <div class="row">
                    <div class="col-xs-6">
                        <h1><?= $title;?></h1>
                        <br>
                       	<p style="padding-left: 8px;">Download .csv file example <a href="<?= base_url('assets/csv/example-'.$route.'.csv');?>">here</a></p>
                    </div>
                </div>
            </div>
            <!-- /.page-header -->
            <div class="row">
            	<?php echo form_open_multipart(); ?>
            	<div class="col-xs-12">
            		<br>
            		<div class="form-group">
            			<label class="col-xs-1">File :</label>
            			<div class="col-xs-8">
            				<input type="file" name="import_data" class="form-control" required="required">
            			</div>
            		</div>
            	</div>
            	<div class="col-xs-12">
            		<div class="form-group">
            			<br>
            			<br>
            			<input type="hidden" name="import_stage" value="<?= $route;?>">
            			<a href="<?php echo base_url($route)?>" class="btn btn-danger btn-md">Cancel</a>
						<button type="submit" name="submit" class="btn btn-success btn-md">Submit</button>
            		</div>
            	</div>
            	<?php echo form_close(); ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.page-content -->
    </div>
</div>
<!-- /.main-content -->
