<?php
	# Insert Recent Products

	function hyunmoo_shortcode_recent_products( $atts, $content = '' )
	{	
		$default_atts = array(
		);

		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
				
		$args = apply_filters('woocommerce_recent_products_args', array(
			'post_status' => 'publish',
			'post_type' => 'product',
			'posts_per_page' => 4,
		) );
		$hm_recent = new WP_Query( $args);
		
		if ($hm_recent ->have_posts()) : 
		$output= '<div class="hmrecent products">';
		$output.='<input type="hidden" id="recentpercolumn" value="'.$per_column.'">';
        $output.= '<h3>Recent Products</h3>';
        $output.= '<ul class="products">'; $ij=0;
			while ($hm_recent ->have_posts()) : 
				$hm_recent ->the_post();
				$ij++;
				$product = get_product( $hm_recent->post->ID );
				$output.= '<li class="';
				foreach(get_post_class( $classes, $product->ID ) as $prodclass)
					$output.=$prodclass." ";
				$output.='" id="recentprod'.$ij.'">';
                $output.= '<a href="'.get_permalink().'">';
                $output.= '<div class="prodimagecontainer" align="center"><div class="prodimageback"></div>';
                if ($product->is_on_sale()) : 
					$output.=apply_filters('woocommerce_sale_flash', '<span class="onsale"></span>', $post, $product);
				endif;
                if ( has_post_thumbnail() ) {
                    $image = get_the_post_thumbnail($post->ID, "grid-small" );
               		$output.=$image;
				}
                $output.='<div class="priceandnamecontainer" style="opacity:1">';
                $output.='<h3>';
				if(strlen(get_the_title())>11) 
					$output.=substr(get_the_title(),0,11)." ...<br>"; 
				else
					$output.=get_the_title();
				$output.='</h3>';
				if ( $price_html = $product->get_price_html() ) :
					$output.='<span class="price">'.$price_html.'</span>';
				endif;
				if ( $rating_html = $product->get_rating_html() ) : 
				   $output.='<div class="star-rating">';
				   for($kk=0;$kk<5;$kk++){
				   		$kkk=$kk*16;
				   		$output.='<i class="fa fa-star-o" style="left:'.$kkk.'px;"></i>';
				   }
				   $ppercent=$product->get_average_rating()*20;
				   $output.="<span style='width:".$ppercent."%;'>";
				   for($kk=0;$kk<5;$kk++){
				   		$kkk=$kk*16;
						$output.="<i class='fa fa-star' style='left:".$kkk."px;'></i>";
				   }
				   $output.="</span></div>";
				endif;
				$output.="</div></div></a></li>";
       		endwhile;
       $output.="<div class='clear'></div></ul></div>";
	   endif;		
		# Prepare Output
		
		return $output;
	} 
	add_shortcode( 'hm_recent_products', 'hyunmoo_shortcode_recent_products' );
?>