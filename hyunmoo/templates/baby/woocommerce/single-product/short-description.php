<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

?>
<br>
<div itemprop="description" id="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
   	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>