<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
?>
<div id="content" class="page-container">
	<input type="hidden" id="blogview" value="smallimage" />
	<input type="hidden" id="sidebarcheck" value="right" />
    <input type="hidden" id="posttag" value="<?php single_tag_title(); ?>" />
   	<div class="post-container"></div>
  	<?php if( $options['blog_sidebar'] != "nosidebar" ){ ?>
	<div id="blogsidebar" class="wrapper" style="float:right;">
        <?php
			if( is_active_sidebar( 'hyunmoo-blog' ) )
				dynamic_sidebar( 'hyunmoo-blog' );
		?>
    </div>
	<?php } ?>
</div>
