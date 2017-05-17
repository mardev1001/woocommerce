jQuery(document).ready(function() {
	jQuery('.image_upload').click(function() {
		formfield = jQuery(this).attr('rel');
		tb_show('', 'media-upload.php?type=image&post_id=0&TB_iframe=true');
		return false;
	});
		/* send the uploaded image url to the field */
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src'); // get the image url
		imgoutput = '<img src="' + imgurl + '" />'; //get the html to output for the image preview
		jQuery('#' + formfield).val(imgurl);
		jQuery('#' + formfield).siblings('.image_preview').slideDown().html(imgoutput);
		tb_remove();
	}
});