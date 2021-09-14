<?php

function joinPaths(...$parts)
{
  $path = join('/', array_map(function ($item) {
    return trim($item, '/');
  }, $parts));

  if (substr($parts[0], 0, 1) === "/") {
    return '/' . $path;
  }

  return $path;
}

function getRequirePath($input)
{
  return joinPaths(__DIR__, "/../", $input);
}
