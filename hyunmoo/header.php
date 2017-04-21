<?php
	global $theme;
	
	$path = get_template_directory_uri();
	$template = $theme->getTemplate();
//Styles for template
	$theme->enqueue_style( 'bootstrap-style', $path . '/css/bootstrap.css' );
	$theme->enqueue_style( 'fontawesome-style', $path . '/css/font-awesome.min.css' );
	$theme->enqueue_style( 'select2-style', $path . '/css/select2.css' );
	$theme->enqueue_style( 'owlcarousel-style', $path . '/css/owl.carousel.css' );
	$theme->enqueue_style( 'range-slider-style', $path . '/css/jquery.slider.min.css' );
	if( $template == 'baby' && class_exists( 'woocommerce' ) && is_product() ) {
		$theme->enqueue_style( 'jqzoom-style', $path . '/css/jquery.jqzoom.css' );
	}
	$theme->enqueue_style( 'responsive-style', $path . '/css/responsive.css' );
	$theme->enqueue_style( 'shortcode-style', $path . '/css/shortcode.css' );
//Scripts for template
	$theme->enqueue_script( 'jquery' );
	$theme->enqueue_script( 'jquery-ui-core' );
	$theme->enqueue_script( 'jquery-ui-tabs' );
	if( $template == 'baby' ) {
		$theme->enqueue_script( 'jquery-effects-core' );
		$theme->enqueue_script( 'jquery-effects-slide' );
	}
	$theme->enqueue_script( 'bootstrap-script', $path . '/js/bootstrap.js', true );
	$theme->enqueue_script( 'select2-script', $path . '/js/select2.min.js', true );
	$theme->enqueue_script( 'owlcarousel-script', $path . '/js/owl.carousel.js' );
	$theme->enqueue_script( 'jquery-parallax', $path . '/js/parallax.js' );
	$theme->enqueue_script( 'jquery-cookie', $path . '/js/jquery.cookie.js' );
	$theme->enqueue_script( 'range-slider-script', $path . '/js/jquery.slider.min.js' );
	$theme->enqueue_script( 'slimscroll-script', $path . '/js/jquery.slimscroll.min.js', true );
	if( $template == 'baby' ) {
		$theme->enqueue_script( 'theme-functions-script', $path . '/js/theme-functions.js', true );
		$theme->enqueue_script( 'theme-main-script', $path . '/js/theme-main.js', true );
	}
	elseif( $template == 'tablet' ) {
		$theme->enqueue_script( 'theme-functions-script', $path . '/js/theme-functions-tablet.js', true );
		$theme->enqueue_script( 'theme-main-script', $path . '/js/theme-main-tablet.js', true );
	}
	elseif( $template == 'mobile' ) {
		$theme->enqueue_script( 'theme-functions-script', $path . '/js/theme-functions-mobile.js', true );
		$theme->enqueue_script( 'theme-main-script', $path . '/js/theme-main-mobile.js', true );
	}
	$theme->enqueue_script( 'theme-search-script', $path . '/js/theme-search.js', true );
	$theme->enqueue_script( 'theme-elements-script', $path . '/js/theme-elements.js', true );
	if( $template == 'baby' || $template == 'tablet' )
		$theme->enqueue_script( 'theme-toolbox-script', $path . '/js/theme-toolbox.js', true );
	$theme->enqueue_script( 'shortcode-script', $path . '/js/shortcode.js', true );
	if ( is_singular() )
		wp_enqueue_script( "comment-reply" );
	if( class_exists( 'woocommerce' ) ) {
		if( is_product() ) {
			if( $template == 'baby' )
				$theme->enqueue_script( 'jqzoom-script', $path . '/js/jquery.jqzoom-core.js');
			$theme->enqueue_script( 'theme-woocommerce-product', $path . '/js/wc-product.js', true );
			$theme->enqueue_script( 'theme-woocommerce-product-assist', $path . '/js/single-product.js', true );
		}
		elseif( is_shop() || is_product_category() || is_product_tag() ) {
			$theme->enqueue_script( 'theme-woocommerce-shop', $path . '/js/wc-shop.js', true );
		}
		elseif( is_cart() ) {
			$theme->enqueue_script( 'theme-woocommerce-cart', $path . '/js/wc-cart.js', true );
		}
		elseif( is_checkout() || is_account_page() ) {
			$theme->enqueue_script( 'theme-woocommerce-checkout', $path . '/js/wc-checkout.js', true );
		}
		elseif( is_home() || is_archive() ){
			$theme->enqueue_script('theme-blog-script', $path . '/js/blog-script.js', true );
		}
		elseif( is_single() ){
			$theme->enqueue_script('theme-single-script', $path . '/js/single-post.js', true );
		}
	}
	$theme->render( 'header' );
?>