<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("../../mainfile.php");

if ($_GET['bid']) {
	$bid = (int)$_GET['bid'];
	$result = $db->query("SELECT clickurl FROM ".$db->prefix("banner_items")." WHERE bid=$bid");
	list($clickurl) = $db->fetch_row($result);
	if ($clickurl) {
		if ( !isset($_COOKIE['banners'][$bid]) ) {
			cookie("banners[$bid]", $bid, 86400);
			$db->query("UPDATE ".$db->prefix("banner_items")." SET clicks=clicks+1 WHERE bid=$bid");
		}
		echo "
	<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>$clickurl</title>
		<meta http-equiv='Refresh' content='0; URL=".$clickurl."'>
		</head>
		<body></body>
		</html>";
	exit();	
	}
	}
redirect_header(RCX_URL.'/');
exit();
?>
