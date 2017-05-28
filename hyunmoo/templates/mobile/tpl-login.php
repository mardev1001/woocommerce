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
	<div class="form-group">
		<label for="username">Username: </label>
		<input type="text" class="form-control input-text" name="username" id="username" placeholder="Username" value="<?php if( isset( $_POST['username'] ) ) echo esc_attr( stripslashes( $_POST['username'] ) ); ?>" />
	</div>
	<div class="form-group">
		<label for="password">Password: </label>
		<input type="password" class="form-control input-text" name="password" id="password" placeholder="Password" value="<?php if( isset( $_POST['password'] ) ) echo esc_attr( stripslashes( $_POST['password'] ) ); ?>" />
	</div>
	<div class="checkbox">
		<input type="checkbox" id="rememberme" name="rememberme" checked="checked" value="forever" class="input-checkbox">
		<i class="fa checkbox"></i><label for="rememberme" class="checkbox">Remember Me</label>
	</div>
	<?php do_action( 'login_form' ); ?>
	<button type="submit" name="login" class="btn btn-primary skin-primary">Login &raquo;</button>
	<a href="<?php wp_register(); ?>"><button name="register" class="btn btn-primary skin-primary">Register</button></a>
</form>
</div>