<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/


// Single Links
function get_meta($id, $limit) {
global $db;

$SQL =  "
	SELECT
	".$db->prefix("mylinks_cat.title").",
	".$db->prefix("mylinks_links.title").",
	".$db->prefix("mylinks_links.description")."
	FROM
	".$db->prefix("mylinks_cat").",
	".$db->prefix("mylinks_links")."
	WHERE
	(".$db->prefix("mylinks_links.lid")."=$id
	AND
	".$db->prefix("mylinks_cat.cid")."=".$db->prefix("links_links.cid").")";

$query  = $db->query($SQL, $limit);
list($cat_title, $link_title, $description) = $db->fetch_row($query);
	$result["title"]    = $link_title .", ". $cat_title;
	$result["keywords"] = $link_title ." ". $cat_title ." ". $description;

return $result;
}
?>
