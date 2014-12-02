<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/

// Story Articles

function get_meta($id, $limit) {
  global $db;

  $SQL = "SELECT
    ".$db->prefix("topics.topic_title").",
    ".$db->prefix("stories.title").",
    ".$db->prefix("stories.hometext").",
    ".$db->prefix("stories.bodytext")."
    FROM
    ".$db->prefix("stories")."
    INNER JOIN
    ".$db->prefix("topics")."
    ON
    ".$db->prefix("stories.topicid")."=".$db->prefix("topics.topic_id")."
    WHERE
    ".$db->prefix("stories.storyid")."=$id";

  $query = $db->query($SQL, $limit);

  list($topic, $title, $hometext, $bodytext) = $db->fetch_row($query);
  $result["title"]    = $title ." : ". $topic;
  $result["keywords"] = $topic ." ". $title ." ". $hometext ." ". $bodytext;
  $result["description"] = substr(strip_tags($hometext) ." ". strip_tags($bodytext),0,255); 

  return $result;
}
?>
