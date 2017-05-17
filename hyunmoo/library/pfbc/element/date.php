<?php
require_once('textbox.php');
class Element_Date extends Element_Textbox {
	protected $_attributes = array(
		"type" => "text",
		"role" => "date",
		"autocomplete" => "off"
	);
	public $styles = array( 'jquery-ui-style' => "%cssurl%/jquery-ui.css" );
	public $javascripts = array( 
		'jquery-ui-core' => "https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js",
		'jquery-ui-datepicker' => "");
	
    public function jQueryDocumentReady() {
        parent::jQueryDocumentReady();
        echo 'jQuery("#', $this->_attributes["id"], '").datepicker(', $this->jQueryOptions(), ');';
    }
}
