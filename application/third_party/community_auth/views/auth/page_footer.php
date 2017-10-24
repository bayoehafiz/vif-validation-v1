	<style type="text/css">
		.form-inline {
		  @media (min-width: @screen-sm-min) {
			.form-group {
			  display: inline-block;
			  margin-bottom: 0;
			  vertical-align: middle;
			}

			.form-control {
			  display: inline-block;
			  width: auto;
			  vertical-align: middle;
			}

			.input-group > .form-control {
			  width: 100%;
			}
		  }
		}

		.alert {
			text-align: center;
		}
	</style>
	<script src="<?php echo base_url('assets/js/jquery-2.1.4.min.js');?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<!-- <![endif]-->
	<!--[if IE]>
			<script src="assets/js/jquery-1.11.3.min.js"></script>
			<![endif]-->
	<script type="text/javascript">
	if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>
	<!-- inline scripts related to this page -->
	<script type="text/javascript">
	jQuery(function($) {
		$(document).on('click', '.toolbar a[data-target]', function(e) {
			e.preventDefault();
			var target = $(this).data('target');
			$('.widget-box.visible').removeClass('visible'); //hide others
			$(target).addClass('visible'); //show target
		});
	});

	//you don't need this, just used for changing background
	jQuery(function($) {
		$('#btn-login-dark').on('click', function(e) {
			$('body').attr('class', 'login-layout');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'blue');

			e.preventDefault();
		});
		$('#btn-login-light').on('click', function(e) {
			$('body').attr('class', 'login-layout light-login');
			$('#id-text2').attr('class', 'grey');
			$('#id-company-text').attr('class', 'blue');

			e.preventDefault();
		});
		$('#btn-login-blur').on('click', function(e) {
			$('body').attr('class', 'login-layout blur-login');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'light-blue');

			e.preventDefault();
		});

	});
	</script>
</body>

</html>
<?php

/* End of file page_footer.php */
/* Location: /community_auth/views/examples/page_footer.php */