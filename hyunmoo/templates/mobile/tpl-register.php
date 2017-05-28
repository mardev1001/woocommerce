<div class="auth">
<?php if( get_option( 'users_can_register' ) ) : ?>
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
		<label for="user_login">Username: </label>
		<input type="text" class="form-control input-text" name="user_login" id="user_login" placeholder="Username" value="<?php if( isset( $_POST['user_login'] ) ) echo esc_attr( stripslashes( $_POST['user_login'] ) ); ?>" />
	</div>
	<div class="form-group">
		<label for="user_email">Email: </label>
		<input type="text" class="form-control input-text" name="user_email" id="user_email" placeholder="Email" value="<?php if( isset( $_POST['user_email'] ) ) echo esc_attr( stripslashes( $_POST['user_email'] ) ); ?>" />
	</div>
	<div class="form-field">
		<label for="pass1">Password: </label>
		<input type="password" class="form-control input-text" name="pass1" id="pass1" value="" autocomplete="off" />
	</div>
	<div class="form-field">
		<label for="pass2">Password Again: </label>
		<input type="password" class="form-control input-text" name="pass2" id="pass2" value="" autocomplete="off" />
	</div>
	<div class="form-field">
		<div id="pass-strength-result" class="hide-if-no-js"><?php _e( 'Strength indicator', 'hyunmoo' ); ?></div>
		<p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', 'hyunmoo' ); ?></p>
	</div>
	<?php do_action( 'register_form' ); ?>
	<button type="submit" name="register" class="btn btn-primary skin-primary">Register &raquo;</button>
</form>
<?php else : ?>
<div class="alert alert-danger">
	Sorry, user registration is currently not allowed.<br>
	However you can still login <a href="<?php echo wp_login_url(); ?>">here.</a>
</div>
<?php endif; ?>
</div>