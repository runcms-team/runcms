<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("admin_header.php");
include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
include_once(RCX_ROOT_PATH."/class/rcxcomments.php");
include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/poll.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polloption.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/polllog.php");
include_once(RCX_ROOT_PATH."/modules/poll/class/pollrenderer.php");

$op = "list";
if (!empty($_REQUEST['op']))
{
  $op = $_REQUEST['op'];
}
if (isset($_POST))
{
  foreach ($_POST as $k => $v)
  {
    $$k = $v;
  }
}

if ($op == 'PollConfig')
{
  PollConfig();
}
if ($op == 'PollConfigS')
{
  PollConfigS();
}

if ( $op == "list" ) {
  $limit = (!empty($_GET['limit'])) ? $_GET['limit'] : 30;
  $start = (!empty($_GET['start'])) ? $_GET['start'] : 0;
  $polls_arr =& RcxPoll::getAll(array(), true, "weight ASC, end_time DESC", $limit+1, $start);
     rcx_cp_header();
  OpenTable();
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
<tr><td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _AM_POLLSLIST;?></div><br /><br />
<div class="kpicon"><table id="table1"><tr><td>		
<a href="index.php?op=PollConfig"><img src="<?php echo RCX_URL;?>/images/system/captcha.png" alt="<?php echo _MI_POLLS_ADMENU0;?>"/>	
<br /><?php echo _MI_POLLS_ADMENU0;?></a>
<a href="index.php"><img src="<?php echo RCX_URL;?>/images/system/finduser.png" alt="<?php echo _MI_POLLS_ADMENU1;?>">
<br /><?php echo _MI_POLLS_ADMENU1;?></a>
<a href="index.php?op=add"><img src="<?php echo RCX_URL;?>/images/system/nyebruger.png" alt="<?php echo _MI_POLLS_ADMENU2;?>"/>
<br /><?php echo _MI_POLLS_ADMENU2;?></a>
</td></tr></table></div>
<?php
  $polls_count = count($polls_arr);
  if ( is_array($polls_arr) && $polls_count > 0) {
    echo "<form action='index.php' method='post'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='bg3'><td>"._AM_DISPLAYBLOCK."</td><td>"._AM_DISPLAYORDER."</td><td>"._AM_POLLQUESTION."</td><td>"._AM_VOTERS."</td><td>"._AM_VOTES."</td><td>"._AM_EXPIRATION."</td><td>&nbsp;</td></tr>";
    $max = ( $polls_count > $limit ) ? $limit : $polls_count;
    for ( $i = 0; $i < $max; $i++ ) {
      $checked = "";
      if ( 1 == $polls_arr[$i]->getVar("display") ) {
        $checked = " checked='checked'";
      }
      if ( $polls_arr[$i]->getVar("end_time") > time() ) {
        $end = formatTimestamp($polls_arr[$i]->getVar("end_time"),"m");
      } else {
        $end = "<span style='color:#ff0000;'>"._AM_EXPIRED."</span><br /><a href='index.php?op=restart&amp;poll_id=".$polls_arr[$i]->getVar("poll_id")."'>"._AM_RESTART."</a>";
      }
      echo "<tr class='bg1'><td align='center'><input type='hidden' name='poll_id[$i]' value='".$polls_arr[$i]->getVar("poll_id")."' /><input type='hidden' name='old_display[$i]' value='".$polls_arr[$i]->getVar("display")."' /><input type='checkbox' class='checkbox' name='display[$i]' value='1'".$checked." /></td><td><input type='hidden' name='old_weight[$i]' value='".$polls_arr[$i]->getVar("weight")."' /><input type='text' class='text' name='weight[$i]' value='".$polls_arr[$i]->getVar("weight")."' size='6' maxlength='5' /></td><td>".$polls_arr[$i]->getVar("question")."</td><td align='center'>".$polls_arr[$i]->getVar("voters")."</td><td align='center'>".$polls_arr[$i]->getVar("votes")."</td><td>".$end."</td><td align='right'><a href='index.php?op=edit&amp;poll_id=".$polls_arr[$i]->getVar("poll_id")."'>"._EDIT."</a><br /><a href='index.php?op=delete&amp;poll_id=".$polls_arr[$i]->getVar("poll_id")."'>"._DELETE."</a><br /><a href='index.php?op=log&amp;poll_id=".$polls_arr[$i]->getVar("poll_id")."'>"._AM_VIEWLOG."</a></td></tr>";
    }
    echo "<tr align='center' class='bg3'><td colspan='7'><input type='submit' class='button' value='"._SUBMIT."' /><input type='hidden' name='op' value='quickupdate' /></td></tr></table></td></tr></table></form>";
    echo "<table width='100%'><tr><td align='left'>";
    if ( $start > 0 ) {
      $prev_start = ($start - $limit > 0) ? $start - $limit : 0;
      echo "<a href='index.php?start=".$prev_start."&amp;limit=".$limit."'>"._PREV."</a>";
    } else {
      echo "&nbsp;";
    }
    echo "</td><td align='right'>";
    if ( $polls_count > $limit ) {
      echo "<a href='index.php?start=".($start+$limit)."&amp;limit=".$limit."'>"._NEXT."</a>";
    }
    echo "</td></tr></table>";
  }
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ( $op == "add" ) {
  $poll_form = new RcxThemeForm(_AM_CREATNEWPOLL, "poll_form", "index.php");
  $question_text = new RcxFormText(_AM_POLLQUESTION, "question", 50, 255);
  $poll_form->addElement($question_text);
  $desc_tarea = new RcxFormTextarea(_AM_POLLDESC, "description");
  $poll_form->addElement($desc_tarea);
  $currenttime = formatTimestamp(time(), "Y-m-d H:i:s");
  $endtime = formatTimestamp(time()+604800, "Y-m-d H:i:s");
  $expire_text = new RcxFormText(_AM_EXPIRATION."<br /><small>"._AM_FORMAT."<br />".sprintf(_AM_CURRENTTIME, $currenttime)."</small>", "end_time", 30, 19, $endtime);
  $poll_form->addElement($expire_text);
  $disp_yn = new RcxFormRadioYN(_AM_DISPLAYBLOCK, "display", 1);
  $poll_form->addElement($disp_yn);
  $weight_text = new RcxFormText(_AM_DISPLAYORDER, "weight", 6, 5, 0);
  $poll_form->addElement($weight_text);
  $multi_yn = new RcxFormRadioYN(_AM_ALLOWMULTI, "multiple", 0);
  $poll_form->addElement($multi_yn);
  $notify_yn = new RcxFormRadioYN(_AM_NOTIFY, "notify", 1);
  $poll_form->addElement($notify_yn);
  $option_tray = new RcxFormElementTray(_AM_POLLOPTIONS, "");
  $barcolor_array = RcxLists::getImgListAsArray(RCX_ROOT_PATH."/modules/poll/images/colorbars/");
  for($i = 0; $i < 10; $i++){
    $current_bar = (current($barcolor_array) != "blank.gif") ? current($barcolor_array) : next($barcolor_array);
    $option_text = new RcxFormText("", "option_text[]", 50, 255);
    $option_tray->addElement($option_text);
    $color_select = new RcxFormSelect("", "option_color[".$i."]", $current_bar);
    $color_select->addOptionArray($barcolor_array);
    $color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/poll/images/colorbars\")'");
    $color_label = new RcxFormLabel("", "<img src='".RCX_URL."/modules/poll/images/colorbars/".$current_bar."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
    $option_tray->addElement($color_select);
    $option_tray->addElement($color_label);
    if ( !next($barcolor_array) ) {
      reset($barcolor_array);
    }
  }
  $poll_form->addElement($option_tray);
  $submit_button = new RcxFormButton("", "poll_submit", _SUBMIT, "submit");
  $poll_form->addElement($submit_button);
  $op_hidden = new RcxFormHidden("op", "save");
  $poll_form->addElement($op_hidden);
  rcx_cp_header();
  OpenTable();
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
  <tr>
    <td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _AM_CREATNEWPOLL;?></div><br /><br />
<div class="kpicon"><table id="table1"><tr><td>
<a href="index.php?op=PollConfig"><img src="<?php echo RCX_URL;?>/images/system/captcha.png" alt="<?php echo _MI_POLLS_ADMENU0;?>"/>	
<br /><?php echo _MI_POLLS_ADMENU0;?></a>
<a href="index.php"><img src="<?php echo RCX_URL;?>/images/system/finduser.png" alt="<?php echo _MI_POLLS_ADMENU1;?>">
<br /><?php echo _MI_POLLS_ADMENU1;?></a>
<a href="index.php?op=add"><img src="<?php echo RCX_URL;?>/images/system/nyebruger.png" alt="<?php echo _MI_POLLS_ADMENU2;?>"/>
<br /><?php echo _MI_POLLS_ADMENU2;?></a>
</td></tr></table></div>
<?php
  $poll_form->display();
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ( $op == "save" ) {
  $poll = new RcxPoll();
  $poll->setVar("question", $question);
  $poll->setVar("description", $description);
  if ( !empty($end_time) ) {
    $poll->setVar("end_time", userTimeToServerTime(strtotime($end_time), $rcxUser->timezone()));
  } else {
    // if expiration date is not set, set it to 10 days from now
    $poll->setVar("end_time", time() + (86400 * 10));
  }
  $poll->setVar("display", $display);
  $poll->setVar("weight", $weight);
  $poll->setVar("multiple", $multiple);
  if ( $notify == 1 ) {
    // if notify, set mail status to "not mailed"
    $poll->setVar("mail_status", POLL_NOTMAILED);
  } else {
    // if not notify, set mail status to already "mailed"
    $poll->setVar("mail_status", POLL_MAILED);
  }
  $poll->setVar("user_id", $rcxUser->getVar("uid"));
  $new_poll_id = $poll->store();
  if ( !empty($new_poll_id) ) {
    $i = 0;
    foreach ( $option_text as $optxt ) {
      $optxt = trim($optxt);
      if ( $optxt != "" ) {
        $option = new RcxPollOption();
        $option->setVar("option_text", $optxt);
        $option->setVar("option_color", $option_color[$i]);
        $option->setVar("poll_id", $new_poll_id);
        $option->store();
      }
      $i++;
    }
  } else {
    echo $poll->getErrors();
    exit();
  }
  redirect_header("index.php", 1, _UPDATED);
  exit();
}

if ( $op == "edit" ) {
  $poll = new RcxPoll($_GET['poll_id']);
  $poll_form = new RcxThemeForm("", "poll_form", "index.php");
  $author_label = new RcxFormLabel(_AM_AUTHOR, "<a href='".RCX_URL."/userinfo.php?uid=".$poll->getVar("user_id")."'>".RcxUser::getUnameFromId($poll->getVar("user_id"))."</a>");
  $poll_form->addElement($author_label);
  $question_text = new RcxFormText(_AM_POLLQUESTION, "question", 50, 255, $poll->getVar("question", "E"));
  $poll_form->addElement($question_text);
  $desc_tarea = new RcxFormTextarea(_AM_POLLDESC, "description", $poll->getVar("description", "E"));
  $poll_form->addElement($desc_tarea);
  $date = formatTimestamp($poll->getVar("end_time"), "Y-m-d H:i:s");

  if ( !$poll->hasExpired() ) {
    $expire_text = new RcxFormText(_AM_EXPIRATION."<br /><small>"._AM_FORMAT."<br />".sprintf(_AM_CURRENTTIME, formatTimestamp(time(), "Y-m-d H:i:s"))."</small>", "end_time", 20, 19, $date);
    $poll_form->addElement($expire_text);
    } else {
      $restart_label = new RcxFormLabel(_AM_EXPIRATION, sprintf(_AM_EXPIREDAT, $date)."<br /><a href='index.php?op=restart&amp;poll_id=".$poll->getVar("poll_id")."'>"._AM_RESTART."</a>");
      $poll_form->addElement($restart_label);
    }

  $disp_yn = new RcxFormRadioYN(_AM_DISPLAYBLOCK, "display", $poll->getVar("display"));
  $poll_form->addElement($disp_yn);
  $weight_text = new RcxFormText(_AM_DISPLAYORDER, "weight", 6, 5, $poll->getVar("weight"));
  $poll_form->addElement($weight_text);
  $multi_yn = new RcxFormRadioYN(_AM_ALLOWMULTI, "multiple", $poll->getVar("multiple"));
  $poll_form->addElement($multi_yn);
  $options_arr =& RcxPollOption::getAllByPollId($poll->getVar("poll_id"));
  $notify_value = 1;

  if ( $poll->getVar("mail_status") != 0 ) {
    $notify_value = 0;
  }

  $notify_yn = new RcxFormRadioYN(_AM_NOTIFY, "notify", $notify_value);
  $poll_form->addElement($notify_yn);
  $option_tray = new RcxFormElementTray(_AM_POLLOPTIONS, "");
  $barcolor_array =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/modules/poll/images/colorbars/");

  $i = 0;
  foreach($options_arr as $option){
    $option_text = new RcxFormText("", "option_text[]", 50, 255, $option->getVar("option_text"));
    $option_tray->addElement($option_text);
    $option_id_hidden = new RcxFormHidden("option_id[]", $option->getVar("option_id"));
    $option_tray->addElement($option_id_hidden);
    $color_select = new RcxFormSelect("", "option_color[".$i."]", $option->getVar("option_color"));
    $color_select->addOptionArray($barcolor_array);
    $color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/poll/images/colorbars\")'");
    $color_label = new RcxFormLabel("", "<img src='".RCX_URL."/modules/poll/images/colorbars/".$option->getVar("option_color", "E")."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
    $option_tray->addElement($color_select);
    $option_tray->addElement($color_label);
    $i++;
  }

  $more_label = new RcxFormLabel("", "<br /><a href='index.php?op=addmore&amp;poll_id=".$poll->getVar("poll_id")."'>"._AM_ADDMORE."</a>");
  $option_tray->addElement($more_label);
  $poll_form->addElement($option_tray);
  $op_hidden = new RcxFormHidden("op", "update");
  $poll_form->addElement($op_hidden);
  $poll_id_hidden = new RcxFormHidden("poll_id", $poll->getVar("poll_id"));
  $poll_form->addElement($poll_id_hidden);
  $submit_button = new RcxFormButton("", "poll_submit", _SUBMIT, "submit");
  $poll_form->addElement($submit_button);
  rcx_cp_header();
  echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITPOLL.'</div>
            <br />
            <br />';
  OpenTable();
  $poll_form->display();
  CloseTable();
  echo "                        
        </td>
    </tr>
</table>";

  rcx_cp_footer();
  exit();
}

if ( $op == "update" ) {
  $poll = new RcxPoll($poll_id);
  $poll->setVar("question", $question);
  $poll->setVar("description", $description);

  if ( !empty($end_time) ) {
    $end_time = userTimeToServerTime(strtotime($end_time), $rcxUser->timezone());
    $poll->setVar("end_time", $end_time);
  }

  $poll->setVar("display", $display);
  $poll->setVar("weight", $weight);
  $poll->setVar("multiple", $multiple);

  if ( $notify == 1 && $end_time > time() ) {
    // if notify, set mail status to "not mailed"
    $poll->setVar("mail_status", POLL_NOTMAILED);
    } else {
      // if not notify, set mail status to already "mailed"
      $poll->setVar("mail_status", POLL_MAILED);
    }

  if ( !$poll->store() ) {
    echo $poll->getErrors();
    exit();
  }

  $i = 0;
  foreach ( $option_id as $opid ) {
    $option = new RcxPollOption($opid);
    $option_text[$i] = trim ($option_text[$i]);
    if ( $option_text[$i] != "" ) {
      $option->setVar("option_text", $option_text[$i]);
      $option->setVar("option_color", $option_color[$i]);
      $option->store();
    } else {
      if ( $option->delete() != false ) {
        RcxPollLog::deleteByOptionId($option->getVar("option_id"));
      }
    }
    $i++;
  }
  $poll->updateCount();
  redirect_header("index.php",1,_UPDATED);
  exit();
}

if ( $op == "addmore" ) {
  $poll = new RcxPoll($_GET['poll_id']);
  $poll_form = new RcxThemeForm("", "poll_form", "index.php");
  $question_label = new RcxFormLabel(_AM_POLLQUESTION, $poll->getVar("question"));
  $poll_form->addElement($question_label);
  $option_tray = new RcxFormElementTray(_AM_POLLOPTIONS, "");
  $barcolor_array =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/modules/poll/images/colorbars/");

  for($i = 0; $i < 10; $i++){
    $current_bar = (current($barcolor_array) != "blank.gif") ? current($barcolor_array) : next($barcolor_array);
    $option_text = new RcxFormText("", "option_text[]", 50, 255);
    $option_tray->addElement($option_text);
    $color_select = new RcxFormSelect("", "option_color[".$i."]", $current_bar);
    $color_select->addOptionArray($barcolor_array);
    $color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/poll/images/colorbars\")'");
    $color_label = new RcxFormLabel("", "<img src='".RCX_URL."/modules/poll/images/colorbars/".$current_bar."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
    $option_tray->addElement($color_select);
    $option_tray->addElement($color_label);
    if ( !next($barcolor_array) ) {
      reset($barcolor_array);
    }
  }

  $poll_form->addElement($option_tray);
  $submit_button = new RcxFormButton("", "poll_submit", _SUBMIT, "submit");
  $poll_form->addElement($submit_button);
  $op_hidden = new RcxFormHidden("op", "savemore");
  $poll_form->addElement($op_hidden);
  $poll_id_hidden = new RcxFormHidden("poll_id", $poll->getVar("poll_id"));
  $poll_form->addElement($poll_id_hidden);
  rcx_cp_header();
  echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_ADDMORE.'</div>
            <br />
            <br />';
  OpenTable();
  $poll_form->display();
  CloseTable();
  echo "                        
        </td>
    </tr>
</table>";
  rcx_cp_footer();
  exit();
}

if ( $op == "savemore" ) {
  $poll = new RcxPoll($poll_id);

  $i = 0;
  foreach ( $option_text as $optxt ) {
    $optxt = trim($optxt);
    if ( $optxt != "" ) {
      $option = new RcxPollOption();
      $option->setVar("option_text", $optxt);
      $option->setVar("poll_id", $poll->getVar("poll_id"));
      $option->setVar("option_color", $option_color[$i]);
      $option->store();
    }
    $i++;
  }

  redirect_header("index.php", 1, _UPDATED);
  exit();
}

if ( $op == "delete" ) {
  rcx_cp_header();
  $poll = new RcxPoll($_GET['poll_id']);
  OpenTable();
  echo "<h4 style='text-align:left;'>".sprintf(_AM_RUSUREDEL, $poll->getVar("question"))."</h4>\n";
  echo "<table><tr><td>";
  echo myTextForm("index.php?op=delete_ok&poll_id=".$poll->getVar("poll_id")."", _YES);
  echo "</td><td>";
  echo myTextForm("index.php?op=list", _NO);
  echo "</td></tr></table>";
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ( $op == "delete_ok" ) {
  $poll = new RcxPoll($_GET['poll_id']);
  if ( $poll->delete() != false ) {
    RcxPollOption::deleteByPollId($poll->getVar("poll_id"));
    RcxPollLog::deleteByPollId($poll->getVar("poll_id"));
    // delete comments for this poll
    $com = new RcxComments($db->prefix("pollcomments"));
    $criteria = array("item_id=".$poll->getVar("poll_id")."", "pid=0");
    $commentsarray = $com->getAllComments($criteria);
    foreach($commentsarray as $comment) {
      $comment->delete();
    }
  }
  redirect_header("index.php", 1, _UPDATED);
  exit();
}

if ( $op == "restart" ) {
  $poll = new RcxPoll($_GET['poll_id']);
  $poll_form = new RcxThemeForm(_AM_RESTARTPOLL, "poll_form", "index.php");
  $expire_text = new RcxFormText(_AM_EXPIRATION."<br /><small>"._AM_FORMAT."<br />".sprintf(_AM_CURRENTTIME, formatTimestamp(time(), "Y-m-d H:i:s"))."</small>", "end_time", 20, 19);
  $poll_form->addElement($expire_text);
  $notify_yn = new RcxFormRadioYN(_AM_NOTIFY, "notify", 1);
  $poll_form->addElement($notify_yn);
  $reset_yn = new RcxFormRadioYN(_AM_RESET, "reset", 0);
  $poll_form->addElement($reset_yn);
  $op_hidden = new RcxFormHidden("op", "restart_ok");
  $poll_form->addElement($op_hidden);
  $poll_id_hidden = new RcxFormHidden("poll_id", $poll->getVar("poll_id"));
  $poll_form->addElement($poll_id_hidden);
  $submit_button = new RcxFormButton("", "poll_submit", _AM_RESTART, "submit");
  $poll_form->addElement($submit_button);
  rcx_cp_header();
  OpenTable();
  $poll_form->display();
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ( $op == "restart_ok" ) {
  $poll = new RcxPoll($poll_id);
  if ( !empty($end_time) ) {
    $end_time = userTimeToServerTime(strtotime($end_time), $rcxUser->timezone());
    $poll->setVar("end_time", $end_time);
    // echo $end_time;
    } else {
      $poll->setVar("end_time", time() + (86400 * 10));
    }

  if ( $notify == 1 && $end_time > time() ) {
    // if notify, set mail status to "not mailed"
    $poll->setVar("mail_status", POLL_NOTMAILED);
    } else {
      // if not notify, set mail status to already "mailed"
      $poll->setVar("mail_status", POLL_MAILED);
    }

  if ( $reset == 1 ) {
    // reset all logs
    RcxPollLog::deleteByPollId($poll->getVar("poll_id"));
    RcxPollOption::resetCountByPollId($poll->getVar("poll_id"));
  }

  if (!$poll->store()) {
    echo $poll->getErrors();
    exit();
  }

  $poll->updateCount();
  redirect_header("index.php", 1, _UPDATED);
  exit();
}

if ( $op == "log" ) {

  $limit = (!empty($_GET['limit'])) ? $_GET['limit'] : 30;
  $start = (!empty($_GET['start'])) ? $_GET['start'] : 0;
  
  $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : "time";
  $orderdir = (!empty($_GET['orderdir'])) ? $_GET['orderdir'] : "ASC";

  $poll = new RcxPoll($poll_id);

  rcx_cp_header();
  echo "<h4 style='text-align:left;'>"._AM_LOGSLIST."</h4>";

  // show brief descriptions of the question we are focusing
  echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
  echo "<tr><td class='bg2'>";
  echo "<table width='100%' border='0' cellpadding='4' cellspacing='1'>";
  echo "<tr class='bg3'>";
  echo "<td nowrap>"._AM_POLLQUESTION."</td><td nowrap>"._AM_POLLDESC."</td>";
  echo "<td nowrap>"._AM_VOTERS."</td><td nowrap>"._AM_VOTES."</td>";
  echo "<td nowrap>"._AM_EXPIRATION."</td>";
  echo "</tr>";
  echo "<tr class='bg1'>";
  echo "<td>".$poll->getVar('question')."</td><td>".$poll->getVar('description')."</td>";
  echo "<td align='center'>".$poll->getVar('voters')."</td><td align='center'>".$poll->getVar('votes')."</td>";
  echo "<td>".formatTimestamp($poll->getVar('end_time'), "l")."</td>";
  echo "</tr>";
  echo "</table>";
  echo "</td></tr>";
  echo "</table>";
  echo "<br>";

  // show logs
  $logs_arr =& RcxPollLog::getAllByPollId($poll_id, $orderby." ".$orderdir);
  $logs_count = count($logs_arr);
  $arrow_up = RCX_URL."/modules/poll/images/up.gif";
  $arrow_down = RCX_URL."/modules/poll/images/down.gif";
  $sorthref = "index.php?op=log&amp;poll_id=".$poll_id."&amp;orderby=";
  if ( is_array($logs_arr) && $logs_count > 0) {
    echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
    echo "<tr><td class='bg2'>";
    echo "<table width='100%' border='0' cellpadding='4' cellspacing='1'>";
    echo "<tr align='center' class='bg3'>";
    echo "<td nowrap>";
    echo "<a href='".$sorthref."log_id&amp;orderdir=ASC'><img src=".$arrow_up." alt='"._AM_ASC."'></a>";
    echo "&nbsp;"._AM_LOGID."&nbsp;<a href='".$sorthref."log_id&amp;orderdir=DESC'><img src=".$arrow_down." alt='"._AM_DESC."'></a></td>";
    echo "<td nowrap>";
    echo "<a href='".$sorthref."option_id&amp;orderdir=ASC'><img src=".$arrow_up." alt='"._AM_ASC."'></a>";
    echo "&nbsp;"._AM_OPTIONID."&nbsp;<a href='".$sorthref."option_id&amp;orderdir=DESC'><img src=".$arrow_down." alt='"._AM_DESC."'></a></td>";
    echo "<td nowrap>";
    echo "<a href='".$sorthref."ip&amp;orderdir=ASC'><img src=".$arrow_up." alt='"._AM_ASC."'></a>";
    echo "&nbsp;"._AM_IP."&nbsp;<a href='".$sorthref."ip&amp;orderdir=DESC'><img src=".$arrow_down." alt='"._AM_DESC."'></a></td>";
    echo "<td nowrap>";
    echo "<a href='".$sorthref."user_id&amp;orderdir=ASC'><img src=".$arrow_up." alt='"._AM_ASC."'></a>";
    echo "&nbsp;"._AM_VOTER."&nbsp;<a href='".$sorthref."user_id&amp;orderdir=DESC'><img src=".$arrow_down." alt='"._AM_DESC."'></a></td>";
    echo "<td nowrap>";
    echo "<a href='".$sorthref."time&amp;orderdir=ASC'><img src=".$arrow_up." alt='"._AM_ASC."'></a>";
    echo "&nbsp;"._AM_VOTETIME."&nbsp;<a href='".$sorthref."time&amp;orderdir=DESC'><img src=".$arrow_down." alt='"._AM_DESC."'></a></td>";
    echo "</tr>";

    $max = ( $logs_count > $limit ) ? $limit : $logs_count;
    for ( $i = 0; $i < $max; $i++ ) {
      $option = new RcxPollOption($logs_arr[$i]->getVar("option_id"));
      echo "<tr class='bg1'>";
      echo "<td align='center'>".$logs_arr[$i]->getVar("log_id")."</td>";
      echo "<td>".$option->getVar('option_text')."</td>";
        
      $remote_ip = $logs_arr[$i]->getVar("ip");
      
      echo "<td align='center'>".$remote_ip."</td>";

      if ($logs_arr[$i]->getVar("user_id") != 0) {
        $user = new RcxUser($logs_arr[$i]->getVar("user_id"));
        $uname = $user->getVar('uname');
        echo "<td align='center'><a href=".RCX_URL."/userinfo.php?uid=".$user->getVar("uid").">".$uname."</a></td>";
      } else {
        $uname = $rcxConfig['anonymous'];
        echo "<td align='center'>".$uname."</td>";
      }
      echo "<td>".formatTimeStamp($logs_arr[$i]->getVar("time"), "l")."</td>";
      echo "</tr>";
    }
    echo "</table></td></tr></table>";

    echo "<table width='100%'><tr><td align='left'>";
    if ( $start > 0 ) {
      $prev_start = ($start - $limit > 0) ? $start - $limit : 0;
      echo "<a href='index.php?op=log&amp;poll_id=".$poll_id."&amp;start=".$prev_start."&amp;limit=".$limit."'>"._PL_PREV."</a>";
    } else {
      echo "&nbsp;";
    }
    echo "</td><td align='right'>";
    if ( $logs_count > $limit ) {
      echo "<a href='index.php?op=log&amp;poll_id=".$poll_id."&amp;start=".($start+$limit)."&amp;limit=".$limit."'>"._PL_NEXT."</a>";
    }
    echo "</td></tr></table>";
  }

  // Link to polls list
  echo "<table width='100%'><tr><td align='center'><a href='index.php?op=list'>"._AM_RETURNLIST."</a></td></tr></table>";

  rcx_cp_footer();
  exit();
}


if ( $op == "quickupdate" ) {
  $count = count($poll_id);
  for ( $i = 0; $i < $count; $i++ ) {
    $display[$i] = empty($display[$i]) ? 0 : 1;
    $weight[$i] = empty($weight[$i]) ? 0 : $weight[$i];
    if ( $display[$i] != $old_display[$i] || $weight[$i] != $old_weight[$i] ) {
      $poll = new RcxPoll($poll_id[$i]);
      $poll->setVar("display", $display[$i]);
      $poll->setVar("weight", intval($weight[$i]));
      $poll->store();
    }
  }
  redirect_header("index.php", 1, _UPDATED);
  exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function PollConfig()
{
  global $rcxOption;

  rcx_cp_header();
  OpenTable();
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
<tr><td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _AM_POLLCONF;?></div><br /><br />
<div class="kpicon"><table id="table1"><tr><td>
<a href="index.php?op=PollConfig"><img src="<?php echo RCX_URL;?>/images/system/captcha.png" alt="<?php echo _MI_POLLS_ADMENU0;?>"/>	
<br /><?php echo _MI_POLLS_ADMENU0;?></a>
<a href="index.php"><img src="<?php echo RCX_URL;?>/images/system/finduser.png" alt="<?php echo _MI_POLLS_ADMENU1;?>">
<br /><?php echo _MI_POLLS_ADMENU1;?></a>
<a href="index.php?op=add"><img src="<?php echo RCX_URL;?>/images/system/nyebruger.png" alt="<?php echo _MI_POLLS_ADMENU2;?>"/>
<br /><?php echo _MI_POLLS_ADMENU2;?></a>
</td></tr></table></div>
<br />
  <form action="index.php" method="post">
    <table width="100%" border="0">
    <tr>
      <td nowrap><?php echo _ALLOWCAP;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    $chk = ($rcxOption['use_captcha'] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>



        <input type="radio" class="radio" name="use_captcha" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="use_captcha" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
    </tr>
    <tr>
      <td colspan=2><hr /></td>
    </tr>
    </tr>
  </table>
  <input type="hidden" name="op" value="PollConfigS" />
  <input type="submit" class="button" value="<?php echo _SAVE;?>" />
  <input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
  </form>
  <?php

  CloseTable();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function PollConfigS()
{
//  global $_REQUEST;
  $content .= "<?php\n";
  $content .= "\$rcxOption['use_captcha'] = ".intval($_REQUEST['use_captcha']).";\n";
  $content .= "?>";

  $filename = "../cache/config.php";
  if ($file = fopen($filename, "w"))
  {
    fwrite($file, $content);
    fclose($file);
  }
  else
  {
    redirect_header("index.php?op=PollConfig", 1, _NOTUPDATED);
    exit();
  }

  redirect_header("index.php?op=PollConfig", 1, _UPDATED);
  exit();
}

?>