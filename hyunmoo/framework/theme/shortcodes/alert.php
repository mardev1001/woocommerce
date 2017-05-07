<?php
// Alert Message
function hyunmoo_shortcode_alert($atts, $content = null) {
	$default_atts = array(
		'type' => ''
	);
	
	# Overwrite Default Attributes
	$atts = shortcode_atts( $default_atts, $atts );

	extract( $atts );	
	
	$output = '';
	$output .= '<div class="salert '.$type.'">';
		$output .= '<div class="msg">'.do_shortcode($content).'</div>';
		$output .= '<a href="#" class="close-alert">X</a>';
	$output .= '</div>';

	return $output;
}
add_shortcode('alert', 'hyunmoo_shortcode_alert');
?>
