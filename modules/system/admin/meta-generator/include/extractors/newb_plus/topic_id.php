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

$SQL = "
    SELECT
    T.topic_title,
    T.forum_id,
    P.subject,
    P.post_text,
    S.forum_name
    FROM
    ".$db->prefix("bbplus_topics")." T,
    ".$db->prefix("bbplus_posts")." P,
    ".$db->prefix("bbplus_forums")." S
    WHERE P.topic_id = $id AND T.topic_id = $id AND S.forum_id = T.forum_id";

$query = $db->query($SQL, $limit);

while (list($topic_title, $forum_id, $subject, $post_text, $forum_name) = $db->fetch_row($query)) {
    $result["title"]     = $topic_title ." : ". $forum_name;
    $result["keywords"] .= " ". $forum_name ." ". $topic_title ." ". $subject ." ". $post_text ." ";
}

return $result;
}
?>
