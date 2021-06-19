<?php
define('PAGE_LIMIT', 8);

function rebuildUrl($page)
{
  if (!isset($_GET["page"])) {
    $_GET["page"] = "0";
  }

  $result = $_SERVER["PATH_INFO"] . "?";
  $i = 0;
  $count = count($_GET);
  foreach ($_GET as $key => $value) {
    if ($key == "page") {
      $result .= "{$key}={$page}";
    } else {
      $result .= "{$key}={$value}";
    }

    if ($i > $count) {
      $result .= "&";
    }

    $i++;
  }

  return $result;
}

function createPagination($posts)
{
  $page = $_GET["page"];
  if (!isset($page)) {
    $page = "0";
  }
  $page = intval($page);

  $totalPosts = count($posts);
  $offset = $page * PAGE_LIMIT;
  $current_items = array_slice($posts, $offset, PAGE_LIMIT);
  $previous_page = $offset > 0 ? strval($page - 1) : null;
  $next_page = ($offset + PAGE_LIMIT) < $totalPosts ? strval($page + 1) : null;

  return (object)[
    'posts' =>  $current_items,
    'previous_page' => $previous_page != null ? rebuildUrl($previous_page) : null,
    'next_page' => $next_page != null ? rebuildUrl($next_page) : null
  ];
};
