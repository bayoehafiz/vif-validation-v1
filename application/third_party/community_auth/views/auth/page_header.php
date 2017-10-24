<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Validation App</title>
	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/4.5.0/css/font-awesome.min.css');?>" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/fonts.googleapis.com.css');?>" />
	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />
	<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-rtl.min.css');?>" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.css" rel="stylesheet" />
	<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
	<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.js"></script>
	<?php
		// Add any javascripts
		if( isset( $javascripts ) )
		{
			foreach( $javascripts as $js )
			{
				echo '<script src="' . $js . '"></script>' . "\n";
			}
		}

		if( isset( $final_head ) )
		{
			echo $final_head;
		}
	?>
</head>
<body class="login-layout">
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
    <?php }

    if ($this->session->flashdata('info_msg')) { ?>
        <script>
        swal({
            title: 'Forbidden',
            text: "<?php echo $this->session->flashdata('info_msg'); ?>",
            confirmButtonColor: "#16a085",
            type: 'info'
        });
        </script>
    <?php }

    if ($this->session->flashdata('error_msg')) { ?>
        <script>
        swal({
            title: 'Error Happened...',
            text: "<?php echo $this->session->flashdata('error_msg'); ?>",
            confirmButtonColor: "#c0392b",
            type: 'error'
        });
        </script>
<?php }
/* End of file page_header.php */
/* Location: /community_auth/views/auth/page_header.php */