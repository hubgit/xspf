<?php

ini_set('display_errors', false);
$pid = preg_replace('/\W/', '', $_GET['series']);

if (!$pid) {
  include __DIR__ . '/list.php';
  exit();
}

// find the latest episode of this series
$series = json_decode(file_get_contents(sprintf('http://www.bbc.co.uk/programmes/%s/episodes/player.json', $pid)));
if (!$series) exit('No series found');
if (!$series->episodes) exit('No episode found');

$episode = $series->episodes[0];

// fetch the list of tracks played in this episode
$dom = new DOMDocument;
$dom->preserveWhiteSpace = false;
$result = $dom->load(sprintf('http://www.bbc.co.uk/programmes/%s/segments.xspf', $episode->programme->pid));

if (!$result) exit('A segments XSPF was not found for this episode');

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('xspf', 'http://xspf.org/ns/0/');

// set the title of the playlist to the series title instead of the episode title
$titleNode = $xpath->query('xspf:title')->item(0);
$titleNode->removeChild($titleNode->firstChild); // setting $titleNode->textContent doesn't work
$titleNode->appendChild($dom->createTextNode($episode->programme->programme->title));

// make the tracks chronological instead of reverse chronological
//$nodeList = $xpath->query('xspf:trackList')->item(0);
//$reverseNodeList = $nodeList->cloneNode(); // clone the original node
//while ($nodeList->lastChild) $reverseNodeList->appendChild($nodeList->lastChild); // move all nodes off the bottom of the original list onto the new one
//$nodeList->parentNode->replaceChild($reverseNodeList, $nodeList); // replace the original node with the new one

// output the modified XSPF XML
header('Content-Type: application/xspf+xml');
header('Content-Disposition: attachment; filename=' . $pid . '.xspf');
//header('Content-Type: text/plain');
//$dom->formatOutput = true;
print $dom->saveXML();

