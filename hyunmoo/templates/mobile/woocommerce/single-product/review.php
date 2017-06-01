<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
$rating = esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="commentandrating">
		<?php echo get_avatar( $GLOBALS['comment'], $size='60' ); ?>
        <?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>

				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating skin-primary-text" title="<?php echo sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) ?>">
					<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php for($si=0;$si<5;$si++){if($si<=intval(get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) )-1){ ?><i class='fa fa-star'></i><?php }else{ ?><i class='fa fa-star-o'></i><?php }} ?></strong></span>
				</div>

			<?php endif; ?>
		</div>
		<div class="commentmeta">
			<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>
			<?php else : ?>
				<p class="meta">
					by <strong itemprop="author"><?php comment_author(); ?></strong> <?php

						if ( get_option('woocommerce_review_rating_verification_label') == 'yes' )
							if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) )
								echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

					?>on <time itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(__( get_option('date_format'), 'woocommerce' )); ?></time>
				</p>
			<?php endif; ?></div>
				<div class="clear"></div>
		<div class="comment-text">
			<div itemprop="description" class="description"><?php comment_text(); ?></div>

				
			</div>
		<div class="clear"></div>
	</div>