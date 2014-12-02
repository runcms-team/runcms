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
include_once("class/class.permissions.php");

$forum = intval($forum);
$post_id = intval($post_id);

if (!isset($forum))
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
elseif (!isset($post_id))
{
	redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
	exit();
}
else
{
	$editpost = 1;
	$sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id=$forum";
	if (!$result = $db->query($sql))
	{
		redirect_header("index.php", 2, _MD_CANTGETFORUM);
		exit();
	}
	$forumdata = $db->fetch_array($result);
	$permissions = new Permissions($forumdata['forum_id']);
	if ( $permissions->can_view == 0 || $permissions->can_edit == 0 )
	{
		redirect_header("viewtopic.php?topic_id=$topic_id&post_id=$post_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum",2,_MD_NORIGHTTOPOST);
		exit();
	}
}

include_once(RCX_ROOT_PATH."/header.php");
include_once("class/class.forumposts.php");
OpenTable();
$forumpost      = new ForumPosts($post_id);
$allow_html     = intval($forumpost->allow_html());
$allow_smileys  = intval($forumpost->allow_smileys());
$allow_bbcode   = intval($forumpost->allow_bbcode());
$icon           = $forumpost->icon();
$attachsig      = intval($forumpost->attachsig());
$topic_id       = intval($forumpost->topic());
if ($forumpost->is_topic($post_id))
{
	$istopic = 1;
	$notify = $forumpost->notify();
}
else
{
	$istopic = 0;
}
$subject  = $forumpost->subject("Edit");
$message  = $forumpost->text("Edit");
$hidden   = "";
$viewmode = $myts->oopsHtmlSpecialChars($viewmode);
include_once("include/forumform.inc.php");
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
