<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_rcxpoll_show() {
global $_COOKIE, $rcxUser;

	include_once(RCX_ROOT_PATH."/modules/poll/class/poll.php");
	include_once(RCX_ROOT_PATH."/modules/poll/class/polllog.php");
	include_once(RCX_ROOT_PATH."/modules/poll/class/polloption.php");
	include_once(RCX_ROOT_PATH."/modules/poll/class/pollrenderer.php");

	$block            = array();
	$block['title']   = _MB_POLLS_TITLE1;
	$block['content'] = '';

	$polls =& RcxPoll::getAll(array("display=1"), true, "weight ASC, end_time DESC");

	foreach ($polls as $poll) {
		$renderer = new RcxPollRenderer($poll);
		$expired  = intval($poll->getVar('end_time') < time());
		$already  = isset($_COOKIE["voted_polls"][$poll->getVar("poll_id")]);

		if ( $expired || $already) {
			$block['content'] .= $renderer->renderResults();
			} else {
				$uid = $rcxUser ? $rcxUser->getVar("uid") : 0;
				if ( RcxPollLog::hasVoted($poll->getVar("poll_id"), _REMOTE_ADDR, $uid) ) {
					$block['content'] .= $renderer->renderResults();
					} else {
						$block['content'] .= $renderer->renderForm();
					}
			}
	}

return $block;
}
?>
