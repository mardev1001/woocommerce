<?php
function getAttachmentURL( $attachment, $media = 'image', $size = 'thumbnail' ) {
	if( $media == 'image' ) {
		$attributes = wp_get_attachment_image_src( $attachment, $size );
		if( is_array( $attributes ) )
			return $attributes[0];
		return false;
	}
	else {
		return wp_get_attachment_url( $attachment );
	}
	return false;
}
?>