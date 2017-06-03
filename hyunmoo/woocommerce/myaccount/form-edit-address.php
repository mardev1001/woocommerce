<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$GLOBALS['load_address'] = $load_address;
$GLOBALS['address'] = $address;

global $theme;
$theme->render( 'form-edit-address', 'woocommerce/myaccount' );