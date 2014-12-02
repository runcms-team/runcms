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
include_once(RCX_ROOT_PATH."/header.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/poll.php");

$poll    = new RcxPoll(intval($_GET['item_id']));
$subject = $poll->getVar("question");
$message = "";
$pid     = 0;

OpenTable();
include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
CloseTable();

include_once(RCX_ROOT_PATH."/footer.php");
?>
