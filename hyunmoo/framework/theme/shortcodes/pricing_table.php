<?php
// Prcing table shortcode

	function hyunmoo_shortcode_pricing_table($atts, $content = null) {

		$default_atts = array(
		);

		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );

		static $pricing_table_counter = 1;


		$output = "";

		$output .= '<div id="pricing-table-'.$pricing_table_counter.'" class="pricingtable">';
		$output .= do_shortcode($content);
		$output .= '<div class="clear"></div></div>';

		$pricing_table_counter++;

		return $output;
	}
	add_shortcode('pricing_table', 'hyunmoo_shortcode_pricing_table');

// Pricing Column
	function hyunmoo_shortcode_pricing_column($atts, $content = null) {
		$default_atts = array(
			'title' => '',
			'highlight' => 'no'
		);

		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );

		extract( $atts );
		
		if($highlight == "yes")
			$highlightclass = " highlight";
		else if($highlight == "no")
			$highlightclass = "";
		
		$output = '<div class="column'.$highlightclass.'">';
		$output .= '<ul>';
		$output .= '<li class="title-row skin-primary">'.$title.'</li>';
		$output .= do_shortcode($content);
		$output .= '</ul>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('pricing_column', 'hyunmoo_shortcode_pricing_column');

// Pricing Row
	function hyunmoo_shortcode_pricing_row($atts, $content = null) {
		$output = '';
		$output .= '<li class="pricing-row">';
		if(isset($atts['price']) && !empty($atts['price'])) {
			$class = '';
			$price = explode('.', $atts['price']);
			if($price[1]){
				$class .= 'price-with-decimal';
			}
			$output .= '<div class="price '.$class.'">';
				if(isset($atts['currency']) && !empty($atts['currency']))
					$output .= '<strong>'.$atts['currency'].'</strong>';
				$output .= '<em class="exact_price">'.$price[0].'</em>';
				if($price[1]){
					$output .= '<sup>'.$price[1].'</sup>';
				}
				if($atts['time']) {
					$output .= '<br><em class="time">Per '.$atts['time'].'</em>';
				}
			$output .= '</div>';
		} else {
			$output .= do_shortcode($content);
		}
		$output .= '</li>';

		return $output;
	}
	add_shortcode('pricing_row', 'hyunmoo_shortcode_pricing_row');

// Normal Row
	function hyunmoo_shortcode_normal_row($atts, $content = null) {
		$output = '';
		$output .= '<li class="normal-row">';
		$output .= do_shortcode($content);
		$output .= '</li>';

		return $output;
	}
	add_shortcode('normal_row', 'hyunmoo_shortcode_normal_row');

// Pricing Footer
	function hyunmoo_shortcode_pricing_footer($atts, $content = null) {
		$output = '';
		$output .= '<li class="footer-row">';
		$output .= do_shortcode($content);
		$output .= '</li>';

		return $output;
	}
	add_shortcode('pricing_footer', 'hyunmoo_shortcode_pricing_footer');
?>