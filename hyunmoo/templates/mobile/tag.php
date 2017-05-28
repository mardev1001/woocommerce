<?php
	$options = Hyunmoo::getConfig( 'settings.style' );
?>
<div id="content" class="page-container">
	<input type="hidden" id="blogview" value="grid" />
	<input type="hidden" id="sidebarcheck" value="nosidebar" />
    <input type="hidden" id="posttag" value="<?php single_tag_title(); ?>" />
   	<div class="post-container"></div>
</div>
