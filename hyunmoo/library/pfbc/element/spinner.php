<?php
require_once('textbox.php');
class Element_Spinner extends Element_Textbox {
	protected $_attributes = array(
		"type" => "text",
		"role" => "spin");
	public $styles = array( 'jquery-ui-style' => "%cssurl%/jquery-ui.css" );
	public $javascripts = array( 
			'jquery-ui-core' => "https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js",
			'jquery-ui-spinner' => "",
			'jquery-ui-mousewheel' => "%jsurl%/mousewheel.js");
}
