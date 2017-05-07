<?php
// Row shortcode
//////////////////////////////////////////////////////////////////
	function hyunmoo_shortcode_circle($atts, $content = null) {
		$default_atts = shortcode_atts(
			array(
				'bgcolor' => '#ddd',
				'bgimg' => '',
				'borderradius' => "50%",
				'size'	=> '100%',
				'border'  => "",
				'contentstyle' => ""
			), $atts);
			
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		$output="";
		if($bgimg!=""){
			$output.= '<div class="hmcircle bgimg" data-bgimg="'.$bgimg.'" style="border-radius:'.$borderradius.';width:'.$size.';border:'.$border.';"><div class="content" 
			style="'.$contentstyle.'">' .do_shortcode($content). '</div></div>';
		}else{
			$output.= '<div class="hmcircle" style="border-radius:'.$borderradius.';width:'.$size.';background-color:'.$bgcolor.';border:'.$border.';"><div class="content"
			style="'.$contentstyle.'">' .do_shortcode($content). '</div></div>';
		}
		return $output;
	}
	
	add_shortcode('circle', 'hyunmoo_shortcode_circle');
?>