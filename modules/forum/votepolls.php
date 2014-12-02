<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include("header.php");

include_once($bbPath['path']."class/forumpoll.php");
include_once($bbPath['path']."class/forumpolloption.php");
include_once($bbPath['path']."class/forumpolllog.php");
include_once($bbPath['path']."class/forumpollrenderer.php");

if ( !empty($_POST['poll_id']) ) {
	$poll_id = intval($_POST['poll_id']);
} elseif (!empty($_GET['poll_id'])) {
	$poll_id = intval($_GET['poll_id']);
}

if ( !empty($_POST['option_id']) ) {
	$mail_author = false;
	$poll = new ForumPoll($poll_id);
	
		if ( $rcxUser ) {
			if ( ForumPollLog::hasVoted($poll_id, $REMOTE_ADDR, $rcxUser->getVar("uid")) ) {
				$msg = _PL_ALREADYVOTED;
				cookie("bb_polls[$poll_id]", 1);
			} else {
				$poll->vote($_POST['option_id'], '', $rcxUser->getVar("uid"));
				$poll->updateCount();
				$msg = _PL_THANKSFORVOTE;
				cookie("bb_polls[$poll_id]", 1);
			}
		} else {
			if ( ForumPollLog::hasVoted($poll_id, $REMOTE_ADDR) ) {
				$msg = _PL_ALREADYVOTED;
				cookie("bb_polls[$poll_id]", 1);
			} else {
				$poll->vote($_POST['option_id'], $REMOTE_ADDR);
				$poll->updateCount();
				$msg = _PL_THANKSFORVOTE;
				cookie("bb_polls[$poll_id]", 1);
			}
		}

	redirect_header($bbPath['url']."viewtopic.php?topic_id=$topic_id&amp;forum=$forum&poll_id=$poll_id", 1, $msg);
	exit();
}
redirect_header($bbPath['url']."viewtopic.php?topic_id=$topic_id&amp;forum=$forum", 1, "You must choose an option !!");
?>
