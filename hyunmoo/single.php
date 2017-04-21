<?php
	global $theme;
	
	get_header();
	$theme->render( 'single' );
	get_sidebar();
	get_footer();