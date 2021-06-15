<?php

use Pecee\SimpleRouter\SimpleRouter;

$renderPage = require "page-renderer.php";
$renderHome = require "home-renderer.php";
$renderPost = require "post-renderer.php";
$renderCategory = require "category-renderer.php";
$renderTag = require "tag-renderer.php";
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

SimpleRouter::get('/gallery/{type}/{slug}/{gallery}', function ($type, $slug, $gallery) use ($renderGallery) {
  return $renderGallery($type, $slug, $gallery);
});

SimpleRouter::get('/post/{post}', function ($post) use ($renderPost) {
  return $renderPost($post);
});

SimpleRouter::get('/{page}', function ($page) use ($renderPage) {
  return $renderPage($page);
});

// Start the routing
SimpleRouter::start();
