<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./header.php");

if ($rcxConfig['startpage'] == "links") {
	$rcxOption['show_rblock'] = 1;
	include_once(RCX_ROOT_PATH."/header.php");
	make_cblock();
	echo "<br />";
	} else {
		$rcxOption['show_rblock'] = 0;
		include_once(RCX_ROOT_PATH."/header.php");
	}

$mytree = new RcxTree($db->prefix("links_cat"), "cid", "pid");
$result = $db->query("SELECT cid, title, imgurl FROM ".$db->prefix("links_cat")." WHERE pid=0 ORDER BY title") or die("Error");

OpenTable();
mainheader();

echo "<center><table border='0' cellspacing='0' cellpadding='10'><tr>";

$count = 0;
while ($myrow = $db->fetch_array($result)) {
	$title = $myts->makeTboxData4Show($myrow['title']);
	$totallink = getTotalItems($myrow['cid'], 1);
	echo "<td valign='top'>";
	if ( !empty($myrow['imgurl']) && $myrow['imgurl'] != "http://" ) {
		echo "<a href='".RCX_URL."/modules/links/viewcat.php?cid=".$myrow['cid']."'><img src='".formatURL(RCX_URL .'/modules/links/cache/logos/', $myrow['imgurl'])."' border='0' alt='$title'></a><br />";
	}
	echo "<a href='".RCX_URL."/modules/links/viewcat.php?cid=".$myrow['cid']."'><b>$title</b></a>&nbsp;($totallink)<br />";
	// get child category objects
	$arr     = array();
	$arr     = $mytree->getFirstChild($myrow['cid'], "title");
	$space   = 0;
	$chcount = 0;
	foreach($arr as $ele) {
		$chtitle = $myts->makeTboxData4Show($ele['title']);
		if ($chcount>5) {
			echo "...";
			break;
		}
		if ($space>0) {
			echo ", ";
		}
		echo "<a href='".RCX_URL."/modules/links/viewcat.php?cid=".$ele['cid']."'>".$chtitle."</a>";
		$space++;
		$chcount++;
	}
	if ($count<1) {
		echo "</td>";
		}
	$count++;
	if ($count == 2) {
		echo "</td></tr><tr>";
		$count = 0;
	}
}
echo "</td></tr></table>";
$query = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE status>0");
list($numrows) = $db->fetch_row($query);
echo "<br /><br />";
printf(_MD_THEREARE, $numrows);
echo "</center>";

if ($linksConfig['rss_enable'] == 1) {
	echo "<div align='right'><a href='./cache/links.xml' target='_blank'><img src='./images/xml.gif' border='0' vspace=2></a></div>";
}

CloseTable();

echo "<br />";

OpenTable();
echo "<div align='left'><h4>"._MD_LATESTLIST."</h4>";
showNew($mytree);
echo "</div>";
CloseTable();
include_once(RCX_ROOT_PATH."/modules/links/footer.php");

/**
* Shows the Latest Listings on the front page
*
* @param type $var description
* @return type description
*/
function showNew($mytree) {
global $myts, $db, $rcxConfig, $rcxModule, $linksConfig;

$sql = "
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
	status>0
	ORDER BY date DESC";

$result = $db->query($sql, $linksConfig['newlinks'], 0);

while (list($lid, $cid, $ltitle, $url, $email, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $db->fetch_row($result)) {
	$rating      = number_format($rating, 2);
	$ltitle      = $myts->makeTboxData4Show($ltitle);
	$url         = $myts->makeTboxData4Show($url);
	$email       = $myts->makeTboxData4Show($email);
	$logourl     = $myts->makeTboxData4Show($logourl);
	$datetime    = formatTimestamp($time, "s");
	$description = $myts->makeTareaData4Show($description, 1, 1, 1);
	include("include/linkformat.php");
	}

}
?>
