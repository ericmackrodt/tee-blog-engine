<?php

return function () use ($templates) {
  $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  parse_str($parsedUrl, $query);
  $id = $query["id"];
  $category = $_SESSION["categories"][$id];

  $filteredPosts = array_filter($_SESSION['posts'], function ($post) use ($category) {
    foreach ($category->slugs as $slug) {
      if ($slug == $post->slug) {
        return true;
      }
    }
    return false;
  });
  return $templates->render(withVariant('category'), [
    'name' => $category->name,
    'posts' => $filteredPosts,
  ]);
};
