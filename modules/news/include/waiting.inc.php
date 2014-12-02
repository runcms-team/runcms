<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function news_waiting() {
global $db;
$count   = 0;
$waiting = array();

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("stories")." WHERE published=0");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/news/admin/index.php?op=newarticle';
		$waiting[$count]['text']  = _MB_SYSTEM_SUBMS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}
return $waiting;
}
?>
