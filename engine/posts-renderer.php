<?php
return function () use ($templates) {
  $page = $_GET["page"] ?? "0";

  $filteredPosts = array_map(function ($slug) {
    return (object) BLOG_POSTS[$slug];
  }, BLOG_POSTS_ORDER);

  return $templates->render(withVariant('posts'), [
    'posts' => $filteredPosts,
    'page' => $page
  ]);
};
