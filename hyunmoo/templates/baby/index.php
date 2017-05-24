<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	if( !isset( $options['blog_tpl'] ) || !$options['blog_tpl'] )
		$options['blog_tpl'] = 'grid';
	if( !isset( $options['blog_sidebar'] ) || !$options['blog_sidebar'] )
		$options['blog_sidebar'] = 'nosidebar';
?>
<div id="content" class="page-container">
	<input type="hidden" id="blogview" value="<?php echo $options['blog_tpl']; ?>" />
	<input type="hidden" id="sidebarcheck" value="<?php echo $options['blog_sidebar']; ?>" />
	<div class="post-container"></div>
	<?php if( $options['blog_sidebar'] != "nosidebar" ){ ?>
	<div id="blogsidebar" class="wrapper">
        <?php
			if( is_active_sidebar( 'hyunmoo-blog' ) )
				dynamic_sidebar( 'hyunmoo-blog' );
		?>
    </div>
	<?php } ?>
</div>