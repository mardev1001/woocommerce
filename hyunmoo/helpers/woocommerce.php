<?php

class HyunmooHelperWoocommerce {

	public function &getProducts( $view = 'classicview', $sort = 'none', $category = '', $tags = '', $atts = false, $offset = 0, $howmany = 20, $search = false ) {
		$args = $this->buildQuery( $sort );
		// The Query
		
		$args['product_cat'] = $category;
		$args['product_tag'] = $tags;
		$args['offset'] = $offset;
		$args['posts_per_page'] = $howmany;
		if( $search )
			$args['s'] = $search;

		$data = array( );
		$data['products'] = array();
		while( count( $data['products'] ) < $howmany ) :
			$query = new WP_Query( $args );
			
			if ( $query->have_posts() ) :
				// The Loop
				while ( $query->have_posts() ) {
					$query->the_post();
					
					global $post, $product;
					
					if( $product->is_in_stock() ) {
						$id = get_the_ID();
						$link = get_permalink();
						$title = get_the_title();
						$rating = $product->get_average_rating();
						$price = $product->get_price_html();
						
						if ( $product->is_on_sale() ) 
							$sale = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale', 'woocommerce' ) . '</span><br>', $post, $product );
						else
							$sale="not sale";
						$cart = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
						switch( $view )
						{
							case 'classicview':
								$image1 = get_the_post_thumbnail( get_the_ID(), 'classic-large' );
								$image2 = get_the_post_thumbnail( get_the_ID(), 'classic-small' );
								break;
							case 'gridview':
								$image1 = get_the_post_thumbnail( get_the_ID(), 'grid-large' );
								$image2 = get_the_post_thumbnail( get_the_ID(), 'grid-small' );
								break;
							case 'compactview':
								$image1 = get_the_post_thumbnail( get_the_ID(), 'compact' );
								break;
						}
						$pdt = array(
							'id'			=> $id,
							'image1'		=> $image1,
							'image2'		=> $image2,
							'link'			=> $link,
							'title'			=> $title,
							'rating'		=> $rating,
							'price'			=> $price,
							'sale'			=> $sale,
							'cart'			=> $cart
						);
						if( $this->is_filtered( $product, $atts ) )
							$data['products'][] = $pdt;
					}
				}
			endif;
			$args['offset'] += $howmany;
			if( $query->found_posts == 0 || $args['offset'] > $query->found_posts )
				break;
		endwhile;
			/* Restore original Post Data 
			 * NB: Because we are using new WP_Query we aren't stomping on the 
			 * original $wp_query and it does not need to be reset.
			*/
		wp_reset_postdata();
		$data['offset'] = $args['offset'];
		$results = json_encode( $data );
		return $results;
	}
	public function &getCategories( $parent ) {
		$catTerms = get_terms( 'product_cat','parent=' . $parent . '&orderby=count&hide_empty=0' );
		$categories=array( );
		foreach($catTerms as $catTerm){
			$link=get_term_link($catTerm->slug, 'product_cat');
			$name=$catTerm->name;
			$count=$catTerm->count;
			$image = wp_get_attachment_image( get_woocommerce_term_meta( $catTerm->term_id, 'thumbnail_id', true ), 'classic-small' );
			$cat = array(
				'image'  => $image,
				'link'	  => $link,
				'count'	  => $count,
				'title'	  => $name,
			);
			$categories[] = $cat;
		}
		$results = json_encode( $categories );
		return $results;
	}
	public function &getCart() {
		global $woocommerce;
		
		$cart = $woocommerce->cart->cart_contents;
		$cartjs = array();
		$cartjs['currency'] = get_woocommerce_currency_symbol();
		$cartjs['total'] = $woocommerce->cart->get_cart_total();
		$cartjs['totalcount'] = $woocommerce->cart->cart_contents_count;
		$cartjs['items'] = array();
		foreach( $cart as $key => $item ) {
			$_pdt = $item['data'];
			$products = array();
			$products['id'] = $_pdt->id;
			$products['title'] = $_pdt->get_title();
			$products['link'] = get_permalink( $_pdt->id );
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $_pdt->id ), 'shop_thumbnail' );
			$products['image'] = $src[0];
			$products['quantity'] = $item['quantity'];
			$products['price'] = $_pdt->get_price();
			$products['formatted'] = number_format( $_pdt->get_price() );
			$products['removeurl'] = esc_url( $woocommerce->cart->get_remove_url( $key ) );
			$products['key'] = $key;
			
