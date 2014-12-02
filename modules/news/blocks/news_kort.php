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
function b_news_kort_show($options) {
global $db, $myts;
$block            = array();
//$block['content'] = "<small>";
$block['content'] = "";
$extra  ="";
if (!empty($options[5]) && is_numeric($options[5])) {
  $extra = "AND topicid=".$options[5];
}
$sql = "
  SELECT storyid, title, hometext, published, counter
  FROM ".$db->prefix("stories")."
  WHERE published<".time()."
  AND published>0
  $extra
  ORDER BY ".$options[0]." DESC";
if ( empty($options[4]) || !is_numeric($options[4]) ) {
  $options[4] = 200;
  }
if ( empty($options[3]) || !is_numeric($options[3]) ) {
  $options[3] = 5;
  }

if ( empty($options[2]) || !is_numeric($options[2]) ) {
  $options[2] = 19;
  }
$result = $db->query($sql, $options[3], 0);
while ( list($storyid, $title, $hometext, $published, $counter) = $db->fetch_row($result) ) {
  $title = $myts->makeTboxData4Show($title);
  if ( strlen($title) > $options[2] ) {
    $title = substr($title, 0, $options[2])."..";
    } 
	if ( strlen($hometext) > $options[4] ) {
    $hometext = substr($hometext, 0, $options[4])."..";
    }
  $block['content'] .= "  &nbsp;<strong><big>&middot;</big></strong>
<a  href='".RCX_URL."/modules/news/article.php?storyid=".$storyid."'><b>".$title."</b></a>";
  $block['content'] .= "&nbsp;<strong><big>&middot;</big></strong>
 <a href='".RCX_URL."/modules/news/article.php?storyid=".$storyid."'>".$hometext."</a>";
  if ($options[0] == "published") {
    $block['title'] = _MB_NEWS_TITLE6;
    if ($options[1] == 1) {
      $block['content'] .= "<br> (udgivet d.&nbsp; ".formatTimestamp($published, "s").")";
      }
    $block['content'] .= "<hr><br />";

    } elseif ($options[0] == "counter") {
      $block['title'] = _MB_NEWS_TITLE5;
      if ($options[1] == 1) {
        $block['content'] .= " (".$counter.")";
        }
      $block['content'] .= "<br />";
    }
  }
//$block['content'] .= "</small>";
return $block;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_news_kort_edit($options) {
global $db;
$form   = "<input type='hidden' name='options[0]' value='".$options[0]."' />";
$form  .= "<table border='0'>";
// Show Date/Hits?
$form .= "<tr><td>"._MB_NEWS_SHOW." ".$options[0].":</td><td>";
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
// TRIM
$form .= "
<tr><td>"._MB_NEWS_TRIM."</td>
<td><input type='text' class='text' name='options[4]' value='".$options[4]."' size='3' maxlength='3' /></td>
</tr>";
// LIMIT TO CATS
include_once(RCX_ROOT_PATH."/class/rcxtree.php");
$cats = new RcxTree($db->prefix("topics"), "topic_id", "topic_pid");
ob_start();
$cats->makeMySelBox("topic_title", "topic_title", $options[5], 1, "options[5]");
$content = ob_get_contents();
ob_end_clean();
$form .= "
<tr><td>"._MB_NEWS_LIMIT2."</td>
<td>$content</td>
</tr>";
$form .= "</table>";
return $form;
}
?>
