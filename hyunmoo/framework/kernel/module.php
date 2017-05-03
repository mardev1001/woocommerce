<?php

require_once( dirname( __FILE__ ) . DS . 'view.php' );

class HyunmooModule extends HyunmooView {
	public function __construct() {
		parent::__construct( 'module' );
		
	}
	public function show_modules( $position ) {
		foreach( $this->data['modules'] as $module ) {
			if( $module['position'] != $position ) continue;
			echo '<div class="postbox"><div class="handlediv" title="Click to toggle"><br /></div>';
			echo '<h3 class="hndle"><span class="' . $module['ico'] . '">' . $module['label'] . '</span></h3>';
			echo '<div class="inside">';
			$hook = 'hyunmoo-module-' . $position . '-' . $module['hook'];
			do_action( $hook );
			echo '</div></div>';
		}
	}
}
?>