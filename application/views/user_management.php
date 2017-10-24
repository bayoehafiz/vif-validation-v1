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
                    <i class="ace-icon fa fa-user user-icon"></i>
                    <a href="#">
                        Users
                    </a>
                </li>
            </ul>
            <!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <div class="page-header">
                <div class="row">
                    <div class="col-xs-6">
                        <h1><?= $title;?></h1>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="<?php echo base_url().'user/new'?>" class="btn btn-white btn-round btn-info">
							<i class="fa fa-plus"></i> &nbsp;ADD USER
						</a>
                    </div>
                </div>
            </div>
            <!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="user" class="table table-striped simple-table">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">No</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Branch</th>
                                        <th>Position</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$no = 1;
										foreach ($users as $value) {
									?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $no;?>
                                            </td>
                                            <td>
                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <img class="pull-left" src="<?= $value['image'];?>">
                                                        <a class="user" href="<?php echo base_url('user/edit/').$value['user_id'];?>"> <?= $value['name'];?> </a>
                                                        <div class="time" style="font-weight: 100;">
                                                            <?= $value['user_id'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $value['email'];?>
                                            </td>
                                            <td>
                                                <?php echo $value['branch_name']; ?>
                                            </td>
                                            <td>
                                                <?php if($value['position'] == 1){ echo'<span class="text-danger"><i class="ace-icon fa fa-lock"></i> Administrator</span>'; }else{echo $value['position_name'];}?>
                                            </td>
                                            <td>
                                                <?= $value['last_login'];?>
                                            </td>
                                            <td>
                                                <?php if($value['email'] !== $_SESSION['email']) { ?>
                                                    <a href="<?php echo base_url('user/edit/').$value['user_id'];?>" class="btn btn-warning btn-sm btn-white btn-round"><i class="fa fa-pencil"></i></a>
                                                    <!-- <a href="<?php echo base_url('user/edit/permissions/').$value['user_id'];?>" class="btn btn-info btn-sm"><i class="fa fa-lock"></i></a> -->
                                                    <button class="btn btn-danger btn-sm btn-white btn-round" onclick="validate(this)" value="<?php echo $value['user_id']?>"><i class="fa fa-trash"></i></button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
											$no++;
										}
									?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.span -->
                    </div>
                    <!-- /.row -->
                    <!-- PAGE CONTENT ENDS -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.page-content -->
    </div>
</div>
<!-- /.main-content -->
<script>
function validate(a)
{
    var id = a.value;
    swal({
            title: "Delete this user?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#c0392b",
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            closeOnConfirm: false 
        }).then(function() {
            $(location).attr('href','<?php echo base_url()?>delete-user/'+id);
        });
}
 </script>
 <style type="text/css">
    .profile-activity a.user {
        color: #2980b9;
    }

    .profile-activity {
        border-bottom: 0px!important;
    }

    .profile-activity:first-child:hover {
        border-top-color: transparent!important;
    }

    .profile-activity:hover {
        background-color: transparent!important;
        border-left: transparent!important;
        border-right: transparent!important;
    }
 </style>