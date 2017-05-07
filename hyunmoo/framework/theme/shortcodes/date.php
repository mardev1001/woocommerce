<?php
	function hyunmoo_shortcode_date( $atts, $content = '' ) {
		$default_atts = array(
			'format' => 0
		);
		
		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		$output = '';
		switch( $format ) {
			case 1:
				$output = date( "Y-m-d" );
				break;
			case 2:
				$output = date( "d F Y" );
				break;
			case 0:
			default:
				$output = date( "d/m/Y" );
				break;
		}
		return $output;
	}
	add_shortcode( 'date', 'hyunmoo_shortcode_date' );
?>