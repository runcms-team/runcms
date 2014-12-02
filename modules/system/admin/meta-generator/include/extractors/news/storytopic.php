<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/


// Story Topics

function get_meta($id, $limit) {
global $db;

$SQL = "SELECT
	T.topic_title,
	S.title,
	S.hometext,
	S.bodytext
	FROM
	".$db->prefix("stories")." S
	INNER JOIN
	".$db->prefix("topics")." T
	ON
	S.topicid = T.topic_id
	WHERE
	(S.topicid = $id AND T.topic_id = $id)
	ORDER BY
	S.storyid
	DESC";


$query = $db->query($SQL, $limit);

while (list($topic, $title, $hometext, $bodytext) = $db->fetch_row($query)) {
	$result["title"]     = $topic;
	$result["keywords"] .= $topic ." ". $title ." ". $hometext ." ". $bodytext;
}

return $result;
}
?>
