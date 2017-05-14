<?php

class HyunmooHelperBlog {
	
	public function getPosts( $view , $sidebar , $category = '', $author = '', $tags = '', $atts = false, $offset = 0, $howmany = 20, $search = false ) {
		// The Query
		$args = array(
			'post_type' => 'post'
		);
		$args['category_name'] = $category;
		$args['author_name'] = $author_name;
		$args['tag'] = $tags;
		$args['offset'] = $offset;
		$args['posts_per_page'] = $howmany;
		if( $search )
			$args['s'] = $search;
		$query = new WP_Query( $args );
		$posts = array( );
		
		if ( $query->have_posts() ) :
			// The Loop
			while ( $query->have_posts() ) {
				$query->the_post();
				
				global $post;
				
				if( $post ) {
					$id = get_the_ID();
					$link = get_permalink();
					$title = get_the_title();
					if( strlen( strip_tags( do_shortcode( get_the_content() ) , "<p><a><br><br/>" ) ) > 300 ) 
						$content = substr( strip_tags( do_shortcode( get_the_content() ) , "<p><a><br><br/>" ) , 0, 300 ) . " ...<br>" ; 
					else 
						$content = strip_tags( do_shortcode( get_the_content() ) , "<p><a><br><br/>" ) ; 
					$date = get_the_date();
					$pi = 0; $pt = 0;
					$postcategories = get_the_category(); 
					$postcatcount = sizeof( $postcategories );
					$posttagcount = sizeof( get_the_tags() );
					$category = ""; $tag = "";
					if(get_the_category()){
						foreach(get_the_category() as $postcategory){
							$category.= "<a class='skin-primary-text' href='".get_category_link($postcategory->term_id) . "' title='" . $postcategory->name . "'>" . $postcategory->name . "</a>"; $pi++;
							if($pi<$postcatcount)
								$category .= ", ";	
						}
					}
					if(get_the_tags()){
						foreach(get_the_tags() as $posttag){
							$tag.= "<a class='skin-primary-text' href='".get_tag_link($posttag->term_id) . "' title='" . $posttag->name . "'>" . $posttag->name . "</a>"; $pt++;
							if($pt<$posttagcount)
								$tag.= ", ";	
						}
					}
					$author = get_the_author();
					$authorlink = get_author_posts_url( get_the_author_meta( 'ID' ) );
					if( get_comments_number( $id ) == 0 )
						$commentlink = get_permalink() . "#respond";
					else
						$commentlink = get_permalink() . "#comments";
					if( get_comments_number( $id ) == 0 )
						$commenttxt = "No comments";
					else if( get_comments_number( $id ) == 1 )
						$commenttxt = get_comments_number( $id ) . " comment";
					else
						$commenttxt = get_comments_number( $id ) . " comments";
					
					if( !get_post_meta( $post->ID, "_hyunmoo_featured_slider" , true ) ){
						switch( $view )
						{
							case 'grid':
								$image = get_the_post_thumbnail( get_the_ID(),'postimage-grid' );
								break;
							case 'largeimage':
								if( $sidebar == 'nosidebar')
									$image = get_the_post_thumbnail( get_the_ID(), 'postimage-large-nosidebar' );
								else if($sidebar == 'left' || $sidebar == 'right')
									$image = get_the_post_thumbnail( get_the_ID(), 'postimage-large' );
								break;
							case 'smallimage':
								if( $sidebar == 'nosidebar')
									$image = get_the_post_thumbnail( get_the_ID(), 'postimage-small-nosidebar' );
								else if($sidebar == 'left' || $sidebar == 'right')
									$image = get_the_post_thumbnail( get_the_ID(), 'postimage-small' );
								break;
						}	
					}else{
						$slider = Hyunmoo::getConfig( 'slider.' . get_post_meta( $post->ID,"_hyunmoo_featured_slider", true ), 'records' ); 
						if( is_array( $slider ) && !empty( $slider ) ) {
							$image = '<div class="hmslider-post">';
							foreach($slider['slides'] as $slide){
								$image .= '<div class="item"><img src="' . $slide['imgurl'] . '"><div class="content">' . '</div><div class="caption">' . $slide['caption'] . '</div></div>';				
							}
							$image .= '</div>';
						}
					}			
					$pst = array(
						'id'    => $id,
						'image'  => $image,
						'link'	  => $link,
						'title'	  => $title,
						'content'  => $content,
						'date'	  => $date,
						'tag'	 => $tag,
						'category'	 => $category,
						'author'    => $author,
						'authorlink'    => $authorlink,
						'commentlink'    => $commentlink,
						'commenttxt'    => $commenttxt
					);
					$posts[] = $pst;
				}
			}
		endif;
			/* Restore original Post Data 
			 * NB: Because we are using new WP_Query we aren't stomping on the 
			 * original $wp_query and it does not need to be reset.
			*/
		wp_reset_postdata();
		$results = json_encode( $posts );
		return $results;
	}
	public function getPages( $size , $atts = false, $offset = 0, $howmany = 20, $search = false ) {
		// The Query
		$args = array(
			'post_type' => 'page'
		);
		$args['offset'] = $offset;
		$args['posts_per_page'] = $howmany;
		$args['meta_query'] = array(
			'key'	=> '_wp_page_template',
			'value'	=> array( 'tpl-login.php', 'tpl-register.php', 'tpl-recover.php', 'tpl-reset.php' ),
			'compare'	=> 'NOT IN'
		);
		if( $search )
			$args['s'] = $search;
		
		$query = new WP_Query( $args );
		$pages = array( );
		
		if ( $query->have_posts() ) :
			// The Loop
			while ( $query->have_posts() ) {
				$query->the_post();
				
				global $post;
				
				if( $post ) {
					$id= get_the_ID();
					$link = get_permalink();
					$title = get_the_title();
					if( strlen( strip_tags( strip_shortcodes ( get_the_content() ) , "<p><a><br><br/>" ) ) > 300 ) 
						$content = substr( strip_tags( strip_shortcodes( get_the_content() ) , "<p><a><br><br/>" ) , 0, 300 ) . " ...<br>"; 
					else 
						$content = strip_tags( strip_shortcodes ( get_the_content() ) , "<p><a><br><br/>" ); 
					$date = get_the_date();
					
					$author = get_the_author();
					$authorlink = get_author_posts_url( get_the_author_meta( 'ID' ) );
					
					$image = get_the_post_thumbnail( get_the_ID(), $size );
							
								
					$p = array(
						'id'    => $id,
						'image'  => $image,
						'link'	  => $link,
						'title'	  => $title,
						'content'  => $content,
						'date'	  => $date,
						'author'    => $author,
						'authorlink'    => $authorlink
					);
					$pages[] = $p;
				}
			}
		endif;
			/* Restore original Post Data 
			 * NB: Because we are using new WP_Query we aren't stomping on the 
			 * original $wp_query and it does not need to be reset.
			*/
		wp_reset_postdata();
		$results = json_encode( $pages );
		return $results;
	}
}
?>