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
include_once(RCX_ROOT_PATH."/class/groupaccess.php");
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
$cid    = intval($_GET['cid']);
OpenTable();
mainheader();
$query = $db->query("SELECT description FROM ".$db->prefix("downloads_cat")." WHERE cid='$cid'");
list($desc) = $db->fetch_row($query);
if ($desc) {
	$myts->setType('admin');
	$desc = $myts->makeTareaData4Show($desc, 1, 1, 1);
	echo $desc."<br /><br />";
}
if ( $_GET['show'] != "" ) {
	$show = intval($_GET['show']);
	} else {
		$show = $downloadsConfig['perpage'];
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
$str_path  = "<a href='index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
$str_path .= $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
echo "<b>".$str_path."</b></td></tr></table>";
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
	foreach($arr as $ele) {
		$title = $myts->makeTboxData4Show($ele['title']);
		$totaldownload = RcxDownload::countDownloadsByCategory($ele['cid']);
		echo "<td align='left'><b><a href=viewcat.php?cid=".$ele['cid'].">$title</a></b>&nbsp;($totaldownload)</td>";
		$scount++;
		if ( $scount == 4 ) {
			echo "</tr><tr>";
			$scount = 0;
			}
	}
	echo "</tr></table><br /><hr />";
}
$numrows = RcxDownload::countDownloadsByCategory($cid);
if ($numrows>0) {
	//if 2 or more items in result, show the sort menu
	if ($numrows>1) {
		$orderbyTrans = convertorderbytrans($orderby);
		echo "
		<br /><small><center>"._MD_SORTBY."&nbsp;&nbsp;
		"._MD_TITLE." (<a href='viewcat.php?cid=$cid&orderby=titleA'><img src='images/up.gif' border='0' align='middle' alt='' /></a>&nbsp;&nbsp;<a href='viewcat.php?cid=$cid&orderby=titleD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_DATE." (<a href='viewcat.php?cid=$cid&orderby=dateA'><img src='images/up.gif' border='0' align='middle' alt='' /></a>&nbsp;&nbsp;<a href='viewcat.php?cid=$cid&orderby=dateD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_RATING." (<a href='viewcat.php?cid=$cid&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a>&nbsp;&nbsp;<a href='viewcat.php?cid=$cid&orderby=ratingD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		"._MD_POPULARITY." (<a href='viewcat.php?cid=$cid&orderby=hitsA'><img src='images/up.gif' border='0' align='middle' alt='' /></a>&nbsp;&nbsp;<a href='viewcat.php?cid=$cid&orderby=hitsD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
		<b><br />";
		printf(_MD_CURSORTBY, $orderbyTrans);
		echo "</small></b></center><br /><br />";
		}
if ($rcxUser) {
	$groups = $rcxUser->groups();
} else {
	$groups = RcxGroup::getByType("Anonymous");
}
	$sql = "
		SELECT
		lid,
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
		cid=$cid
		AND
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
		$sql.= " ORDER BY $orderby";
	$result = $db->query($sql, $show, $min);
	$countdwls = 0;
	while (list($lid, $dtitle, $url, $homepage, $version, $size, $platform, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description, $uid)=$db->fetch_row($result)) {
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
	$orderby       = convertorderbyout($orderby);
	//Calculates how many pages exist.  Which page one should be on, etc...
	$downloadpages = ceil($numrows / $show);
	//Page Numbering
	if ($downloadpages != 1 && $downloadpages != 0) {
		echo "<br /><br />";
		$prev = ($min - $show);
		if ($prev >= 0) {
			echo "
			&nbsp;<a href='viewcat.php?cid=$cid&min=$prev&orderby=$orderby&show=$show'>
			<b>&lt; "._PREVIOUS." </b></a>&nbsp;";
			}
		$counter = 1;
		$currentpage = ($max / $show);
		while ( $counter <= $downloadpages ) {
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
			<b> "._NEXT." &gt;</b></a>";
			}
		}
}
echo "</td></tr></table>";
if ($countdwls == 0) {
	echo "<p align=\"center\"><b>"._AM_NODOWNLOADS."</b></p>";
}
CloseTable();
include_once("footer.php");
?>
