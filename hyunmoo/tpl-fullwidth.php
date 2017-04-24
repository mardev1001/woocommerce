<?php
// Template Name: Full Width Template
	global $theme;
	
	get_header();
	$theme->render( 'tpl-fullwidth' );
	get_sidebar();
	get_footer();