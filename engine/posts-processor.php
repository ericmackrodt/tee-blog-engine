<?php

use Spatie\YamlFrontMatter\YamlFrontMatter;

$config = require(__DIR__ . '/../config.php');

function split($input)
{
  $arr = explode(',', $input);
  return array_map(function ($item) {
    return trim($item);
  }, $arr);
}

function getPostsList()
{
  global $config;
  $BLOG_POSTS_PATH = $config["posts-folder"];
  $folders = array_slice(scandir($BLOG_POSTS_PATH), 2);
  $posts_list = array();

  // Get only summary (first lines of post)
  foreach ($folders as $slug) {
    if (strtolower($slug) == ".ds_store") {
      continue;
    }

    $post_path = $BLOG_POSTS_PATH . "/{$slug}/";
    $file_path = $post_path . $config["post-filename"];
    try {
      $md = file_get_contents($file_path);
    } catch (Exception $error) {
      continue;
    }
    $object = YamlFrontMatter::parse($md);

    $tags = array_map(function ($t) {
      $id = md5(trim(strtolower($t)));
      return (object)[
        'id' => $id,
        'name' => $t,
      ];
    },  split($object->tags));

    $categories = array_map(function ($c) {
      $id = md5(trim(strtolower($c)));
      return (object)[
        'id' => $id,
        'name' => $c,
      ];
    }, split($object->category));

    $posts_list[] = (object) array(
      'title' => $object->title,
      'date' => $object->date,
      'tags' =>  $tags,
      'categories' => $categories,
      'full_path' => $post_path,
      'image' => $object->image,
      'slug' => $slug,
      'description' => $object->description,
    );
  }

  usort($posts_list, function ($a, $b) {
    $datetime1 = strtotime($a->date);
    $datetime2 = strtotime($b->date);
    return $datetime2 - $datetime1;
  });

  return $posts_list;
}

function getCategories($post, &$categories)
{
  foreach ($post->categories as $cat) {
    if (empty($categories[$cat->id])) {
      $categories[$cat->id] = (object)[
        'id' => $cat->id,
        'name' => $cat->name,
        'slugs' => array(),
      ];
    }

    $categories[$cat->id]->slugs[] = $post->slug;
  }
}

function getTags($post, &$tags)
{
  foreach ($post->tags as $t) {;
    if (empty($tags[$t->id])) {
      $tags[$t->id] = (object)[
        'id' => $t->id,
        'name' => $t->name,
        'slugs' => array(),
      ];
    }

    $tags[$t->id]->slugs[] = $post->slug;
  }
}

function getMetadata($posts, &$categories, &$tags)
{
  foreach ($posts as $post) {
    getCategories($post, $categories);
    getTags($post, $tags);
  }
}

function processPosts()
{
  if (!empty($_SESSION["posts"]) && !empty($_SESSION["categories"]) && !empty($_SESSION["tags"])) {
    return;
  }

  $categories = array();
  $tags = array();
  $posts = getPostsList();
  getMetadata($posts, $categories, $tags);

  $_SESSION["posts"] = $posts;
  $_SESSION["categories"] = $categories;
  $_SESSION["tags"] = $tags;
}

processPosts();
