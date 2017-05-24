<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/woocommerce/taxonomy-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$category = get_queried_object();
$display = get_woocommerce_term_meta( $category->term_id, 'display_type' );
if( $display == '' )
	$display = get_option( 'woocommerce_category_archive_display' );

woocommerce_get_template( 'archive-product.php' );