<?php
function getGalleries(string $type, string $slug)
{
  global $templates;

  switch ($type) {
    case "pages":
      $object = loadPageMd($slug);
      break;
    case "posts":
      list('object' => $object) = loadPostMd($slug);
      break;
  }

  return (object)[
    'title' => $object->title,
    'slug' => $object->slug,
    'galleries' => parseGalleries($object->body(), $templates),
  ];
}

return function (string $type, string $slug, string $gallery) use ($templates) {
  $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  parse_str($parsedUrl, $query);
  $img = intval($query["img"]);
  $data = getGalleries($type, $slug, getVariant());

  $index = array_search($gallery, array_column($data->galleries, "id"));

  $selected = $data->galleries[$index];

  $previousImageIndex = $img - 1;
  $nextImageIndex = $img + 1;

  $currentImage = $selected["images"][$img];
  $previousImage = $selected["images"][$previousImageIndex] ? "/gallery/{$type}/{$slug}/{$gallery}?img={$previousImageIndex}" : null;
  $nextImage = $selected["images"][$nextImageIndex] ? "/gallery/{$type}/{$slug}/{$gallery}?img={$nextImageIndex}" : null;


  return $templates->render(withVariant('gallery-page'), [
    'page_title' => $data->title,
    'page_slug' => $data->slug,
    'gallery' => $selected,
    'currentImage' => $currentImage,
    'previousImage' => $previousImage,
    'nextImage' => $nextImage
  ]);
};
