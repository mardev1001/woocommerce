<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	$featured = $options['featured_image'];
	
	global $post;
?>
<?php while ( have_posts() ) : the_post(); ?>
    <div class="post-content nocontainer">
	<?php if( !is_front_page() ) : ?>
		<header class="breadcrumb">
			<div id="title"><?php echo $post->post_title; ?></div>
			<?php hyunmoo_breadcrumb(); ?>
			<div class="clear"></div>
		</header>
	<?php endif; ?>
    <?php
		if ( has_post_thumbnail() && ( $featured == 'page' || $featured == 'both' ) ) 
			the_post_thumbnail( 'full' );
		the_content();
	?>
    </div>               
<?php endwhile; // end of the loop. ?>
