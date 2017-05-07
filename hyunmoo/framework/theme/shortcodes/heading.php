<?php
	// Highlight shortcode
	function hyunmoo_shortcode_heading($atts, $content = null) {
		$default_atts = array(
			'textalign' => 'left',
			'color'		=> '#333',
			'bgcolor'	=> '',
			'otherstyle' => '',
			'fontsize' => '30'
		);

		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output='';
		$output.='<h1 style="font-size:'.$fontsize.'px;text-align:'.$textalign.';color:'.$color.';background-color:'.$bgcolor.';'.$otherstyle.'" class="hmheading">' .do_shortcode($content). '</h1>';
		return $output;
	}
	add_shortcode('h1', 'hyunmoo_shortcode_heading');
?>