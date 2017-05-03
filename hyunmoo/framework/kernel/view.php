<?php

require_once( dirname( __FILE__ ) . DS . 'string.php' );

class HyunmooView {
	protected $data = array();
	protected $vType;
	protected $xmlconfig;
	
	public function __construct( $viewtype ) {
		$this->vType = ucfirst( strtolower( $viewtype ) );
		$function = 'load' . $this->vType;
		$success = $this->$function();
		
	}

	public function loadRecords() {
		global $wpdb;
		
		$sql = "SELECT * FROM {$wpdb->prefix}hyunmoo_records WHERE `type` = '{$this->_type}'";
		$this->data = $wpdb->get_results( $sql, ARRAY_A );
		foreach( $this->data as $id => $record )
			if( $record['attributes'] )
				$this->data[$id]['attributes'] = json_decode( $record['attributes'] );
		return true;
	}
	
	protected function _validateXml( $file ) {
		if( !file_exists( $file ) ) {
			return new WP_Error( 'invalid file', __( 'XML file does not exist.', 'hyunmoo' ) );
		}
		libxml_use_internal_errors( true );
		$config = simplexml_load_file( $file );
		if( !$config ) {
			$errors = libxml_get_errors();
			$message = new WP_Error();
			foreach( $errors as $error ) {
				$message->add( 'bad xml', $error->message . " in " . $error->file . "\r\n" );
			}
			libxml_clear_errors();
			return $message;
		}
		return true;
	}
	public function loadForm() {
		$valid = $this->_validateXml( $this->xmlconfig );
		if( $valid !== true )
			return false;
		$config = simplexml_load_file( $this->xmlconfig );
		$this->data['title'] = (string)$config->attributes();
		
		foreach( $config->children() as $panel ) {
			$panel_r = array();
			foreach( $panel->attributes() as $name => $value )
				$panel_r[$name] = esc_attr( $value );
			if( !array_key_exists( 'name', $panel_r ) )
				$panel_r['name'] = strtolower( HyunmooString::sanitize( $panel_r['label'] ) );
			if( !array_key_exists( 'formid', $panel_r ) )
				$panel_r['formid'] = $panel_r['name'];
			$panel_r['groups'] = array();
			foreach( $panel->children() as $group ) {
				$group_r = array();
				$group_r['label'] = (string)$group->attributes();
				$group_r['fields'] = array();
				foreach( $group->children() as $element ) {
					$element_r = array();
					foreach( $element->attributes() as $name => $value )
						$element_r[$name] = esc_attr( $value );
					$element_r['options'] = array();
					foreach( $element->children() as $child ) {
						if( $child->getName() == 'option' ) {
							$opt_value = (string)$child->attributes();
							$opt_text = (string)$child;
							$element_r['options'][$opt_value] = $opt_text;
						}
						elseif( $child->getName() == 'after' ) {
							$after = new SimpleXMLElement( $child->asXML(), LIBXML_NOCDATA );
							$element_r['after'] = (string)$after;
						}
						elseif( $child->getName() == 'before' ) {
							$before = new SimpleXMLElement( $child->asXML(), LIBXML_NOCDATA );
							$element_r['before'] = (string)$before;
						}
					}
					if( empty( $element_r['options'] ) )
						unset( $element_r['options'] );
					$group_r['fields'][] = $element_r;
				}
				$panel_r['groups'][] = $group_r;
			}
			$this->data['panels'][] = $panel_r;
		}
		return true;
	}
	
	protected function loadModule() {
		$valid = $this->_validateXml( $this->xmlconfig );
		if( $valid !== true )
			return $valid;
		$config = simplexml_load_file( $this->xmlconfig );
		$this->data['title'] = (string)$config->attributes();
		foreach( $config->children() as $module ) {
			$widget_r = array();
			foreach( $module->attributes() as $name => $value )
				$widget_r[$name] = esc_attr( $value );
			$this->data['modules'][] = $widget_r;
		}
		return true;
	}
	
	public function show() {
		$function = 'show' . $this->vType;
		
		$this->$function();
	}
	
	public function addDecorations() {
	}
	
	public function showRecords() {
		$this->data = apply_filters( 'hyunmoo-records-fields', $this->data );
	}
	public function showForm() {
		$this->data = apply_filters( 'hyunmoo-form-params', $this->data );
		add_action( 'hyunmoo-form-panels', array( $this, 'buildForms' ) );
		
		ob_start();
?>
<div class="wrap">
	<div class="icon32" id="icon-themes">&nbsp;</div>
	<h2><?php _e( $this->data['title'], 'hyunmoo' ); ?></h2>
	<?php do_action( 'before-hyunmoo-form' ); ?>
	<input type="hidden" name="setIndex" id="setIndex" value="<?php echo $_POST['tabID'] ?>" />
	<div id="tabs-wrap">
		<?php
			$tabs = count( $this->data['panels'] );
			$style = '';
			if( $tabs < 2 )
				$style = 'display:none;';
		?>
		<ul class="tabs" style="<?php echo $style ?>">
		<?php
			$counter = 0;
			foreach( $this->data['panels'] as $panel ) :
		?>
			<li><a href="#tab<?php echo $counter ?>"><?php echo $panel['label']; ?></a></li>
		<?php
			$counter ++;
			endforeach;
		?>
		</ul>
		<?php do_action( 'hyunmoo-form-panels' ); ?>
	</div>
	<?php do_action( 'after-hyunmoo-form' ); ?>
</div>
<?php
		$view = ob_get_contents();
		ob_end_clean();
		$view = apply_filters( 'hyunmoo-form-view', $view );
		echo $view;
	}
	public function showModule() {
		$this->data = apply_filters( 'hyunmoo-module-params', $this->data );
		
		//Hooks to Widget positions
		add_action( 'hyunmoo-module-top', array( $this, 'show_modules' ) );
		add_action( 'hyunmoo-module-left', array( $this, 'show_modules' ) );
		add_action( 'hyunmoo-module-right', array( $this, 'show_modules' ) );
		add_action( 'hyunmoo-module-bottom', array( $this, 'show_modules' ) );
		
		ob_start();
?>
<div class="wrap">
	<div class="icon32" id="icon-themes">&nbsp;</div>
	<h2><?php _e( $this->data['title'], 'hyunmoo' ); ?></h2>
	<?php do_action( 'before-hyunmoo-module' ); ?>
	<br>
	<div class="dash-top metabox-holder">
		<div class="dash-wrap">
		<?php do_action( 'hyunmoo-module-top', 'top' ); ?>
		</div>
	</div>
	<div style="clear: both">&nbsp;</div>
	<div class="dash-left metabox-holder">
		<div class="dash-wrap">
		<?php do_action( 'hyunmoo-module-left', 'left' ); ?>
		</div>
	</div>
	<div class="dash-right metabox-holder">
		<div class="dash-wrap">
		<?php do_action( 'hyunmoo-module-right', 'right' ); ?>
		</div>
	</div>
	<div style="clear: both">&nbsp;</div>
	<div class="dash-bottom metabox-holder">
		<div class="dash-wrap">
		<?php do_action( 'hyunmoo-module-bottom', 'bottom' ); ?>
		</div>
	</div>
	<?php do_action( 'after-hyunmoo-module' ); ?>
</div>
<?php
		$view = ob_get_contents();
		ob_end_clean();
		$view = apply_filters( 'hyunmoo-module-view', $view );
		echo $view;
	}
	public function __call( $name, $arguments ) {
		if( !method_exists( $this, $name ) )
			return;
	}
}
?>