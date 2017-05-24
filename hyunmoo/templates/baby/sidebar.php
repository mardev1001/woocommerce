<?php
	if( is_active_sidebar( 'hyunmoo-toolbox' ) ) {
		echo '<div id="toolbox">';
		echo '<div id="toolbox-container">';
		echo '<div id="toolbox-title">ToolBox</div><div id="toolbox-main">';
		dynamic_sidebar( 'hyunmoo-toolbox' );
		echo '</div></div><div id="toolbox-toggle"><i class="fa fa-location-arrow"></i></div></div>';
	}
?>