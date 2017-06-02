<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $theme;
get_header( 'shop' ); 
$theme->render( 'archive-product', 'woocommerce' );
get_footer( 'shop' );
?>
