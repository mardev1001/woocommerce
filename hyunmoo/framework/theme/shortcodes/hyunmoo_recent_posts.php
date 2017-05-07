<?php
	# Insert recent posts

	function hyunmoo_shortcode_recent_posts( $atts, $content = '' )
	{	
		$default_atts = array(
		);

		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
				
		$args = apply_filters('woocommerce_recent_posts_args', array(
			'post_status' => 'publish',
			'post_type' => 'post',
			'posts_per_page' => 4,
		) );
		$hm_recent = new WP_Query( $args);
		
		if ($hm_recent ->have_posts()) : 
		$output= '<div class="hmrecent posts">';
		$output.='<input type="hidden" id="recentpercolumn" value="'.$per_column.'">';
        $output.= '<h3>Recent Posts</h3>';
        $output.= '<ul class="posts">'; $ij=0;
			while ($hm_recent ->have_posts()) : 
				$hm_recent ->the_post();
				$ij++;
				$output.= '<li class="';
				foreach(get_post_class( $classes, $post->ID ) as $prodclass)
					$output.=$prodclass." ";
				$output.='" id="recentpost'.$ij.'">';
                $output.= '<div class="recentpostcont">';
                if ( has_post_thumbnail() ) {
                    $image = get_the_post_thumbnail($post->ID, "grid-small" );
               		$output.=$image;
				}
                $output.='<a class="skin-primary-text" href="'.get_permalink().' rel="bookmark" title="'.get_the_title().'"><h3>'.get_the_title().'</h3></a>';
				$output.="</div></li>";
       		endwhile;
       $output.="<div class='clear'></div></ul></div>";
	   endif;		
		# Prepare Output
		
		return $output;
	} 
	add_shortcode( 'hm_recent_posts', 'hyunmoo_shortcode_recent_posts' );
?>