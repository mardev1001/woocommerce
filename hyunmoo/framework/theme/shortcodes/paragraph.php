<?php
	//paragraph shortcode
	function hyunmoo_shortcode_paragraph($atts, $content = '') {
		$default_atts = array(
			'fontsize' => 14,
			'color' => '#747474',
			'bgcolor' => '',
			'otherstyle' => '',
			'dropcap' => 'no'
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		if($dropcap == "yes")
			$pclass = "dropcap";
		else
			$pclass = "";
		
		$output='';
		$output .='<p class="'.$pclass.'" style="font-size:' .  $fontsize . 'px;color:' . $color . ';background-color:'.$bgcolor.';'.$otherstyle.'">' .do_shortcode($content). '</p>';
		return $output; 
	}
	add_shortcode('p', 'hyunmoo_shortcode_paragraph');
?>
