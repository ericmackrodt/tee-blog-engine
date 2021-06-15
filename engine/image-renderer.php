<?php

/*
 * Crop-to-fit PHP-GD
 * http://salman-w.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html
 *
 * Resize and center crop an arbitrary size image to fixed width and height
 * e.g. convert a large portrait/landscape image to a small square thumbnail
 */

function getNewSize($originalWidth, $originalHeight, $targetWidth, $aspectRatio)
{
	$height = $originalHeight;
	$width = $originalWidth;

	if (!empty($aspectRatio)) {
		list($w, $h) = array_map(function ($i) {
			return (int)$i;
		}, explode(':', $aspectRatio));

		$height = floor(($h * $width) / $w);
	}

	if (!empty($targetWidth)) {
		$width = (int)$targetWidth;
	}


	$height = floor(($height * $width) / $originalWidth);

	return [
		'w' => $width,
		'h' => $height
	];
}

return function ($path, $target_width, $fit, $aspectRatio) {

	list($source_width, $source_height, $source_type) = getimagesize($path);

	['w' => $dst_width, 'h' => $dst_height] = getNewSize($source_width, $source_height, $target_width, $aspectRatio);

	switch ($source_type) {
		case IMAGETYPE_GIF:
			$source_gdim = imagecreatefromgif($path);
			break;
		case IMAGETYPE_JPEG:
			$source_gdim = imagecreatefromjpeg($path);
			break;
		case IMAGETYPE_PNG:
			$source_gdim = imagecreatefrompng($path);
			break;
	}



	$source_aspect_ratio = $source_width / $source_height;
	$desired_aspect_ratio = $dst_width / $dst_height;

	if ($source_aspect_ratio > $desired_aspect_ratio) {
		/*
     * Triggered when source image is wider
     */
		$temp_height = $dst_height;
		$temp_width = (int) ($dst_height * $source_aspect_ratio);
	} else {
		/*
     * Triggered otherwise (i.e. source image is similar or taller)
     */
		$temp_width = $dst_width;
		$temp_height = (int) ($dst_width / $source_aspect_ratio);
	}

	/*
 * Resize the image into a temporary GD image
 */

	$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
	imagecopyresampled(
		$temp_gdim,
		$source_gdim,
		0,
		0,
		0,
		0,
		$temp_width,
		$temp_height,
		$source_width,
		$source_height
	);

	/*
 * Copy cropped region from temporary image into the desired GD image
 */

	$x0 = ($temp_width - $dst_width) / 2;
	$y0 = ($temp_height - $dst_height) / 2;
	$desired_gdim = imagecreatetruecolor($dst_width, $dst_height);
	imagecopy(
		$desired_gdim,
		$temp_gdim,
		0,
		0,
		$x0,
		$y0,
		$dst_width,
		$dst_height
	);

	/*
 * Render the image
 * Alternatively, you can save the image in file-system or database
 */

	header("Content-type: {$source_type}");
	switch ($source_type) {
		case IMAGETYPE_GIF:
			imagegif($desired_gdim);
			break;
		case IMAGETYPE_JPEG:
			imagejpeg($desired_gdim);
			break;
		case IMAGETYPE_PNG:
			imagepng($desired_gdim);
			break;
	}
};
