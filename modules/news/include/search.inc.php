<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function news_search($queryarray, $andor, $limit, $offset, $userid) {
global $db;
$sql = "
	SELECT
	storyid,
	uid,
	title,
	created,
	LEFT(hometext, 95) AS content
	FROM ".$db->prefix("stories")."
	WHERE
	published > 0
	AND
	published < ".time()."";
if ( $userid != 0 ) {
	$sql .= " AND uid=".$userid." ";
}
// fordi count() returnere 1 selv om vi har givet en variable
// som ikke er et array, mp vi checke om $querryarray virkelig er et array
$count = count($queryarray);
if ( $count > 0 && is_array($queryarray) ) {
	$sql .= " AND ((hometext LIKE '%$queryarray[0]%' OR bodytext LIKE '%$queryarray[0]%' OR title LIKE '%$queryarray[0]%')";
	for ($i=1; $i<$count; $i++) {
		$sql .= " $andor ";
		$sql .= "(hometext LIKE '%$queryarray[$i]%' OR bodytext LIKE '%$queryarray[$i]%' OR title LIKE '%$queryarray[$i]%')";
	}
	$sql .= ") ";
}
$sql   .= " ORDER BY created DESC";
$result = $db->query($sql, $limit, $offset);
$i = 0;
if ($result) {
	while ($myrow = $db->fetch_array($result)) {
		$ret[$i]['image']   = "images/content.gif";
		$ret[$i]['link']    = "article.php?storyid=".$myrow['storyid']."";
		$ret[$i]['title']   = $myrow['title'];
		$ret[$i]['content'] = $myrow['content'];
		$ret[$i]['time']    = $myrow['created'];
		$ret[$i]['uid']     = $myrow['uid'];
		$i++;
	}
}
return $ret;
}
?>
