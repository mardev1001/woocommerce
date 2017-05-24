<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>
<div class="singleproductwrapper container">
<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>">
	<input type="hidden" id="jqzoomimagehref" />
	<input type="hidden" id="jqzoomimagesrc" />
	<div class="singleproductleftpart">
	<div class="singleproductimage wrapper">
	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div id="singleproductdescriptionpart"></div>
	<?php woocommerce_get_template("single-product/related.php"); ?>
	<?php woocommerce_get_template("single-product/tabs/tabs.php"); ?>
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		 
	//	do_action( 'woocommerce_after_single_product_summary' );
	?>
   
	</div></div>
	<div class="singleproductrightpart">
	<div class="summary entry-summary productdescription wrapper">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
		//	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			do_action( 'woocommerce_single_product_summary' );
		?>
		
	</div><!-- .summary -->

	</div>
    <div class="clear"></div>
</div><!-- #product-<?php the_ID(); ?> -->
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>