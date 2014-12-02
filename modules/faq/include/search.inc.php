<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function faq_search($queryarray, $andor, $limit, $offset, $userid){
global $db;

$ret = array();

if ( $userid != 0 ) {
	return $ret;
}

$sql = "
	SELECT
	contents_id,
	category_id,
	contents_title,
	LEFT(contents_contents, 95) AS content,
	contents_time
	FROM ".$db->prefix("faq_contents")."
	WHERE
	contents_visible = 1";

// because count() returns 1 even if a supplied variable
// is not an array, we must check if $querryarray is really an array
$count = count($queryarray);
if ( $count > 0 && is_array($queryarray) ) {
	$sql .= " AND ((contents_title LIKE '%$queryarray[0]%' OR contents_contents LIKE '%$queryarray[0]%')";
	for ( $i = 1; $i < $count; $i++ ) {
		$sql .= " $andor ";
		$sql .= "(contents_title LIKE '%$queryarray[$i]%' OR contents_contents LIKE '%$queryarray[$i]%')";
	}
	$sql .= ") ";
}

$sql   .= " ORDER BY contents_id DESC";
$result = $db->query($sql, $limit, $offset);

$i = 0;
if ($result) {
	while ( $myrow = @$db->fetch_array($result) ) {
		$ret[$i]['image']   = "images/question2.gif";
		$ret[$i]['link']    = "index.php?cat_id=".$myrow['category_id']."#".$myrow['contents_id'];
		$ret[$i]['title']   = $myrow['contents_title'];
		$ret[$i]['content'] = $myrow['content'];
		$ret[$i]['time']    = $myrow['contents_time'];
		$i++;
	}
}
return $ret;
}
?>
