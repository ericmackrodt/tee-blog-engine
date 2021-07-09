<?php

function getImageFromMap(array $map, string $imagePath)
{
  $result = $map[$imagePath];
  return isset($result) ? $result : $imagePath;
}

function getPostThumbnail($path)
{
  return getImageFromMap(POST_THUMBNAILS_MAP, $path);
}

function getContentImages($path)
{
  return getImageFromMap(CONTENT_IMAGES_MAP, $path);
}

function getGalleryThumbnail($path)
{
  return getImageFromMap(GALLERY_THUMBNAIL_MAP, $path);
}

function getGalleryImage($path)
{
  return getImageFromMap(GALLERY_IMAGES_MAP, $path);
}
