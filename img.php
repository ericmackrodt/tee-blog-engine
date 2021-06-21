<?php
$config = require "config.php";
$renderImage = require "engine/image-renderer.php";
$parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($parsedUrl, $query);

if (filter_var($query["p"], FILTER_VALIDATE_URL) == true) {
  $path = $query["p"];
} else {
  $path = __DIR__ . '/' . trim($query["p"], '/');
}

$fit = $query["fit"];
$width = $query["w"];
$aspectRatio = $query["aspectRatio"];
$output = $query["output"];

$renderImage($path, $width, $fit, $aspectRatio, $output);
