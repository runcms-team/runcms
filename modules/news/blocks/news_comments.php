<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_news_comments_show($options) {
global $db, $myts;

$block            = array();
$block['title']   = _MB_NEWS_TITLE6;
$block['content'] = "<small>";

if ( empty($options[2]) || !is_numeric($options[2]) ) {
	$options[2] = 19;
}

if ( empty($options[3]) || !is_numeric($options[3]) ) {
	$options[3] = 5;
}

$sql = "
	SELECT item_id, LEFT(subject, ".($options[2]+3)."), LEFT(comment, ".$options[2]."), date
	FROM ".$db->prefix("comments")."
	WHERE date<".time()."
	AND date>0
	ORDER BY date DESC";

$result = $db->query($sql, $options[3], 0);
while ( list($item_id, $subject, $comment, $date) = $db->fetch_row($result) ) {
	$subject = $myts->makeTboxData4Show($subject);
	$subject = str_replace('Re: ', '', $subject);
	$comment = $myts->makeTboxData4Show($comment);

	if ($options[1] == 1) {
		$block['content'] .= "&nbsp;<strong><big>&middot;</big></strong><a href='".RCX_URL."/modules/news/article.php?storyid=".$item_id."'>".$subject."</a><br />";
		$block['content'] .= "&nbsp;&nbsp;".$comment;
		} else {
			$block['content'] .= "&nbsp;<strong><big>&middot;</big></strong><a href='".RCX_URL."/modules/news/article.php?storyid=".$item_id."'>".$comment."</a>";
		}

	if ($options[0] == 1) {
		$block['content'] .= " (".formatTimestamp($date,'s').")";
	}

	$block['content'] .= "<br />";
}
$block['content'] .= "</small>";

return $block;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_news_comments_edit($options) {
global $db;

$form  = "<table border='0'>";

// Show Date?
$form .= "<tr><td>"._MB_NEWS_SHOWD."</td><td>";

$chk   = "";
if ($options[0] == 0) {
	$chk = " checked='checked'";
}
$form .= "<input type='radio' class='radio' name='options[0]' value='0'".$chk." />"._NO."";

$chk   = "";
if ($options[0] == 1) {
	$chk = " checked='checked'";
}
$form .= "<input type='radio' class='radio' name='options[0]' value='1'".$chk." />"._YES."</td></tr>";


// Show Subject?
$form .= "<tr><td>"._MB_NEWS_SHOWS."</td><td>";

$chk   = "";
if ($options[1] == 0) {
	$chk = " checked='checked'";
}
$form .= "<input type='radio' class='radio' name='options[1]' value='0'".$chk." />"._NO."";

$chk   = "";
if ($options[1] == 1) {
	$chk = " checked='checked'";
}
$form .= "<input type='radio' class='radio' name='options[1]' value='1'".$chk." />"._YES."</td></tr>";


// TRIM
$form .= "
<tr><td>"._MB_NEWS_TRIM."</td>
<td><input type='text' class='text' size='3' maxlength='2' name='options[2]' value='".$options[2]."'></td>
</tr>";


// LIMIT TO
$form .= "
<tr><td>"._MB_NEWS_LIMIT."</td>
<td><input type='text' class='text' name='options[3]' value='".$options[3]."' size='3' maxlength='2' /></td>
</tr>";

$form .= "</table>";

return $form;
}
?>
