<?php
// Column three_fourth shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_three_fourth($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		if($last == 'yes') {
			$output.= '<div class="three_fourth last">' .do_shortcode($content). '</div><div class="clear"></div>';
		} else {
			$output.= '<div class="three_fourth">' .do_shortcode($content). '</div>';
		}
	
		return $output;
	}
	
	add_shortcode('three_fourth', 'hyunmoo_shortcode_three_fourth');
?>