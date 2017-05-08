<?php
// Column one_half shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_one_half($atts, $content = '') {
		$default_atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		if($last == 'yes') {
			$output.= '<div class="one_half last">' .do_shortcode($content). '</div><div class="clear"></div>';
		} else {
			$output.= '<div class="one_half">' .do_shortcode($content). '</div>';
		}
		return $output;
	}
	
	add_shortcode('one_half', 'hyunmoo_shortcode_one_half');
?>