<?php

return function () use ($templates) {
  $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  parse_str($parsedUrl, $query);
  $id = $query["id"];
  $tag = $_SESSION["tags"][$id];

  $filteredPosts = array_filter($_SESSION['posts'], function ($post) use ($tag) {
    foreach ($tag->slugs as $slug) {
      if ($slug == $post->slug) {
        return true;
      }
    }
    return false;
  });
  return $templates->render(withVariant('tag'), [
    'name' => $tag->name,
    'posts' => $filteredPosts,
  ]);
};
