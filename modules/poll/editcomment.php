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
include_once(RCX_ROOT_PATH."/header.php");

$pollcomment   = new RcxComments($db->prefix("pollcomments"), intval($_GET['comment_id']));
$allow_html    = $pollcomment->getVar("allow_html");
$allow_smileys = $pollcomment->getVar("allow_smileys");
$allow_bbcode  = $pollcomment->getVar("allow_bbcode");
$icon          = $pollcomment->getVar("icon");
$item_id       = $pollcomment->getVar("item_id");
$subject       = $pollcomment->getVar("subject", "E");
$message       = $pollcomment->getVar("comment", "E");

OpenTable();
include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
CloseTable();

include_once(RCX_ROOT_PATH."/footer.php");
?>
