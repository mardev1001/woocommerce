<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'handler.php' );

class AdminInquiryHandler extends HyunmooHandler {
	public function __construct() {
		add_action( 'wp_ajax_get_inquiry', array( $this, 'getInquiry' ) );
		add_action( 'wp_ajax_reply', array( $this, 'reply' ) );
		add_action( 'wp_ajax_mark_solved', array( $this, 'markSolved' ) );
		add_action( 'wp_ajax_mark_unsolved', array( $this, 'markUnsolved' ) );
		add_action( 'wp_ajax_remove', array( $this, 'remove' ) );
	}
	
	public function getInquiry() {
		$status = trim( $_POST['filter'] );
		$limit = intval( $_POST['howmany'] );
		$offset = intval( $_POST['offset'] );
		
		global $wpdb;
		if( $status == '' ) {
			$sql = "SELECT * FROM {$wpdb->prefix}hyunmoo_records WHERE `type` = 'inquiry' ORDER BY `id` DESC LIMIT $offset, $limit";
		}
		else {
			$sql = "SELECT * FROM {$wpdb->prefix}hyunmoo_records WHERE `status` = '$status' AND `type` = 'inquiry' ORDER BY `id` DESC LIMIT $offset, $limit";
		}
		$rows = $wpdb->get_results( $sql );
		$records = array();
		foreach( $rows as $row ) {
			$record = array();
			$data = Hyunmoo::getConfig( 'inquiry.' . $row->name, 'records' );
			if( $data == false ) {
				$sql = "DELETE FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '{$row->id}'";
				$wpdb->query( $sql );
				continue;
			}
			foreach( $data as $key => $field )
				$record[$key] = $field;
				
			$atts = json_decode( $row->attributes );
			foreach( $atts as $key => $value )
				$record[$key] = $value;
			$record['id'] = $row->id;
			$record['status'] = $row->status;
			$records[] = $record;
		}
		echo json_encode( $records );
		die;
	}
	public function reply() {
		$to = $_POST['to'];
		$subject = $_POST['subject'];
		$body = $_POST['body'];
		
		$sent = wp_mail( $to, $subject, $body );
		return $sent;
		die;
	}
	public function markSolved() {
		global $wpdb;
		
		$id = intval( $_POST['id'] );
		$sql = "UPDATE {$wpdb->prefix}hyunmoo_records SET `status` = 'solved' WHERE `id` = '$id'";
		$wpdb->query( $sql );
		return true;
		die;
	}
	public function markUnsolved() {
		global $wpdb;
		
		$id = intval( $_POST['id'] );
		$sql = "UPDATE {$wpdb->prefix}hyunmoo_records SET `status` = 'unsolved' WHERE `id` = '$id'";
		$wpdb->query( $sql );
		return true;
		die;
	}
	public function remove() {
		global $wpdb;
		
		$id = intval( $_POST['id'] );
		$sql = "SELECT `name` FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$id'";
		$name = $wpdb->get_var( $sql );
		Hyunmoo::deleteConfig( 'inquiry.' . $name, 'records' );
	
		$sql = "DELETE FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$id'";
		$wpdb->query( $sql );
		
		return true;
		die;
	}
	public function processRequest() {
		
	}
	
}
?>