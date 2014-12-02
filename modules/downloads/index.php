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
if ($rcxConfig['startpage'] == "downloads") {
	$rcxOption['show_rblock'] = 1;
	include_once(RCX_ROOT_PATH."/header.php");
	make_cblock();
	echo "<br />";
	} else {
		$rcxOption['show_rblock'] = 0;
		include_once(RCX_ROOT_PATH."/header.php");
	}
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
$result = $db->query("SELECT cid, title, imgurl FROM ".$db->prefix("downloads_cat")." WHERE pid=0 ORDER BY title") or die("Error");
OpenTable();
mainheader();
echo "<center><table border='0' cellspacing='0' cellpadding='10'><tr>";
$count = 0;
$totals = 0;
while ($myrow = $db->fetch_array($result)) {
	$title = $myts->makeTboxData4Show($myrow['title']);
	$totaldownload = RcxDownload::countDownloadsByCategory($myrow['cid']);
	$totals = $totals + $totaldownload;
	echo "<td valign='top'>";
	if ( !empty($myrow['imgurl']) && $myrow['imgurl'] != "http://" ) {
		echo "<a href='".RCX_URL."/modules/downloads/viewcat.php?cid=".$myrow['cid']."'><img src='".formatURL(RCX_URL .'/modules/downloads/cache/logos/', $myrow['imgurl'])."' border='0' alt='$title'></a><br />";
	}
	echo "<a href='".RCX_URL."/modules/downloads/viewcat.php?cid=".$myrow['cid']."'><b>$title</b></a>&nbsp;($totaldownload)<br />";
	// get child category objects
	$arr     = array();
	$arr     = $mytree->getFirstChild($myrow['cid'], "title");
	$space   = 0;
	$chcount = 0;
	foreach($arr as $ele) {
		$chtitle = $myts->makeTboxData4Show($ele['title']);
		if ($chcount > 5) {
			echo "...";
			break;
		}
		if ($space>0) {
			echo ", ";
		}
				$catdls = RcxDownload::countDownloadsByCategory($ele['cid']);
		echo "<a href='".RCX_URL."/modules/downloads/viewcat.php?cid=".$ele['cid']."'>".$chtitle."</a> (".$catdls.")";
		$space++;
		$chcount++;
	}
	if ($count < 1) {
		echo "</td>";
	}
	$count++;
	if ($count == 2) {
		echo "</td></tr><tr>";
		$count = 0;
	}
}
echo "</td></tr></table>";
list($numrows) = $db->fetch_row($db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_downloads")." WHERE status>0"));
echo "<br /><br />";
printf(_MD_THEREARE, "<b>".RcxDownload::countDownloads()."</b>");
echo "</center>";
if ($downloadsConfig['rss_enable'] == 1) {
$SQL= "SELECT title, lid, version, description FROM ".$db->prefix("downloads_downloads")." WHERE status <> 0 ORDER BY date DESC";
		$query = $db->query($SQL, $downloadsConfig['rss_maxitems']);
		if ($query) {
		include_once(RCX_ROOT_PATH.'/class/xml-rss.php');
		$rss = new xml_rss(RCX_ROOT_PATH . '/modules/downloads/cache/downloads.xml');
		$rss->channel_title       .= " :: " . _MI_DOWNLOADS_NAME;
		$rss->image_title         .= " :: " . _MI_DOWNLOADS_NAME;
		$rss->max_items            = $downloadsConfig['rss_maxitems'];
		$rss->max_item_description = $downloadsConfig['rss_maxdescription'];
	
		while ( list($title, $link, $version, $description) = $db->fetch_row($query) ) {
			$link = RCX_URL . '/modules/downloads/singlefile.php?lid=' . $link;
			if ( !empty($version) ) { $title .= " - ".$version; }
			$rss->build($title, $link, $description);
		}
		$rss->save();
	}
echo "<div align='right'><a href='./cache/downloads.xml' target='_blank'><img src='./images/xml.gif' border='0' vspace='2'></a></div>";
}
CloseTable();
echo "";
OpenTable();
echo "<div align='left'><h4>"._MD_LATESTLIST."</h4>";
showNew($mytree);
echo "</div>";
CloseTable();
include_once(RCX_ROOT_PATH."/modules/downloads/footer.php");
/**
* Shows the Latest Listings on the front page
*
* @param type $var description
* @return type description
*/
function showNew($mytree) {
global $myts, $db, $rcxConfig, $rcxModule, $rcxUser, $downloadsConfig;
if ($rcxUser) {
	$groups = $rcxUser->groups();
} else {
	$groups = RcxGroup::getByType("Anonymous");
}
$sql = "
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
	status>0 AND (";
	$first = true;
	foreach ( $groups as $group ) {
		if (!$first) {
			$sql.= " or ";
		}
		if ( $first == true ) { $first = false; }
		$sql.= "groups like '%$group%'";
	}
	$sql.= ")";
	$sql.= " ORDER BY date DESC";
$result = $db->query($sql, $downloadsConfig['newdownloads'], 0);
$countdwls = 0;
while (list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $platform, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description, $uid)=$db->fetch_row($result)) {
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
	$countdwls++;
	}
if ( $countdwls == 0 ) {
	echo "<p align=\"center\"><b>"._AM_NODOWNLOADS."</b></p>";
}
}
?>