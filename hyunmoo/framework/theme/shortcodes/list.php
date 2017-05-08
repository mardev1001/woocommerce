<?php
	function hyunmoo_shortcode_list( $atts, $content = '' )
	{
		$default_atts = array(
			'is_numeric' => 'no'
		);
		
		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		# Create Rows
		$content = explode( "\n", $content );
		
		$list_lis = '';
		
		foreach( $content as $li_element )
		{
			$list_lis .= '<li>' . do_shortcode($li_element) . '</li>';
		}
		
		
		# Set Lit Type
		$list_type = 'ul';
		
		if( $is_numeric != 'no' )
		{
			$list_type = 'ol';
		}
		
		# Prepare Output
		$output = <<<EOD
<{$list_type} class="hmslist">{$list_lis}</{$list_type}>
EOD;
	
		return $output;
	}
	add_shortcode( 'list', 'hyunmoo_shortcode_list' );
?>