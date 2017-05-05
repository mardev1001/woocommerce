<?php
/**
 * Adds Shop_Widget widget.
 * This widget is shown on the toolbox sidebar.
 */
class HyunmooShopWidget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'shop', // Base ID
			'Hyunmoo: Toolbox Shop Widget', // Name
			array( 'description' => __( 'Theme Shop Widget - Users will be given rich options when viewing and filtering products in the toolbox', 'hyunmoo' ) ) // Args
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
			return;		//Check if woocommerce is installed
		if( !is_woocommerce() || is_product() )
			return;	//Check if product archive page
		if( !is_shop() && !is_product_category() && !is_product_tag() )
			return;
		if( is_shop() ) {
			$display = get_option( 'woocommerce_shop_page_display' );
			if( $display == 'subcategories' )
				return;		//Check if shop page view type is products
		}
		$term = get_queried_object();
		
		$display = get_woocommerce_term_meta( $term->term_id, 'display_type' );
		if( $display == 'subcategories' )
			return;	//Check if product categories page
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		if ( ! empty( $title ) )
			echo '<div class="tool-title">' . $title . '</div>';	
		$currency = get_woocommerce_currency();
		$symbol = get_woocommerce_currency_symbol( $currency );
		$obj = get_queried_object();
		$parent = 0;
		if( $obj->taxonomy == 'product_cat' )
			$parent = $obj->term_id;
		
		$args = array(
			'hierarchical' => 1,
			'show_option_none' => '',
			'hide_empty' => 0,
			'parent' => $parent,
			'taxonomy' => 'product_cat'
		);
		$subcats = get_categories( $args, 'product_cat' );
		if( empty( $subcats ) && $parent > 0 ) {
			$parent = $obj->parent;
			$args = array(
				'hierarchical' => 1,
				'show_option_none' => '',
				'hide_empty' => 0,
				'parent' => $parent,
				'taxonomy' => 'product_cat'
			);
			$subcats = get_categories( $args, 'product_cat' );
		}
		
		$tags = get_terms( 'product_tag' );
		
		global $woocommerce;
		$attributes = $woocommerce->get_attribute_taxonomies();
?>
<div class="tool-content shop">
	<p>
		<select id="pdt_display">
			<option value="gridview">Grid View</option>
			<option value="classicview">Classic View</option>
			<option value="compactview">Compact View</option>
		</select>
	</p>
	<p>
		<select id="sort">
			<option value="default">Default</option>
			<option value="new">Newest</option>
			<option value="old">Oldest</option>
			<option value="name">Alphabetic</option>
			<option value="sales">Best sellers</option>
			<option value="rate">Top rated</option>
			<option value="highprice">High prices</option>
			<option value="lowprice">Low prices</option>
			<option value="onsale">Saled only</option>
			<option value="featured">Featured only</option>
		</select>
	</p>
	<br>
	<p>
		<div class="layout-slider">
			<input id="price" type="slider" name="area" value="0;<?php echo $instance['maxprice'] ?>" />
		</div>
		<script type="text/javascript">
			jQuery("#price").slider({ from: 0, to: <?php echo $instance['maxprice'] ?>, limits: false, step: 1, dimension: '<?php echo $symbol ?>', skin: "round_plastic" });
		</script>
	</p>
	<?php if( !empty( $subcats ) ) : ?>
	<p>
		<select id="pdt_subcats" multiple>
		<?php
			foreach( $subcats as $cat ) :
		?>
			<option value="<?php echo $cat->slug ?>"><?php echo $cat->name ?></option>
		<?php endforeach; ?>
		</select>
	</p>
	<?php endif; ?>
	<?php if( !empty( $tags ) ): ?>
	<p>
		<select id="pdt_tags" multiple>
		<?php
			foreach( $tags as $tag ) :
		?>
			<option value="<?php echo $tag->slug ?>"><?php echo $tag->name ?></option>
		<?php endforeach; ?>
		</select>
	</p>
	<?php endif; ?>
	<?php if( !empty( $attributes ) ): ?>
	<?php foreach( $attributes as $attr ): ?>
		<?php
			$attname = $woocommerce->attribute_taxonomy_name( $attr->attribute_name );
			if( !in_array( $attname, $instance['attributes'] ) )
				continue;
			$terms = get_terms( $attname );
			if( !empty( $terms ) ):
		?>
		<p>
		<select class="shop_att_list" id="<?php echo $attname ?>" multiple>
		<?php foreach( $terms as $term ): ?>
			<option value="<?php echo $term->slug ?>"><?php echo $term->name ?></option>
		<?php endforeach; ?>
		</select>
		</p>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
	<p>
		<button class="btn form-control" style="background: #4e72d9 !important;" id="pdt_filter">Filter products</button>
	</p>
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
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Shop', 'hyunmoo' );
		}
		if( isset( $instance[ 'maxprice' ] ) ) {
			$maxprice = intval($instance[ 'maxprice' ]);
		}
		else {
			$maxprice = 10000;
		}
		
		global $woocommerce;
		$attributes = $woocommerce->get_attribute_taxonomies();
		
		$options = array();
		foreach( $attributes as $attr ) {
			$value = $woocommerce->attribute_taxonomy_name( $attr->attribute_name );
			$options[] = $value;
		}
		if( isset( $instance[ 'attributes'] ) ) {
			$options = $instance['attributes'];
		}
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'maxprice' ); ?>"><?php _e( 'Max Price' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'maxprice' ); ?>" name="<?php echo $this->get_field_name( 'maxprice' ); ?>" type="text" value="<?php echo $maxprice; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'attributes' ); ?>"><?php _e( 'Include attributes' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'attributes' ); ?>" name="<?php echo $this->get_field_name( 'attributes' ); ?>[]" multiple>
		<?php
			foreach( $attributes as $attr ):
				$val = $woocommerce->attribute_taxonomy_name( $attr->attribute_name );
				$text = $attr->attribute_label;
		?>
			<option value="<?php echo $val ?>" <?php if( in_array( $val, $options ) ) echo 'selected="selected"'; ?>><?php echo $text ?></option>
		<?php endforeach; ?>
		</select>
		</p>
		
		<?php 
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['maxprice'] = ( intval( $new_instance['maxprice'] ) <= 0 ) ? 10000 : intval( $new_instance['maxprice'] );
		$instance['attributes'] = $new_instance['attributes'];
		
		return $instance;
	}
}
?>