<?php

function getPost(string $slug)
{
  global $templates;
  global $templates;
  list('object' => $object, 'post_path' => $post_path) = loadPostMd($slug);

  $tags = array_map(function ($t) {
    $id = md5($t);
    return (object)[
      'id' => $id,
      'name' => $t,
    ];
  },  split($object->tags));

  $categories = array_map(function ($c) {
    $id = md5($c);
    return (object)[
      'id' => $id,
      'name' => $c,
    ];
  }, split($object->category));

  $templates->addData(
    [
      'page_title' => $object->title,
      'page_slug' => 'posts/' . $slug,
    ],
    withVariant('gallery')
  );

  return (object) array(
    'title' => $object->title,
    'date' => $object->date,
    'tags' => $tags,
    'categories' => $categories,
    'full_path' => $post_path,
    'image' => $object->image,
    'slug' => $slug,
    'description' => $object->description,
    'content' => renderMarkdown($object->body()),
  );
}

return function (string $key) use ($templates) {
  $data = getPost($key);
  return $templates->render(withVariant('post'), ['data' => $data]);
};
