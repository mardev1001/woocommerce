<?php
	function hyunmoo_shortcode_donate( $atts, $content = '' ) {
		$default_atts = array(
			'email' => '',
			'name' => 'Donate',
			'currency' => 'USD',
			'image' => 'https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif'
		);
		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		if( !isset( $email ) ) {
			return '';
		}
		ob_start();
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="<?php echo $email ?>">
	<input type="hidden" name="item_name" value="<?php echo $name ?>">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="currency_code" value="<?php echo $currency ?>">
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
	<input type="image" src="<?php echo $image ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<?php
		$output = ob_get_contents();
		ob_end_clean();
		$output .= $content;
		return $output;
	}
	add_shortcode( 'donate', 'hyunmoo_shortcode_donate' );
?>