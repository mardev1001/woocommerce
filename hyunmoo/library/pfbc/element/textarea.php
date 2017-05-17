<?php
require_once(dirname(dirname(__FILE__)) . '/element.php');
class Element_Textarea extends Element {
	protected $_attributes = array("rows" => "5");

	public function render() {
        echo "<textarea", $this->getAttributes("value"), ">";
        if(!empty($this->_attributes["value"]))
			echo $this->filter($this->_attributes["value"]);
        echo "</textarea>";
    }
}
