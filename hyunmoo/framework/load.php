<?php
	
	$GLOBALS['hyunmoo']['version'] = '1.0';
	$GLOBALS['hyunmoo']['directory'] = dirname( dirname( __FILE__ ) );
	$GLOBALS['hyunmoo']['framework'] = dirname( __FILE__ );
	$GLOBALS['hyunmoo']['kernel'] = dirname( __FILE__ ) . DS . 'kernel';
	$GLOBALS['hyunmoo']['library'] = dirname( dirname( __FILE__ ) ) . DS . 'library';
	$GLOBALS['hyunmoo']['helpers'] = dirname( dirname( __FILE__ ) ) . DS . 'helpers';
	
	require_once( dirname( __FILE__ ) . DS . 'hyunmoo.php' );
	$theme = Hyunmoo::getTheme();
	$theme->initialize();
	Hyunmoo::runAuth();
	
	require_once( dirname( __FILE__ ) . DS . 'theme' . DS . 'widget.php' );
	require_once( dirname( __FILE__ ) . DS . 'theme' . DS . 'shortcode.php' );
	require_once( get_template_directory() . DS . 'includes' . DS . 'ajax.php' );

	$GLOBALS['hyunmoo']['theme'] = &$theme;
?>