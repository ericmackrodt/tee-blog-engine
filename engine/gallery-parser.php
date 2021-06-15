<?php
function galleryStart($line, array $block = null): ?array
{
  if (preg_match('/^\[gallery\]/', $line['text'], $matches)) {
    return array(
      'images' => array(),
      'id' => '',
      'title' => '',
      'char' => $line['text'][0],
      'element' => array(
        'rawHtml' => '',
      ),
    );
  }

  return null;
}

function galleryContinue($line, array $block): ?array
{
  if (isset($block['complete'])) {
    return null;
  }

  // A blank newline has occurred.
  if (isset($block['interrupted'])) {
    $block['element']['rawHtml'] .= "\n";
    unset($block['interrupted']);
  }

  // Check for end of the block. 
  if (preg_match('/\[\/gallery\]/', $line['text'])) {
    $block['element']['rawHtml'] = substr($block['element']['rawHtml'], 1);

    // This will flag the block as 'complete':
    // 1. The 'continue' function will not be called again.
    // 2. The 'complete' function will be called instead.
    $block['complete'] = true;
    return $block;
  }

  if (preg_match('/title: (.+)/', $line['body'], $nameMatch)) {
    $block["title"] = $nameMatch[1];
    $block["id"] = md5($nameMatch[1]);

    return $block;
  }

  if (!preg_match('/\-\s+\[(.*)\]\((.+)\)/', $line['body'], $linkMatch)) {
    return $block;
  }

  list(0 => $match, 1 => $content, 2 => $url) = $linkMatch;

  $block['images'][] = (object)['content' => $content, 'url' => $url];

  return $block;
}

function galleryComplete(array $block, $templates): ?array
{
  $block['element']['rawHtml'] = $templates->render(withVariant('gallery'), $block);
  return $block;
}

function parseGalleries($contents, $templates)
{
  $lines = explode(PHP_EOL, $contents);
  $currentBlock = null;
  $galleries = array();

  foreach ($lines as $line) {
    $lineArr = ["text" => $line, "body" => $line];

    if (!$currentBlock) {
      $currentBlock = galleryStart($lineArr, $currentBlock);
      continue;
    }

    if ($currentBlock["complete"] == true) {
      $galleries[] = galleryComplete($currentBlock, $templates);
      $currentBlock = null;
      continue;
    }

    $currentBlock = galleryContinue($lineArr, (array)$currentBlock);
  }

  return $galleries;
}
