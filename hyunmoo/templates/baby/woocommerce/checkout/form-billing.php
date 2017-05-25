<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php if ( $woocommerce->cart->ship_to_billing_address_only() && $woocommerce->cart->needs_shipping() ) : ?>

	<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

<?php else : ?>

	<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>

<?php endif; ?>

<?php do_action('woocommerce_before_checkout_billing_form', $woocommerce->checkout ); ?>

<?php foreach ($woocommerce->checkout->checkout_fields['billing'] as $key => $field) : ?>

	<?php woocommerce_form_field( $key, $field, $woocommerce->checkout->get_value( $key ) ); ?>

<?php endforeach; ?>

<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?></div>


<div class="col-2">
<?php if ( ! is_user_logged_in() && $woocommerce->checkout->enable_signup ) : ?>

	<?php if ( $woocommerce->checkout->enable_guest_checkout ) : ?>

		<div class="form-row form-row-wide">
			<input class="input-checkbox" id="createaccount" <?php checked($checkout->get_value('createaccount'), true) ?> type="checkbox" name="createaccount" value="1" /><i class="fa fa-check-square-o checkbox"></i> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_registration_form', $woocommerce->checkout ); ?>

	<div class="create-account">

		<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

		<?php foreach ($woocommerce->checkout->checkout_fields['account'] as $key => $field) : ?>

			<?php woocommerce_form_field( $key, $field, $woocommerce->checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

		<div class="clear"></div>

	</div>

	<?php do_action( 'woocommerce_after_checkout_registration_form', $woocommerce->checkout ); ?>

<?php endif; ?>