<?php

use Pecee\SimpleRouter\SimpleRouter;

$renderPage = require "page-renderer.php";
$renderHome = require "home-renderer.php";
$renderPost = require "post-renderer.php";
$renderCategory = require "category-renderer.php";
$renderTag = require "tag-renderer.php";
$renderPosts = require "posts-renderer.php";
$renderGallery = require "gallery-renderer.php";

SimpleRouter::get('/', function () use ($renderHome) {
  return $renderHome();
});

SimpleRouter::get('/category', function () use ($renderCategory) {
  return $renderCategory();
});

SimpleRouter::get('/tag', function () use ($renderTag) {
  return $renderTag();
});

SimpleRouter::get('/posts', function () use ($renderPosts) {
  return $renderPosts();
});

SimpleRouter::get('/gallery/{type}/{slug}/{gallery}', function ($type, $slug, $gallery) use ($renderGallery) {
  return $renderGallery($type, $slug, $gallery);
});

SimpleRouter::get('/post/{post}', function ($post) use ($renderPost) {
  return $renderPost($post);
});

// SimpleRouter::group(['defaultParameterRegex' => '/(.+)/is'], function () use ($renderPage) {
//   SimpleRouter::get('/{parameter}', function ($parameter) use ($renderPage) {
//     echo "comeon";
//   });
// });

// SimpleRouter::get('/', function ($page) use ($renderPage) {
//   echo var_dump($page);
// })->setMatch('/(.+)/is');

SimpleRouter::get('/{param}', function ($param = null) use ($renderPage) {
  return $renderPage($param);
}, ['defaultParameterRegex' => '.+']);

// SimpleRouter::get('/{page}*', function ($page) use ($renderPage) {
//   echo var_dump($page);
//   return $renderPage($page);
// });

// Start the routing
SimpleRouter::start();
