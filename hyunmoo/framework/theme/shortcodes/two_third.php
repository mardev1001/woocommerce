<?php
// Column two_third shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_two_third($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		if($last == 'yes') {
			$output.= '<div class="two_third last">' .do_shortcode($content). '</div><div class="clear"></div>';
		} else {
			$output.= '<div class="two_third">' .do_shortcode($content). '</div>';
		}
		
		return $output;
	}
	
	add_shortcode('two_third', 'hyunmoo_shortcode_two_third');
?>