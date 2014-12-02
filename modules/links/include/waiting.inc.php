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
function links_waiting() {
global $db;

$count   = 0;
$waiting = array();

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE status=0");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/links/admin/index.php?op=listNewLinks';
		$waiting[$count]['text']  = _MB_SYSTEM_WLNKS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_broken")."");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/links/admin/index.php?op=listBrokenLinks';
		$waiting[$count]['text']  = _MB_SYSTEM_BLNK;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_mod")."");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/links/admin/index.php?op=listModReq';
		$waiting[$count]['text']  = _MB_SYSTEM_MLNKS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}

return $waiting;
}
?>
