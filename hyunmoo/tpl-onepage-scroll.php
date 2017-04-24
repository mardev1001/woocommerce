<?php
// Template Name: Onepage Scroll Template
	global $theme;
	$url = get_template_directory_uri();
	
	$theme->enqueue_style( 'onepage-scroll-style', $url . '/css/onepage-scroll.css' );
	$theme->enqueue_script( 'onepage-scroll-script', $url . '/js/jquery.onepage-scroll.js' );
	
	get_header();
	$theme->render( 'tpl-onepage-scroll' );
	wp_footer();