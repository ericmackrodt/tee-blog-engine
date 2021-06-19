<?php
return function () use ($templates) {
  $page = $_GET["page"] ?? "0";

  return $templates->render(withVariant('posts'), [
    'posts' => $_SESSION['posts'],
    'page' => $page
  ]);
};
