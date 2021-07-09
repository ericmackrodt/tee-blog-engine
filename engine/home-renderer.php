<?php
$config = require(__DIR__ . '/../config.php');

return function () use ($templates, $config) {
  $intro_path = __DIR__ . '/../' . $config["intro"];;
  $md = file_get_contents($intro_path);

  $filteredPosts = array_map(function ($slug) {
    return (object) BLOG_POSTS[$slug];
  }, BLOG_POSTS_ORDER);

  return $templates->render(withVariant('home'), [
    'intro' => renderMarkdown($md),
    'posts' => $filteredPosts
  ]);
};
