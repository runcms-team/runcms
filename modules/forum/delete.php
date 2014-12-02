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

if ( empty($forum) ){
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
	} elseif ( empty($post_id) ) {
		redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
		exit();
	}

if ( $rcxUser )
{
	if ( !$rcxUser->isAdmin($rcxModule->mid()) )
	{
		if ( !is_moderator($forum, $rcxUser->uid()) )
		{
			$permissions = new Permissions($forum);
			if ($permissions->can_delete == 0)
			{
				redirect_header("viewtopic.php?topic_id=$topic_id&order=$order&viewmode=$viewmode&pid=$pid&forum=$forum", 2, _MD_DELNOTALLOWED);
				exit();
			}
		}
	}
}
else
{
	redirect_header("viewtopic.php?topic_id=$topic_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum", 2, _MD_DELNOTALLOWED);
	exit();
}

include_once("class/class.forumposts.php");

if ( !empty($ok) ) {
	if ( !empty($post_id) ) {
		$post = new ForumPosts($post_id);
		$post->delete();
		sync($post->forum(), "forum");
		sync($post->topic(), "topic");
	}
	if ( $post->istopic() ) {
		redirect_header("viewforum.php?forum=$forum", 2, _MD_POSTSDELETED);
		exit();
	} else {
		redirect_header("viewtopic.php?topic_id=$topic_id&order=$order&viewmode=$viewmode&pid=$pid&amp;forum=$forum", 2, _MD_POSTSDELETED);
		exit();
	}
	} else {
		include_once(RCX_ROOT_PATH."/header.php");
		OpenTable();
		echo "<h4 style='color:#ff0000;'>"._MD_AREUSUREDEL."</font></h4>";
		echo "<table><tr><td>";
		echo myTextForm("./delete.php?post_id=".$post_id."&viewmode=".$viewmode."&order=".$order."&amp;forum=".$forum."&topic_id=".$topic_id."&ok=1", _YES);
		echo "</td><td>";
		echo myTextForm("javascript:history.go(-1)", _NO);
		echo "</td></tr></table>";
		CloseTable();
	}

include_once(RCX_ROOT_PATH."/footer.php");
?>
