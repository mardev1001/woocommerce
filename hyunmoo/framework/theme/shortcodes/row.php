<?php
// Row shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_row($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		$output.= '<div class="hmrow">' .do_shortcode($content). '</div>';
		return $output;
	}
	
	add_shortcode('row', 'hyunmoo_shortcode_row');
?>