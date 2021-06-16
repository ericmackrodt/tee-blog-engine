<?php
require __DIR__ . "/../third-party/load-parsedown.php";

define('FULL_YOUTUBE_REGEX', '/(?:(?:https?:)?(?:\/\/)?)(?:(?:www)?\.)?youtube\.(?:.+?)\/(?:(?:watch\?v=)|(?:embed\/))([a-zA-Z0-9_-]{11})/');
define('SHORT_YOUTUBE_REGEX', '/(?:(?:https?:)?(?:\/\/)?)?youtu\.be\/([a-zA-Z0-9_-]{11})/');

class BlogParsedown extends Parsedown
{
  private $templates;
  function __construct($templates)
  {
    $this->templates = $templates;

    $this->InlineTypes['!'][] = 'Youtube';

    // $this->inlineMarkerList .= '!';

    $this->BlockTypes['['][] = 'PageMenu';
    $this->BlockTypes['['][] = 'FileDownload';
    $this->BlockTypes['['][] = 'Gallery';
  }

  # parsedown-extra stuff

  #
  # Fields
  #

  protected $regexAttribute = '(?:[#.][-\w]+[ ]*)';

  protected function parseAttributeData($attributeString)
  {
    $Data = array();

    $attributes = preg_split('/[ ]+/', $attributeString, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($attributes as $attribute) {
      if ($attribute[0] === '#') {
        $Data['id'] = substr($attribute, 1);
      } else # "."
      {
        $classes[] = substr($attribute, 1);
      }
    }

    if (isset($classes)) {
      $Data['class'] = implode(' ', $classes);
    }

    return $Data;
  }

  #
  # Header

  protected function blockHeader($Line)
  {
    $level = strspn($Line['text'], '#');

    if ($level > 6) {
      return;
    }

    $text = trim($Line['text'], '#');

    if ($this->strictMode and isset($text[0]) and $text[0] !== ' ') {
      return;
    }

    $text = trim($text, ' ');

    $Block = array(
      'element' => array(
        'name' => 'h' . $level,
        'handler' => array(
          'function' => 'lineElements',
          'argument' => $text,
          'destination' => 'elements',
        )
      ),
    );

    $fullText = $text;

    if (!isset($Block)) {
      return null;
    }

    $strLevel = strval($level);
    $attributes = array();
    $content = $text;

    if (preg_match('/[ #]*{(' . $this->regexAttribute . '+)}[ ]*$/', $text, $matches, PREG_OFFSET_CAPTURE)) {
      $attributeString = $matches[1][0];
      $attributes = $this->parseAttributeData($attributeString);
      $content = substr($text, 0, $matches[0][1]);
    };

    return [
      'extent' => strlen($fullText),
      'element' => ['rawHtml' =>  $this->templates->render(withVariant('header'), ['size' => $strLevel, 'content' => $content, 'id' => $attributes['id']])],
    ];
  }

  ## Image

  protected function inlineImage($Excerpt)
  {
    $Inline = parent::inlineImage($Excerpt);

    if (!isset($Inline)) {
      return;
    }

    return [
      'extent' => $Inline["extent"],
      'element' => ['rawHtml' =>  $this->templates->render(withVariant('image'), ['attributes' => $Inline['element']['attributes']])],
    ];
  }

  ##
  ## Blog parsedown stuff
  ##

  ## Page Menu

  public function blockPageMenu($line, array $block = null): ?array
  {
    if (preg_match('/^\[page-menu\]/', $line['text'], $matches)) {
      return array(
        'links' => array(),
        'char' => $line['text'][0],
        'element' => array(
          'rawHtml' => '',
        ),
      );
    }

    return null;
  }

  public function blockPageMenuContinue($line, array $block): ?array
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
    if (preg_match('/\[\/page-menu\]/', $line['text'])) {
      $block['element']['rawHtml'] = substr($block['element']['rawHtml'], 1);

      // This will flag the block as 'complete':
      // 1. The 'continue' function will not be called again.
      // 2. The 'complete' function will be called instead.
      $block['complete'] = true;
      return $block;
    }

    if (!preg_match('/\-\s+\[(.+)\]\((.+)\)/', $line['body'], $linkMatch)) {
      return $block;
    }

    list(0 => $match, 1 => $content, 2 => $url) = $linkMatch;

    $block['links'][] = (object)['content' => $content, 'url' => $url];

    return $block;
  }

