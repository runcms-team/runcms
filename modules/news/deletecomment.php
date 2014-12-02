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
include_once("class/class.newsstory.php");

if ($rcxUser) {
	if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
		include_once(RCX_ROOT_PATH."/header.php");
		echo "<h4>"._NW_DELNOTALLOWED."</h4>";
		echo "<br />";
		echo "<a href='javascript:history.go(-1)'>"._GOBACK."</a>";
		include_once(RCX_ROOT_PATH."/footer.php");
		exit();
	}
	} else {
		include_once(RCX_ROOT_PATH."/header.php");
		echo "<h4>"._NW_DELNOTALLOWED."</h4>";
		echo "<br />";
		echo "<a href='javascript:history.go(-1)'>"._GOBACK."</a>";
		include_once(RCX_ROOT_PATH."/footer.php");
		exit();
	}

if ( !empty($_GET['ok']) ) {
	if ( !empty($_GET['comment_id']) ) {
		$artcomment = new RcxComments($db->prefix("comments"),$_GET['comment_id']);
		$deleted = $artcomment->delete();
		$item_id = $artcomment->getVar("item_id");
	}
	redirect_header("article.php?storyid=$item_id&order=".$_GET['order']."&mode=".$_GET['mode']."",2,_PL_COMMENTSDEL);
	exit();
	} else {
		include_once(RCX_ROOT_PATH."/header.php");
		OpenTable();
		echo "<h4 style='color:#ff0000;'>"._NW_AREUSUREDEL."</font></h4>";
		echo "<table><tr><td>";
		echo myTextForm("./deletecomment.php?comment_id=".$_GET['comment_id']."&mode=".$_GET['mode']."&order=".$_GET['order']."&ok=1", _YES);
		echo "</td><td>";
		echo myTextForm("javascript:history.go(-1)", _NO);
		echo "</td></tr></table>";
		CloseTable();
	}

include_once(RCX_ROOT_PATH."/footer.php");
?>
