<?php
// Row shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_parallax($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
				'speed' => 0,
				'bgurl' => '',
				'contentstyle' => '',
				'height' => 100
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		$output.= '<div class="hmparallax" style="min-height:'.$height.'px;" data-bgimage="'.$bgurl.'" data-speed="'.$speed.'"><div class="pacontent" style="'.$contentstyle.'">' .do_shortcode($content). '</div></div>';
		return $output;
	}
	
	add_shortcode('parallax', 'hyunmoo_shortcode_parallax');
?>