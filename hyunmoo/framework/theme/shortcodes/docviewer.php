<?php
	function hyunmoo_shortcode_docviewer( $atts, $content = '' ) {
		$default_atts = array(
			'url' => '',
			'style' => 'border: none, margin: 0 auto',
			'width' => '',
			'height' => 500
		);
		$atts = shortcode_atts( $default_atts, $atts );
	
		extract($atts);

		$url = 'http://docs.google.com/viewer?url=' . urlencode( $url ) . '&embedded=true';
		if($width=="")
			$output = '<iframe src="' . $url . '" height="' . $height . '" style="width:100%;' . $style. '"></iframe>';
		else
			$output = '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '" style="width:100%;' . $style. '"></iframe>';
		return $output;
	}
	add_shortcode( 'docviewer', 'hyunmoo_shortcode_docviewer' );
?>