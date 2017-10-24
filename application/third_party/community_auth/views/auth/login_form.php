<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Login Form View
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

if( ! isset( $on_hold_message ) )
{
	if( isset( $login_error_mesg ) )
	{
		echo '
			<div class="alert alert-danger">
				<p>
					INVALID EMAIL ADDRESS OR PASSWORD!
				</p>
				<p>
					Warning: You have tried ' . $this->authentication->login_errors_count . ' out of maximum ' . config_item('max_allowed_attempts') . ' login attempts
				</p>
			</div>
		';
	}

	if( $this->input->get(AUTH_LOGOUT_PARAM) )
	{
		echo '
			<div class="alert alert-success">
				<p>
					You have successfully logged out.
				</p>
			</div>
		';
	}

	echo form_open( $login_url, ['class' => 'std-form'] );
?>
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<h1>
							<div class="center">
								<span class="red"><img src="<?php echo base_url('assets/images/vif.png'); ?>"></span>
							</div>
						</h1>
						<div class="space-6"></div>
						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border row">
								<div class="widget-body col-lg-12">
									<div class="widget-main loader-container input-group" style="padding: 20px!important;">
											<div class="space-6"></div>
											<input type="text" name="login_string" id="login_string" placeholder="Your Email Address" class="form_input form-control" autocomplete="off" maxlength="255" style="margin-bottom: 1em;" />
											<input type="password" name="login_pass" id="login_pass" placeholder="Your Password" class="form_input password form-control" <?php 
												if( config_item('max_chars_for_password') > 0 )
													echo 'maxlength="' . config_item('max_chars_for_password') . '"'; 
											?> autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');"  style="margin-bottom: 1em;"/>
											<div>
												<?php
													if( config_item('allow_remember_me') )
													{
												?>
													<br />
													<label for="remember_me" class="form_label">Remember Me</label>
													<input type="checkbox" id="remember_me" name="remember_me" value="yes" />
												<?php
													}
												?>
											</div>
											<div class="space"></div>
											<div class="clearfix">
												<button type="submit" class="btn btn-info btn-block" value="Login" id="submit_button">
													<i class="ace-icon fa fa-key"></i>
													<span class="bigger-110">LOG IN</span>
												</button>
											</div>
											<!-- <div class="space"></div>
												<p>
													<?php
														$link_protocol = USE_SSL ? 'https' : NULL;
													?>
													<small><a href="<?php echo site_url('recover', $link_protocol); ?>">
														Can't access your account ?
													</a></small>
												</p> -->
									</div>
									<!-- /.widget-main -->
								</div>
								<!-- /.widget-body -->
							</div>
							<!-- /.login-box -->
							<h4 class="blue" id="id-company-text" align="center" style="font-size: 12px;">&copy; 2017 <a href="https://www.mss.co.id" target="_blank">PT. Menara Sinar Semesta</a></h4>
						</div>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.main-content -->
		</div>
	  </div>
	<!-- Login form EOF -->
</form>
<?php
	}
	else
	{
		// EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
		echo '
			<div class="alert alert-danger">
				<p>
					MAXIMUM LOGIN ATTEMPTS REACHED!
				</p>
				<p>
					You have exceeded the maximum number of failed login attempts that this website will allow.
					Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
				</p>
				<p>
					Please contact Administrator if you require assistance gaining access to your account.
				</p>
			</div>
		';
	}

/* End of file login_form.php */
/* Location: /community_auth/views/auth/login_form.php */ 