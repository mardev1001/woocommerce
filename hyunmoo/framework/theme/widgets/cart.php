<?php
/**
 * Adds Cart_Widget widget.
 * This widget is shown on the toolbox sidebar.
 */
class HyunmooCartWidget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'cart', // Base ID
			'Hyunmoo: Header Cart Widget', // Name
			array( 'description' => __( 'Theme Cart Widget - Cart widget appears in header', 'hyunmoo' ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		if( !class_exists( 'woocommerce' ) )
			return;
		
		global $woocommerce;
		global $theme;
?>
<div class="header_cart">
	<a class="cart_heading" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
		<i></i><span class='count'><?php echo sprintf( _n( '%d', $woocommerce->cart->cart_contents_count, 'woothemes' ), $woocommerce->cart->cart_contents_count );?></span> <span class='txt'>item(s)</span>
	</a>
	<div class="cart_content">
	<?php                                    
		echo '<table><thead><tr><td>DESCRIPTION</td><td class="qty">QTY</td><td class="price">PRICE</td></tr></thead><tbody>';
							   
		if( sizeof( $woocommerce->cart->cart_contents ) > 0 ) : 
			foreach( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) :
				$_product = $cart_item['data'];                                       
				if( $_product->exists() && $cart_item['quantity'] > 0 ) :
					echo '<tr id="'.$_product->id.'"><td class="thumb">';
					$gbtr_product_title = $_product->get_title();
																		   
					echo '<a href="' . get_permalink( $cart_item['product_id'] ).'">' . $_product->get_image() . '<strong>' . apply_filters( 'woocommerce_cart_widget_product_title', $gbtr_product_title, $_product ) . '</strong></a></td>';                     
					echo '<td class="qty">' . $cart_item['quantity'] . "</td>";
					echo '<td class="price">';
					echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<div><a rel="' . $cart_item_key . '" href="%s" class="remove" title="%s">&times;</a></div>' . woocommerce_price( $_product->get_price() ) . '</td>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
					echo '</tr>';                                         
				endif;                                        
			endforeach;
		endif;
		echo "</tbody></table>";
	?>
		<div class="ordertotal">
			<strong>Order Sub Total:</strong>
			<b><?php echo $woocommerce->cart->get_cart_total(); ?></b>
		</div>
		<?php if($theme->getTemplate()=="tablet"){ ?>
			<a class="proceedtocheckout" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><div>Go to Cart</div></a>
		<?php } ?>
		<a class="proceedtocheckout" href="<?php echo $woocommerce->cart->get_checkout_url(); ?>"><div>Proceed to Checkout</div></a>
	</div>
</div>
<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		
	}
}
?>