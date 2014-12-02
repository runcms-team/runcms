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
$rcxOption['show_rblock'] = 0;
include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
echo '
<u><h3 align="center">'.$myts->makeTboxData4Show($meta['title']).' '._NW_TOPICS.'</h3></u>
<table align="center" border="0" cellspacing="5" cellpadding="0" width="75%"><tr>';
include_once(RCX_ROOT_PATH."/class/rcxtree.php");
$topic_tree = new RcxTree($db->prefix("topics"),"topic_id","topic_pid");
$sql = "
	SELECT topic_id, topic_title , topic_imgurl
	FROM ".$db->prefix("topics")."
	WHERE topic_pid=0 ORDER BY topic_imgurl = '' ASC, topic_title ASC";
$result = $db->query($sql);
$count  = 0;
while ($myrow = $db->fetch_array($result)) {
	$title = $myts->makeTboxData4Show($myrow['topic_title']);
	echo '
	<td align="center" valign="middle">';
	if ( !empty($myrow['topic_imgurl']) ) {
		echo '<br /><a href="'.RCX_URL.'/modules/news/index.php?storytopic='.$myrow['topic_id'].'"><img src="'.formatURL(RCX_URL.'/modules/news/cache/topics/', $myrow['topic_imgurl']).'" border="0" alt="'.$title.'"></a>';
		}
	echo '<br /><a href="'.RCX_URL.'/modules/news/index.php?storytopic='.$myrow['topic_id'].'"><b>'.$title.'</b></a><br />';

	$arr     = array();
	$arr     = $topic_tree->getFirstChild($myrow['topic_id'], "topic_title");
	$space   = 0;
	$chcount = 0;
	foreach($arr as $ele) {
		$chtitle=$myts->makeTboxData4Show($ele['topic_title']);
		if ( $chcount > 5 ) {
			echo '...';
			break;
		}
		if ( $space > 0 ) {
			echo ', ';
		}
		echo '<a href="'.RCX_URL.'/modules/news/index.php?storytopic='.$ele['topic_id'].'">'.$chtitle.'</a>';
		$space++;
		$chcount++;
	} // END FOREACH
	$count++;
	if ( $count == 4 ) {
		echo '<br /></td></tr><tr>';
		$count = 0;
		} else {
			echo '<br /></td>';
		}
}
echo '</tr></table><br /><br />';
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
