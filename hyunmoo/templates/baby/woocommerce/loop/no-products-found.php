<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="woocommerce wrapper">
<p class="woocommerce-info"><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>
<p><a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn btn-primary skin-primary">Return to shop</a></p>
</div>