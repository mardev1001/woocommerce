<?php
	global $post;
	$options = Hyunmoo::getConfig( 'settings.style' );
	$image = $options['featured_image'];
	$slider = $options['featured_slider'];
?>
<div id="content" class="page-container">

	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

	<div class="singlepostcontainer">
    <div class="singlepostcontent wrapper">
		<h3 class='title'><?php the_title(); ?></h3>
	    <?php 
			if ( has_post_thumbnail() && ( $image == 'post' || $image == 'both' ) ) {
				the_post_thumbnail('postimage-large');
				echo '<div class="clear">&nbsp;</div>';
			}
		if( get_post_meta( $post->ID, "_hyunmoo_featured_slider", true ) != "" && $slider == 'yes' ) {
				$slider = Hyunmoo::getConfig( 'slider.' . get_post_meta( $post->ID, "_hyunmoo_featured_slider", true ), 'records' ); ?>
				<?php if( is_array( $slider ) && !empty( $slider ) ) : ?>
				<div class="hmslider-post"><?php 
					foreach( $slider['slides'] as $value ) : ?>
						<div class="item">
							<img src="<?php echo $value['imgurl']; ?>">
							<div class="content">
							<?php echo $value['content']; ?></div><div class="caption"><?php echo $value['caption']; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
		<?php } ?>
       	<?php the_content(); ?>
        <div class="postotherinfo">
         	<span id="postauthor">By <?php the_author_posts_link(); ?></span>
            <span id="postdate">On <?php echo get_the_date(); ?></span>
            <span class="sepa">|</span>
            <span id="postcategory">
            <?php 
				$pi=0; $postcategories=get_the_category(); $postcatcount=sizeof($postcategories);
				foreach(get_the_category() as $postcategory){
				echo "<a href='".get_category_link($postcategory->term_id)."' title='".$postcategory->name."'>".$postcategory->name."</a>"; $pi++;
				if($pi<$postcatcount)
					echo ", ";	
				}
			?>
            </span>
			
            <?php 
				$pi = 0; $posttags = get_the_tags(); $posttagcount = sizeof( $posttags );
				
				if( is_array( $posttags) && $posttagcount > 0 ) {
			?>
			<span class="sepa">|</span>
            <span id="posttags">
			<?php
					foreach( $posttags as $posttag){
					echo "<a href='".get_tag_link( $posttag->term_id ) . "' title='" . $posttag->name . "'>".$posttag->name . "</a>"; $pi++;
					if( $pi < $posttagcount )
						echo ", ";	
					}
			?>
			</span>
			<?php
				}
			?>

            <span class="sepa">|</span>
            <span id="postcomment">
            <?php
				comments_popup_link("No comments","1 comment","% comments");
			?>
            </span>
	        <div class="clear"></div>
        </div>
		<?php
			$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => -1, 'post__not_in' => array($post->ID) ) );
			if( is_array( $related ) && !empty( $related ) ) :
		?>
		<div class="related-post wrapper">
			<h2><?php _e( 'Related Posts', 'woocommerce' ); ?></h2>
			<?php
				echo "<div class='related-content'><ul>";
				foreach( $related as $post ) {
			?>
				<li class="item">
					<div class="relatedpostcont">
					<?php 
						if ( has_post_thumbnail() ) 
							the_post_thumbnail('grid-small');
					?>
					<div class="relatedposttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
					</div>
				</li>
		   
			<?php } if( $related ) echo "</ul></div>"; 
				wp_reset_postdata(); 
			?>
		</div>
		<?php endif; ?>
		<div class="postcomment wrapper">   
			<?php comments_template(); ?>
		</div>
    </div>           
	<?php endwhile; ?>
 
</div><!-- #content -->
