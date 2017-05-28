<div class="auth wrapper">
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
	<p><?php _e( 'Complete the fields below to register.', 'hyunmoo' ) ?></p>
	<div class="form-group">
		<label for="user_login">Username or Email: </label>
		<input type="text" class="form-control input-text" name="user_login" id="user_login" placeholder="Username" value="<?php if( isset( $_POST['user_login'] ) ) echo esc_attr( stripslashes( $_POST['user_login'] ) ); ?>" />
	</div><div class="clear"></div>
	<?php do_action('lostpassword_form'); ?>
	<button type="submit" name="lostpass" class="btn btn-primary skin-primary">Reset Password</button>
</form>
</div>