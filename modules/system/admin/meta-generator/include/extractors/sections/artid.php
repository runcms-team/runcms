<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/


// Section Articles

function get_meta($id, $limit) {
global $db;

$SQL = "SELECT
	".$db->prefix("nsections.secname").",
	".$db->prefix("nseccont.title").",
	".$db->prefix("nseccont.content")."
	FROM
	".$db->prefix("nseccont")."
	INNER JOIN
	".$db->prefix("nsections")."
	ON
	".$db->prefix("nsections.secid")."=".$db->prefix("nseccont.secid")."
	WHERE
	".$db->prefix("nseccont.artid")."=$id";

$query = $db->query($SQL, $limit);

list($secname, $title, $content) = $db->fetch_row($query);
	$result["title"]     = $secname .", ". $title;
	$result["keywords"] .= $secname ." ". $title ." ". $content;

return $result;
}
?>
