<?php
require_once('textbox.php');
class Element_Email extends Element_Textbox {
	protected $_attributes = array(
		"type" => "email",
		"data-pattern" => '^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$');
}
