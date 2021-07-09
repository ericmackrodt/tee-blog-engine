<?php
session_start();
try {
  $config = require "config.php";

  require $config['contents-folder'] . '/' . 'categories.php';
  require $config['contents-folder'] . '/' . 'posts.php';
  require $config['contents-folder'] . '/' . 'tags.php';
} catch (Exception $e) {
  echo "Mising contents configuration";
}

try {
  // the code that throws an exception
  require 'vendor/autoload.php';
  require 'engine/exceptions.php';
  require 'engine/helpers.php';
  require 'engine/image-mapper.php';
  require 'engine/variant-selector.php';
  require 'engine/file-loader.php';
  require 'engine/paginator.php';
  require 'engine/gallery-parser.php';
  require 'engine/templating.php';
  require 'engine/markdown.php';
  require "engine/routes.php";
} catch (Exception $e) {
  echo var_dump($e);
  echo var_dump($e->getTrace());
}
