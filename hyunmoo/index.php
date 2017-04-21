<?php
	global $theme;

	get_header();
	$theme->render( 'index' );
	get_sidebar();
	get_footer();
?>