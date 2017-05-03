<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'string.php' );

//Hyunmoo Dynamic Sidebars
function hyunmoo_sidebars() {
	register_sidebar( array( 
		'name' => __( 'Hyunmoo Toolbox' ),
		'id' => 'hyunmoo-toolbox',
		'description' => __( 'Widgets in this area will be shown on the right toolbox.' ),
		'class'	=> 'toolbox'
	));
	register_sidebar( array(
		'name' => __( 'Hyunmoo Blog Sidebar' ),
		'id' => 'hyunmoo-blog',
		'description' => __( 'Widgets in this area will be shown on Post and Blog area.' )
	));
}
//Registers All Widgets in widgets folder.

function register_widgets() {
	$dir = dirname( __FILE__ ) . DS . 'widgets' . DS;
	$widgets = glob( $dir . "*.php" );
	
	foreach( $widgets as $file ) {
		require_once( $file );
		$id = HyunmooString::sanitize( basename( $file, '.php' ) );
		$id = ucfirst( strtolower( $id ) );
		$class = 'Hyunmoo' . $id . 'Widget';
		if( class_exists( $class ) )
			register_widget( $class );
	}
}
add_action( 'widgets_init', 'hyunmoo_sidebars' );
add_action( 'widgets_init', 'register_widgets' );