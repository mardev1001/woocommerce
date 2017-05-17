<?php
require_once('base.php');
abstract class Element extends Base {
	protected $_attributes = array();
	protected $_form;
	protected $errors = array();

	protected $label;
	public $javascripts = array();
	public $styles = array();

	public function __construct($label, $name, array $properties = null) {
		$configuration = array(
			"label" => $label,
			"name" => $name
		);

		/*Merge any properties provided with an associative array containing the label
		and name properties.*/
		if(is_array($properties))
			$configuration = array_merge($configuration, $properties);
		
		$this->configure($configuration);
	}

	/*When an element is serialized and stored in the session, this method prevents any non-essential
	information from being included.*/
	public function __sleep() {
		return array("_attributes", "label");
	}

	public function getLabel() {
		return $this->label;
	}

	/*Many of the included elements make use of the <input> tag for display.  These include the Hidden, Textbox, 
	Password, Date, Color, Button, Email, and File element classes.  The project's other element classes will
	override this method with their own implementation.*/
	public function render() {
		echo '<input', $this->getAttributes(), '/>';
	}

	public function setLabel($label) {
		$this->label = $label;
	}

}
