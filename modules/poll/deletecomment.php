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
include_once(RCX_ROOT_PATH."/class/rcxcomments.php");

if ( !$rcxUser ) {
	include_once(RCX_ROOT_PATH."/header.php");
	echo "<h4>"._PL_DELNOTALLOWED."</h4><br />";
	echo "<a href=\"javascript:history.go(-1)\">"._GOBACK."</a>";
	include_once(RCX_ROOT_PATH."/footer.php");
	exit();
	} else {
		if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
			include_once(RCX_ROOT_PATH."/header.php");
			echo "<h4>"._PL_DELNOTALLOWED."</h4><br />";
			echo "<a href=\"javascript:history.go(-1)\">"._GOBACK."</a>";
			include_once(RCX_ROOT_PATH."/footer.php");
			exit();
		}
	}

if ( $_GET['ok'] == 1 ) {
	if ( !empty($_GET['comment_id']) ) {
		$pollcomment = new RcxComments($db->prefix("pollcomments"), intval($_GET['comment_id']));
		$deleted = $pollcomment->delete();
		$item_id = $pollcomment->getVar("item_id");
	}
	redirect_header("pollresults.php?poll_id=".intval($item_id)."&amp;order=".intval($_GET['order']), 2, _PL_COMMENTSDEL);
	exit();
	} else {
		include_once(RCX_ROOT_PATH."/header.php");
		OpenTable();
		echo "<div align='center'><h4 style='color:#ff0000;'>"._PL_AREYOUSURE."</h4><table><tr><td>";
		echo myTextForm("deletecomment.php?comment_id=".intval($_GET['comment_id'])."&amp;order=".intval($_GET['order'])."&amp;ok=1", _YES);
		echo "</td><td>";
		echo myTextForm("javascript:history.go(-1)", _NO);
		echo "</td></tr></table></div>";
		CloseTable();
	}

include_once(RCX_ROOT_PATH."/footer.php");
?>
