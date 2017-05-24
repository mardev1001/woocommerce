<?php
	global $theme;
	$basics = Hyunmoo::getConfig( 'settings.basic' );
	$copyright = $basics['copyright'];
?>
	<div style="clear:both"></div>
    </div>
<div class="footer">
<?php if( $copyright != '' ) : ?>
	Copyright &copy; <?php echo $copyright ?>
<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>