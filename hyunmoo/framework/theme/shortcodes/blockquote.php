<?php
	// Highlight shortcode
	function hyunmoo_shortcode_blockquote($atts, $content = null) {
		$default_atts = array(
			'color' => '#555',
			'fontsize' => '15',
			'author' => 'Author'
		);

		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output='';
		$output.='<blockquote><p style="color:'.$color.';font-size:'.$fontsize.'px;">'.do_shortcode($content).'</p>';
		$output.='<small>By '.$author.'</small></blockquote>';
		return $output;
	}
	add_shortcode('hmblockquote', 'hyunmoo_shortcode_blockquote');
?>