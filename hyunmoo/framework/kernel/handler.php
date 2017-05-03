<?php

class HyunmooHandler {
	
	public function __construct() {
	}
	public function processRequest() {
		if( !isset( $_POST['formid'] ) )
			return;
		
		$form = $_POST;
		$form = apply_filters( 'hyunmoo-form-data', $form );
		$page = $_GET['page'];
		$name = $page . '.' . $form['formid'];
		Hyunmoo::setConfig( $name, $form );
	}
}
?>