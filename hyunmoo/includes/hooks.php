<?php
/** All hooks and functions for front-end use
*/
	global $theme;
	$options = Hyunmoo::getConfig( 'settings.advanced' );
	$adminbar = $options['adminbar'];
	if( !$adminbar )
		$adminbar = 'disable';
		
	add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
	add_action( 'wp_enqueue_scripts', array( $theme, 'print_styles' ), 99 );
	add_action( 'wp_enqueue_scripts', array( $theme, 'print_scripts' ) );
	if( $adminbar == 'disable' )
		add_filter( 'show_admin_bar', '__return_false' );	//Disable admin bar
	add_filter( 'woocommerce_product_additional_information_tab_title', 'custom_product_tab' );
	
	add_action( 'woocommerce_after_add_to_cart_button', 'add_checkout_button' );
	
	function add_checkout_button() {
		global $woocommerce;
?>
	<button onclick="window.location.href='<?php echo $woocommerce->cart->get_checkout_url(); ?>';return false;" class="skin-secondary tocheckout button alt"><?php echo __( 'Checkout', 'woocommerce' ); ?></button>
<?php
	}
	function child_manage_woocommerce_styles() {
		remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		if( class_exists( 'woocommerce' ) && is_checkout() ){
			wp_dequeue_script( 'wc-chosen' );
			wp_deregister_script( 'wc-checkout' );
			wp_register_script( 'wc-checkout', get_stylesheet_directory_uri() . '/js/checkout.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'wc-checkout' );
		}
		if( class_exists( 'woocommerce' ) && is_product() ){
			wp_deregister_script( 'wc-single-product' );
		//	wp_register_script( 'wc-single-product', get_bloginfo( 'stylesheet_directory' ) . '/js/single-product.js', array( 'jquery' ), false, true );
		//	wp_enqueue_script( 'wc-single-product' );
		}
	}
	function custom_product_tab( $key ) {
		return 'Extra';
	}

?>