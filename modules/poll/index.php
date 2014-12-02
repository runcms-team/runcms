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
include_once(RCX_ROOT_PATH."/modules/poll/class/poll.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polloption.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polllog.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/pollrenderer.php");

if ( !empty($_POST['poll_id']) ) {
  $poll_id = intval($_POST['poll_id']);
  } elseif (!empty($_GET['poll_id'])) {
    $poll_id = intval($_GET['poll_id']);
  }

if ( empty($poll_id) ) {
  if ($rcxConfig['startpage'] == "poll") {
    $rcxOption['show_rblock'] =1;
    include_once(RCX_ROOT_PATH."/header.php");
    make_cblock();
    echo "<br />";
    } else {
      $rcxOption['show_rblock'] =0;
      include_once(RCX_ROOT_PATH."/header.php");
    }

  $limit = (!empty($_GET['limit'])) ? intval($_GET['limit']) : 50;
  $start = (!empty($_GET['start'])) ? intval($_GET['start']) : 0;
  OpenTable();
  echo "<h4>"._PL_POLLSLIST."</h4>";
  // add 1 to $limit to know whether there are more polls
  $polls_arr =& RcxPoll::getAll(array(), true, "weight ASC, end_time DESC", $limit+1, $start);
  $polls_count = count($polls_arr);
  $max = ( $polls_count > $limit ) ? $limit : $polls_count;
  echo "
  <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
  <table width='100%' border='0' cellpadding='4' cellspacing='1'>
  <tr class='bg3'><td><b>"._PL_POLLQUESTION."</b></td><td align='center'><b>"._PL_VOTERS."</b></td><td align='center'><b>"._PL_VOTES."</b></td><td align='center'><b>"._PL_EXPIRATION."</b></td><td>&nbsp;</td></tr>";
  for ($i=0; $i<$max; $i++) {
    if ( $polls_arr[$i]->getVar("end_time") > time() ) {
      $end = formatTimestamp($polls_arr[$i]->getVar("end_time"),"m");
      } else {
        $end = "<span style='color:#ff0000;'>"._PL_EXPIRED."</span>";
      }
    echo "<tr class='bg1'><td><a href='index.php?poll_id=".$polls_arr[$i]->getVar("poll_id")."'>".$polls_arr[$i]->getVar("question")."</a></td><td align='center'>".$polls_arr[$i]->getVar("voters")."</td><td align='center'>".$polls_arr[$i]->getVar("votes")."</td><td align='center'>".$end."</td><td align='right'><a href='pollresults.php?poll_id=".$polls_arr[$i]->getVar("poll_id")."'>"._PL_RESULTS."</a></td></tr>";
  }
  echo "
  </table></td></tr></table>
  <table width='100%'><tr><td align='left'>";

  if ( $start > 0 ) {
    $prev_start = ($start - $limit > 0) ? $start - $limit : 0;
    echo "<a href='index.php?start=".$prev_start."&amp;limit=".$limit."'>"._PREV."</a>";
  }

  echo "</td><td align='right'>";

  if ( $polls_count > $limit ) {
    echo "<a href='index.php?start=".($start+$limit)."&amp;limit=".$limit."'>"._NEXT."</a>";
  }

  echo "</td></tr></table>";
  CloseTable();
  include_once(RCX_ROOT_PATH."/footer.php");

} elseif ( !empty($_POST['option_id']) ) {
  $voted_polls = (!empty($_COOKIE['voted_polls'])) ? $_COOKIE['voted_polls'] : array();
  $mail_author = false;
  $poll = new RcxPoll($poll_id);
  if ( !$poll->hasExpired() ) {
    if ( empty($voted_polls[$poll_id]) ) {
      if ( $rcxUser ) {
        if ( RcxPollLog::hasVoted($poll_id, _REMOTE_ADDR, $rcxUser->getVar("uid")) ) {
          cookie("voted_polls[$poll_id]", 1, 31536000);
          $msg = _PL_ALREADYVOTED;
          } else {
            $poll->vote($_POST['option_id'], _REMOTE_ADDR, $rcxUser->getVar("uid"));
            $poll->updateCount();
            cookie("voted_polls[$poll_id]", 1, 31536000);
            $msg = _PL_THANKSFORVOTE;
          }
        } else {
          if ( RcxPollLog::hasVoted($poll_id, _REMOTE_ADDR) ) {
            cookie("voted_polls[$poll_id]", 1, 31536000);
            $msg = _PL_ALREADYVOTED;
            } else {
              $poll->vote($_POST['option_id'], _REMOTE_ADDR);
              $poll->updateCount();
              cookie("voted_polls[$poll_id]", 1, 31536000);
              $msg = _PL_THANKSFORVOTE;
            }
        }
      } else {
        $msg = _PL_ALREADYVOTED;
      }
    } else {
      $msg = _PL_SORRYEXPIRED;
      if ( $poll->getVar("mail_status") != POLL_MAILED ) {
        $rcxMailer =& getMailer();
        $rcxMailer->useMail();
        $rcxMailer->setTemplateDir(RCX_ROOT_PATH."/modules/poll/");
        $rcxMailer->setTemplate("mail_results.tpl");
        $author = new RcxUser($poll->getVar("user_id"));
        $rcxMailer->setToUsers($poll->getVar("uid"));
        $rcxMailer->assign("POLL_QUESTION", $poll->getVar("question"));
        $rcxMailer->assign("POLL_START", formatTimestamp($poll->getVar("start_time"), "l", $author->timezone()));
        $rcxMailer->assign("POLL_END", formatTimestamp($poll->getVar("end_time"), "l", $author->timezone()));
        $rcxMailer->assign("POLL_VOTES", $poll->getVar("votes"));
        $rcxMailer->assign("POLL_VOTERS", $poll->getVar("voters"));
        $rcxMailer->assign("POLL_ID", $poll->getVar("poll_id"));
        $rcxMailer->assign("SITENAME", $meta['title']);
        $rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
        $rcxMailer->assign("SITEURL", $rcxConfig['rcx_url']."/");
        $rcxMailer->setFromEmail($rcxConfig['adminmail']);
        $rcxMailer->setFromName($meta['title']);
        $rcxMailer->setSubject(sprintf(_PL_YOURPOLLAT, $author->uname(), $meta['title']));
        if ( $rcxMailer->send() != false ) {
          $poll->setVar("mail_status", POLL_MAILED);
          $poll->store();
        }
      }
    }
  redirect_header(RCX_URL."/modules/poll/pollresults.php?poll_id=$poll_id", 1, $msg);
  exit();

  } elseif ( !empty($poll_id) ) {
    include_once(RCX_ROOT_PATH."/header.php");
    OpenTable();
    echo "<div align='center'>";
    $poll     = new RcxPoll($poll_id);
    $renderer = new RcxPollRenderer($poll);
    echo $renderer->renderForm('160');
    echo "</div>";
    CloseTable();
    include_once(RCX_ROOT_PATH."/footer.php");
  }
?>
