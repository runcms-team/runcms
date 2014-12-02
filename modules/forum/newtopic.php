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
include_once('class/class.permissions.php');

$forum = intval($forum);

if ( empty($forum) ) {
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
} else {
	$sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id = $forum";
	if(!$result = $db->query($sql)) {
		redirect_header("index.php", 2, _MD_CANTGETFORUM);
		exit();
	}
	$forumdata = $db->fetch_array($result);
	
	$permissions = new Permissions($forumdata['forum_id']);
	if ( $permissions->can_view == 0 || $permissions->can_post == 0)
	{
		redirect_header("viewforum.php?order=$order&viewmode=$viewmode&amp;forum=$forum",2,_MD_NORIGHTTOPOST);
		exit();
	}

	include_once(RCX_ROOT_PATH."/header.php");
	OpenTable();
	$istopic  = 1;
	$pid      = 0;
	$subject  = "";
	$message  = "";
	$viewmode = $myts->oopsHtmlSpecialChars($viewmode);
	$hidden   = "";
	unset($post_id);
	unset($topic_id);
	include_once("include/forumform.inc.php");
	CloseTable();
	include_once(RCX_ROOT_PATH."/footer.php");
}
?>
