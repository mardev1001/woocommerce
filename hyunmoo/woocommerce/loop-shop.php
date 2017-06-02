<?php
/**
 * Loop-shop (deprecated)
 *
 * Outputs a product loop
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 * @deprecated 	1.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $theme;
$theme->render( 'loop-shop', 'woocommerce' );