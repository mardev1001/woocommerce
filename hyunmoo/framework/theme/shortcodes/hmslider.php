<?php
	# Insert Hyunmoo Slider

	function hyunmoo_shortcode_hmslider( $atts, $content = '' )
	{	
		$default_atts = array(
			'name'	=> ''
		);

		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );

		if( $name == '' )	return '';
		
		$slider = Hyunmoo::getConfig( 'slider.' . $name, 'records' );
		if( empty( $slider['slides'] ) )
			return '<div class="alert alert-danger">Slider is empty.</div>';
		# Prepare Output
		$output = '<div class="hmslider-container">';
		foreach($slider['slides'] as $value){
			$output.= '<div class="item"><img src="'.$value['imgurl'].'"><div class="content">'.$value['content'].'</div><div class="caption">'.$value['caption'].'</div></div>';				
		}
		$output .= '</div>';

		return $output;
	} 
	add_shortcode( 'hmslider', 'hyunmoo_shortcode_hmslider' );
?>