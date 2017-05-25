<?php
/**
 * Single Product Tags
 *
 * @author 		Hyunmoo
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

?>
<h1 class="product_tags"><i class="fa fa-tags"></i>
<?php
	$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
	echo $product->get_tags( ' ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '</span>' ); 
?>
</h1>