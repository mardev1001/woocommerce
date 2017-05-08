<?php
	function hyunmoo_shortcode_socialicons( $atts, $content = '' )
	{
		$default_atts = array(
			'background' => '#fff'
		);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Prepare Output
		$output = '<div class="socialicons skin-primary">';
		$output .= do_shortcode($content);
		$output .= '<div style="clear:both"></div></div>';

		ob_start();

		$js = ob_get_contents();
		ob_end_clean();
		$output .= $js;
		
		return $output;
	}
	add_shortcode( 'social_icons', 'hyunmoo_shortcode_socialicons' );
	
	function hyunmoo_shortcode_socialicon( $atts, $content = '' )
	{
		$default_atts = array(
			'color' => '#000',
			'icon'	=> '',
			'href'	=> '',
			'target'=> ''
		);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Prepare Output
		$icon1=str_replace(" ","-",$icon);
		$output = '<div class="socialicon">';
		$output.= '<div class="title">'.$icon.'<div class="titlebottom"></div></div>';
		if($icon!="vimeo")
			$output.= '<a href="'.$link.'" target="'.$target.'"><i class="fa fa-'.$icon1.'" style="color:'.$color.'"></i></a>';
		else
			$output.= '<a href="'.$link.'" target="'.$target.'"><i class="fa fa-'.$icon1.'-square" style="color:'.$color.'"></i></a>';
		$output.= '</div>';

		wp_enqueue_script("shortcode-script",get_bloginfo( 'template_url' ) . '/js/shortcode.js');
		wp_enqueue_style( 'shortcode-style' ,get_bloginfo( 'template_url' ) . '/css/shortcode.css' );
	
		ob_start();

		$js = ob_get_contents();
		ob_end_clean();
		$output .= $js;
		
		return $output;
	}
	add_shortcode( 'social_icon', 'hyunmoo_shortcode_socialicon' );
?>