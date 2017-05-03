<?php
//Registered all shortcodes in shortcodes folder
	
	$dir = dirname( __FILE__ ) . DS . 'shortcodes' . DS;
	$shortcodes = glob( $dir . "*.php" );
	foreach( $shortcodes as $shortcode )
		require_once( $shortcode );
		
//Extended Wysiwyg editor section

	function register_button( $buttons ) {
	   array_push( $buttons, "accordion", "alert", "button", "columns", "circle", "counterbox", "docviewer", "donate", "hmproducts" ,"heading",  "highlight", 
	   "hmblockquote", "hmslider", "list", "map", "recentposts", "paragraph", "parallax", "pricingtable", "row", "socialicon", "tab" ,"testimonial","toggle" ,"vimeo","youtube" );
	   return $buttons;
	}
	
	function add_plugin( $plugin_array ) {
	   $plugin_array['accordion'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['alert'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['button'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['columns'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['circle'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['counterbox'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['docviewer'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['donate'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['hmproducts'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['heading'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['highlight'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['hmblockquote'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['hmslider'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['list'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['map'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['recentposts'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['paragraph'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['parallax'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['pricingtable'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['row'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['socialicon'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['tab'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['testimonial'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['toggle'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['vimeo'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   $plugin_array['youtube'] = get_template_directory_uri() . '/tinymce/shortcode.js';
	   return $plugin_array;
	}
	
	function my_recent_posts_button() {

	   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		  return;
	   }
	
	   if ( get_user_option('rich_editing') == 'true' ) {
		  add_filter( 'mce_external_plugins', 'add_plugin' );
		  add_filter( 'mce_buttons_4', 'register_button' );
	   }
	
	}
	
	add_action('init', 'my_recent_posts_button');
	
?>