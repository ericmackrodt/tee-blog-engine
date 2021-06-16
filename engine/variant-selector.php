<?php
$config = require __DIR__ . "/../config.php";

if (isset($config["custom_variant_selector"])) {
  $customVariantSelector = require joinPaths(__DIR__, "..", $config["custom_variant_selector"]);
  $customVariant = $customVariantSelector();
}

function getVariant()
{
  global $config, $customVariant;
  if (isset($customVariant)) {
    return $customVariant;
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
