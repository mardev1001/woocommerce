<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
?>

<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<?php //echo $rating_html; ?>
   <div class='star-rating onload'>
   <?php for($kk=0;$kk<5;$kk++){ ?>
		<i class='fa fa-star-o' style='left:<?php echo $kk*16; ?>px;'></i>
   <?php } ?>
   <span style='width:<?php echo $product->get_average_rating()*20; ?>%;'>
   <?php for($kk=0;$kk<5;$kk++){ ?>
   		<i class='fa fa-star' style='left:<?php echo $kk*16; ?>px;'></i>
   <?php } ?>
	</span>
   </div>
<?php endif; ?>