<?php
	global $theme;
	
	get_header();
	$theme->render( 'date' );
	get_sidebar();
	get_footer();