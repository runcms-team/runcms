<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/

// Forum Posts

function get_meta($id, $limit) {
global $db;

$SQL =  "
    SELECT
    ".$db->prefix("bbplus_forums.forum_name").",
    ".$db->prefix("bbplus_topics.topic_title").",
    ".$db->prefix("bbplus_forums.forum_desc")."
    FROM
    ".$db->prefix("bbplus_forums").",
    ".$db->prefix("bbplus_topics")."
    WHERE
    (".$db->prefix("bbplus_topics.forum_id")."=$id
    AND
    ".$db->prefix("bbplus_forums.forum_id")."=$id)";

$query = $db->query($SQL, $limit);
while (list($forum_name, $topic_title, $forum_desc) = $db->fetch_row($query)) {
    $result["title"]     = $forum_name;
    $result["keywords"] .=  " ". $forum_name ." ". $topic_title ." ". $forum_desc ." ";
}

return $result;
}
?>
