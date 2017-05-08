<?php
	# Insert Vimeo Link
	function hyunmoo_shortcode_vimeo( $atts, $content = '' )
	{		
		$default_atts = array(
			'width' => '100%',
			'height' => '60%',
			'href' => '',
			'align' => '',
		);
		
		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Numeric width and height
		if( ! $width || $width < 1 )
		{
			$width1 = $default_atts['width'];
		}else if( is_numeric( $width ) ){
			$width1 = $width . "px";
		}else{
			$width1 = $width;
		}
		
		if( ! $height || $height < 1)
		{
			$height1 = $default_atts['height'];
		}else if( is_numeric( $height ) ){
			$height1 = $height . "px";
		}else{
			$height1 = $height;
		}
		
		# Vimeo ID
		preg_match( "#com/(\d+)#", $href, $vimeo_video_id );
		$vimeo_video_id = end( $vimeo_video_id );
		
		$href = "http://vimeo.com/moogaloop.swf?clip_id={$vimeo_video_id}";
		
		# Prepare Output
		if($align=="")
			$output = '<div class="hmvideo vimeo_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . '">';
		else if($align=="left")
			$output = '<div class="hmvideo vimeo_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . ';float:left;margin-right:10px;margin-bottom:10px">';
		else if($align=="right")
			$output = '<div class="hmvideo vimeo_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . ';float:right;margin-left:10px;margin-bottom:10px">';
		$output .= '<iframe src="' . $href . '" frameborder="0" allowfullscreen></iframe>';
		$output .= '</div>';
	
		return $output;
	}

	add_shortcode( 'vimeo', 'hyunmoo_shortcode_vimeo' );
?>