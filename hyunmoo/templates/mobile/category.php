<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
	$cat = get_query_var('cat');
	$yourcat = get_category($cat);
?>
<div id="content" class="page-container">
	<input type="hidden" id="blogview" value="grid" />
	<input type="hidden" id="sidebarcheck" value="nosidebar" />
    <input type="hidden" id="postcategoryslug" value="<?php echo $yourcat->slug; ?>" />
	<div class="post-container"></div>
</div>