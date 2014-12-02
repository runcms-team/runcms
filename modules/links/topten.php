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

//generates top 10 charts by rating and hits for each main category
OpenTable();
mainheader();

if (isset($rate)) {
	$sort   = _MD_RATING;
	$sortDB = "rating";
	} else {
		$sort   = _MD_HITS;
		$sortDB = "hits";
	}

$arr    = array();
$result = $db->query("SELECT cid, title from ".$db->prefix("links_cat")." WHERE pid=0");

while (list($cid, $ctitle) = $db->fetch_row($result)) {
	$boxtitle  = "<big>";
	$boxtitle .= sprintf(_MD_TOP10, $ctitle);
	$boxtitle .= " (".$sort.")</big>";
	$thing     = "<table width='100%' border='0'><tr><td width='7%' class='bg3'><b>"._MD_RANK."</b></td><td width='28%' class='bg3'><b>"._MD_TITLE."</b></td><td width='40%' class='bg3'><b>"._MD_CATEGORY."</b></td><td width='8%' class='bg3' align='center'><b>"._MD_HITS."</b></td><td width='9%' class='bg3' align='center'><b>"._MD_RATING."</b></td><td width='8%' class='bg3' align='right'><b>"._MD_VOTE."</b></td></tr>";
	$query     = "SELECT lid, cid, title, hits, rating, votes FROM ".$db->prefix("links_links")." where status>0 and (cid=$cid";
	// get all child cat ids for a given cat id
	$arr  = $mytree->getAllChildId($cid);
	$size = count($arr);
	for ($i=0; $i<$size; $i++) {
		$query .= " or cid=".$arr[$i]."";
	}
	$query  .= ") order by ".$sortDB." DESC";
	$result2 = $db->query($query, 10, 0);
	$rank    = 1;
	while (list($lid, $lcid, $ltitle, $hits, $rating, $votes) = $db->fetch_row($result2)) {
		$rating = number_format($rating, 2);
		if ($hit) {
			$hits = "$hits";
			} elseif ($rate) {
				$rating = "$rating";
			}
		$catpath = $mytree->getNicePathFromId($lcid, "title", "viewcat.php?");
		$catpath = substr($catpath, 0, -2);
		$catpath = str_replace(":", "&raquo;", $catpath);
		$thing  .= "<tr><td>$rank</td>";
		$thing  .= "<td><a href='singlelink.php?lid=$lid'>$ltitle</a></td>";
		$thing  .= "<td>$catpath</td>";
		$thing  .= "<td align='center'>$hits</td>";
		$thing  .= "<td align='center'>$rating</td><td align='right'>$votes</td></tr>";
		$rank++;
	}
	$thing .= "</table>";
	themecenterposts($boxtitle, $thing);
	echo "<br />";
}

CloseTable();
include_once("footer.php");
?>
