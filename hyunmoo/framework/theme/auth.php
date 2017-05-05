<?php
//Customized Login/Registration/RecoverPassword/ResetPassword

abstract class HyunmooAuthBase {
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}
	
	abstract function get_action();
	
	public static function get_page_id( $template = '' ) {
		$args = array(
			'post_type'		=> 'page',
			'post_status'	=> 'publish',
			'meta_key'		=> '_wp_page_template',
			'meta_value'	=> $template,
			'posts_per_page' => 1,
			'suppress_filters' => true
		);
		$query = new WP_Query( $args );
		if( empty( $query->posts ) )
			$pid = 0;
		else
			$pid = $query->posts[0]->ID;
		
		return $pid;
	}
	public function init() {
		global $pagenow;

		if ( $pagenow != 'wp-login.php' )
			return false;
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'login';
		if( !in_array( $action, (array)$this->get_action() ) )
			return false;
		
		$url = call_user_func( array( $this, 'get_url' ), 'redirect' );
		
		wp_redirect( $url );
		exit;
	}
}

class HyunmooLogin extends HyunmooAuthBase {
	public function __construct() {
		parent::__construct();
		add_filter( 'login_url', array( $this, 'change_login_url' ), 10, 2 );
		add_action( 'hyunmoo-login', array( $this, 'process_login' ) );
	}
	public function get_action() {
		return 'login';
	}
	public function change_login_url( $url = '', $context = 'redirect' ) {
		$pid = self::get_page_id( 'tpl-login.php' );
		$args = wp_array_slice_assoc( $_GET, array( 'checkemail', 'registration', 'loggedout' ) );

		if ( $context == 'display' && $url != '' )
			$args['redirect_to'] = urlencode( $url );
		if( $pid )
			$permalink = get_permalink( $pid );
		else
			$permalink = site_url( 'wp-login.php' );
		
		return esc_url( add_query_arg( $args, $permalink ), null, 'redirect' );
	}
	public function get_url( $context = 'display' ) {
		$redirect_to = home_url( '/' );
		return $this->change_login_url( $redirect_to, $context );
	}
	public function process_login() {
		if( is_user_logged_in() )
			wp_safe_redirect( home_url( '/' ) );
	
		$error = new WP_Error;
		if( !isset( $_POST['login'] ) )
			return;
		if ( empty( $_POST['username'] ) )
			$error->add( 'empty_username', __( '<strong>ERROR</strong>: The username field is empty.', 'hyunmoo' ) );

		if ( empty( $_POST['password'] ) )
				$error->add( 'empty_password', __( '<strong>ERROR</strong>: The password field is empty.', 'hyunmoo' ) );

		if ( $error->get_error_code() ) {
			$GLOBALS['error'] = $error;
			return;
		}
		
		if ( isset( $_GET['loggedout'] ) && TRUE == $_GET['loggedout'] ) {
			$error->add( 'message', __('You are now logged out.', 'hyunmoo' ) );

		} elseif ( isset( $_GET['registration'] ) && 'disabled' == $_GET['registration'] )	{
			$error->add('registerdisabled', __( 'User registration is currently not allowed.', 'hyunmoo' ) );

		} elseif ( isset( $_GET['checkemail'] ) && 'confirm' == $_GET['checkemail'] ) {
			$error->add( 'message', __( 'Check your email for the confirmation link.', 'hyunmoo' ) );

		} elseif ( isset( $_GET['checkemail'] ) && 'newpass' == $_GET['checkemail'] ) {
			$error->add( 'message', __( 'Check your email for your new password.', 'hyunmoo' ) );

		} elseif ( isset( $_GET['checkemail'] ) && 'registered' == $_GET['checkemail'] ) {
			$error->add( 'message', __( 'Registration complete. Please check your e-mail.', 'hyunmoo' ) );
		} elseif ( isset($_GET['action']) && 'lostpassword' == $_GET['action'] && !empty($_GET['success'])) {
			$error->add( 'message', __( 'Your password has been reset. Please login.', 'hyunmoo' ) );
		}

		if ( isset( $_REQUEST['redirect_to'] ) )
			$redirect_to = $_REQUEST['redirect_to'];
		else
			$redirect_to = admin_url();

		if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
			$secure_cookie = false;
		else
			$secure_cookie = '';
		
		$creds = array();
		$creds['user_login'] = $_POST['username'];
		$creds['user_password'] = $_POST['password'];
		if( isset( $_POST['remember'] ) && $_POST['remember'] == 'yes' )
			$remember = true;
		else
			$remember = false;
		$creds['remember'] = $remember;
		$user = wp_signon( $creds, $secure_cookie );

		$redirect_to = apply_filters( 'login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user );

		if ( !is_wp_error( $user ) ) {
			wp_safe_redirect( $redirect_to );
			exit;
		}
		$GLOBALS['error'] = $user;
	}
}
class HyunmooRegister extends HyunmooAuthBase {
	public function __construct() {
		parent::__construct();
		add_filter( 'register', array( $this, 'change_register_url' ), 10, 1 );
		add_action( 'hyunmoo-register', array( $this, 'process_register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'addDecorations' ) );
	}
	public function get_action() {
		return 'register';
	}
	public function change_register_url( $url = '', $context = 'redirect' ) {
		if( !get_option( 'users_can_register' ) )
			return '';
		$pid = self::get_page_id( 'tpl-register.php' );

		$args = array();
		if( $context == 'display' && $url != '' )
			$args['redirect_to'] = urlencode( $url );
		if( $pid )
			$permalink = get_permalink( $pid );
		else
			$permalink = site_url( 'wp-login.php?action=register' );
		
		if( empty( $args ) )
			return $permalink;
		return esc_url( add_query_arg( $args, $permalink ), null, 'redirect' );
	}
	public function get_url( $context = 'display' ) {
		$redirect_to = home_url( '/' );
		return $this->change_register_url( $redirect_to, $context );
	}
	public function process_register() {
		if( is_user_logged_in() )
			wp_safe_redirect( home_url( '/' ) );
		
		if ( ! isset( $_POST['register'] ) || ! isset( $_POST['user_login'] ) || ! isset( $_POST['user_email'] ) )
			return;
		$error = $this->register_new_user();
		if ( !is_wp_error( $error ) ) {
			$url = wp_login_url();
			$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : $url;
			wp_safe_redirect( $redirect_to );
			exit();
		}
		$GLOBALS['error'] = $error;
	}
	public function register_new_user() {

		$posted = array();
		$errors = new WP_Error();
		$user_pass = wp_generate_password();
		
		$fields = array(
			'user_login',
			'user_email',
			'pass1',
			'pass2'
		);

		foreach ( $fields as $field ) {
			if ( isset( $_POST[$field] ) )
				$posted[$field] = stripslashes( trim( $_POST[$field] ) );
		}

		$sanitized_user_login = sanitize_user( $posted['user_login'] );
		$user_email = apply_filters( 'user_registration_email', $posted['user_email'] );

		// Check the username
		if ( $sanitized_user_login == '' ) {
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.', 'hyunmoo' ) );
		} elseif ( !validate_username( $posted['user_login'] ) ) {
			$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.', 'hyunmoo' ) );
			$sanitized_user_login = '';
		} elseif ( username_exists( $sanitized_user_login ) ) {
			$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.', 'hyunmoo' ) );
		}

		// Check the e-mail address
		if ( $user_email == '' ) {
			$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.', 'hyunmoo' ) );
		} elseif ( ! is_email( $user_email ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'hyunmoo' ) );
			$user_email = '';
		} elseif ( email_exists( $user_email ) ) {
			$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.', 'hyunmoo' ) );
		}

		do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

		if ( $errors->get_error_code() ) {
			$this->error = $errors;
			return $this->error;
		}

		if ( empty( $posted['pass1'] ) )	{
			$errors->add( 'empty_password', __( '<strong>ERROR</strong>: Please enter a password.', 'hyunmmoo' ) );
		} elseif ( empty( $posted['pass2'] ) ) {
			$errors->add( 'empty_password', __( '<strong>ERROR</strong>: Please enter the password twice.', 'hyunmoo' ) );
		} elseif ( !empty( $posted['pass1'] ) && $posted['pass1'] != $posted['pass2'] ) {
			$errors->add( 'password_mismatch', __( '<strong>ERROR</strong>: The passwords do not match.', 'hyunmoo' ) );
		}

		if ( $errors->get_error_code() ) {
			$this->error = $errors;
			return $this->error;
		}

		if ( isset( $posted['pass1'] ) )
			$user_pass = $posted['pass1'];

		// create the account and pass back the new user id
		$user_id = wp_create_user( $posted['user_login'], $user_pass, $posted['user_email'] );

		// something went wrong captain
		if ( !$user_id ) {
			$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#39;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'hyunmoo' ), get_option( 'admin_email' ) ) );

			if ( $errors->get_error_code() ) {
				$this->error = $errors;
				return $this->error;
			}
		}

		// set the WP login cookie (log the user in)
		$secure_cookie = is_ssl() ? true : false;
		wp_set_auth_cookie( $user_id, true, $secure_cookie );

		if ( isset( $_REQUEST['redirect_to'] ) )
			$success_redirect = $_REQUEST['redirect_to'];
		else
			$success_redirect = home_url( '/' );
		// redirect
		wp_redirect( $success_redirect );
		exit;
	}
	public function addDecorations() {
		wp_enqueue_script( 'password-strength-meter' );
		wp_enqueue_script( 'user-profile' );
	}
}
class HyunmooRecover extends HyunmooAuthBase {
	public function __construct() {
		parent::__construct();
		add_filter( 'lostpassword_url', array( $this, 'change_recover_url' ) );
		add_action( 'hyunmoo-recover', array( $this, 'process_recover' ) );
	}
	public function get_action() {
		return array( 'lostpassword', 'retrievepassword' );
	}
	public function change_recover_url( $context = 'redirect' ) {
		$pid = self::get_page_id( 'tpl-recover.php' );

		if( $pid )
			$url = get_permalink( $pid );
		else
			$url = site_url( 'wp-login.php' );
		if ( !empty( $_GET['action'] ) && empty( $_GET['key'] ) ) {
			$url = add_query_arg( 'action', $_GET['action'], $permalink );
		}
		return esc_url( $url , null, $context );
	}
	public function get_url( $context = '' ) {
		return $this->change_recover_url( $context );
	}
	function process_recover() {
		$error = new WP_Error();

		if ( isset( $_POST['user_login'] ) ) {
			$error = $this->retrieve_password();

			if ( !is_wp_error( $error ) ) {
				$pid = self::get_page_id( 'tpl-login.php' );
				if( $pid )
					$url = get_permalink( $pid );
				else
					$url = site_url( 'wp-login.php' );
				$url = add_query_arg( array( 'checkemail' => 'confirm' ), $url );
				wp_redirect( $url );
				exit();
			}

			if( isset( $_GET['invalidkeyerror'] ) && '1' == $_GET['invalidkeyerror'] ) {
				$error->add( 'error', __( 'Sorry, that key does not appear to be valid. Please try again.', 'hyunmoo' ) );
			}
			$GLOBALS['error'] = $error;
		}

		do_action('lost_password');
	}
	public function retrieve_password() {
		global $wpdb, $current_site;

		$error = new WP_Error();

		if ( empty( $_POST['user_login'] ) ) {
			$error->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or e-mail address.', 'hyunmoo' ) );
		} elseif ( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
			if ( empty( $user_data ) )
				$error->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no user registered with that email address.', 'hyunmoo' ) );
		} else {
			$login = trim( $_POST['user_login'] );
			$user_data = get_user_by( 'login', $login );
		}

		do_action('lostpassword_post');

		if ( $error->get_error_code() )
			return $error;

		if ( !$user_data ) {
			$error->add( 'invalidcombo', __( '<strong>ERROR</strong>: Invalid username or e-mail.', 'hyunmoo' ) );
			return $error;
		}

		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

		do_action( 'retreive_password', $user_login );  // Misspelled and deprecated
		do_action( 'retrieve_password', $user_login );

		$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

		if ( !$allow )
			return new WP_Error( 'no_password_reset', __( 'Password reset is not allowed for this user', 'hyunmoo' ) );
		else if ( is_wp_error( $allow ) )
			return $allow;

		$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );
		if ( empty( $key ) ) {
			// Generate something random for a key...
			$key = wp_generate_password( 20, false );
			do_action( 'retrieve_password_key', $user_login, $key );
			// Now insert the new md5 key into the db
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );
		}
		$message = __( 'Someone requested that the password be reset for the following account:', 'hyunmoo' ) . "\r\n\r\n";
		$message .= site_url() . "\r\n\r\n";
		$message .= sprintf( __( 'Username: %s', 'hyunmoo' ), $user_login ) . "\r\n\r\n";
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'hyunmoo' ) . "\r\n\r\n";
		$message .= __( 'To reset your password, visit the following address:', 'hyunmoo' ) . "\r\n\r\n";
		$url = HyunmooReset::get_reset_url();
		$url = add_query_arg( array( 'action' => 'rp', 'key' => $key, 'login' => rawurlencode( $user_login ) ), $url );
		$message .= '<' . $url . ">\r\n";

