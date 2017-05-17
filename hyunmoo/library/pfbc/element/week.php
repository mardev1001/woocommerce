<?php
require_once('textbox.php');
class Element_Week extends Element_Textbox {
    protected $_attributes = array(
        "type" => "week",
        "data-pattern" => "\d{4}-W\d{2}"
    );

    public function __construct($label, $name, array $properties = null) {
        $this->_attributes["placeholder"] = "YYYY-Www (e.g. " . date("Y-\WW") . ")";
        $this->_attributes["title"] = $this->_attributes["placeholder"];

        parent::__construct($label, $name, $properties);
    }
}
