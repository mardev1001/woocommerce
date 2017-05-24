<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	$featured = $options['featured_image'];
	
	global $post;
?>
<?php while ( have_posts() ) : the_post(); ?>
    <div class="post-content fullwidthcontent">
	<?php if( !is_front_page() ) : ?>
		<header class="breadcrumb">
			<div class="wrap">
				<div id="title"><?php echo $post->post_title; ?></div>
				<?php hyunmoo_breadcrumb(); ?>
				<div class="clear"></div>
			</div>
		</header>
	<?php endif; ?>
    <?php
		if ( has_post_thumbnail() && ( $featured == 'page' || $featured == 'both' ) ) 
			the_post_thumbnail( 'full' );
		the_content();
	?>
    </div>               
<?php endwhile; // end of the loop. ?>