			$cartjs['items'][] = $products;
		}
		return $cartjs;
	}
	public function &addCart( $product_id, $amount ) {
		global $woocommerce;
		$woocommerce->cart->add_to_cart( $product_id, $amount );
		
		$cartjs = $this->getCart();
		return $cartjs;
	}
	public function &removeCart( $key ) {
		global $woocommerce;
		$woocommerce->cart->set_quantity( $key, 0 );
		
		$cartjs = $this->getCart();
		return $cartjs;
	}
	public function &buildQuery( $sort ) {
		global $woocommerce;
		
		$args = array();
		$args['post_type'] = 'product';
	//	$args['no_found_rows'] = 1;	//Speed up query, must be disabled for infinite scroll when scrolling
		$args['post_status'] = 'publish';
		$meta_query = $woocommerce->query->get_meta_query();
		$args['meta_query'] = array();
	//	$args['meta_query'][] = $meta_query;
		switch( $sort ) {
		case 'default':
			$args['order'] = 'DESC';
			$args['orderby'] = 'ID';
			break;
		case 'new':
			$args['order'] = 'DESC';
			$args['orderby'] = 'date';
			break;
		case 'old':
			$args['order'] = 'ASC';
			$args['orderby'] = 'date';
			break;
		case 'name':
			$args['order'] = 'ASC';
			$args['orderby'] = 'name';
			break;
		case 'sales':
			$args['meta_key'] = 'total_sales';
			$args['order'] = 'DESC';
			$args['orderby'] = 'meta_value_num';
			break;
		case 'rate':
			add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
			$args['post_type'] = 'product';
			$args['product_cat'] = $category;
			$args['product_tag'] = $tags;
			$args['offset'] = $offset;
			$args['no_found_rows'] = 1;
			$args['posts_per_page'] = $howmany;
			$args['post_status'] = 'publish';
			break;
		case 'highprice':
			$args['meta_key'] = '_price';
			$args['order'] = 'DESC';
			$args['orderby'] = 'meta_value_num';
			$args['meta_query'][] = array(
				'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL'
			);
			break;
		case 'lowprice':
			$args['meta_key'] = '_price';
			$args['order'] = 'ASC';
			$args['orderby'] = 'meta_value_num';
			$args['meta_query'][] = array(
				'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL'
			);
			break;
		case 'onsale':
			// Get products on sale
			$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
			$product_ids_on_sale[] = 0;
			$args['orderby'] = 'date';
			$args['order'] = 'ASC';
			$args['post__in'] = $product_ids_on_sale;
			break;
		case 'featured':
			$args['meta_query'][] = array(
				'key'	=> '_featured',
				'value'	=> 'yes'
			);
		default:
			$args['orderby'] = 'none';
			break;
		}
		return $args;
	}
	public function is_filtered( $product, $atts ) {
		$atts = json_decode( stripslashes( $atts ), true );
		if( !$atts )
			return true;

		$price = $product->get_price();
		if( isset( $atts['minPrice'] ) && $price < $atts['minPrice'] )
			return false;
		if( isset( $atts['maxPrice'] ) && $price > $atts['maxPrice'] )
			return false;
		
		$attributes = $product->get_attributes();
		$att_names = array();
		foreach( $attributes as $att )
			if( $att['is_taxonomy'] )
				$att_names[] = $att['name'];
		$att_names_query = array();
		foreach( $atts as $key => $att )
			if( substr( $key, 0, 3 ) == 'pa_' && $att != '' )
				$att_names_query[] = $key;
		foreach( $att_names_query as $name )
			if( !in_array( $name, $att_names ) )
				return false;	//Check if product has certain attribute field
		
		foreach( $atts as $key => $att ) {
			if( substr( $key, 0, 3 ) == 'pa_' && $att != '' ) {
				$values = woocommerce_get_product_terms( $product->id, $key, 'slugs' );
				$criteria = explode( ',', $att );
				$test = array_intersect( $values, $criteria );
				if( empty( $test ) )
					return false;
			}
		}
		return true;
	}
}
?>