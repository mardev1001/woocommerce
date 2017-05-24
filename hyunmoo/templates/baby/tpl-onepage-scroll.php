<?php
	$page = get_the_ID();
	$sections = get_post_meta( $page, '_hyunmoo_onepage_sections', true );
	if( !is_array( $sections ) || empty( $sections ) ) :
?>
	<div id="content" class="site-content">
		<header class="breadcrumb">
			<div id="title"><?php echo $post->post_title; ?></div>
			<?php hyunmoo_breadcrumb(); ?>
			<div class="clear"></div>
		</header>
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
<?php else: ?>
<style type="text/css">
	body {
		overflow: hidden;
	}
	div#main section.scroll{
		word-wrap:break-word;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("div#main").onepage_scroll({
			sectionContainer: "section.scroll",
			loop: true,
			pagination: false,
			responsiveFallback: 767
		});
	});		
</script>
	</div>
	<div id="main">
<?php
	foreach( $sections as $section ) :
		$pageid = intval( $section['page'] );
		$page = get_post( $pageid );
		$color = $section['color'] != '' ? '#' . $section['color'] : '';
		switch( $section['background'] ) {
		case 'featured':
			$image_id = get_post_thumbnail_id( $pageid );
			$image = wp_get_attachment_url( $image_id );
			$style = 'background:url(' . $image . ') repeat ' . $color . ' !important;';
			break;
		case 'url':
			$style = 'background:url(' . $section['url'] . ') repeat ' . $color . ' !important;';
			break;
		case 'color':
			$style = 'background-color: #' . $section['color'] . ';';
			break;
		default:
			$style = '';
			break;
		}
?>
		<section style="<?php echo $style ?>" class="scroll">
		<div class="post-content">
		<?php echo do_shortcode( $page->post_content ); ?>
		</div>
		</section>
<?php endforeach; ?>
	</div>
<?php endif; ?>