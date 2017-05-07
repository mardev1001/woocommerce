<?php
// Counters Box

function hyunmoo_shortcode_counter_boxes($atts, $content = null) {
	$output = '<div class="counters-boxes">';
	$output .= do_shortcode($content);
	$output .= '<div style="clear:both"></div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('counter_boxes', 'hyunmoo_shortcode_counter_boxes');

// Counter Box
function hyunmoo_shortcode_counter_box($atts, $content = null) {

	$default_atts = array(
		'value' => '100'
	);
	
	# Overwrite Default Attributes
	$atts = shortcode_atts( $default_atts, $atts );

	extract( $atts );

	static $ccount=1;
	
	$output = '';
	$output .= '<div class="counter-box" id="counter-box'.$ccount.'">';
	$output .= '<div class="content-box-percentage">';
	$output .= '<span class="display-percentage" data-percentage="'.$value.'">0</span><span class="percent">%</span>';
	$output .= '</div>';
	$output .= '<div class="counter-box-content">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	$ccount++;

	return $output;
}
add_shortcode('counter_box', 'hyunmoo_shortcode_counter_box');

?>
