
<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="thumbnails"><ul><?php

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_smalldata =wp_get_attachment_image_src( $attachment_id, "classic-large" );
			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );
			$gal1="gal1";
			
			//echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s"  rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="item"><a href="javascript:void(0);"  rel="{gallery: \''.$gal1.'\', smallimage: \''.$image_smalldata[0].'\',largeimage: \''.$image_link.'\',width: \''.$image_smalldata[1].'\',height: \''.$image_smalldata[2].'\'}">%s</a></li>', $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?></ul></div>
<?php
} ?>