<?php
return function () use ($templates) {
  $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  parse_str($parsedUrl, $query);
  $id = $query["id"];
  $category = (object) BLOG_CATEGORIES[$id];

  $filteredPosts = array_map(function ($slug) {
    return (object) BLOG_POSTS[$slug];
  }, $category->slugs);

  return $templates->render(withVariant('category'), [
    'name' => $category->name,
    'posts' => $filteredPosts,
  ]);
};
