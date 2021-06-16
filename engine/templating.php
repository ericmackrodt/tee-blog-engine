<?php

$config = require(__DIR__ . '/../config.php');

// Create new Plates engine
$templates = new \League\Plates\Engine(__DIR__ . '/default-template');

$json = file_get_contents($config["main-menu"]);
$mainMenu = json_decode($json);
$variant = getVariant();

function addData($mainMenu, $variantFn = null)
{
  global $templates, $config;
  if (!$variantFn) {
    $variantFn = function ($input) {
      return $input;
    };
  }

  $templates->addData(['mainMenu' => $mainMenu], $variantFn('main-menu'));
  $templates->addData(['siteName' => $config["site-name"]], $variantFn('layout'));
  $templates->addData(['categories' => $_SESSION["categories"]], $variantFn('categories'));
  $templates->addData(['tags' =>  $_SESSION["tags"]], $variantFn('tags'));
}

// Add default data
addData($mainMenu);

if ($config["template-folders"]) {
  foreach ($config["template-folders"] as $name => $folder) {
    $templates->addFolder($name, $folder, true);
    addData($mainMenu, "withVariant");
  }
}
