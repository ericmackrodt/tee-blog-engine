<?php
$config = require __DIR__ . "/../config.php";

function getVariant()
{
  global $config;
  if (isset($config["custom_variant_selector"])) {
    $customVariantSelector = require __DIR__ . $config["custom_variant_selector"];
    return $customVariantSelector();
  }

  $keys = array_keys($config["template-folders"]);
  if (isset($keys[0])) {
    return $keys[0];
  }
  return null;
}

function withVariant($page)
{
  $variant = getVariant();
  if (isset($variant)) {
    return "{$variant}::{$page}";
  }

  return $page;
};
