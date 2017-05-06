<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'form.php' );
	
class AdminSettings extends HyunmooForm {
	public $pageTitle;
	public $menuTitle;
	
	public function __construct() {
		$this->xmlconfig = dirname( __FILE__ ) . DS . 'config.xml';
		$this->pageTitle = 'Hyunmoo Baby Settings';
		$this->menuTitle = 'Settings';
		
		parent::__construct();
		
		
	}
	public function addDecorations() {
		$path = get_template_directory_uri();
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'media-upload' ); // needed for image upload
		wp_enqueue_script( 'thickbox' ); // needed for image upload
		wp_enqueue_style( 'thickbox' ); // needed for image upload
		
		wp_enqueue_script( 'form-validator', $path . '/js/jquery-validate.js', array( 'jquery' ) );
		wp_enqueue_script( 'admin-scripts', $path . '/js/admin-scripts.js' );
		wp_enqueue_script( 'tooltip-script', $path . '/js/jquery.tipsy.js' );
		
		wp_enqueue_style( 'hyunmoo-admin-style', $path . '/css/admin.css' );
		wp_enqueue_style( 'hyunmoo-form-style', $path . '/css/admin-form.css' );
		wp_enqueue_style( 'tooltip-style', $path . '/css/tipsy.css' );
	}
}