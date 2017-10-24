<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                </li>
                <li>
                    Profile
                </li>
                <li>
                    <span style="text-transform: capitalize;"><?= $profile['name']; ?></span>
                </li>
            </ul>
            <!-- /.breadcrumb -->
        </div>
        <div class="page-content">
        	<?php if ($this->session->flashdata('flash_messages')) { ?>
			    <?php $flashMessages = $this->session->flashdata('flash_messages'); ?>
			        <?php foreach ($flashMessages as $errorType => $messages) { ?>
			            <?php foreach ($messages as $message) { ?>
			                <div class="alert alert-<?php echo $errorType; ?>"> <?= $message; ?> </div>
			        <?php } ?>
			    <?php } ?>
			<?php } ?>
			<?php echo form_open();
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <h2>
						<?= $title;?>
						<div class="pull-right">
                            <a href="<?php echo base_url('/')?>" class="btn btn-danger btn-white btn-round"><i class="fa fa-arrow-left"></i> BACK</a>
							<a href="<?php echo base_url('profile/update-password');?>" class="btn btn-success btn-white btn-round"><i class="ace-icon fa fa-lock"></i> CHANGE PASSWORD</a>
							<a href="<?php echo base_url('profile/update-photo');?>" class="btn btn-success btn-white btn-round"><i class="ace-icon fa fa-photo"></i> UPDATE PHOTO</a>
						</div>
					</h2>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="col-sm-10 col-md-8 form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label" for="form-field-1"> User ID</label>
                        <div class="col-sm-9 text-muted">
                            <span class="label label-info"><?= $profile['uuid'] ?></span>
                        </div>
                    </div>
                    <?php $error = form_error('name', '<p class="text-danger">', '</p>');?>
                    <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
                        <label class="col-sm-2 control-label" for="form-field-1"> Name</label>
                        <div class="col-sm-9">
                        <?php 
                        if($_SESSION['position']==1){?>
                            <input name="name" type="text" id="form-field-1-1" class="form-control" value="<?php echo $profile['name']; ?>"/>
                        <?php } else{?>
                            <input name="name" type="text" id="form-field-1-1" class="form-control" value="<?php echo $profile['name']; ?>" readonly/>
                        <?php }
                        ?>
                            <?php echo $error;?>
                        </div>
                    </div>
                    <?php $error = form_error('email', '<p class="text-danger">', '</p>');?>
                    <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
                        <label class="col-sm-2 control-label" for="form-field-1"> Email</label>
                        <div class="col-sm-9">
                            <input name="email" type="email" id="form-field-1-1" class="form-control" value="<?php echo $profile['email'];?>" readonly/>
                            <?php echo $error;?>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group row">
                                <div class="col-md-6 col-md-offset-2">
                                    <br/>
                                    <a href="<?php echo base_url('/')?>" class="btn btn-default btn-md">Cancel</a>
                                    <?php 
                                    if($_SESSION['position']==1){
                                        echo '<button type="submit" class="btn btn-success btn-md">Update</button>';
                                    }
                                    
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>