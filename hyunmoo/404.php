<?php
	global $theme;
	
	get_header();
	$theme->render( '404' );
	get_sidebar();
	get_footer();
?>