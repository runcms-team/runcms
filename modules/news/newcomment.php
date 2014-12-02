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
include_once("class/class.newsstory.php");
include_once(RCX_ROOT_PATH."/header.php");

$article   = new NewsStory($_GET['item_id']);
$hometext  = $article->hometext();
$bodytext  = $article->bodytext();
$date      = formatTimestamp($article->published());
$r_subject = $article->title();
$subject   = $article->title("Edit");
$message   = "";
$r_text    = _NW_POSTERC." ".$article->uname()." "._NW_DATEC." ".$date;
$r_text   .= "<br /><br />".$hometext."";

if ( $bodytext != "" ) {
	$r_text .= "<br /><br />".$bodytext."";
}

themecenterposts($r_subject, $r_text);
$pid = 0;

OpenTable();
include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
CloseTable();

include_once(RCX_ROOT_PATH."/footer.php");
?>
