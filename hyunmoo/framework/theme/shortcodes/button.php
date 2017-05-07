<?php
	//button shortcode
	function hyunmoo_shortcode_button($atts, $content = '') {
		$default_atts = array(
			'type' => 'default',
			'size' => '',
			'link' => '',
			'target' => ''
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		if($type=="secondary")
			$class="skin-secondary";
		else
			$class="btn-".$type;
		if($size=="medium")
			$class.="";			
		if($size=="large")
			$class.=" btn-lg";
		else if($size=="small")
			$class.=" btn-sm";
		else if($size=="extrasmall")
			$class.=" btn-xs";
				
		$output='';
		$output .='<a href="' . $link . '" target="' . $target . '"><button class="sbutton btn '.$class.'">' .do_shortcode($content). '</button></a>';
		return $output; 
	}
	add_shortcode('button', 'hyunmoo_shortcode_button');
?>
