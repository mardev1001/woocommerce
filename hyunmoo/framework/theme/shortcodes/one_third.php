<?php
// Column one_third shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_one_third($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		if($last == 'yes') {
			$output.= '<div class="one_third last">' .do_shortcode($content). '</div><div class="clear"></div>';
		} else {
			$output.= '<div class="one_third">' .do_shortcode($content). '</div>';
		}
		return $output;
	}
	
	add_shortcode('one_third', 'hyunmoo_shortcode_one_third');
?>