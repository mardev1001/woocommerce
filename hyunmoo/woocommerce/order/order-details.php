<?php
/**
 * Order details
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $theme;
$GLOBALS['order_id'] = $order_id;

$theme->render( 'order-details', 'woocommerce/order' );