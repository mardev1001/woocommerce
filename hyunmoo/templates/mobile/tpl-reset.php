<div class="auth">
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
	<p><?php _e( 'Enter your new password below.', 'hyunmoo' ) ?></p>
	<input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />
	<div class="form-group">
		<label for="pass1">New Password: </label>
		<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
	</div>
	
	<div class="form-group">
		<label for="pass2">Confirm Password: </label>
		<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
	</div><div class="clear"></div>
	
	<div class="form-field">
		<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator', APP_TD); ?></div>
		<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', APP_TD ); ?></p>
	</div>
	
	<?php do_action('lostpassword_form'); ?>
	<button type="submit" name="lostpass" class="btn btn-primary skin-primary">Reset Password</button>
</form>
</div>