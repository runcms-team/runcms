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

$forum = intval($forum);
$topic_id = intval($topic_id);
$post_id = intval($post_id);

if (!isset($forum)) {
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
	} elseif (!isset($topic_id)) {
		redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORTOPIC);
		exit();
		} elseif (!isset($post_id)) {
			redirect_header("viewtopic.php?topic_id=$topic_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum", 2, _MD_ERRORPOST);
			exit();
			} else {
				if (is_locked($topic_id)) {
					redirect_header("viewtopic.php?topic_id=$topic_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum", 2, _MD_TOPICLOCKED);
					exit();
				}

			$sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id = $forum";
			if (!$result = $db->query($sql)) {
				redirect_header("index.php", 2, _MD_CANTGETFORUM);
				exit();
			}

	$forumdata = $db->fetch_array($result);
	$permissions = new Permissions($forumdata['forum_id']);
	if ( $permissions->can_view == 0 || $permissions->can_reply == 0)
	{
		redirect_header("viewtopic.php?topic_id=$topic_id&post_id=$post_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum",2,_MD_NORIGHTTOPOST);
		exit();
	}

	include_once(RCX_ROOT_PATH."/header.php");
	OpenTable();
	include_once("class/class.forumposts.php");
	$forumpost  = new ForumPosts($post_id);
	$myts->setType($forumpost->type);
	$r_message  = $forumpost->text();
	$r_date     = formatTimestamp($forumpost->posttime());
	$r_name     = RcxUser::getUnameFromId($forumpost->uid());
	$r_content  = _MD_BY." ".$r_name." "._MD_ON." ".$r_date."<br /><br />";
	$r_content .= $r_message;
	$r_subject  = $forumpost->subject();
	$subject    = $forumpost->subject("Edit");
	$q_message  = $forumpost->text("Quotes");
	$hidden     = "[quote]\n";
	$hidden    .= sprintf(_MD_USERWROTE, $r_name);
	$hidden    .= "\n".$q_message."[/quote]";
	$message    = "";
	themecenterposts($r_subject, $r_content);
	echo "<br />";
	$pid = $post_id;
	unset($post_id);
	$topic_id = $forumpost->topic();
	$forum    = $forumpost->forum();
	$viewmode = $myts->oopsHtmlSpecialChars($viewmode);
	$isreply  = 1;
	include_once("include/forumform.inc.php");
	CloseTable();
	include_once(RCX_ROOT_PATH."/footer.php");
}
?>
