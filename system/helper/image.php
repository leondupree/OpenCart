<?php
function image_resize($filename, $width, $height) {
	if (!file_exists(DIR_IMAGE . $filename)) {
		return;
	} 
	
	$old_image = $filename;
	$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.jpg';
	
	if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
		$image = new Image(DIR_IMAGE . $old_image);
		$image->resize($width, $height);
		$image->save(DIR_IMAGE . $new_image);
	}

	if ((isset($_SERVER['HTTPS'])) && ($_SERVER['HTTPS'] == 'on')) {
		return HTTPS_IMAGE . $new_image;
	} else {
		return HTTP_IMAGE . $new_image;
	}
}
?>