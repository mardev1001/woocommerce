<?php
require_once('textbox.php');
class Element_Number extends Element_Textbox {
	protected $_attributes = array(
		"type" => "number",
		"data-pattern" => "^[0-9]$");
}
