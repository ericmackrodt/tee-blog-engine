<?php

$config = require(__DIR__ . '/../config.php');
$variant = getVariant();

// Get image maps

require_once joinPaths(__DIR__, '..', $config["contents-folder"], $variant . '-image-maps.php');

// Create new Plates engine
$templates = new \League\Plates\Engine(__DIR__ . '/default-template');

$json = file_get_contents($config["main-menu"]);
$mainMenu = json_decode($json);

$categories = array_map(function ($cat) {
  return (object) $cat;
}, BLOG_CATEGORIES);
$tags = array_map(function ($tag) {
  return (object) $tag;
}, BLOG_TAGS);

function addData($mainMenu, $variantFn = null)
{
  global $templates, $config, $categories, $tags;
  if (!$variantFn) {
    $variantFn = function ($input) {
      return $input;
    };
  }

  $templates->addData(['mainMenu' => $mainMenu], $variantFn('main-menu'));
  $templates->addData(['siteName' => $config["site-name"]], $variantFn('layout'));
  $templates->addData(['categories' => $categories], $variantFn('categories'));
  $templates->addData(['tags' =>  $tags], $variantFn('tags'));
}

// Add default data
addData($mainMenu);

if ($config["template-folders"]) {
  foreach ($config["template-folders"] as $name => $folder) {
    $templates->addFolder($name, $folder, true);
    addData($mainMenu, "withVariant");
  }
}
