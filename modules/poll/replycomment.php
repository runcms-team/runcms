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

$pollcomment = new RcxComments($db->prefix("pollcomments"), intval($_REQUEST['comment_id']));

$r_date      = formatTimestamp($pollcomment->getVar("date"));
$r_name      = RcxUser::getUnameFromId($pollcomment->getVar("user_id"));
$r_content   = _PL_POSTERC."".$r_name."&nbsp;"._PL_DATEC."".$r_date."<br /><br />";
$r_content  .= $pollcomment->getVar("comment");
$r_subject   = $pollcomment->getVar("subject");
$subject     = $pollcomment->getVar("subject", "E");
$message     = '[quote]'.$pollcomment->getVar("comment", "E").'[/quote]';

themecenterposts($r_subject, $r_content);

$pid = $_REQUEST['comment_id'];
unset($comment_id);
$item_id = $pollcomment->getVar("item_id");

OpenTable();
include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
CloseTable();

include_once(RCX_ROOT_PATH."/footer.php");
?>
