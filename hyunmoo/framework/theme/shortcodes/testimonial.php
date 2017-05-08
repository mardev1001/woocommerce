<?php
	//testimonial shortcode
	function hyunmoo_shortcode_testimonials_slider($atts, $content = '') {
		$default_atts = array(
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
				
		$output='<div class="testimonial_slider">';
		$output .= do_shortcode($content);
		$output .= "</div>";
		
		return $output; 
	}
	add_shortcode('testimonial_slider', 'hyunmoo_shortcode_testimonials_slider');
	
	function hyunmoo_shortcode_testimonials_list($atts, $content = '') {
		$default_atts = array(
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
				
		$output='<div class="testimonial_list">';
		$output .= do_shortcode($content);
		$output .= "</div>";
		
		return $output; 
	}
	add_shortcode('testimonial_list', 'hyunmoo_shortcode_testimonials_list');

	function hyunmoo_shortcode_testimonial($atts, $content = '') {
		$default_atts = array(
			'name' => "",
			'role' => "",
			'image' => ""
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
				
		$output='<div class="testimonial">';
		$output .= '<div class="testimonial-content">'.do_shortcode($content).'</div>';
		if($name!=""){
			$output .= '<div class="testimonial-info">';
			if($image=="")
				$output .= '<div>'.get_avatar('',50).'</div>';
			else
				$output .= '<div><img src="'.$image.'" width="50" height="50"></div>';
			$output .= '<div><p class="name">'.$name.'</p><p class="role">'.$role.'</p></div>';
			$output .= '</div><div style="clear:both"></div>';
		}
		$output .= "</div>";
		
		return $output; 
	}
	add_shortcode('testimonial', 'hyunmoo_shortcode_testimonial');
?>
