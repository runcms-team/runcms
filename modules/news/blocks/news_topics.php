<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_news_topics_show() {
global $db, $storytopic;
include_once(RCX_ROOT_PATH."/class/rcxtopic.php");
$block = array();
$block['title']   = _MB_NEWS_TITLE3;
$block['content'] = "<div align='center'><form name='newstopicform' action='".RCX_URL."/modules/news/index.php' method='get'>\n";
$xt         = new RcxTopic($db->prefix("topics"));
$jump       = RCX_URL."/modules/news/index.php?storytopic=";
$storytopic = !empty($storytopic) ? intval($storytopic) : 0;
ob_start();
$xt->makeTopicSelBox(1, $storytopic, "storytopic", "location.href='".$jump."'+this.options[this.selectedIndex].value");
$content = ob_get_contents();
ob_end_clean();
$block['content'] .= $content."</form></div>";
return $block;
}
?>
