<?php
	global $theme;
	
	get_header();
	$theme->render( 'search' );
	get_sidebar();
	get_footer();
?>