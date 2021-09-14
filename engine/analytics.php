<?php

use TheIconic\Tracking\GoogleAnalytics\Analytics;

function getRemoteIP()
{
  return array_key_exists('REMOTE_ADDR', $_SERVER)
    ? $_SERVER['REMOTE_ADDR'] : "";
}

function parseOrCreateAnalyticsCookie()
{
  if (isset($_COOKIE['_ga'])) {
    // An analytics cookie is found
    list($version, $domainDepth, $cid1, $cid2) = preg_split('[\.]', $_COOKIE["_ga"], 4);
    $contents = array(
      'version' => $version,
      'domainDepth' => $domainDepth,
      'cid' => $cid1 . '.' . $cid2
    );
    $cid = $contents['cid'];
  } else {
    // no analytics cookie is found. Create a new one
    $cid1 = mt_rand(0, 2147483647);
    $cid2 = mt_rand(0, 2147483647);

    $cid = $cid1 . '.' . $cid2;
    setcookie('_ga', 'GA1.2.' . $cid, time() + 60 * 60 * 24 * 365 * 2, '/');
  }
  return $cid;
}

function getUserAgent()
{
  return array_key_exists('HTTP_USER_AGENT', $_SERVER)
    ? $_SERVER['HTTP_USER_AGENT'] : "";
}

function getReferer()
{
  return array_key_exists('HTTP_REFERER', $_SERVER)
    ? $_SERVER['HTTP_REFERER'] : "";
}

function getUrlPath()
{
  return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') .
    '://' .
    "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

$clientId = parseOrCreateAnalyticsCookie();
$ip = getRemoteIP();
$userAgent = getUserAgent();
$referrer = getReferer();
$locationUrl = getUrlPath();
$parsedUrl = parse_url($locationUrl);
$documentPath = $parsedUrl["path"];
$documentQuery = $parsedUrl["query"] ?? "";
$documentHost = $parsedUrl["host"];

if (strpos($documentHost, 'localhost') === false) {
  $analytics = new Analytics(true);
  $analytics
    ->setProtocolVersion(1)
    ->setTrackingId("UA-184512961-1")
    ->setClientId($clientId)
    ->setDocumentPath($documentPath)
    ->setDocumentTitle($pageTitle ?? "")
    ->setDocumentReferrer($referrer)
    ->setDocumentLocationUrl($locationUrl)
    ->setDocumentHostName($documentHost)
    ->setIpOverride($ip)
    ->setUserAgentOverride($userAgent);

  $analytics->sendPageview();
}
