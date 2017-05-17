<?php
require_once(dirname(dirname(__FILE__)) . '/element.php');
class Element_HTML extends Element {
//	public function __construct($valeu) {
//		$properties = array("value" => $value);
//		parent::__construct("", "", $properties);
//	}

	public function render() { 
		echo $this->_attributes["value"];
	}
}
