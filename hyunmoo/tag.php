<?php
	global $theme;
	
	get_header();
	$theme->render( 'tag' );
	get_sidebar();
	get_footer();