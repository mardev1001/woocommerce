<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	$featured = $options['featured_image'];
	
	global $post;
?>
	<div id="content" class="site-content">
	<?php if( !is_front_page() ) : ?>
		<header class="breadcrumb">
			<div id="title"><?php echo $post->post_title; ?></div>
			<?php hyunmoo_breadcrumb(); ?>
			<div class="clear"></div>
		</header>
	<?php endif; ?>
		<div id="defaultcontent" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
	            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content">
					<?php
						if ( has_post_thumbnail() && ( $featured == 'page' || $featured == 'both' ) ) 
							the_post_thumbnail( 'full' );
						
						the_content(); 
					?>
                        <div class="clear"></div>
                    </div>
               </div>
 			<?php endwhile; // end of the loop. ?>

		</div><!-- #main -->
	</div><!-- #content -->