  public function blockPageMenuComplete(array $block): ?array
  {
    $block['element']['rawHtml'] = $this->templates->render(withVariant("page-menu"), ['items' => $block["links"]]);
    return $block;
  }

  ## Youtube

  protected function inlineYoutube($excerpt)
  {
    if (preg_match('/\!yt\[(.+)\]\((.+)\)/', $excerpt['text'], $matches)) {
      list(0 => $fullMatch, 1 => $title, 2 => $url) = $matches;

      if (!preg_match(FULL_YOUTUBE_REGEX, $url, $urlMatches) && !preg_match(SHORT_YOUTUBE_REGEX, $url, $urlMatches)) {
        return null;
      }

      preg_match('/t=(.+)$/', $url, $timestamp);

      $embedUrl = "https://www.youtube.com/embed/{$urlMatches[1]}?rel=0";

      if (isset($timestamp)) {
        $embedUrl .= "&start={$timestamp[1]}";
      }

      return [
        'extent' => strlen($fullMatch),
        'element' => ['rawHtml' =>  $this->templates->render(withVariant("youtube"), [
          'variant' => 'modern',
          'videoId' => $urlMatches[1],
          'title' => $title,
          'full_url' => $url,
          'embed_url' => $embedUrl
        ])],
      ];
    }

    return null;
  }

  ## File Download

  public function blockFileDownload($line, array $block = null): ?array
  {
    if (preg_match('/^\[file-download\]/', $line['text'], $matches)) {
      return array(
        'download-contents' => array(),
        'char' => $line['text'][0],
        'element' => array(
          'rawHtml' => '',
        ),
      );
    }

    return null;
  }

  public function blockFileDownloadContinue($line, array $block): ?array
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
    if (preg_match('/\[\/file-download\]/', $line['text'])) {
      $block['element']['rawHtml'] = substr($block['element']['rawHtml'], 1);

      // This will flag the block as 'complete':
      // 1. The 'continue' function will not be called again.
      // 2. The 'complete' function will be called instead.
      $block['complete'] = true;
      return $block;
    }

    if (isset($block["reached-description"])) {
      $block["download-contents"]["description"] .= $line['body'] . PHP_EOL;
    }

    if (preg_match('/name: "(.+)"/', $line['body'], $nameMatch)) {
      $block["download-contents"]["name"] = $nameMatch[1];
      $id = preg_replace("/[\s\.,]+/", "", $nameMatch[1]);
      $block["download-contents"]["id"] = strtolower($id);
      return $block;
    }

    if (preg_match('/file: "(.+)"/', $line['body'], $fileMatch)) {
      $block["download-contents"]["file"] = $fileMatch[1];
      return $block;
    }

    if (preg_match('/url: "(.+)"/', $line['body'], $urlMatch)) {
      $block["download-contents"]["url"] = $urlMatch[1];
      return $block;
    }

    if (preg_match('/description:/', $line['body'])) {
      $block["reached-description"] = true;
      return $block;
    }

    return $block;
  }

  public function blockFileDownloadComplete(array $block): ?array
  {
    $block["download-contents"]["description"] = $this->parse($block["download-contents"]["description"]);

    $block['element']['rawHtml'] = $this->templates->render(withVariant("file-download"), ['data' => (object)$block["download-contents"]]);
    return $block;
  }

  ## Page Menu

  public function blockGallery($line, array $block = null): ?array
  {
    return galleryStart($line, $block);
  }

  public function blockGalleryContinue($line, array $block): ?array
  {
    return galleryContinue($line, $block);
  }

  public function blockGalleryComplete(array $block): ?array
  {
    return galleryComplete($block, $this->templates, $this->variant);
  }
}

$parsedown = new BlogParsedown($templates);

function renderMarkdown($markdown)
{
  global $parsedown;
  return $parsedown->parse($markdown);
};
