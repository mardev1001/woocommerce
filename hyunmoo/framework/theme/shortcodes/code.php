<?php
	function hyunmoo_shortcode_code( $atts, $content = '' )
	{
		$default_atts = array(
		);
		
		# Shortcode the content inside
		#$content = do_shortcode($content);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Prepare Output
		$output = <<<EOD
<pre>{$content}</pre>
EOD;
	
		return $output;
	}
?>