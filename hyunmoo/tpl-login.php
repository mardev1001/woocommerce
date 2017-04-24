<?php
// Template Name: Login

	do_action( 'hyunmoo-login' );
	
	global $theme;
	
	get_header();
	$theme->render( 'tpl-login' );
	get_sidebar();
	get_footer();
?>