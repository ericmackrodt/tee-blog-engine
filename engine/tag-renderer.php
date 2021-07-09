<?php

return function () use ($templates) {
  $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  parse_str($parsedUrl, $query);
  $id = $query["id"];
  $tag = (object) BLOG_TAGS[$id];

  $filteredPosts = array_map(function ($slug) {
    return (object) BLOG_POSTS[$slug];
  }, $tag->slugs);

  return $templates->render(withVariant('tag'), [
    'name' => $tag->name,
    'posts' => $filteredPosts,
  ]);
};
