<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>

	<div class="related products wrapper">

		<h2><?php _e( 'You may also like ..', 'woocommerce' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <li <?php post_class( $classes ); ?> >
                
                    <?php
                        woocommerce_get_template("loop/sale-flash.php");
                        if ( has_post_thumbnail() ) {
                            $image = get_the_post_thumbnail($post->ID, "classic-small" );
                            echo $image ;
						}
                    ?>
					<div class="priceandnamecontainer">
                    <a href="<?php the_permalink(); ?>">
					<?php
						$title = get_the_title();
						if( strlen( $title ) > 20 )
							$title = substr( $title, 0, 20 ) . '...';
					?>
					<h3><?php echo $title; ?></h3></a><?php woocommerce_get_template("loop/price.php"); ?>
                    </div>  
 
                </li>
			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
