<?php
require_once('textbox.php');
class Element_WordpressImage extends Element_Textbox {
	protected $_attributes = array(
		"type" => "text",
		"role" => "imageupload",
		"style" => "min-width: 400px");
	public $styles = array( 'thickbox' => "" );
	public $javascripts = array( 
			'media-upload' => "",
			'thickbox' => "" );
	public function render() {

		$id = $this->getAttribute('id');
		if(!$id) {
			$name = $this->getAttribute('name');
			$this->setAttribute('id', $name);
		}
		parent::render();
?>
<input type="button" class="button image_upload" value="Upload Image" rel="<?php echo $this->getAttribute('id') ?>" />
<div class="image_preview"></div>
<?php
	}
}