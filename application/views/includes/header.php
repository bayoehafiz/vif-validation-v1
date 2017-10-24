<?php defined('BASEPATH') OR exit('No direct script access allowed');


    // $sql = "select COUNT(N.id_notif) as hitung from notif N, form F where F.stage = ".$_SESSION['position']." and N.id_form = F.id and F.branch = ".$_SESSION['branch']."";

    // $notif = $this->Crud->specialQuery($sql);

    // $que = "select COUNT(N.id_notif) as hitung from notif N, form F where F.stage = ".$_SESSION['position']." and N.id_form = F.id";
    // $notifelse = $this->Crud->specialQuery($que);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>VIF Validation</title>
    <meta name="description" content="Common form elements and layouts" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- bootstrap & fontawesome -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300i,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300i,400" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/4.5.0/css/font-awesome.min.css');?>" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.custom.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker3.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-timepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/daterangepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-colorpicker.min.css');?>" />
    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fonts.googleapis.com.css');?>" />
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" class="ace-main-stylesheet" id="main-ace-style" />
    <!--[if lte IE 9]>
            <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/ace-skins.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/ace-rtl.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/fileuploader/src/jquery.fileuploader.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fileuploader-theme-thumbnails.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lightgallery.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/offline-theme-default.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loader.css');?>" />
    <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->
    <script src="<?php echo base_url('assets/js/ace-extra.min.js');?>"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    <!-- basic scripts -->
    <script src="<?php echo base_url('assets/chart/Chart.bundle.js');?>"></script>
    <script src="<?php echo base_url('assets/chart/utils.js');?>"></script>
    <!--[if !IE]> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lightgallery.min.js');?>"></script>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/cropit/0.5.1/jquery.cropit.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
        <script src="assets/js/jquery-1.11.3.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!-- page specific plugin scripts -->
    <!--[if lte IE 8]>
          <script src="assets/js/excanvas.min.js"></script>
        <![endif]-->
    <!--start jquery plugin script-->
    <!--end jquery plugin script-->
    <script src="<?php echo base_url('assets/js/jquery-ui.custom.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.ui.touch-punch.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/chosen.jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/spinbox.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-timepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/moment.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/daterangepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-colorpicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.knob.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/autosize.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.inputlimiter.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-tag.min.js');?>"></script>
    <!--<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="<?php //echo base_url('assets/js/jquery-1.12.4.js');?>"></script>-->
    <!-- ace scripts -->
    <script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>
    <script src="<?php echo base_url('assets/fileuploader/src/jquery.fileuploader.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.price_format.min.js')?>"></script>
     <!-- LazyLoad -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.4/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.4/jquery.lazy.plugins.min.js"></script>
    <!-- Highcharts -->
    <script src="//code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/modules/exporting.js"></script>
    <script src="//code.highcharts.com/modules/offline-exporting.js"></script>
</head>

