<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $theme;

$GLOBALS['order'] = $order;

get_header( 'shop' ); 
$theme->render( 'thankyou', 'woocommerce/checkout' );
get_footer( 'shop' );