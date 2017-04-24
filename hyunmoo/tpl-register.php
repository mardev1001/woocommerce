<?php
// Template Name: Register

	do_action( 'hyunmoo-register' );
	
	global $theme;
	
	get_header();
	$theme->render( 'tpl-register' );
	get_sidebar();
	get_footer();
?>
