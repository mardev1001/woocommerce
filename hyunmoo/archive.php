<?php
	global $theme;
	
	get_header();
	$theme->render( 'archive' );
	get_sidebar();
	get_footer();