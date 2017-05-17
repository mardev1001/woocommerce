<?php
require_once('textbox.php');
class Element_Color extends Element_Textbox {
	protected $_attributes = array(
		"type" => "text",
		"role" => "color",
		"data-pattern" => "[a-f0-9]{6}",
		"title" => "6-digit hexidecimal color (e.g. 000000)"
		);
	public $styles = array( 
			'jquery-ui-style' => "%cssurl%/jquery-ui.css",'custom-colorpicker-style' => "%cssurl%/colorpicker.css" );
	public $javascripts = array( 
			'jquery-ui-core' => "https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js",
			'custom-colorpicker-script' => "%jsurl%/colorpicker.js" );
}
