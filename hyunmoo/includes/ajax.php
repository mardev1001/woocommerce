<?php

	//All ajax hook lists for front-end use
	add_action( 'wp_ajax_complete_search', 'completeSearch' );
	add_action( 'wp_ajax_nopriv_complete_search', 'completeSearch' );
	add_action( 'wp_ajax_search', 'search' );
	add_action( 'wp_ajax_nopriv_search', 'search' );
	add_action( 'wp_ajax_send_note', 'newNote' );
	add_action( 'wp_ajax_nopriv_send_note', 'newNote' );
	add_action( 'wp_ajax_get_products', 'getProducts' );
	add_action( 'wp_ajax_nopriv_get_products', 'getProducts' );
	add_action( 'wp_ajax_get_categories', 'getCategories' );
	add_action( 'wp_ajax_nopriv_get_categories', 'getCategories' );
	add_action( 'wp_ajax_addcart', 'addCart' );
	add_action( 'wp_ajax_nopriv_addcart', 'addCart' );
	add_action( 'wp_ajax_removecart', 'removeCart' );
	add_action( 'wp_ajax_nopriv_removecart', 'removeCart' );
	add_action( 'wp_ajax_get_posts', 'getPosts' );
	add_action( 'wp_ajax_nopriv_get_posts', 'getPosts' );
	
	function completeSearch() {
		$term = trim( $_POST['term'] );
		$term = esc_attr( $term );
		$type = trim( $_POST['type'] );
		$howmany = intval( $_POST['howmany'] );
		$offset = intval( $_POST['offset'] );
		
		$json = '';
		
		if( $type == 'product' ) {
			if( class_exists( 'woocommerce' ) )
				$wchelper = Hyunmoo::getHelper( 'woocommerce' );
			if( !$wchelper ) {
				echo '';
				die;
			}
			
			$json = $wchelper->getProducts( 'gridview' , 'none', '', '', false, $offset, $howmany, $term );
		}
		elseif( $type == 'post' ) {
			$helper = Hyunmoo::getHelper( 'blog' );
			if( !$helper ) {
				echo '';
				die;
			}
			
			$json = $helper->getPosts( 'grid' , '', '', '', '', false, $offset, $howmany, $term );
		}
		elseif( $type == 'page' ) {
			$helper = Hyunmoo::getHelper( 'blog' );
			if( !$helper ) {
				echo '';
				die;
			}
			
			$json = $helper->getPages( 'compact', false, $offset, $howmany, $term );
		}
		elseif( $type == 'user' ) {
			$args = array(
				'search'			=> '*' . $term . '*',
				'search_columns'	=> array( 'login', 'nicename', 'email' ),
				'number'			=> $howmany,
				'offset'			=> $offset
			);
			$query = new WP_User_Query( $args );

			if( $query->total_users ) {
				$users = array();
				foreach( $query->results as $user ) {
					$u = array();
					$u['title'] = $user->display_name;
					$u['link'] = get_author_posts_url( $user->ID );
					if(strlen($user->description)>50)
						$u['biography'] = substr($user->description,0,50);
					else
						$u['biography'] = $user->description;						
					$avatar = get_avatar( $user->ID, 144 );
					preg_match( "/src='(.*?)'/i", $avatar, $matches );
					$u['image'] = $matches[1];
					$users[] = $u;
				}
				$json = json_encode( $users );
			}
		}
		wp_reset_postdata();
		echo $json;
		die;
	}
	
	function search() {
		$query = trim( $_POST['query'] );
		$query = esc_attr( $query );
		$search = array();
		
		$args = array(
			's'					=> $query,
			'posts_per_page'	=> 10,
			'paged'				=> 1,
			'post_type'			=> array( 'post', 'page' ),
			'meta_query'	=> array(
				array(
					'key'	=> '_wp_page_template',
					'value'	=> array( 'tpl-login.php', 'tpl-register.php', 'tpl-recover.php', 'tpl-reset.php' ),
					'compare'	=> 'NOT IN'
				)
			)
		);
		$q_blog = new WP_Query( $args );
		if( $q_blog->found_posts && $q_blog->have_posts() ) {
			$blog = array();
			while( $q_blog->have_posts() ) {
				$q_blog->the_post();
				$item = array();
				$item['title'] = get_the_title();
				$item['link'] = get_permalink();
				$blog[] = $item;
			}
			$search['blog'] = $blog;
		}
		
		$args = array(
			's'			=> $query,
			'posts_per_page'	=> 30,
			'paged'				=> 1,
			'post_type'	=> 'product'
		);
		$q_shop = new WP_Query( $args );
		if( $q_shop->found_posts && $q_shop->have_posts() ) {
			$shop = array();
			while( $q_shop->have_posts() ) {
				$q_shop->the_post();
				$product = array();
				$product['title'] = get_the_title();
				$product['link'] = get_permalink();
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'search-thumb' );
				$product['image'] = $image[0];
				$shop[] = $product;
			}
			$search['shop'] = $shop;
		}
		$args = array(
			'search'			=> '*' . $query . '*',
			'search_columns'	=> array( 'login', 'nicename', 'email' ),
			'number'			=> 10,
			'offset'			=> 0
		);
		$q_user = new WP_User_Query( $args );
		if( $q_user->total_users ) {
			$users = array();
			foreach( $q_user->results as $user ) {
				$u = array();
				$u['title'] = $user->display_name;
				$u['link'] = get_author_posts_url( $user->ID );
				$avatar = get_avatar( $user->ID, 24 );
				preg_match( "/src='(.*?)'/i", $avatar, $matches );
				$u['image'] = $matches[1];
				$users[] = $u;
			}
			$search['users'] = $users;
		}
		wp_reset_postdata();
		echo json_encode( $search );
		die;
	}
	function newNote() {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$inquiry = $_POST['inquiry'];
		
		$atts = array();
		$atts['date'] = date( 'm-d-Y H:i:s' );
		$atts = mysql_real_escape_string( json_encode( $atts ) );
		
		$subject = mysql_real_escape_string( $subject );
		$filename = strtolower( sanitize_file_name( $subject ) ) . md5( rand( 1, 99999999 ) );
		if( strlen( $filename ) > 200 )
			$filename = substr( $filename, 0, 200 );
		
		global $wpdb;
		$sql = "INSERT INTO {$wpdb->prefix}hyunmoo_records (`id`, `name`, `title`, `type`, `attributes`, `status`) VALUES  (NULL, '$filename', '$subject', 'inquiry', '$atts', 'unsolved')";
		
		$wpdb->query( $sql );
		
		$config = 'inquiry.' . $filename;
		$data = array();
		$data['name'] = $name;
		$data['email'] = $email;
		$data['subject'] = $subject;
		$data['note'] = $inquiry;
		Hyunmoo::setConfig( $config, $data, 'records' );
		
		echo $config;die;
	}
	function getProducts() {
		if( class_exists( 'woocommerce' ) )
			$wchelper = Hyunmoo::getHelper( 'woocommerce' );
		if( !$wchelper ) {
			echo '';
			die;
		}
		
		$view = $_POST['view'];
		$sort = $_POST['sort'];
		$category = $_POST['category'];
		$tags = $_POST['tags'];
		$atts = $_POST['atts'];
		$offset = intval( $_POST['offset'] );
		$howmany = intval( $_POST['howmany'] );
		
		$json = $wchelper->getProducts( $view, $sort, $category, $tags, $atts, $offset, $howmany );
		echo $json;
		die;
	}
	function getCategories() {
		if( class_exists( 'woocommerce' ) )
			$wchelper = Hyunmoo::getHelper( 'woocommerce' );
		if( !$wchelper ) {
			echo '';
			die;
		}
		
		$parent = $_POST['parent'];
		$json = $wchelper->getCategories( $parent );
		echo $json;
		die;
	}
	function addCart() {
		if( class_exists( 'woocommerce' ) )
			$wchelper = Hyunmoo::getHelper( 'woocommerce' );
		if( !$wchelper ) {
			echo '';
			die;
		}
		
		$product_id = intval( $_POST['product'] );
		$amount = isset( $_POST['amount'] ) ? intval( $_POST['amount'] ) : 1;
		$cartjs = $wchelper->addCart( $product_id, $amount );
		echo json_encode( $cartjs );
		die;
	}
	function removeCart() {
		if( class_exists( 'woocommerce' ) )
			$wchelper = Hyunmoo::getHelper( 'woocommerce' );
		if( !$wchelper ) {
			echo '';
			die;
		}
		
		$key = $_POST['key'];
		$cartjs = $wchelper->removeCart( $key );
		echo json_encode( $cartjs );
		die;
	}
	
	function getPosts() {
		$helper = Hyunmoo::getHelper( 'blog' );
		if( !$helper ) {
			echo '';
			die;
		}
		
		$view = $_POST['view'];
		$sidebar = $_POST['sidebar'];
		$category = $_POST['category'];
		$author = $_POST['author'];
		$tags = $_POST['tags'];
		$atts = $_POST['atts'];
		$offset = intval( $_POST['offset'] );
		$howmany = intval( $_POST['howmany'] );
		
		$json = $helper->getPosts( $view, $sidebar, $category, $author, $tags, $atts, $offset, $howmany );
		echo $json;
		die;
	}
?>