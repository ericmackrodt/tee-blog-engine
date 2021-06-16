<?php
session_start();
try {

  // the code that throws an exception
  require 'vendor/autoload.php';
  require 'engine/helpers.php';
  require 'engine/variant-selector.php';
  require 'engine/file-loader.php';
  require 'engine/posts-processor.php';
  require 'engine/gallery-parser.php';
  require 'engine/templating.php';
  require 'engine/markdown.php';
  require "engine/routes.php";
} catch (Exception $e) {
  echo var_dump($e);
  echo var_dump($e->getTrace());
}
