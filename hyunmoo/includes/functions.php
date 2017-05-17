<?php
//Fallback function when no menu assigned
	function hyunmoo_nomenu() {
		echo '<div class="menu"></div>';
	}

//Hook for comment display on single post
	function hyunmoo_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$add_below = '';
		global $theme;
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	
		<div class="the-comment">
			<div class="avatar">
				<?php echo get_avatar( $comment, 60 ); ?>
			</div>
			<?php if( $theme->getTemplate() == "mobile" ) { ?>
			<div class="comment-author meta">
               	<?php if ($comment->comment_approved == '0') { ?>
				<em><?php echo __('Your comment is awaiting approval.', 'Hyunmoo') ?></em>
				<br />
				<?php }else{ ?>
				By <strong><?php echo get_comment_author_link() ?></strong> 
				On <?php printf( __( '%1$s at %2$s', 'hyunmoo' ), get_comment_date(),  get_comment_time() ) ?></a>&nbsp;<?php edit_comment_link( __( '(Edit)', 'hyunmoo' ), '  ', '' ) ?>&nbsp;<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'hyunmoo' ), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				<?php } ?>
			</div><div class="clear"></div>
			<?php } ?>
			<div class="comment-box">
			
				<div class="comment-txt">
					<?php comment_text() ?>
				</div>
                
				<?php if( $theme->getTemplate() != "mobile" ) { ?>
				<div class="comment-author meta">
                	<?php if ( $comment->comment_approved == '0' ) { ?>
					<em><?php echo __( 'Your comment is awaiting approval.', 'hyunmoo' ) ?></em>
					<br />
					<?php }else{ ?>
					By <strong><?php echo get_comment_author_link() ?></strong> 
					On <?php printf( __( '%1$s at %2$s', 'hyunmoo' ), get_comment_date(),  get_comment_time() ) ?></a>&nbsp;<?php edit_comment_link( __( '(Edit)', 'hyunmoo' ), '  ', '' ) ?>&nbsp;<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'hyunmoo' ), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<div style="clear:both"></div>
		</div>
<?php
	}
// Breadcrumb for the top of pages
function hyunmoo_breadcrumb() {
	global $post;

	$delimiter = '&raquo;';
	$currentBefore = '<span class="current">';
	$currentAfter = '</span>';

	if ( !is_home() || !is_front_page() || is_paged() ) :
		$flag = 1;
		echo '<div id="crumbs">';
		echo '<a href="' . home_url() . '">' . __( 'Home', 'hyunmoo' ) . '</a> ' . $delimiter . ' ';

		// figure out what to display
		switch ( $flag ) :
			case is_tax():
				// get the current ad category
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				// get the current ad category parent id
				$parent = $term->parent;
				// WP doesn't have a function to grab the top-level term id so we need to
				// climb up the tree and create a list of all the ad cat parents
				while ( $parent ):
					$parents[] = $parent;
					$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
					$parent = $new_parent->parent;
				endwhile;
				
				// if parents are found display them
				if( !empty( $parents ) ):
					// flip the array over so we can print out descending
					$parents = array_reverse( $parents );
					// for each parent, create a breadcrumb item
					foreach ( $parents as $parent ):
						$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
						$url = get_term_link( $iterm );
						echo '<a href="' . $url . '">' . $item->name . '</a> ' . $delimiter . ' ';
					endforeach;
				endif;
				echo $currentBefore . $term->name . $currentAfter;
			break;

			case is_single():
				$cat = get_the_category();
				$cat = $cat[0];
				echo get_category_parents( $cat, TRUE, " $delimiter " );
				echo $currentBefore . the_title() . $currentAfter;
			break;

			case is_category():
				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category( $thisCat );
				$parentCat = get_category( $thisCat->parent );
				if ( $thisCat->parent != 0 ) echo( get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' ) );
				echo $currentBefore . single_cat_title() . $currentAfter;
			break;

			case is_page():
				// get the parent page id
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				if ($parent_id > 0 ) :
					// now loop through and put all parent pages found above current one in array
					while ( $parent_id ) {
						$page = get_page( $parent_id );
						$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
						$parent_id  = $page->post_parent;
					}

					$breadcrumbs = array_reverse( $breadcrumbs );
					foreach ( $breadcrumbs as $crumb ) echo $crumb . ' ' . $delimiter . ' ';
				endif;
				echo $currentBefore . the_title() . $currentAfter;
			break;

			case is_search():
				echo $currentBefore . __( 'Search results for', 'hyunmoo' ) .' &#39;' . get_search_query() . '&#39;' . $currentAfter;
			break;

			case is_tag():
				echo $currentBefore . __( 'Posts tagged with', 'hyunmoo' ) .' &#39;' . single_tag_title( '', false ) . '&#39;' . $currentAfter;
			break;

			case is_author():
				global $author;
				$userdata = get_userdata( $author );
				echo $currentBefore . __( 'About', 'hyunmoo' ) .'&nbsp;' . $userdata->display_name . $currentAfter;
			break;

			case is_day():
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo '<a href="' . get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				echo $currentBefore . get_the_time( 'd' ) . $currentAfter;
			break;

			case is_month():
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo $currentBefore . get_the_time( 'F' ) . $currentAfter;
			break;

			case is_year():
				echo $currentBefore . get_the_time( 'Y' ) . $currentAfter;
			break;

			case is_404():
				echo $currentBefore . __( 'Page not found', 'hyunmoo' ) . $currentAfter;
			break;

		endswitch;

		if ( get_query_var('paged') ) {
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_archive() || is_tax() ) echo ' (';
			echo __('Page', 'hyunmoo') . ' ' . get_query_var('paged');
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_archive() || is_tax() ) echo ')';
		}

		echo '</div>';

	endif;

}

//Check if url is valid
	function isValidUrl( $url )
	{
		$response = wp_remote_head( $url );
		$accepted_status_codes = array( 200, 301, 302 );
 
        /* If no error occured and the status code matches one of the above, go on... */
        if ( ! is_wp_error( $response ) && in_array( wp_remote_retrieve_response_code( $response ), $accepted_status_codes ) ) {
            /* Target URL exists. Let's return the (working) URL */
            return true;
        }
        /* If we have reached this point, it means that either the HEAD request didn't work or that the URL
         * doesn't exist. This is a fallback so we don't show the malformed URL */
        return false;
	}
?>