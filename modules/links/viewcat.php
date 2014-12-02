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
include_once(RCX_ROOT_PATH."/header.php");

$mytree = new RcxTree($db->prefix("links_cat"), "cid", "pid");
$cid    = intval($_GET['cid']);

OpenTable();
mainheader();

$query      = $db->query("SELECT description FROM ".$db->prefix("links_cat")." WHERE cid='$cid'");
list($desc) = $db->fetch_row($query);

if ($desc) {
	$myts->setType('admin');
	$desc = $myts->makeTareaData4Show($desc, 1, 1, 1);
	echo $desc."<br /><br />";
}

if ( $_GET['show'] != "" ) {
	$show = intval($_GET['show']);
	} else {
		$show = $linksConfig['perpage'];
	}

if ( !isset($_GET['min']) ) {
	$min = 0;
	} else {
		$min = intval($_GET['min']);
	}

if ( !isset($max) ) {
	$max = $min + $show;
	}

if ( isset($_GET['orderby']) ) {
	$orderby = convertorderbyin($_GET['orderby']);
	} else {
		$orderby = "title ASC";
	}

echo "
<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td align='center'>
<table width='100%' cellspacing='1' cellpadding='2' border='0' class='bg3'><tr><td>";

$pathstring  = "<a href='index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
$nicepath    = $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
$pathstring .= $nicepath;

echo "<b>".$pathstring."</b></td></tr></table>";

// get child category objects
$arr = array();
$arr = $mytree->getFirstChild($cid, "title");

if ( count($arr) > 0 ) {
	echo "
	</td></tr>
	<tr><td align='left'><h4>"._MD_CATEGORIES."</h4></td></tr>
	<tr><td align='center'>";
	$scount = 0;
echo "<table width='90%'><tr>";

foreach ($arr as $ele) {
	$title     = $myts->makeTboxData4Show($ele['title']);
	$totallink = getTotalItems($ele['cid'], 1);
	echo "<td align='left'><b><a href='viewcat.php?cid=".$ele['cid']."'>$title</a></b>&nbsp;($totallink)</td>";
	$scount++;
	if ($scount==4) {
		echo "</tr><tr>";
		$scount = 0;
	}
}
echo "</tr></table><br />";
	echo "<hr />";
}

$fullcountresult = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE cid=$cid AND status>0");
list($numrows)   = $db->fetch_row($fullcountresult);

if ($numrows>0) {

	//if 2 or more items in result, show the sort menu
	if ($numrows>1) {
		$orderbyTrans = convertorderbytrans($orderby);
		echo "
		<br /><small><center>"._MD_SORTBY."&nbsp;&nbsp;
		"._MD_TITLE." (<a href='viewcat.php?cid=$cid&orderby=titleA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=titleD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_DATE." (<a href='viewcat.php?cid=$cid&orderby=dateA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=dateD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_RATING." (<a href='viewcat.php?cid=$cid&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=ratingD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_POPULARITY." (<a href='viewcat.php?cid=$cid&orderby=hitsA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=hitsD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		<b><br />";
		printf(_MD_CURSORTEDBY, $orderbyTrans);
		echo "</small></b></center><br /><br />";
	}

	$sql = "
		SELECT
		lid,
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
		cid=$cid
		AND
		status>0
		ORDER BY
		$orderby";

	$result = $db->query($sql, $show, $min);
	while (list($lid, $ltitle, $url, $email, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $db->fetch_row($result)) {
		$rating      = number_format($rating, 2);
		$ltitle      = $myts->makeTboxData4Show($ltitle);
		$url         = $myts->makeTboxData4Show($url);
		$email       = $myts->makeTboxData4Show($email);
		$logourl     = $myts->makeTboxData4Show($logourl);
		$datetime    = formatTimestamp($time, "s");
		$description = $myts->makeTareaData4Show($description, 1, 1, 1);
		include("include/linkformat.php");
	}

	$orderby   = convertorderbyout($orderby);
	//Calculates how many pages exist.  Which page one should be on, etc...
	$linkpages = ceil($numrows / $show);
	//Page Numbering
	if ($linkpages != 1 && $linkpages != 0) {
		echo "<br /><br />";
		$prev = $min - $show;
		if ($prev>=0) {
			echo "
			&nbsp;<a href='viewcat.php?cid=$cid&min=$prev&orderby=$orderby&show=$show'>
			<b>&lt; "._PREVIOUS." ]</b></a>&nbsp;";
		}
	$counter = 1;
	$currentpage = ($max / $show);
	while ( $counter<=$linkpages ) {
		$mintemp = (($show * $counter) - $show);
		if ($counter == $currentpage) {
			echo "<b>$counter</b>&nbsp;";
			} else {
				echo "<a href='viewcat.php?cid=$cid&min=$mintemp&orderby=$orderby&show=$show'>$counter</a>&nbsp;";
			}
	$counter++;
	}

	if ( $numrows>$max ) {
		echo "
		&nbsp;<a href='viewcat.php?cid=$cid&min=$max&orderby=$orderby&show=$show'>
		<b>[ "._NEXT." &gt;</b></a>";
		}
	}
}

echo "</td></tr></table>";

CloseTable();
include_once("footer.php");
?>
