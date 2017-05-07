<?php
	function hyunmoo_shortcode_accordion( $atts, $content = '' )
	{
		$default_atts = array(
		);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Prepare Output
		$output = '<div class="accordion">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		ob_start();

		$js = ob_get_contents();
		ob_end_clean();
		$output .= $js;
		
		return $output;
	}
	add_shortcode( 'accordion', 'hyunmoo_shortcode_accordion' );
?>