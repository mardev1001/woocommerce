<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	$featured = $options['featured_image'];
?>
	<div id="primary" class="site-content">
		<div id="fullwidthcontent" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
            <div class="post-content">
            <?php
				if ( has_post_thumbnail() && ( $featured == 'page' || $featured == 'both' ) ) 
					the_post_thumbnail( 'full' );
				the_content();
			?>
            </div>               
 			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->