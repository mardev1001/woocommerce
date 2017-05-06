<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'handler.php' );

class AdminSlidersHandler extends HyunmooHandler {
	public function __construct() {
		add_filter( 'media_upload_tabs', array( $this, 'image_tabs' ), 10, 1 );
		add_filter('attachment_fields_to_edit', array( $this, 'media_action_button' ), 20, 2);
		add_action( 'wp_ajax_slide_image_thumbsize', array( $this, 'getImageThumbnail' ) );	//Ajax function used for media library thumbnail image
		
		add_action( 'wp_ajax_check_name', array( $this, 'checkSliderName' ) );	//Check slider name to prevent duplicates
	}
	
	public function getImageThumbnail() {
		global $hyunmoo;
		require_once( $hyunmoo['directory'] . DS . 'includes' . DS . 'media-functions.php' );
		
		$attachment = intval( $_POST['attachment'] );
		$src = getAttachmentURL( $attachment, 'image', 'thumbnail' );
		echo $src;
		die;
	}
	
	public function media_action_button( $form_fields, $post ) {
		$page = $_GET['referer'];
		if( $page != 'sliders' )
			return $form_fields;
			
		$send = "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add to Slider' ) . "' />";
 
		$form_fields['buttons'] = array('tr' => "\t\t<tr class='submit'><td></td><td class='savesend'>$send</td></tr>\n");
		return $form_fields;
	}
	
	public function image_tabs( $_default_tabs ) {
		$page = $_GET['referer'];
		if( $page != 'sliders' )
			return $_default_tabs;
		
		unset( $_default_tabs['type'] );
		unset( $_default_tabs['type_url'] );
			 
		return $_default_tabs;
	}
	
	public function checkSliderName() {
		global $wpdb;
		
		$name = $_POST['name'];
		$id = $_POST['sid'];
		$clean = strtolower( sanitize_file_name( $name ) );
		
		$sql = "SELECT `id` FROM {$wpdb->prefix}hyunmoo_records WHERE `name` = '$clean'";
		$duplicate = $wpdb->get_var( $sql );
		if( $duplicate > 0) {
			if( $id == 0 || $duplicate != $id )		//Exit if new slider page or duplicate slider name
				die( 'exists' );
		}
		exit;
	}
	
	public function processRequest() {
		$form = $_POST;
		if( !isset( $form['name'] ) )
			return false;
		$page = $_GET['page'];
		$action = $_GET['action'];
		switch( $action ) {
		case 'new':
			$this->saveNew( $form );
			break;
		case 'edit':
			$this->update( $form );
			break;
		default:
			break;
		}
	}
	public function saveNew( &$form ) {
		global $hyunmoo, $wpdb;
		
		$clean = mysql_real_escape_string( strtolower( sanitize_file_name( $form['name'] ) ) );
		$name = 'slider.' . $clean;
		
		$slides = $form['slides'];
		usort( $slides, array( $this, 'slideSort' ) );
		
		unset( $form['slides'] );
		$form['slides'] = $slides;
		Hyunmoo::setConfig( $name, $form, 'records' );
		
		//Database store section
		$title = mysql_real_escape_string( $form['title'] );
		$atts = array( 'modified' => date( 'm-d-Y H:i:s' ) );
		$atts = mysql_real_escape_string( json_encode( $atts ) );
		$sql = "INSERT INTO {$wpdb->prefix}hyunmoo_records (`id`, `name`, `title`, `type`, `attributes`, `status`) VALUES  (NULL, '$clean', '$title', 'slider', '$atts', 'public')";
		
		$wpdb->query( $sql );
		
		wp_redirect( get_admin_url() . 'admin.php?page=sliders' );
	}
	public function update( &$form ) {
		global $hyunmoo, $wpdb;
		
		$slider = intval( $_GET['id'] );
		$clean = mysql_real_escape_string( strtolower( sanitize_file_name( $form['name'] ) ) );
		$name = 'slider.' . $clean;
		$slides = $form['slides'];
		usort( $slides, array( $this, 'slideSort' ) );
			
		unset( $form['slides'] );	
		$form['slides'] = $slides;
		
		//Database / Config update section
		$slider_name = $wpdb->get_var( "SELECT `name` FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$slider'" );
		$conf = 'slider.' . $slider_name;
		Hyunmoo::deleteConfig( $conf, 'records' );
		Hyunmoo::setConfig( $name, $form, 'records' );
		
		$sql = "UPDATE {$wpdb->prefix}hyunmoo_records SET `name` = '$clean' WHERE `id` = '$slider'";
		$wpdb->query( $sql );
		
		wp_redirect( get_admin_url() . 'admin.php?page=sliders' );
	}
	public function slideSort( $a, $b ) {
		$order1 = $a['pos'];
		$order2 = $b['pos'];
		return ($order1 < $order2) ? -1 : 1;
	}
}
?>