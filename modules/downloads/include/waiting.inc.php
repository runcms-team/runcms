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
function downloads_waiting() {
global $db;
$count   = 0;
$waiting = array();
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_downloads")." WHERE status=0");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/downloads/admin/index.php?op=listNewDownloads';
		$waiting[$count]['text']  = _MB_SYSTEM_WDLS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_broken")."");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/downloads/admin/index.php?op=listBrokenDownloads';
		$waiting[$count]['text']  = _MB_SYSTEM_BFLS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_mod")."");
if ($result) {
	list($num) = $db->fetch_row($result);
	$num = intval($num);
	if ($num > 0) {
		$waiting[$count]['image'] = RCX_URL.'/images/menu/pointer.gif';
		$waiting[$count]['link']  = RCX_URL.'/modules/downloads/admin/index.php?op=listModReq';
		$waiting[$count]['text']  = _MB_SYSTEM_MFLS;
		$waiting[$count]['count'] = $num;
		$count++;
	}
}
return $waiting;
}
?>
