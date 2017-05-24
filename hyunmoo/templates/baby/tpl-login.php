<div class="auth wrapper">
<h4>Login</h4>
<p><?php _e( 'Please complete the fields below to login to your account.', 'hyunmoo' );?></p>
<form role="form" method="post">
	<?php
		global $error;
		if( is_wp_error( $error ) ) {
			echo '<div class="alert alert-danger">';
			foreach( $error->errors as $e )
				echo '<p class="text-danger">' . $e[0] . '</p>';
			echo '</div>';
		}
	?>
	<div class="form-group">
		<label for="username">Username: </label>
		<input type="text" class="form-control input-text" name="username" id="username" placeholder="Username" value="<?php if( isset( $_POST['username'] ) ) echo esc_attr( stripslashes( $_POST['username'] ) ); ?>" />
	</div>
	<div class="form-group last">
		<label for="password">Password: </label>
		<input type="password" class="form-control input-text" name="password" id="password" placeholder="Password" value="<?php if( isset( $_POST['password'] ) ) echo esc_attr( stripslashes( $_POST['password'] ) ); ?>" />
	</div><div class="clear"></div>
	<div class="authlinks"><div class="checkbox">
		<input type="checkbox" class="input-checkbox" id="rememberme" name="rememberme" checked="checked" value="forever" />
		<i class="fa checkbox"></i><label class="checkbox-inline checkbox skin-secondary-text" for="rememberme">Remember Me</label>
	</div>
	<?php do_action( 'login_form' ); ?>
	<a class="skin-secondary-text" href="<?php echo wp_lostpassword_url(); ?>">Lost password</a><br><a class="skin-secondary-text" href="<?php wp_register( '', '' ); ?>">Register</a></div><div class="authlinks" align="right">
	<?php
		if ( isset( $_REQUEST['redirect_to'] ) ) {
			$redirect = $_REQUEST['redirect_to'];
		} else {
			$redirect = admin_url();
		}
	?>
	<input type="hidden" name="redirect_to" value="<?php echo $redirect ?>" />
	<input type="hidden" name="testcookie" value="1" />
	<button type="submit" name="login" class="btn btn-primary skin-primary">Login &raquo;</button>
	</div><div class="clear"></div>
	<br><br>
</form>
</div>