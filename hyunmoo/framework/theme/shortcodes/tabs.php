<?php
	function hyunmoo_shortcode_tab( $atts, $content = '' )
	{
		return '';
	}
	add_shortcode( 'tab', 'hyunmoo_shortcode_tab' );
	
	function hyunmoo_shortcode_tabs( $atts, $content = '' )
	{
		$default_atts = array(
		);
		
		# Shortcode the content inside
		#$content = do_shortcode($content);
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		# Tabs		
		$pattern = get_shortcode_regex();
		
		preg_match_all( "/{$pattern}/", $content, $matches );
		
		$tabs = $matches[0];
		$tab_attrs = $matches[3];
		$tab_contents = $matches[5];
		
		#print_r($matches);
		#exit;
		
		extract( $atts );
		
		# Prepare Output
		$output = '<div class="tabs">';
		
			# Tab Titles
			$output .= '<ul>';
			
			foreach( $tabs as $i => $tab )
			{
				$id = $i + 1;
				$is_current = preg_match( "/current=(\"|\')(.*?)(\"|\')/", $tab_attrs[$i] );
				
				preg_match( "/title=(\"|\')(.*?)(\"|\')/", $tab_attrs[$i], $tab_title );
				
				$output .= '<li'.($i == 2 ? ' class="active"' : '').'>';
				$output .= '<a href="#tab-' . $id . '"' . ( $is_current ? ' class="current"' : '' ) . '>' . $tab_title[2] . '</a>';
				$output .= '</li>';
			}
			
			$output .= '<div style="clear:both"></div></ul>';
			
			
			# Tab Contents
			foreach( $tabs as $i => $tab )
			{
				$id = $i + 1;
				
				$output .= '<div id="tab-' . $id . '">';
				$output .= $tab_contents[$i];
				$output .= '</div>';
			}
		
		$output .= '</div>';
		
		//Load javascript libraries for the tab function
		ob_start();
?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("div.tabs").tabs({
			fx: {opacity: 'toggle', duration: 100}
		});
	});
</script>
<?php
		$js = ob_get_contents();
		ob_end_clean();
		$output .= $js;
		
		return $output;
	}
	add_shortcode( 'tabs', 'hyunmoo_shortcode_tabs' );
?>