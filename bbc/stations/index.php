<?php

ini_set('display_errors', false);
$station = preg_replace('/\W/', '', $_GET['station']);

if (!$station) {
  include __DIR__ . '/list.php';
  exit();
}

// fetch the list of tracks played on this station
$dom = new DOMDocument;
$dom->preserveWhiteSpace = false;
$result = $dom->load(sprintf('http://www.bbc.co.uk/%s/nowplaying/latest.xspf', $station));

if (!$result) exit('A Now Playing XSPF was not found for this station');

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('xspf', 'http://xspf.org/ns/0/');

// make the tracks chronological instead of reverse chronological
$nodeList = $xpath->query('xspf:trackList')->item(0);
$reverseNodeList = $nodeList->cloneNode(); // clone the original node
while ($nodeList->lastChild) $reverseNodeList->appendChild($nodeList->lastChild); // move all nodes off the bottom of the original list onto the new one
$nodeList->parentNode->replaceChild($reverseNodeList, $nodeList); // replace the original node with the new one

// output the modified XSPF XML
header('Content-Type: application/xspf+xml');
header('Content-Disposition: attachment; filename=' . $station . '.xspf');
//header('Content-Type: text/plain');
//$dom->formatOutput = true;
print $dom->saveXML();

