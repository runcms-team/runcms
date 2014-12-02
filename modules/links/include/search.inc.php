<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function links_search($queryarray, $andor, $limit, $offset, $userid) {
global $db;

$sql = "
	SELECT
	lid,
	cid,
	title,
	submitter,
	date,
	LEFT(description, 95) AS content
	FROM ".$db->prefix("links_links")."
	WHERE
	status > 0";

if ( $userid != 0 ) {
	$sql .= " AND submitter=".$userid." ";
}

// because count() returns 1 even if a supplied variable
// is not an array, we must check if $querryarray is really an array
$count = count($queryarray);
if ( $count > 0 && is_array($queryarray) ) {
	$sql .= " AND ((title LIKE '%$queryarray[0]%' OR description LIKE '%$queryarray[0]%')";
	for ($i=1; $i<$count; $i++) {
		$sql .= " $andor ";
		$sql .= "(title LIKE '%$queryarray[$i]%' OR description LIKE '%$queryarray[$i]%')";
	}
	$sql .= ") ";
}

$sql   .= " ORDER BY date DESC";
$result = $db->query($sql, $limit, $offset);

$i = 0;
if ($result) {
	while ($myrow = $db->fetch_array($result)) {
		$ret[$i]['image']   = "images/home.gif";
		$ret[$i]['link']    = "singlelink.php?lid=".$myrow['lid']."";
		$ret[$i]['title']   = $myrow['title'];
		$ret[$i]['content'] = $myrow['content'];
		$ret[$i]['time']    = $myrow['date'];
		$ret[$i]['uid']     = $myrow['submitter'];
		$i++;
	}
}
return $ret;
}
?>
