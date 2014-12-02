<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$results_page = 1;

include_once("header.php");
include_once(RCX_ROOT_PATH."/class/rcxcomments.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/poll.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polloption.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polllog.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/pollrenderer.php");

$item_id = (!empty($_REQUEST['item_id'])) ? intval($_REQUEST['item_id']) : 0;
$poll_id = (!empty($_REQUEST['poll_id'])) ? intval($_REQUEST['poll_id']) : 0;

if ( empty($item_id) && empty($poll_id) ) {
	redirect_header("index.php", 0);
	exit();
}
$mode = $_REQUEST['mode'];
include_once(RCX_ROOT_PATH."/header.php");

// set comment mode if not set
if (!isset($mode) || $mode == "" || ($mode != 0 && $mode != "thread" && $mode != "flat"))
{
	if ($rcxUser)
	{
		$mode = $rcxUser->getVar("umode");
	}
	else
	{
		$mode = $rcxConfig['com_mode'];
	}
}

$comment_id = $_REQUEST['comment_id'];

if (!empty($comment_id))
{
	$pollcomment = new RcxComments($db->prefix("pollcomments"), $comment_id);
}
else
{
	$pollcomment = new RcxComments($db->prefix("pollcomments"));
}

$item_id = (!empty($poll_id)) ? $poll_id : $item_id;
$pollcomment->setVar("item_id", $item_id);
$parentid = $pollcomment->getVar("pid");

if (empty($parentid))
{
	OpenTable();
	$poll     = new RcxPoll($item_id);
	$renderer = new RcxPollRenderer($poll);
	echo $renderer->renderResults();
	CloseTable();
	echo "<br />";
}

//---------------------------------------------------------------------------------------//
// Comments start here
//---------------------------------------------------------------------------------------//
// set comment order if not set
if (!isset($order))
{
	if ($rcxUser)
	{
		$order = $rcxUser->getVar("uorder");
	}
	else
	{
		$order = $rcxConfig['com_order'];
	}
}
$order = intval($order);

$orderby = ($order == 1) ? "date DESC" : "date ASC";
if ($mode == "flat")
{
	$criteria = array("item_id=".$item_id."");
	$commentsArray = $pollcomment->getAllComments($criteria, true, $orderby);
}
elseif ($mode == "thread")
{
	$criteria = array("item_id=".$item_id."", "pid=".$pollcomment->getVar("pid")."");
	$commentsArray = $pollcomment->getAllComments($criteria, true, $orderby);
}
else
{
	$commentsArray = "";
}

OpenTable();
$pollcomment->printNavBar($item_id, $mode, $order);

// Now, show comments
if (is_array($commentsArray) && count($commentsArray))
{
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
	{
		$adminview = 1;
	}
	else
	{
		$adminview = 0;
	}
	if ($mode == "flat")
	{
		$count = 0;
		foreach ($commentsArray as $ele)
		{
			if (!($count % 2))
			{
				$color_num = 1;
			}
			else
			{
				$color_num = 2;
			}
			$ele->showThreadPost($order, $mode, $adminview, $color_num);
			$count++;
		}
	}
	if ($mode == "thread")
	{
		foreach ($commentsArray as $ele)
		{
			$ele->showThreadPost($order, $mode, $adminview);
			//show thread tree
			//if not in the top page, show links to parent and top comment
			if ($ele->getVar("pid") != 0)
			{
				echo "
							<div style='text-align:left'>
								&nbsp;<a href='./pollresults.php?item_id=".$ele->getVar("item_id")."&amp;mode=".$mode."&amp;order=".$order."'>"._TOP."</a>&nbsp;|&nbsp;
								<a href='./pollresults.php?item_id=".$ele->getVar("item_id")."&amp;comment_id=".$ele->getVar("pid")."&amp;mode=".$mode."&amp;order=".$order."#".$ele->getVar("pid")."'>"._PARENT."</a>
							</div>";
			}
			echo "<br />";
			$treeArray = $ele->getCommentTree();
			if (count($treeArray) >0)
			{
				$ele->showTreeHead();
				$count = 0;
				foreach ($treeArray as $treeItem)
				{
					if (!($count % 2))
					{
						$color_num = 1;
					}
					else
					{
						$color_num = 2;
					}
					$treeItem->showTreeItem($order, $mode, $color_num);
					$count++;
				}
				$ele->showTreeFoot();
			}
		}
		echo "<br />";
	}
}

CloseTable();
//---------------------------------------------------------------------------------------//
// Comments stop here
//---------------------------------------------------------------------------------------//

include_once(RCX_ROOT_PATH."/footer.php");
?>