<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                </li>
                <li>
                    <a href="<?= base_url('profile'); ?>" style="text-transform: capitalize;">Profile</a>
                </li>
                <li>
                    Update Password
                </li>
                <li>
                    <span style="text-transform: capitalize;"><?= $_SESSION['name']; ?></span>
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
            <div class="row">
                <div class="col-xs-12">
                    <h2>
						<?= $title;?>
					</h2>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="col-sm-10 col-md-8 form-horizontal">
                    <?php echo form_open(); ?>
                        <?php $error = form_error('password', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 control-label" for="form-field-1"> New Password </label>
                            <div class="col-sm-8">
                                <input name="password" type="password" id="form-field-1-1" placeholder="Password" class="form-control" value="<?php set_value('password'); ?>"/>
                                <?php echo $error;?>
                            </div>
                        </div>

                        <?php $error = form_error('confirm_password', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 control-label" for="form-field-1">Confirm New Password </label>
                            <div class="col-sm-8">
                                <input name="confirm_password" type="password" id="form-field-1-1" placeholder="Confirm Password" class="form-control" value="<?php set_value('confirm_password'); ?>"/>
                                <?php echo $error;?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-md-offset-3">
                                <br/>
                                <a href="<?php echo base_url('profile')?>" class="btn btn-danger btn-lg btn-white btn-round">CANCEL</a>
                                <button type="submit" class="btn btn-success btn-lg btn-white btn-round"><i class="ace-icon fa fa-save"></i> SAVE</button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>