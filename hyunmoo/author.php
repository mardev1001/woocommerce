<?php
	global $theme;
	
	get_header();
	$theme->render( 'author' );
	get_sidebar();
	get_footer();