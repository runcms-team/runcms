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
function b_downloads_top_show($options) {
global $db, $myts, $rcxUser;
if ( $rcxUser ) {
  $groups = $rcxUser->groups();
} else {
  $groups = RcxGroup::getByType("Anonymous");
}
$block  = array();
$extra  ="";
if (!empty($options[4]) && is_numeric($options[4])) {
  $extra = "AND cid=".$options[4];
}
$sql    = "
    SELECT lid, title, date, hits
    FROM ".$db->prefix("downloads_downloads")."
    WHERE status>0 AND (";
$first = true;
foreach ( $groups as $group ) {
  if (!$first) {
    $sql.= " or ";
  }
  if ( $first == true ) { $first = false; }
  $sql.= "groups like '%$group%'";
}
$sql.= ") ";
$sql.= $extra." ORDER BY ".$options[0]." DESC";
if ( empty($options[3]) || !is_numeric($options[3]) ) {
  $options[3] = 5;
}
if ( empty($options[2]) || !is_numeric($options[2]) ) {
  $options[2] = 19;
}
$block['content'] = "";
$result = $db->query($sql, $options[3], 0);
$countdwls = 0;
while ( list($lid, $title, $date, $hits) = $db->fetch_row($result) ) {
  $title = $myts->makeTboxData4Show($title);
  if ( strlen($title) > $options[2] ) {
    $title = substr($title, 0, $options[2])."..";
  }
  $block['content'] .= "
      &nbsp;<strong><big>&middot;</big></strong>
      <a href='".RCX_URL."/modules/downloads/singlefile.php?lid=".$lid."'>$title</a>";
  $countdwls++;
  if ($options[0] == "date") {
    if ($options[1] == 1) {
      $block['content'] .= " (".formatTimestamp($date, "s").")";
      }
    $block['content'] .= "<br />";
    } elseif ($options[0] == "hits") {
      if ($options[1] == 1) {
        $block['content'] .= " (".$hits.")";
        }
      $block['content'] .= "<br />";
    }
  }
if ( $options[0] == "date" ) {
  $block['title'] = _MB_DOWNLOADS_TITLE1;
} elseif ( $options[0] = "hits" ) {
  $block['title'] = _MB_DOWNLOADS_TITLE2;
}
if ( $countdwls == 0 ) {
  $block['content'] = _MB_DOWNLOADS_NODOWNLOADS;
}
return $block;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_downloads_top_edit($options) {
global $db;
$form   = "<input type='hidden' name='options[0]' value='".$options[0]."' />";
$form  .= "<table border='0'>";
// Show Date/Hits?
$form .= "<tr><td>"._MB_DOWNLOADS_SHOW." ".$options[0].":</td><td>";
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
<tr><td>"._MB_DOWNLOADS_TRIM."</td>
<td><input type='text' class='text' size='3' maxlength='2' name='options[2]' value='".$options[2]."'></td>
</tr>";
// LIMIT TO
$form .= "
<tr><td>"._MB_DOWNLOADS_LIMIT."</td>
<td><input type='text' class='text' name='options[3]' value='".$options[3]."' size='3' maxlength='2' /></td>
</tr>";
// LIMIT TO CATS
include_once(RCX_ROOT_PATH."/class/rcxtree.php");
$cats = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
@ob_start();
$cats->makeMySelBox("title", "title", $options[4], 1, "options[4]");
$content = @ob_get_contents();
@ob_end_clean();
$form .= "
<tr><td>"._MB_DOWNLOADS_LIMIT."</td>
<td>$content</td>
</tr>";
$form .= "</table>";
return $form;
}
?>