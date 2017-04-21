<?php
	global $theme;
	
	get_header();
	$theme->render( 'category' );
	get_sidebar();
	get_footer();
