<?php

$config = require(__DIR__ . '/../config.php');

// Create new Plates engine
$templates = new \League\Plates\Engine(__DIR__ . '/default-template');

$json = file_get_contents($config["main-menu"]);
$mainMenu = json_decode($json);
$variant = getVariant();
if (isset($variant)) {
  $templates->addFolder($variant, $config["template-folders"][$variant], true);
}
$templates->addData(['mainMenu' => $mainMenu], withVariant('main-menu'));
$templates->addData(['siteName' => $config["site-name"]], withVariant('layout'));
$templates->addData(['categories' => $_SESSION["categories"]], withVariant('categories'));
$templates->addData(['tags' =>  $_SESSION["tags"]], withVariant('tags'));
