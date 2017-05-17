<?php
require_once('textbox.php');
class Element_DateTime extends Element_Textbox {
	protected $_attributes = array(
		"type" => "text",
		"role" => "datetime");
	public $styles = array( 
			'jquery-ui-style' => "%cssurl%/jquery-ui.css",
			'jquery-ui-timepicker-style' => "%cssurl%/jquery-ui-timepicker-addon.css"
			);
	public $javascripts = array( 
			'jquery-ui-core' => "https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js",
			'jquery-ui-slider' => "",
			'jquery-ui-timepicker' => "%jsurl%/jquery-ui-timepicker-addon.js",
			'jquery-ui-slider-touch' => "%jsurl%/jquery-ui-sliderAccess.js"
			);
}
