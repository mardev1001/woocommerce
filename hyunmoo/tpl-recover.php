<?php
// Template Name: Recover Password

	do_action( 'hyunmoo-recover' );
	
	global $theme;
	
	get_header();
	$theme->render( 'tpl-recover' );
	get_sidebar();
	get_footer();
?>
