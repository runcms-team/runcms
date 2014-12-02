<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/


// Links Categories
function get_meta($id, $limit) {
global $db;

$SQL =  "
	SELECT
	".$db->prefix("links_cat.title").",
	".$db->prefix("links_links.title").",
	".$db->prefix("links_links.description")."
	FROM
	".$db->prefix("links_cat").",
	".$db->prefix("links_links")."
	WHERE
	(".$db->prefix("links_links.cid")."=$id
	AND
	".$db->prefix("links_cat.cid")."=$id)";

$query = $db->query($SQL, $limit);
while (list($cat_title, $link_title, $description) = $db->fetch_row($query)) {
	$result["title"]     = $cat_title;
	$result["keywords"] .=  " ". $link_title ." ". $description ." ";
}

return $result;
}
?>
