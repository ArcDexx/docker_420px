<?php
include_once('dbhandler.php');
header("Content-Type: application/rss+xml; charset=UTF-8");

$users = getAllUsers();

$entries = array();

foreach ($users as $user)
{
    $images = getUserPictures($user);

    $data = array(
        "title" => $user,
        "description" => "Photos de ".$user,
        "link" => "php420px.corentin-watts.com/explore.php?user=".$user
    );

    array_push($entries, $data);
}

$xml = new SimpleXMLElement('<rss/>');
$xml->addAttribute("version", "2.0");

$channel = $xml->addChild("channel");

$channel->addChild("title", '420px');
$channel->addChild("link", "420px.com");
$channel->addChild("description", "Describe your feed");

foreach ($entries as $entry) {
    $item = $channel->addChild("item");
    $item->addChild("title", $entry['title']);
    $item->addChild("link", $entry['link']);
    $item->addChild("description", $entry['description']);
  }

  echo $xml->asXML();
?>
