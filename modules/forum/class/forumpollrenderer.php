<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined('RCX_ROOT_PATH')) {
  exit();
}
include_once($bbPath['path']."language/".$rcxConfig['language']."/main.php");

class ForumPollRenderer {

  var $poll;

  function ForumPollRenderer(&$poll) {
    $this->poll =& $poll;
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function renderForm($width='100%') {
    global $topic_id,$forum, $bbPath, $rcxUser, $bbImage;

$edit_link = '';
if ($rcxUser && ($rcxUser->isAdmin() || is_moderator($forum, $rcxUser->getVar('uid')) ) )
{
  $edit_link = '<a href="./edit_poll.php?poll_id='.$this->poll->getVar('poll_id').'&amp;forum='.$forum.'"><img src="'.$bbImage['edit'].'" alt="#" /></a>';
}

$content = "<form action='".$bbPath['url']."votepolls.php?topic_id=$topic_id&amp;forum=$forum' method='post'>";
$content .= "<table border='0' cellpadding='0' cellspacing='0' width='".$width."'><tr><td class='bg2'>";
$content .= "<table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";
$content .= "<tr class='bg3'><td align='left' colspan=2><input type='hidden' name='poll_id' value='".$this->poll->getVar("poll_id")."' />";
$content .= "<table width='100%'><tr><td><b>"._PL_POLL."&nbsp;&nbsp;".$this->poll->getVar("question")."</b></td><td class='bg3' align='right'>$edit_link</td></tr></table></td></tr>";

$options_arr =& ForumPollOption::getAllByPollId($this->poll->getVar("poll_id"));
$option_type = "radio";
$option_name = "option_id";

if ( $this->poll->getVar("multiple") == 1 ) {
  $option_type = "checkbox";
  $option_name .= "[]";
}

foreach ( $options_arr as $option ) {
  $content .= "<tr class='bg1'><td align='center' width='50%'><input type='$option_type' class='$option_type' name='$option_name' value='".$option->getVar("option_id")."' /></td><td align='left'>".$option->getVar("option_text"). "</td></tr>\n";
}

$content .= "<tr class='bg3'><td align='center' colspan='2'><input type='submit' class='button' value='"._PL_VOTE."' />&nbsp;";
$content .= "<input type='button' value='"._PL_RESULTS."' class='button' onclick='location=\"".$bbPath['url']."viewtopic.php?topic_id=$topic_id&amp;forum=$forum&poll_id=".$this->poll->getVar("poll_id")."\"' />";

$content .= "</td></tr></table></td></tr></table></form>";

return $content;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function renderResults() {
global $results_page,$topic_id,$forum, $rcxUser, $bbImage;

$edit_link = '';
if ($rcxUser && ($rcxUser->isAdmin() || is_moderator($forum, $rcxUser->getVar('uid')) ) )
{
  $edit_link = '<a href="./edit_poll.php?poll_id='.$this->poll->getVar('poll_id').'&amp;forum='.$forum.'"><img src="'.$bbImage['edit'].'" alt="#" /></a>';
}

if ( !$this->poll->hasExpired() ) {
  $end_text = sprintf(_PL_ENDSAT, formatTimestamp($this->poll->getVar("end_time"), "m"));
  } else {
    $end_text = sprintf(_PL_ENDEDAT, formatTimestamp($this->poll->getVar("end_time"), "m"));
  }

$content .= "
<table width='100%' align='center' valign='top' border='0' cellpadding='0' cellspacing='1' class='bg2'><tr><td>
<table width='100%' align='center' valign='top' border='0' cellpadding='2' cellspacing='0' class='bg1'><tr>
<td class='bg3' align='left' width='100%'><b>"._PL_POLL." ".$this->poll->getVar("question")."</b></td><td class='bg3'>$edit_link</td>
</tr><tr>
<td align='right' colspan=2>".$end_text."</td>
</tr>";

$options_arr =& ForumPollOption::getAllByPollId($this->poll->getVar("poll_id"));

foreach ( $options_arr as $option ) {
  $total = $this->poll->getVar("votes");
  if ($total > 0) {
    $percent = (($option->getVar("option_count") / $total) * 100);
    } else {
      $percent = 0;
    }
  $content .= "<tr><td colspan=2><b>&raquo;</b> ".$option->getVar("option_text")."<br />";
  if ( $percent > 0 ) {
    $width    = intval($percent);
    $content .= "<img src='".$bbPath['url']."images/colorbars/".$option->getVar("option_color", "E")."' height='14' width='".$width."%' align='middle' alt='".intval($percent)." %' /><br />";
  }
$content .= sprintf(" %.2f %% (%d)", $percent, $option->getVar("option_count"));
$content .= "<br /></li></td></tr>";
}

$content .= "<tr><td>".sprintf(_PL_TOTALVOTES , $this->poll->getVar("votes"))."<br />".sprintf(_PL_TOTALVOTERS, $this->poll->getVar("voters"))."</td></tr>";

$content .= "</table></td></tr></table><br />";
return $content;
}
}
?>