<body class="no-skin">
    <div class="loader"></div>
    <!-- Flash messages -->
    <?php
        if ($this->session->flashdata('success_msg')) { ?>
        <script>
        swal({
            title: 'Success',
            text: "<?php echo $this->session->flashdata('success_msg'); ?>",
            confirmButtonColor: "#16a085",
            type: 'success'
        });
        </script>
        <?php } ?>
        <?php if ($this->session->flashdata('error_msg')) { ?>
        <script>
        swal({
            title: 'Error Happened...',
            text: "<?php echo $this->session->flashdata('error_msg'); ?>",
            confirmButtonColor: "#c0392b",
            type: 'error'
        });
        </script>
    <?php } ?>
    <!-- Flash Message EOF -->
    <div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top" style="background: #2980b9!important;">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-header pull-left">
                <a href="<?php echo base_url();?>" class="navbar-brand">
                    <small>
                        <i class="fa fa-paperclip"></i> VIF Validation
                    </small>
                </a>
                <!-- <span><small style="color:white;">ver 1.0.576</small></span> -->
            </div>
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    <?php if (isset($_SESSION['active_forms_total'])) { ?>
                    <li class="dropdown-modal" id="notifications">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="badge badge-important">
                                    <?php echo $_SESSION['active_forms_total']; ?>
                                </span>
                            </a>
                        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                <?php 
                                        if ($_SESSION['active_forms_total'] > 1) echo $_SESSION['active_forms_total'] . " forms";
                                        else echo "1 form";
                                    ?> need your review!
                            </li>
                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar navbar-red">
                                    <?php foreach ($_SESSION['active_forms_ids'] as $value) { ?>
                                    <li style="cursor: pointer;">
                                        <a href="<?php echo base_url('/all-forms/view/' . $value['id'])?>">
                                            <div class="clearfix">
                                                <span class="pull-left">
                                                    <i class="fa fa-paperclip"></i>
                                                    &nbsp;&nbsp;Form <strong><?php echo $value['subject'] ?></strong><br/><small><?php echo $value['branch_name'] ?></small>
                                                </span>
                                                <?php if ($value['status'] == 'Rejected') { ?>
                                                <span class="pull-right badge badge-danger"><small>REJECTED</small></span>
                                                <?php } ?>
                                                <?php if ($value['status'] == 'Waiting') { ?>
                                                <span class="pull-right badge badge-warning"><small>WAITING PAYMENT</small></span>
                                                <?php } ?>
                                                <?php if ($value['status'] == 'Paid') { ?>
                                                <span class="pull-right badge badge-success"><small>PAID</small></span>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?php echo $_SESSION['image']; ?>" alt="<?php echo $_SESSION['name'] ?>\'s Photo" />
                                <span class="user-info">
                                    <small>Hello,</small>
                                    <?php 
                                        if (!isset($_SESSION['name'])) {
                                            echo "No Name";
                                        } else {
                                            echo $_SESSION['name']; 
                                        }
                                    ?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="<?php echo base_url('profile'); ?>">
                                        <i class="ace-icon fa fa-user"></i>
                                        My Profile
                                    </a>
                            </li>
                            <?php if($_SESSION['position'] == 2 || $_SESSION['position'] == 3 || $_SESSION['position'] == 4) {?>
                            <li>
                                <a href="#" onclick="under_dev()">
                                        <i class="ace-icon fa fa-file-text"></i>
                                        My Submissions
                                    </a>
                            </li>
                            <?php } ?>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo base_url().'logout'?>">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        Logout
                                    </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.navbar-container -->
    </div>
    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
        try { ace.settings.loadState('main-container') } catch (e) {}
        </script>
        <div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed">
            <script type="text/javascript">
            try { ace.settings.loadState('sidebar') } catch (e) {}
            </script>
            <?php

                    function is_active($a, $url)
                    {
                        $found = FALSE; 

                        foreach ($url as $value) {
                            if ($a == $value) {
                                $found = TRUE;
                            } 
                        }


                        if (!empty($found)) {
                            echo "active";
                        }
                    }

                    $current_url = $this->uri->segment(1);

                ?>
                <ul class="nav nav-list">
                    <li class="<?php is_active($current_url, $url = ['']); ?>">
                        <a href="<?php echo base_url()?>">
                            <i class="menu-icon fa fa-tachometer"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <?php if (isset($_SESSION['position']) && $_SESSION['position'] == 2 || $_SESSION['position'] == 3 || $_SESSION['position'] == 4) { ?>
                    <li class="<?php is_active($current_url, $url = ['new-form']); ?>">
                        <a href="<?php echo base_url().'new-form'?>">
                            <i class="menu-icon fa fa-file-text"></i>
                            <span class="menu-text"> Submit A Form </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <?php }?>
                    <?php if ($_SESSION['email'] == 'developer@mss.co.id' || $_SESSION['position'] == 1 || $_SESSION['position'] == 2 || $_SESSION['position'] == 3 || $_SESSION['position'] == 4) {?>
                    <!-- <li class="<?php is_active($current_url, $url = ['history']); ?>">
                        <a href="<?php echo base_url().'history'?>">
                            <i class="menu-icon fa fa-history"></i>
                            <span class="menu-text"> History </span>
                        </a>
                        <b class="arrow"></b>
                    </li> -->
                    <?php }?>
                    <?php 
                    if (($_SESSION['position'] != 1)) {
                    ?>
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-desktop"></i>
                            <span class="menu-text">
                                Form List
                            </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu" style="<?php echo $this->uri->segment(1) == 'all-forms' || $this->uri->segment(1) == 'verified-forms' || $this->uri->segment(1) == 'rejected-forms' || $this->uri->segment(1) == 'unvalidated-forms' || $this->uri->segment(1) == 'unpaid-forms' || $this->uri->segment(1) == 'unclosed-forms' || $this->uri->segment(1) == 'paid-forms' || $this->uri->segment(1) == 'closed-forms' ? 'display:block':'display:none'; ?>">
                            <li class="<?php is_active($current_url, $url = ['all-forms']);?>">
                                <a href="<?php echo base_url().'all-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    All Forms
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php if($_SESSION['position'] != 2) { ?>
                            <li class="<?php is_active($current_url, $url = ['unvalidated-forms']); ?>">
                                <a href="<?php echo base_url().'unvalidated-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Waiting Validation
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php } ?>
                            <li class="<?php is_active($current_url, $url = ['verified-forms']); ?>">
                                <a href="<?php echo base_url().'verified-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Verified
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php is_active($current_url, $url = ['rejected-forms']); ?>">
                                <a href="<?php echo base_url().'rejected-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Rejected
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php if($_SESSION['branch'] == 1){?>
                            <li class="<?php is_active($current_url, $url = ['unpaid-forms']); ?>">
                                <a href="<?php echo base_url().'unpaid-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Waiting Payment
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <!--<li class="<?php //is_active($current_url, $url = ['paid-forms']); ?>">
                                <a href="<?php //echo base_url().'paid-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Paid
                                </a>
                                <b class="arrow"></b>
                            </li>-->
                            <li class="<?php is_active($current_url, $url = ['unclosed-forms']); ?>">
                                <a href="<?php echo base_url().'unclosed-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Paid
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php is_active($current_url, $url = ['closed-forms']); ?>">
                                <a href="<?php echo base_url().'closed-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Closed
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php 
                                }
                            ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php 
                    if (($_SESSION['position'] == 1)) {
                    ?>
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-desktop"></i>
                            <span class="menu-text">
                                Form List
                            </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu" style="<?php echo $this->uri->segment(1) == 'all-forms' || $this->uri->segment(1) == 'verified-forms' || $this->uri->segment(1) == 'rejected-forms' || $this->uri->segment(1) == 'unvalidated-forms' || $this->uri->segment(1) == 'unpaid-forms' || $this->uri->segment(1) == 'unclosed-forms' || $this->uri->segment(1) == 'paid-forms' || $this->uri->segment(1) == 'closed-forms' ? 'display:block':'display:none'; ?>">
                            <li class="<?php is_active($current_url, $url = ['all-forms']);?>">
                                <a href="<?php echo base_url().'all-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    All Forms
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php if($_SESSION['position'] != 2) { ?>
                            <li class="<?php is_active($current_url, $url = ['unvalidated-forms']); ?>">
                                <a href="<?php echo base_url().'unvalidated-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Waiting Validation
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php } ?>
                            <li class="<?php is_active($current_url, $url = ['verified-forms']); ?>">
                                <a href="<?php echo base_url().'verified-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Verified
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php is_active($current_url, $url = ['rejected-forms']); ?>">
                                <a href="<?php echo base_url().'rejected-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Rejected
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php if($_SESSION['branch']==1){?>
                            <li class="<?php is_active($current_url, $url = ['unpaid-forms']); ?>">
                                <a href="<?php echo base_url().'unpaid-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Waiting Payment
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <!--<li class="<?php //is_active($current_url, $url = ['paid-form']); ?>">
                                <a href="<?php //echo base_url().'paid-form'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Paid
                                </a>
                                <b class="arrow"></b>
                            </li>-->
                            <li class="<?php is_active($current_url, $url = ['unclosed-forms']); ?>">
                                <a href="<?php echo base_url().'unclosed-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Paid
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php is_active($current_url, $url = ['closed-forms']); ?>">
                                <a href="<?php echo base_url().'closed-forms'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Closed
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <?php 
                                }
                            ?>
                        </ul>
                    </li>
                    <li class="<?php is_active($current_url, $url = ['user']); ?>">
                        <a href="<?php echo base_url().'user'?>">
                                <i class="menu-icon fa fa-user"></i>
                                <span class="menu-text"> User Management</span>
                            </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="<?php is_active($current_url, $url = ['branch']); ?>">
                        <a href="<?php echo base_url().'branch'?>">
                                <i class="menu-icon fa fa-users"></i>
                                <span class="menu-text"> Branch Management</span>
                            </a>
                        <b class="arrow"></b>
                    </li>
                    <!--<li class="<?php is_active($current_url, $url = ['position']); ?>">
                        <a href="<?php echo base_url().'position'?>">
                                <i class="menu-icon fa fa-thumb-tack"></i>
                                <span class="menu-text"> Position</span>
                            </a>
                        <b class="arrow"></b>
                    </li>-->
                    <li class="<?php is_active($current_url, $url = ['code']); ?>">
                        <a href="<?php echo base_url().'code'?>">
                                <i class="menu-icon fa fa-tag"></i>
                                <span class="menu-text"> Code Management</span>
                            </a>
                        <b class="arrow"></b>
                    </li>
                    <?php
                    }
                    ?>
                        <!-- 
                    <li class="">
                        <a href="<?php echo base_url().'activities/'?>">
                            <i class="menu-icon fa fa-file-text"></i>
                            <span class="menu-text"> Recent Activities </span>
                        </a>

                        <b class="arrow"></b>
                    </li> -->
                        <!-- <li class="">
                        <a href="<?php //echo base_url().'submission/submissions'?>">
                            <i class="menu-icon fa fa-wpforms"></i>
                            <span class="menu-text"> Submission </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                    -->
                </ul>
                <!-- /.nav-list -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>
        </div>