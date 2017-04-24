<?php
// Template Name: Reset

	do_action( 'hyunmoo-reset' );
	
	global $theme;
	
	get_header();
	$theme->render( 'tpl-reset' );
	get_sidebar();
	get_footer();
?>
