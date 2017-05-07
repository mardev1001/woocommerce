<?php
	// Highlight shortcode
	function hyunmoo_shortcode_highlight($atts, $content = null) {
		$default_atts = array(
			'color' => 'yellow',
			'textcolor' => ''
		);

		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output='';
		if($textcolor == "") {
			$output.='<span class="texthighlight" style="background-color:'.$color.';">' .do_shortcode($content). '</span>';
		} else {
			$output.='<span class="texthighlight" style="background-color:'.$color.';color:"'.$textcolor.';">' .do_shortcode($content). '</span>';
		}
		return $output;
	}
	add_shortcode('highlight', 'hyunmoo_shortcode_highlight');
?>