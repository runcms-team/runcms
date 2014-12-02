<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/

function get_meta($id, $limit) {
global $db;

$SQL =  "SELECT
	".$db->prefix("xoopsfaq_contents.contents_title").",
	".$db->prefix("xoopsfaq_contents.contents_contents").",
	".$db->prefix("xoopsfaq_categories.category_title")."
	FROM
	".$db->prefix("xoopsfaq_contents")."
	INNER JOIN
	".$db->prefix("xoopsfaq_categories")."
	ON
	".$db->prefix("xoopsfaq_contents.category_id")."=".$db->prefix("xoopsfaq_categories.category_id")."
	WHERE
	(".$db->prefix("xoopsfaq_contents.category_id")."=$id
	AND
	".$db->prefix("xoopsfaq_categories.category_id")."=$id)";

$query = $db->query($SQL, $limit);

while (list($question, $answer, $category) = $db->fetch_row($query)) {
	$result["title"]     = $category;
	$result["keywords"] .=  " ". $question ." ". $answer ." ";
}

return $result;
}
?>
