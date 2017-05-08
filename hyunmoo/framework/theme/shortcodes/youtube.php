<?php
	# Insert Youtube Link
	function hyunmoo_shortcode_youtube( $atts, $content = '' )
	{		
		$default_atts = array(
			'width' => '100%',
			'height' => '60%',
			'href' => '',
			'align' => ''
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
		
		# Youtube ID
		preg_match( "#v=(\w+)#", $href, $youtube_video_id );
		$youtube_video_id = end( $youtube_video_id );
		
		$href = "http://www.youtube.com/v/{$youtube_video_id}";
		
		# Prepare Output
		if($align=="")
			$output = '<div class="hmvideo youtube_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . '">';
		else if($align=="left")
			$output = '<div class="hmvideo youtube_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . ';float:left;margin-right:10px;margin-bottom:10px">';
		else if($align=="right")
			$output = '<div class="hmvideo youtube_link" style="max-width:'. $width1 . ';padding-top:' . $height1 . ';float:right;margin-left:10px;margin-bottom:10px">';
		$output .= '<iframe src="' . $href . '" frameborder="0" allowfullscreen></iframe>';
		$output .= '<div class="hmvideoend"></div></div>';
	
		return $output;
	}
	
	add_shortcode( 'youtube', 'hyunmoo_shortcode_youtube' );
?>