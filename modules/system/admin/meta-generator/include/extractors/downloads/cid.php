<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/

// Downloads Categories
function get_meta($id, $limit) {
global $db;

$SQL =  "
	SELECT
	".$db->prefix("downloads_cat.title").",
	".$db->prefix("downloads_downloads.title").",
	".$db->prefix("downloads_downloads.description")."
	FROM
	".$db->prefix("downloads_cat").",
	".$db->prefix("downloads_downloads")."
	WHERE
	(".$db->prefix("downloads_downloads.cid")."=$id
	AND
	".$db->prefix("downloads_cat.cid")."=$id)";

$query = $db->query($SQL, $limit);
while (list($cat_title, $link_title, $description) = $db->fetch_row($query)) {
	$result["title"]     = $cat_title;
	$result["keywords"] .=  " ". $link_title ." ". $description ." ";
}

return $result;
}
?>
