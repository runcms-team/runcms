<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/

// Single Files
function get_meta($id, $limit) {
global $db;

$SQL =  "
    SELECT
    ".$db->prefix("downloads_cat.title").",
    ".$db->prefix("downloads_downloads.title").",
    ".$db->prefix("downloads_downloads.version").",
    ".$db->prefix("downloads_downloads.description")."
    FROM
    ".$db->prefix("downloads_cat").",
    ".$db->prefix("downloads_downloads")."
    WHERE
    (".$db->prefix("downloads_downloads.lid")."=$id
    AND
    ".$db->prefix("downloads_cat.cid")."=".$db->prefix("downloads_downloads.cid").")";

$query  = $db->query($SQL, $limit);
list($cat_title, $link_title, $version, $description) = $db->fetch_row($query);

    if ($version == "") {
      $result["title"]    = $link_title . " : ". $cat_title;
    } else {
      $result["title"]    = $link_title . " " .$version. " : ". $cat_title;
    }
    $result["keywords"] = $link_title ." ". $cat_title ." ". $description;

return $result;
}
?>
