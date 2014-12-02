<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

class RcxPollRenderer {

  var $poll;

  function RcxPollRenderer(&$poll) {
    $this->poll =& $poll;
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function renderForm($width='100%') {

$content  = "<form action='".RCX_URL."/modules/poll/index.php' method='post'>";
$content .= "<table border='0' cellpadding='0' cellspacing='0' width='".$width."'><tr><td class='bg2'>";
$content .= "<table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";
$content .= "<tr class='bg3'><td align='center' colspan='2'><input type='hidden' name='poll_id' value='".$this->poll->getVar("poll_id")."' />";
$content .= "<b>".$this->poll->getVar("question")."</b></td></tr>";

$options_arr =& RcxPollOption::getAllByPollId($this->poll->getVar("poll_id"));
$option_type = "radio";
$option_name = "option_id";

if ( $this->poll->getVar("multiple") == 1 ) {
  $option_type = "checkbox";
  $option_name .= "[]";
}

foreach ( $options_arr as $option ) {
  $content .= "<tr class='bg1'><td align='center'><input type='$option_type' class='$option_type' name='$option_name' value='".$option->getVar("option_id")."' /></td><td align='left'>".$option->getVar("option_text"). "</td></tr>\n";
}

$content .= "<tr class='bg3'><td align='center' colspan='2'><input type='submit' class='button' value='"._PL_VOTE."' />&nbsp;";
$content .= "<input type='button' class='button' value='"._PL_RESULTS."' onclick='location=\"".RCX_URL."/modules/poll/pollresults.php?poll_id=".$this->poll->getVar("poll_id")."\"' />";

$count    = RcxPoll::comment_count($this->poll->getVar("poll_id"));
$content .= "<br />[ ".$count." <a href='".RCX_URL."/modules/poll/pollresults.php?poll_id=".$this->poll->getVar("poll_id")."'>"._PL_COMMENT."</a> ]";


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
global $results_page;

if ( !$this->poll->hasExpired() ) {
  $end_text = sprintf(_PL_ENDSAT, formatTimestamp($this->poll->getVar("end_time"), "m"));
  } else {
    $end_text = sprintf(_PL_ENDEDAT, formatTimestamp($this->poll->getVar("end_time"), "m"));
  }

$content = "
<table width='100%' align='center' border='0' cellpadding='0' cellspacing='1' class='bg2'><tr><td>
<table width='100%' align='center' border='0' cellpadding='2' cellspacing='0' class='bg1'><tr>
<td class='bg3'><b>".$this->poll->getVar("question")."</b></td>
</tr><tr>
<td align='right'>".$end_text."<br /><br /></td>
</tr>";

$options_arr =& RcxPollOption::getAllByPollId($this->poll->getVar("poll_id"));

foreach ( $options_arr as $option ) {
  $total = $this->poll->getVar("votes");
  if ($total > 0) {
    $percent = (($option->getVar("option_count") / $total) * 100);
    } else {
      $percent = 0;
    }
  $content .= "<tr><td><b>&raquo;</b> ".$option->getVar("option_text")."<br />";
  if ( $percent > 0 ) {
    $width    = intval($percent);
    $content .= "<img src='".RCX_URL."/modules/poll/images/colorbars/".$option->getVar("option_color", "E")."' height='14' width='".$width."%' align='middle' alt='".intval($percent)." %' /><br />";
  }
$content .= sprintf(" %.2f %% (%d)", $percent, $option->getVar("option_count"));
$content .= "<br /><br /></td></tr>";
}

$content .= "<tr><td>".sprintf(_PL_TOTALVOTES , $this->poll->getVar("votes"))."<br />".sprintf(_PL_TOTALVOTERS, $this->poll->getVar("voters"))."</td></tr>";

if ($results_page != 1) {
  $count = RcxPoll::comment_count($this->poll->getVar("poll_id"));
  $content .= "<tr><td align='center'>[ ".$count." <a href='".RCX_URL."/modules/poll/pollresults.php?poll_id=".$this->poll->getVar("poll_id")."'>"._PL_COMMENT."</a> ]</td></tr>";
}

$content .= "</table></td></tr></table><br />";

return $content;
}
}
?>
