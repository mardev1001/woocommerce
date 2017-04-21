<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Direct access to this page is not allowed!' );
}
//Pre-defined constants
define( "DS" , DIRECTORY_SEPARATOR );
define( "_HMEXEC", 1 );		//For security reasons, prevent any Hijacking attempts.
define( 'WOOCOMMERCE_USE_CSS', false );	//Disable default WooCommerce Style

//Additional Plugins
require_once dirname( __FILE__ ) . DS . 'library' . DS . 'class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'hyunmoo_extra_plugins' );
//Framework
require_once dirname( __FILE__ ) . DS . 'framework' . DS . 'load.php';

function hyunmoo_extra_plugins() {
	$plugins = array(
		array(
			'name' 		=> 'WP Retina 2x',
			'slug' 		=> 'wp-retina-2x',
			'required' 	=> false,
		),
		array(
			'name'     				=> 'WooCommerce Address Check',
			'slug'     				=> 'wc-addresscheck',
			'source'   				=> get_stylesheet_directory() . '/library/wc-addresscheck.zip', 
			'required' 				=> false,
			'version' 				=> '2.5',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false
		)
	);
	
	$config = array(
		'domain'       		=> 'hyunmoo',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'hyunmoo' ),
			'menu_title'                       			=> __( 'Install Plugins', 'hyunmoo' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'hyunmoo' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'hyunmoo' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'hyunmoo' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'hyunmoo' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'hyunmoo' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
function buildTables() {
	global $wpdb;
		
	$collate = '';

	if ( $wpdb->has_cap( 'collation' ) ) {
		if( ! empty($wpdb->charset ) )
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		if( ! empty($wpdb->collate ) )
			$collate .= " COLLATE $wpdb->collate";
	}
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
	$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}hyunmoo_records ( `id` bigint(20) NOT NULL auto_increment, `name` VARCHAR(100) NOT NULL, `title` VARCHAR(200) NOT NULL, `type` VARCHAR(30) NOT NULL, `attributes` TEXT, `status` VARCHAR(20) NOT NULL DEFAULT 'public', PRIMARY KEY (`id`) ) $collate";

	dbDelta( $sql );
}
function makePages() {
	$templates = array( 'Login' => 'tpl-login.php', 'Register' => 'tpl-register.php', 'Recover Password' => 'tpl-recover.php', 'Reset Password' => 'tpl-reset.php' );
	foreach( $templates as $title => $template ) {
		$args = array(
			'post_type'		=> 'page',
			'post_status'	=> 'publish',
			'meta_key'		=> '_wp_page_template',
			'meta_value'	=> $template,
			'posts_per_page' => 1,
			'suppress_filters' => true
		);
		$query = new WP_Query( $args );
		if( !empty ( $query->posts) )	continue;
		
		$page_id = wp_insert_post( array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_title' => $title
		) );
		add_post_meta( $page_id, '_wp_page_template', $template );
	}
	
}

function hyunmoo_activate() {
	if( !get_option( 'hyunmoo_key' ) ) {
		$key = md5( rand( 1, 99999999) * time() );
		add_option( 'hyunmoo_key', $key );
	}
	
	buildTables();
	makePages();
}
add_action( 'after_switch_theme', 'hyunmoo_activate' );

function hyunmoo_setup() {
	global $wp_version;
	if ( !version_compare( $wp_version, '3.1', '>=' ) )
		wp_die( 'Hyunmoo theme requires at least Wordpress version 3.0' );
	
	
	/*
	 * Create random key for encryption/decryption of configuration files.
	 * Do not change this once it is stored in database.
	 * Otherwise, admin forms will not be loaded.
	*/
	
	/*
	 * Makes Hyunmoo available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Hyunmoo, use a find and replace
	 * to change 'hyunmoo' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hyunmoo', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// this theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'classic-large', 650, 650, true );
	add_image_size( 'classic-small', 315, 315,true );
	add_image_size( 'grid-large', 440, 440, true );
	add_image_size( 'grid-small', 286, 286, true );
	add_image_size( 'compact', 210, 9999 );
	add_image_size( 'search-thumb', 24, 24, true );
	add_image_size( 'postimage-large-nosidebar', 980, 300,true );
	add_image_size( 'postimage-small-nosidebar', 485, 190,true );
	add_image_size( 'postimage-large', 730, 300,true );
	add_image_size( 'postimage-small', 360, 190,true );
	add_image_size( 'postimage-grid', 366, 9999 );
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Adjust markup on all woocommerce pages
/*	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_before_main_content', 'woocommerce_mystile_before_content', 10);
	add_action('woocommerce_after_main_content', 'woocommerce_mystile_after_content', 20);
	*/
}
add_action( 'after_setup_theme', 'hyunmoo_setup' );

//Disabled traditional approaches - Don't edit these lines
function test() {
	if ( ! isset( $content_width ) ) $content_width = 900;
	wp_link_pages();
}
