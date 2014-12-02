<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function nsection_search($queryarray, $andor, $limit, $offset, $userid) {
global $db;

$sql = "
	SELECT
	artid,
	author,
	title,
	byline,
	LEFT(content, 95) AS content,
	date
	FROM ".$db->prefix(_MI_NSECCONT_TABLE)."
	WHERE
	date < ".time()."";

if ( $userid != 0 ) {
	$sql .= " AND author=".$userid." ";
}

// because count() returns 1 even if a supplied variable
// is not an array, we must check if $querryarray is really an array
$count = count($queryarray);
if ( $count > 0 && is_array($queryarray) ) {
	$sql .= " AND ((title LIKE '%$queryarray[0]%' OR byline LIKE '%$queryarray[0]%' OR content LIKE '%$queryarray[0]%')";
	for ($i=1; $i<$count; $i++) {
		$sql .= " $andor ";
		$sql .= "(title LIKE '%$queryarray[$i]%' OR byline LIKE '%$queryarray[$i]%' OR content LIKE '%$queryarray[$i]%')";
	}
	$sql .= ") ";
}

$sql   .= " ORDER BY date DESC";
$result = $db->query($sql, $limit, $offset);

$i = 0;
if ($result) {
	while ($myrow = $db->fetch_array($result)) {
		$ret[$i]['image']   = "images/info.gif";
		$ret[$i]['link']    = "index.php?op=viewarticle&artid=".$myrow['artid']."";
		$ret[$i]['title']   = $myrow['title'];
		$ret[$i]['content'] = $myrow['content'];
		$ret[$i]['time']    = $myrow['date'];
		$ret[$i]['uid']     = $myrow['author'];
		$i++;
	}
}
return $ret;
}
?>
