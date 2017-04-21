<?php
	global $theme;
	
	get_header();
	$theme->render( 'page' );
	get_sidebar();
	get_footer();