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
include_once(RCX_ROOT_PATH."/class/groupaccess.php");
if ( empty($lid) ) {
	redirect_header(RCX_URL."/modules/downloads",3);
	exit();
} elseif ( !RcxDownload::isAccessible($lid) ) {
	redirect_header(RCX_URL."/user.php",3,_MD_MUSTREGFIRST);
	exit();
}
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
$lid    = intval($_GET['lid']);
$sql    = "
		SELECT
		lid,
		cid,
		title,
		url,
		homepage,
		version,
		size,
		platform,
		logourl,
		status,
		date,
		hits,
		rating,
		votes,
		comments,
		description,
		submitter
		FROM
		".$db->prefix("downloads_downloads")."
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
while (list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $platform, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description, $uid)=$db->fetch_row($result)) {
echo "<table width='100%' cellspacing='0' cellpadding='3' border='0'><tr><td>";
$pathstring  = "<a href=index.php>"._MD_MAIN."</a> : ";
$nicepath    = $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
$pathstring .= $nicepath;
echo "<b>".$pathstring."</b></td></tr></table><br />";
$rating      = number_format($rating, 2);
$dtitle      = $myts->makeTboxData4Show($dtitle);
$url         = $myts->makeTboxData4Show($url);
$homepage    = $myts->makeTboxData4Show($homepage);
$version     = $myts->makeTboxData4Show($version);
$size        = $myts->makeTboxData4Show($size);
$platform    = $myts->makeTboxData4Show($platform);
$logourl     = $myts->makeTboxData4Show($logourl);
$datetime    = formatTimestamp($time, "s");
$description = $myts->makeTareaData4Show($description, 1, 1, 1);
if ($uid != 0) {
$submitter = RcxUser::getUnameFromId($uid);
$submitter = $myts->makeTboxData4Show($submitter);
} else {
$submitter = $myts->makeTboxData4Show($rcxConfig['anonymous']);
}
	include("include/dlformat.php");
}
CloseTable();
include_once("footer.php");
?>
