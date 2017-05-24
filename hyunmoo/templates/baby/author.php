<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	global $wp_query; $curauth = $wp_query->get_queried_object(); 
?>
<div id="content" class="author-page page-container">
	<input type="hidden" id="blogview" value="smallimage" />
	<input type="hidden" id="sidebarcheck" value="right" />
    <input type="hidden" id="postauthor" value="<?php echo $curauth->user_nicename; ?>" />
   
    <div class="pagecontainer1">
    <div class="aboutauthor wrapper">
	    <div class="author-avatar"><?php echo get_avatar($curauth->ID,82); ?></div>
        <div class="author-description">
	        <h3>About <?php echo $curauth->display_name; ?></h3>
            <p><?php echo $curauth->description; ?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="post-container"></div>
    </div>
	<div id="blogsidebar" class="wrapper">
        <?php
			if( is_active_sidebar( 'hyunmoo-blog' ) )
				dynamic_sidebar( 'hyunmoo-blog' );
		?>
    </div>
</div>
