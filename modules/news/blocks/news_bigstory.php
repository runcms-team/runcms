<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_news_bigstory_show() {
global $db, $myts;
$block  = array();
$tdate  = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
$result = $db->query("SELECT storyid, title FROM ".$db->prefix("stories")." WHERE (published > ".$tdate." AND published < ".time().") ORDER BY counter DESC", 1, 0);
list($sid, $title) = $db->fetch_row($result);
$block['title'] = _MB_NEWS_TITLE1;
if ( !$sid && !$title ) {
	$block['content'] = _MB_NEWS_NOTYET;
	} else {
		$block['content'] = _MB_NEWS_TMRSI."<br /><br />";
		$block['content'] .= "<a href='".RCX_URL."/modules/news/article.php?storyid=$sid'>".$myts->makeTboxData4Show($title)."</a>";
	}
return $block;
}
?>
