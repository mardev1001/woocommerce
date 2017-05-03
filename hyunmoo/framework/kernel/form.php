<?php

require_once( dirname( __FILE__ ) . DS . 'view.php' );

class HyunmooForm extends HyunmooView {
	public $forms = array();	// String containing form html
	
	public function __construct() {
		parent::__construct( 'form' );
	}
	public function buildForms() {
		ob_start();
		$counter = 0;
		foreach( $this->data['panels'] as $panel ) :
			$page = $_GET['page'];
			$config = Hyunmoo::getConfig( $page . '.' . $panel['formid'] );
?>
<form id="<?php echo $panel['formid'] ?>" name="<?php echo $panel['name'] ?>" enctype="multipart/form-data" method="post">
<div id="tab<?php echo $counter ?>">
	<table class="widefat fixed" style="width: 850px;margin-bottom: 20px">
		<tr><td><input type="submit" name="save" value="Save Changes" /></td><td>&nbsp;</td></tr>
	<?php
		foreach( $panel['groups'] as $group ) :
	?>
		<thead><tr><th scope="col" width="200px"><?php echo $group['label'] ?></th><th>&nbsp;</th></tr></thead>
		<tbody>
		<?php $this->displayFields( $group['fields'], $config ) ?>
		</tbody>
	<?php
		endforeach;
	?>
		<tr><td><input type="submit" name="save" value="Save Changes" /></td><td>&nbsp;</td></tr>
		<tr><td colspan="2">All fields marked with (*) are required fields.</td></tr>
	</table>
</div>
<input type="hidden" name="tabID" value="<?php echo $counter ?>" />
<input type="hidden" name="formid" value="<?php echo $panel['formid'] ?>" />
</form>
<?php
			$counter ++;
		endforeach;
		$forms = ob_get_contents();
		ob_end_clean();
		$forms = apply_filters( 'hyunmoo-panels-view', $forms );
		echo $forms;
	}
	public function displayFields( $fields, &$config ) {
		global $hyunmoo;
		$path = get_template_directory_uri();
		foreach( $fields as $field ) :
			$filename = strtolower( $field['type'] ) . '.php';
			$file = $hyunmoo['library'] . DS . 'pfbc' . DS . 'element' . DS . $filename;
			if( file_exists( $file ) )
				require_once( $file );
			else {
				echo '<tr><td colspan="2"><span class="error">Unknown Datatype</span></td></tr>';
				continue;
			}
			$class = 'Element_' . $field['type'];
			if( isset( $field['options'] ) && !empty( $field['options'] ) ) {
				$element = new $class( $field['label'], $field['name'], $field['options'] );
				
			}
			else {
				$element = new $class( $field['label'], $field['name'] );
			}
			if( !isset( $element ) ) continue;
			
			foreach( $element->styles as $handle => $url) {
				$cssurl = $path . '/css';
				$url = str_replace( '%cssurl%', $cssurl, $url );
				if( !wp_style_is( $handle ) ) {
					wp_enqueue_style( $handle, $url );
				}
			}
			
			foreach( $element->javascripts as $handle => $url) {
				$jsurl = $path . '/js';
				$url = str_replace( '%jsurl%', $jsurl, $url );
				if( !wp_script_is( $handle ) ) {
					wp_enqueue_script( $handle, $url );
				}
			}
			
			$this->addCustomDecorations( $field['type'] );
			
			foreach( $field as $name => $value ) {
				switch( $name ) {
				case 'type':
				case 'label':
				case 'options':
					break;
				case 'before':
					$beforehtml = $value;
					break;
				case 'after':
					$afterhtml = $value;
					break;
				default:
					$element->setAttribute( $name, $value );
					break;
				}
			}
			if( isset( $config[ $field['name'] ] ) )
				$element->setAttribute( 'value', $config[ $field['name'] ] );
			$required = $element->getAttribute( 'data-required' );
			if( $required !== false )
				$field['label'] .= '<font color="red"> *</font>';
			echo '<tr><td>' . $field['label'] . ':</td><td>' . $beforehtml;
			$element->render();
			if( $required !== false )
				echo '<span class="error"></span>';
			echo $afterhtml . '</td></tr>';
			unset( $beforehtml );
			unset( $afterhtml );
		endforeach;
	}
	
	public function addCustomDecorations( $type ) {
		$type = strtolower( $type );
		$path = get_template_directory_uri() . '/library/pfbc';
		$customcss = $path . '/styles/' . $type . '.css';
		wp_enqueue_style( 'element-' . $type . '-custom-style', $customcss );
		$customjs = $path . '/javascripts/' . $type . '.js';
		wp_enqueue_script( 'element-' . $type . '-custom-script', $customjs );
	}
}