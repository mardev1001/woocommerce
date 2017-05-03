<?php

require_once( dirname( __FILE__ ) . DS . 'view.php' );

class HyunmooRecords extends HyunmooView {

	protected $_type;
	protected $_action;
	protected $_form;
	
	public function __construct( $type ) {
		$this->_type = HyunmooString::sanitize( $type );
		parent::__construct( 'records' );
		
		$this->_action = isset( $_GET['action'] ) ? $_GET['action'] : '';
	}
	
	public function showRecords() {
		parent::showRecords();
		switch( $this->_action ) {
			case 'new':
				$this->newRecord();
				break;
			case 'edit':
				$record = $_GET['id'];
				$this->editRecord( $record );
				break;
			case 'delete':
				$record = $_GET['id'];
				$this->deleteRecord( $record );
				break;
			default:
				$this->records();
				break;
		}
	}
	
	public function newRecord() {
	}
	
	public function editRecord( $record ) {
	}
	
	public function deleteRecord( $record ) {
		global $wpdb;
		
		$page = $_GET['page'];
		$slider_name = $wpdb->get_var( "SELECT `name` FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$record'" );
		$conf = $page . '.' . $slider_name;
		Hyunmoo::deleteConfig( $conf, 'records' );
		$sql = "DELETE FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$record'";
		$wpdb->query( $sql );
		wp_redirect( get_admin_url() . 'admin.php?page=sliders' );
	}
	
	public function records() {
	}
}