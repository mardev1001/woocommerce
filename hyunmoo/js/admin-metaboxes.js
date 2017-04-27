/**
 * Admin Metaboxes jQuery functions
 * Written by Hyunmoo Team
 *
 * 
 *
 * Built for use with the jQuery library
 *
 *
 */

// <![CDATA[

jQuery(document).ready(function($) {
	var count = $('table#sections tbody tr').size();
	var urlobject = null;
	
	$('table#sections tbody').sortable({
		opacity: 0.7,
		update: function(event, object) {
			$('#sections tbody tr').each(function(index) {
				$(this).find('input.order').val(index);
			});
		}
	});
	$('a#addnew').click(function(e) {
		var page = $(this).siblings('select#page_id').val();
		if( page < 1 ) return;
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'get_page_featured_image',
				pageid: page
			},
			success: function(image) {
				if( image==0 )	image = '';
				var html = '<tr><td class="imgcontainer" style="width:250px;border-right:1px solid #ccc;cursor:move;">' + image + '</td><td class="config">';
				html += '<h3 style="border:1px solid #ccc;"><i>Choose background for this section</i></h3><br>';
				html += '<p><input type="radio" name="sections[' + count + '][background]" value="featured" checked /> Featured Image</p>';
				html += '<p><input type="radio" name="sections[' + count + '][background]" value="color" /> Background Color : <input type="text" name="sections[' + count + '][color]" class="color" size="6" /></p>';
				html += '<p><input type="radio" name="sections[' + count + '][background]" value="url" /> Custom Image : <input type="text" name="sections[' + count + '][url]" class="url" style="width:400px;margin-left:18px;" />';
			//	html += ' <input type="button" class="button upload" value="Choose Image" /></p>';
				html += '<p><input type="radio" name="sections[' + count + '][background]" value="none" /> None</p>';
				var order = $('table#sections tbody tr').size();
				html += '<input type="hidden" class="order" name="sections[' + count + '][order]" value="' + order + '" />';
				html += '<input type="hidden" name="sections[' + count + '][page]" value="' + page + '" />';
				html += '<p class="right"><input type="button" class="button remove" value="Remove section" /></p>';
				html += '</td></tr>';
				$('table#sections tbody').append(html);
			//Colorpicker	
				$('input.color').ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						$(el).val(hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						$(this).ColorPickerSetColor(this.value);
					}
				})
				.bind('keyup', function(){
					$(this).ColorPickerSetColor(this.value);
				});
			//Media Upload Thickbox
				$('input[type=button].upload').click(function() {
					urlobject = $(this).siblings('input.url');
					tb_show('', 'media-upload.php?type=image&post_id=0&referer=sections&TB_iframe=1');	//Added hook for media add button text
					return false;
				});
			//Add some little styles to sections
				$('td.imgcontainer img').css('maxWidth','250px').css('height','auto');
				$('td.config p').css('marginLeft', '20px');
			//	$('td.config p.right').css('marginLeft', '442px');
			//Section Remove
				$('input[type=button].remove').click(function() {
					var order = $(this).parent().parent().find('input.order').val();
					$('table#sections tbody tr').each(function(index,element) {
						var order1 = $(this).find('input.order').val();
						if(order < order1)
							$(this).find('input.order').val(order1-1);
					});
					$(this).parents().closest('tr').remove();
				});
				
				count ++;
			}
		});
					
		e.preventDefault();
	});
/*	//Disabled due to conflict with Add Media button in editing pages
	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src'); // get the image url
		imgoutput = '<img src="' + imgurl + '" style="max-width:250px;" />'; //get the html to output for the image preview
		$(urlobject).val(imgurl);
		$(urlobject).parent().parent().siblings('td.imgcontainer').slideDown().html(imgoutput);
		tb_remove();
	}
	//Media Upload Thickbox
	$('input[type=button].upload').click(function() {
		urlobject = $(this).siblings('input.url');
		tb_show('', 'media-upload.php?type=image&post_id=0&referer=sections&TB_iframe=1');	//Added hook for media add button text
		return false;
	});
*/	
	//Colorpicker	
	$('input.color').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	
	//Add some little styles to sections
	$('td.imgcontainer img').css('maxWidth','250px').css('height','auto');
	$('td.config p').css('marginLeft', '20px');
	//	$('td.config p.right').css('marginLeft', '442px');
	//Section Remove
	$('input[type=button].remove').click(function() {
		var order = $(this).parent().parent().find('input.order').val();
		$('table#sections tbody tr').each(function(index,element) {
			var order1 = $(this).find('input.order').val();
			if(order < order1)
				$(this).find('input.order').val(order1-1);
		});
		$(this).parents().closest('tr').remove();
	});
});

// ]]>
