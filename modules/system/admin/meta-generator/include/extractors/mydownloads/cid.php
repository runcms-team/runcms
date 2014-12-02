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
	".$db->prefix("mydownloads_cat.title").",
	".$db->prefix("mydownloads_downloads.title").",
	".$db->prefix("mydownloads_downloads.description")."
	FROM
	".$db->prefix("mydownloads_cat").",
	".$db->prefix("mydownloads_downloads")."
	WHERE
	(".$db->prefix("mydownloads_downloads.cid")."=$id
	AND
	".$db->prefix("mydownloads_cat.cid")."=$id)";

$query = $db->query($SQL, $limit);
while (list($cat_title, $link_title, $description) = $db->fetch_row($query)) {
	$result["title"]     = $cat_title;
	$result["keywords"] .=  " ". $link_title ." ". $description ." ";
}

return $result;
}
?>
