<?php
require_once('textbox.php');
class Element_Phone extends Element_Textbox {
	protected $_attributes = array(
		"type" => "tel",
		"data-pattern" => "^\d{10}$");
}
