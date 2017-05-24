<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

?>

<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post" id="cartform">
<?php $woocommerce->show_messages();
do_action( 'woocommerce_before_cart' ); ?>

<h1><?php echo sprintf(_n('There is %d item in the cart', 'There are %d items in the cart', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></h1>

<?php do_action( 'woocommerce_before_cart_table' ); ?>
<div class="cartdiv">
<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				if ( $_product->exists() && $values['quantity'] > 0 ) {
					?>
					<tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">
						<!-- The thumbnail -->
						<td class="product-thumbnail">
							<div>
							<?php
								$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );

								if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
									echo $thumbnail;
								else
									printf('<a href="%s" class="productthumbimage">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
							?>
                            <!-- Product Name -->
                            <div class="product-name">
                                <?php
                                    if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
                                        echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
                                    else
                                        printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );
    
                                    // Meta data
                                    echo $woocommerce->cart->get_item_data( $values );
    
                                    // Backorder notification
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                                        echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
                                ?>
                            </div><div class="clear"></div>

							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">Remove</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
							?><div class="clear"></div></div>

						</td>

						<!-- Product price -->
						<td class="product-price">
							<?php
								$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();

								echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
							?>
						</td>

						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {

									$step	= apply_filters( 'woocommerce_quantity_input_step', '1', $_product );
									$min 	= apply_filters( 'woocommerce_quantity_input_min', '', $_product );
									$max 	= apply_filters( 'woocommerce_quantity_input_max', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product );

									$product_quantity = sprintf( '<div class="quantity"><input type="text" name="cart[%s][qty]" step="%s" min="%s" max="%s" value="%s" size="4" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $step, $min, $max, esc_attr( $values['quantity'] ) );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
						</td>

						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ), $values, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?></tbody></table>
		<div class="couponandotherbuttons">
				<div class="heading"></div>
				<div class="updateandcheckoutbut"><input type="submit" class="skin-secondary button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /></div><div class="updateandcheckoutbut bordertopnone"> <input type="submit" class="skin-secondary checkout-button button alt" name="proceed" value="<?php _e( 'Checkout &rarr;', 'woocommerce' ); ?>" /></div><?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<h1><label for="coupon_code"><?php _e( 'Coupon-code', 'woocommerce' ); ?></label></h1>
						<input type="text" name="coupon_code" id="coupon_code" value="" placeholder="Have a coupon code?" />
						<input type="submit" class="skin-secondary button" name="apply_coupon" value="<?php _e( 'Apply', 'woocommerce' ); ?>" />

						<?php do_action('woocommerce_cart_coupon'); ?>

					</div>
				<?php } ?>
				<div class="cart-collaterals">

					<?php do_action('woocommerce_cart_collaterals'); ?>
                
                    <?php woocommerce_cart_totals(); ?>
                	<div class="clear1"></div>
                    
                    <div id="cartshippingcalculator"><?php woocommerce_shipping_calculator(); ?></div>
                
                </div>


				</div>

				<?php do_action('woocommerce_proceed_to_checkout'); ?>

				<?php $woocommerce->nonce_field('cart') ?>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>

<?php do_action( 'woocommerce_after_cart_table' ); ?>
<div class="clear"></div>
<?php do_action( 'woocommerce_after_cart' ); ?>
</div>
</form>

