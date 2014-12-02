<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("header.php");

$mytree = new RcxTree($db->prefix("links_cat"), "cid", "pid");
$lid    = intval($_GET['lid']);
$sql    = "
		SELECT
		lid,
		cid,
		title,
		url,
		email,
		logourl,
		status,
		date,
		hits,
		rating,
		votes,
		comments,
		description
		FROM
		".$db->prefix("links_links")."
		WHERE
		lid=$lid
		AND
		status>0";

$result = $db->query($sql);

if ($db->num_rows($result) != 1) {
	redirect_header('index.php');
	exit();
}

include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();

list($lid, $cid, $ltitle, $url, $email, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $db->fetch_row($result);
echo "<table width='100%' cellspacing='0' cellpadding='3' border='0'><tr><td>";

$pathstring  = "<a href='index.php'>"._MD_MAIN."</a> : ";
$nicepath    = $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
$pathstring .= $nicepath;

echo "<b>".$pathstring."</b></td></tr></table><br />";

$rating      = number_format($rating, 2);
$ltitle      = $myts->makeTboxData4Show($ltitle);
$url         = $myts->makeTboxData4Show($url);
$email       = $myts->makeTboxData4Show($email);
$logourl     = $myts->makeTboxData4Show($logourl);
$datetime    = formatTimestamp($time, "s");
$description = $myts->makeTareaData4Show($description, 1, 1, 1);

include("include/linkformat.php");

CloseTable();
include_once("footer.php");
?>
