<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'form.php' );

class HyunmooSlidersForm extends HyunmooForm {

	private $config = false;
	public function __construct() {
		parent::__construct();
		
	}
	
	public function setConfig( $config ) {
		$this->config = $config;
	}
	
	public function showForm() {
		$thumb_w = get_option( 'thumbnail_size_w' );
		$thumb_h = get_option( 'thumbnail_size_h' );
		
		$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
		$image_library_url = remove_query_arg( array( 'TB_iframe' ), $image_library_url );
		$image_library_url = add_query_arg( array( 'referer' => 'sliders', 'type' => 'image', 'TB_iframe' => 1 ), 						$image_library_url );
		$sid = isset( $_GET['id'] ) ? $_GET['id'] : 0;
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery('#add_image').click(function() {
		tb_show('', '<?php echo $image_library_url ?>');
		return false;
	});
	
	$('ul#slides').sortable({
		opacity: 0.5,
		update: function(event, object) {
			$('ul#slides li').each(function(index) {
				$(this).children('.slidepos').val(index);
			});
		}
	});

	$('ul#slides li').hover(function() {
		$(this).find('span.remove').show();
		$(this).find('span.remove').click(function() {
			$(this).parent().parent().remove();
		});
	},function() {
		$(this).find('span.remove').hide();
	}).click(function() {
	
		//Save data for the very slide before
		var slide = $('ul#slides li.active');
		var caption = $('#caption').val();
		var url = $('#url').val();
		var target = $('#newwindow').is(':checked') ? 1 : 0;
		slide.find('input[type=hidden].caption').val(caption);
		slide.find('input[type=hidden].url').val(url);
		slide.find('input[type=hidden].target').val(target);
		
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		var caption = $(this).find('input[type=hidden].caption').val();
		var url = $(this).find('input[type=hidden].url').val();
		var target = ($(this).find('input[type=hidden].target').val() > 0) ? true : false;
		$('#caption').val(caption);
		$('#url').val(url);
		$('#newwindow').attr('checked',target);
	});

	$('#save').click(function(e) {
	
		//Save current opening slide data
		var slide = $('ul#slides li.active');
		var caption = $('#caption').val();
		var url = $('#url').val();
		var target = $('#newwindow').is(':checked') ? 1 : 0;
		slide.find('input[type=hidden].caption').val(caption);
		slide.find('input[type=hidden].url').val(url);
		slide.find('input[type=hidden].target').val(target);
		
		var name = $('input[name=name]').val();
		var size = $('ul#slides li').size();
		window.slider_exists = false;
		
		if(name.trim() == '' || size == 0) {
			alert("Please select at least one slide and fill in proper name");
			e.preventDefault();
			return;
		}
		$('input[name=name]').siblings('span.error').text('');
		$.ajax({
			type: 'POST',
			async: false,
			url: ajaxurl, 
			data: {action: 'check_name', name: name, sid: <?php echo $sid ?>}, 
			success: function(response) {
				if(response == 'exists') {
					$('input[name=name]').siblings('span.error').text('This name already exists.');
				}
			}
		});
		var exists = $('input[name=name]').siblings('span.error').text() == '' ? false : true;
		if( exists == true )
			e.preventDefault();
	});
		
	window.send_to_editor = function(html) {
		var imgurl = jQuery('img',html).attr('src');
		var width = jQuery('img',html).attr('width');
		var height = jQuery('img',html).attr('height');
		var cls = jQuery('img',html).attr('class');
		var regex = /(?:^|\s)wp-image-(\d+)(?:\s|$)/g;
		var match = regex.exec(cls);
		var attachment_id = match[1];
		
		jQuery.post(ajaxurl, { action: 'slide_image_thumbsize', attachment: attachment_id }, function(response) {
			var slide = '<div class="item" style="background-image: url(' + response + ');width: <?php echo $thumb_w ?>px;height: <?php echo $thumb_h ?>px">';
			slide += '<span class="remove">x</span>';
			slide += '<span class="details">IMAGE ' + width + ' x ' + height + '</span>';
			slide += '</div>';
			
			var sid = parseInt($('#slideid').val());
			var position = $('ul#slides li').size();
			slide += '<input type="hidden" class="slidepos" name="slides[' + sid + '][pos]" value="' + position + '" />';
			slide += '<input type="hidden" class="imgurl" name="slides[' + sid + '][imgurl]" value="' + imgurl + '" />';
			slide += '<input type="hidden" class="thumbnail" name="slides[' + sid + '][thumbnail]" value="' + response + '" />';
			slide += '<input type="hidden" class="width" name="slides[' + sid + '][width]" value="' + width + '" />';
			slide += '<input type="hidden" class="height" name="slides[' + sid + '][height]" value="' + height + '" />';
			slide += '<input type="hidden" class="caption" name="slides[' + sid + '][caption]" value="" />';
			slide += '<input type="hidden" class="url" name="slides[' + sid + '][url]" value="" />';
			slide += '<input type="hidden" class="target" name="slides[' + sid + '][window]" value="" />';
			var element = '<li class="active" id="slide-' + sid + '">' + slide + '</li>';
			$('ul#slides li').removeClass('active');
			$('ul#slides').append(element);
			$('ul#slides li').hover(function() {
				$(this).find('span.remove').show();
				$(this).find('span.remove').click(function() {
					$(this).parent().parent().remove();
				});
			},function() {
				$(this).find('span.remove').hide();
			}).click(function() {
				//Save data for the very slide before
				var slide = $('ul#slides li.active');
				var caption = $('#caption').val();
				var url = $('#url').val();
				var target = $('#newwindow').is(':checked') ? 1 : 0;
				slide.find('input[type=hidden].caption').val(caption);
				slide.find('input[type=hidden].url').val(url);
				slide.find('input[type=hidden].target').val(target);
				
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				
				var caption = $(this).find('input[type=hidden].caption').val();
				var url = $(this).find('input[type=hidden].url').val();
				var target = ($(this).find('input[type=hidden].target').val() > 0) ? true : false;
				$('#caption').val(caption);
				$('#url').val(url);
				$('#newwindow').attr('checked',target);
			});
			
			$('#slideid').val(sid + 1);
			
			var slide = $('ul#slides li.active');
			var caption = $('#caption').val();
			var url = $('#url').val();
			var target = $('#newwindow').is(':checked') ? 1 : 0;
			slide.find('input[type=hidden].caption').val(caption);
			slide.find('input[type=hidden].url').val(url);
			slide.find('input[type=hidden].target').val(target);
			$('#caption').val('');
			$('#url').val('');
			$('#newwindow').attr('checked',false);
		});
		
		tb_remove();
	}
});
</script>
<form action="" method="post">
<div class="wrapper">
	<div class="left">
		<table style="width: 100%;margin-bottom: 20px" class="widefat fixed">
			<thead>
				<tr>
					<th>Contents</th>
					<th><a id="add_image" class="button" style="float:right" href="#">
						<span class="wp-media-buttons-icon"></span>Add Image</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<div class="container">
							<ul id="slides">
							<?php
								if( $this->config != false ) :
									foreach( $this->config['slides'] as $position => $slide ) :
							?>
								<li id="slide-<?php echo $position ?>">
									<div class="item" style="background-image: url(<?php echo $slide['thumbnail'] ?>);width: <?php echo $thumb_w ?>px;height: <?php echo $thumb_h ?>px">
										<span class="remove">x</span>
										<span class="details">IMAGE <?php echo $slide['width'] . ' x ' . $slide['height'] ?></span>
									</div>
									<input type="hidden" class="slidepos" name="slides[<?php echo $position ?>][pos]" value="<?php echo $position ?>" />
									<input type="hidden" class="imgurl" name="slides[<?php echo $position ?>][imgurl]" value="<?php echo $slide['imgurl'] ?>" />
									<input type="hidden" class="thumbnail" name="slides[<?php echo $position ?>][thumbnail]" value="<?php echo $slide['thumbnail'] ?>" />
									<input type="hidden" class="width" name="slides[<?php echo $position ?>][width]" value="<?php echo $slide['width'] ?>" />
									<input type="hidden" class="height" name="slides[<?php echo $position ?>][height]" value="<?php echo $slide['height'] ?>" />
									<input type="hidden" class="caption" name="slides[<?php echo $position ?>][caption]" value="<?php echo $slide['caption'] ?>" />
									<input type="hidden" class="url" name="slides[<?php echo $position ?>][url]" value="<?php echo $slide['url'] ?>" />
									<input type="hidden" class="target" name="slides[<?php echo $position ?>][window]" value="<?php echo $slide['window'] ?>" />
								</li>
							<?php
									endforeach;
								endif;
								$size = isset( $this->config['slides'] ) ? count( $this->config['slides'] ) : 0;
								$name = isset( $this->config['name'] ) ? $this->config['name'] : '';
								$title = isset( $this->config['title'] ) ? $this->config['title'] : '';
							?>
							</ul>
							<input type="hidden" id="slideid" value="<?php echo $size ?>" />
							<div style="clear:both">&nbsp;</div>
							<div id="extras">
								<label for="caption">Caption :</label>
								<input type="text" style="width: 100%" placeholder="Caption" id="caption" />
								<br>
								<label for="url">URL :</label>
								<input type="text" style="width: 100%" placeholder="http://" id="url" />
								<div class="new_window">
									<label for="newwindow">New Window<input type="checkbox" id="newwindow" /></label>
								</div>
								<br>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="right">
		<table style="width: 100%;margin-bottom: 20px" class="widefat fixed">
			<thead>
				<tr>
					<th>Options</th>
					<th><input type="submit" id="save" value="Save Slider" style="font-weight:lighter;float:right;" name="save" /></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Name<font color="red"> *</font></td>
					<td>
						<input type="text" data-required="true" description="Unique name for slider" name="name" value="<?php echo $name ?>" />&nbsp;&nbsp;<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td>Title<font color="red"> *</font></td>
					<td>
						<input type="text" data-required="true" description="Label for slider" name="title" value="<?php echo $title ?>" />&nbsp;&nbsp;<span class="error"></span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>
<?php
	}
}
?>