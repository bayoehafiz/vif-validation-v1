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
                    Update Photo
                </li>
                <li>
                    <span style="text-transform: capitalize;"><?= $_SESSION['name']; ?></span>
                </li>
            </ul>
            <!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <?php if (isset($error)) { ?>
                <div class="alert alert-error">
                    <?= $error; ?>
                </div>
            <?php } ?>
            <div class="row">
            <?php echo form_open(); ?>
                <div class="col-xs-12">
                    <h2>
                        <?= $title;?>
                    </h2>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="col-sm-12 col-md-6">
                    <input type="text" id="hidden_base64" name="hidden_base64" hidden>
                    <div class="image-editor">
                        <div style="margin-bottom: 25px;">
                            <label class="btn btn-primary btn-file btn-white btn-round">
                                <i class="fa fa-search"></i> Browse Photo
                                <input name="photo" type="file" class="cropit-image-input" style="display: none;">
                            </label>
                        </div>
                        <!-- <input type="file" class="cropit-image-input"><br/><br/> -->
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="cropit-preview"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="range" class="cropit-image-zoom-input" style="width: 250px!important; display: inline-block;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <br/>
                                <a href="<?php echo base_url('profile')?>" class="btn btn-danger btn-lg btn-white btn-round">CANCEL</a>
                                <button type="submit" class="upload btn btn-success btn-lg btn-white btn-round"><i class="ace-icon fa fa-upload"></i> UPLOAD</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>How to upload my photo?</h4></div>
                        <div class="panel-body">
                            1. Click on the <span class="label label-primary"><i class="fa fa-search"></i> Browse Photo</span> button to find your photo file<br/>
                            2. You may drag on its preview to get your photo positioned<br/>
                            3. Or, you can zoom it using the slider<br/>
                            4. Hit <span class="label label-success">SAVE</span> button once you finished
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style type="text/css">
.image-editor {
    text-align: center;
}

.cropit-preview {
    background-color: #f8f8f8;
    background-size: cover;
    border: 5px solid #ccc;
    border-radius: 50%;
    margin-top: 7px;
    width: 250px;
    height: 250px;
    display: inline-block;
}

.cropit-preview-image-container {
    cursor: move;
    border-radius: 50%;
    overflow: hidden;
    z-index: 99999;
}

.cropit-preview-background {
    opacity: .2;
    cursor: auto;
}

.image-size-label {
    margin-top: 10px;
}

button {
    margin-top: 10px;
}

.btn-file {
    /*position: relative;*/
    overflow: hidden;
}

.btn-file input[type=file] {
    /*position: absolute;*/
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>