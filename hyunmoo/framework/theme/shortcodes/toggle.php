<?php
// Toggle shortcode
//////////////////////////////////////////////////////////////////
function shortcode_toggles( $atts, $content = null ) {
	$default_atts = array(
	);

	# Overwrite Default Attributes
	$atts = shortcode_atts( $default_atts, $atts );

	extract( $atts );
	
	$output= "<div class='toggles'>";
	$output.= do_shortcode($content);
	$output.= "</div>";
	
	return $output;
}

add_shortcode('toggles', 'shortcode_toggles');

function shortcode_toggle( $atts, $content = null ) {
	$default_atts = array(
        'title'      => '',
        'open' => 'no'
	);
	
	# Overwrite Default Attributes
	$atts = shortcode_atts( $default_atts, $atts );

	extract( $atts );

    $toggleclass = '';
    $toggleclass2 = '';
    $togglestyle = '';

	if($open == 'yes'){
		$toggleclass = "active";
		$toggleclass2 = "default-open";
		$togglestyle = "display: block;";
		$arrow = "-";
	}else if($open == 'no'){
		$togglestyle = "display: none;";
		$arrow = "+";
	}

	$output = '';
	$output .= '<div class="togglediv"><h5 class="toggle '.$toggleclass.'"><a href="#"><span class="arrow skin-primary">'.$arrow.'</span>' .$title. '</a></h5>';
	$output .= '<div class="toggle-content '.$toggleclass2.'" style="'.$togglestyle.'">';
	$output .= do_shortcode($content);
	$output .= '</div></div>';

   return $output;
}
add_shortcode('toggle', 'shortcode_toggle');
?>