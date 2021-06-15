<?php
$config = require "config.php";
$renderImage = require "engine/image-renderer.php";
$parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($parsedUrl, $query);
$path = __DIR__ . '/' . trim($query["p"], '/');
$fit = $query["fit"];
$width = $query["w"];
$aspectRatio = $query["aspectRatio"];

$renderImage($path, $width, $fit, $aspectRatio);
