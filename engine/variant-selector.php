<?php
$config = require __DIR__ . "/../config.php";

function getVariant()
{
  if (isset($config["custom_variant_selector"])) {
    $customVariantSelector = require __DIR__ . $config["custom_variant_selector"];
    return $customVariantSelector();
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