		if ( is_multisite() )
			$blogname = $GLOBALS['current_site']->site_name;
		else
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		$title = sprintf( __( '[%s] Password Reset', 'hyunmoo' ), $blogname );

		$title = apply_filters( 'retrieve_password_title', $title );
		$message = apply_filters( 'retrieve_password_message', $message, $key );

		if ( $message && !wp_mail( $user_email, $title, $message ) )
			wp_die( __( 'The e-mail could not be sent.', 'hyunmoo' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function...', 'hyunmoo' ) );

		return true;
	}
}
class HyunmooReset extends HyunmooAuthBase {
	public function __construct() {
		parent::__construct();
		add_action( 'hyunmoo-reset', array( $this, 'process_reset' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'addDecorations' ) );
	}
	public function get_action() {
		return array( 'resetpass', 'rp' );
	}
	public function addDecorations() {
		wp_enqueue_script( 'password-strength-meter' );
		wp_enqueue_script( 'user-profile' );
	}
	public function get_url( $context = '' ) {
		return self::get_reset_url( $context );
	}
	public function init() {
		$action = $_GET['action'];
		if( 'rp' != $action || empty( $_GET['key'] ) || empty( $_GET['login'] ) )
			return false;
		parent::init();
	}
	public function process_reset() {
		if( empty( $_GET['action'] ) || 'rp' != $_GET['action'] || empty( $_GET['key'] ) || empty( $_GET['login'] ) )
			return;

		$user = $this->check_password_reset_key( $_GET['key'], $_GET['login'] );

		if ( is_wp_error( $user ) ) {
			$pid = self::get_page_id( 'tpl-recover.php' );

			if( $pid )
				$permalink = get_permalink( $pid );
			else
				$permalink = site_url( 'wp-login.php' );
			$url = esc_url( $url , null, 'redirect' );
			
			$url = add_query_arg( array( 'action' => 'lostpassword', 'invalidkeyerror' => '1' ), $url );
			wp_redirect( $url );

			exit;
		} else {
			$error = $user;
		}

		if ( isset( $_POST['pass1'] ) && $_POST['pass1'] != $_POST['pass2'] ) {
			$error = new WP_Error( 'password_reset_mismatch', __( 'The passwords do not match.', 'hyunmoo' ) );
		}
		elseif ( isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
			$this->reset_password( $user, $_POST['pass1'] );
			$pid = self::get_page_id( 'tpl-login.php' );

			if( $pid )
				$permalink = get_permalink( $pid );
			else
				$permalink = site_url( 'wp-login.php' );
			$url = esc_url( $url , null, 'redirect' );
			$url = add_query_arg( array( 'action' => 'lostpassword', 'success' => '1' ), $url );
			wp_redirect( $url );
			exit;
		}
		$GLOBALS['error'] = $error;
	}
	public function check_password_reset_key( $key, $login ) {
		global $wpdb;

		$key = preg_replace( '/[^a-z0-9]/i', '', $key );

		if ( empty( $key ) || !is_string( $key ) )
			return new WP_Error( 'invalid_key', __( 'Invalid key', 'hyunmoo' ) );

		if ( empty( $login ) || !is_string( $login ) )
			return new WP_Error( 'invalid_key', __( 'Invalid key', 'hyunmoo' ));

		$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login));

		if ( empty( $user ) )
			return new WP_Error( 'invalid_key', __( 'Invalid key', 'hyunmoo' ) );

		return $user;
	}

	public function reset_password( $user, $new_pass ) {
		do_action( 'password_reset', $user, $new_pass );

		wp_set_password( $new_pass, $user->ID );

		wp_password_change_notification( $user );
	}

	public static function get_reset_url( $context = 'display' ) {
		$args = array();

		if ( !empty( $_GET['action'] ) && 'rp' == $_GET['action'] && !empty( $_GET['key'] ) && !empty( $_GET['login'] ) ) {
			$args = array( 'action' => $_GET['action'], 'key' => $_GET['key'], 'login' => $_GET['login'] );
		}

		if ( $pid = self::get_page_id() ) {
			$url = get_permalink( $pid );
			$url = add_query_arg( $args, $url );
			return esc_url( $url, null, $context );
		}

		return esc_url( add_query_arg( $args, site_url( 'wp-login.php' ) ), null, $context );
	}
}

class HyunmooAuth {
	public function __construct() {
		new HyunmooLogin();
		new HyunmooRegister();
		new HyunmooRecover();
		new HyunmooReset();
	}
}
?>