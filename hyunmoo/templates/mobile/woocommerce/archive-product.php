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
?>

<?php
	global $display, $category, $tag;
	
	if( is_shop() )
		$display = get_option( 'woocommerce_shop_page_display' );
?>
<input type="hidden" id="categoryid" value="<?php if( is_shop() ) echo 0; else echo $category->term_id ?>" />
<input type="hidden" id="categoryslug" value="<?php echo $category->slug ?>" />
<input type="hidden" id="tags" value="<?php echo $tag->slug ?>" />
<input type="hidden" id="pagedisplaymode" value="<?php echo $display; ?>" />

<div class="container1">
<div class="shopcontainer">

		<?php if ( have_posts() ) : ?>
			
			<?php woocommerce_product_loop_start(); ?>
				               
			<?php woocommerce_product_loop_end(); ?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?></div></div>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>