<?php
// Template Name: No Container Template
	global $theme;
	
	get_header();
	$theme->render( 'tpl-nocontainer' );
	get_sidebar();
	get_footer();