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
function b_whosonline_show($options) {
global $db, $myts, $rcxUser, $rcxConfig;

$days = $options[1];
b_whosonline_update($days);

$block = array();
$block['title'] = _MB_WHOSONLINE_TITLE1;

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("lastseen")." WHERE uid=0 AND online=1");
list($guest_online_num) = $db->fetch_row($result);

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("lastseen")." WHERE uid>0 AND online=1");
list($member_online_num) = $db->fetch_row($result);

// Added for registered members //
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("users"));
list($member_reg_num) = $db->fetch_row($result);

// .gif could be added //
$who_online_num = ($guest_online_num + $member_online_num);
$block['content']  = "<img src='".RCX_URL."/modules/whosonline/images/pointer.gif' border='0' alt='#' />&nbsp;";
$block['content'] .= sprintf(_MB_WHOSONLINE_GUESTS, $guest_online_num);
$block['content'] .= "<br /><img src='".RCX_URL."/modules/whosonline/images/pointer.gif' border='0' alt='#' />&nbsp;";
$block['content'] .= sprintf(_MB_WHOSONLINE_MEMBERS, $member_online_num);

// Added for registered members //
$block['content'] .= "<br /><img src='".RCX_URL."/modules/whosonline/images/pointer.gif' border='0' alt='#' />&nbsp;";
$block['content'] .= sprintf(_MB_WHOSONLINE_REGISTERED, $member_reg_num);

if ($member_online_num > 3) {
  $block['content'] .= "<br /><br />";
  $result = $db->query("SELECT uid, username FROM ".$db->prefix("lastseen")." WHERE uid > 0 AND online=1",3,0);

  while (list($memuid, $memusername) = $db->fetch_row($result)) {
    $block['content'] .= "<a href=\"".RCX_URL."/userinfo.php?uid=$memuid\">".$myts->makeTboxData4Show($memusername)."</a>, ";
  }
  $block['content'] .= "<a href=\"javascript:openWithSelfMain('".RCX_URL."/modules/whosonline/popup/online.php?t=".time()."','Online',220,350);\">"._MB_WHOSONLINE_MORE."</a>";

  } elseif ($member_online_num != 0) {
    $block['content'] .= "<br /><br />";
    $first = 0;
    $result = $db->query("SELECT uid, username FROM ".$db->prefix("lastseen")." WHERE uid>0 AND online=1");

    while (list($memuid, $memusername) = $db->fetch_row($result)) {
      if ($first!=0) {
        $block['content'] .= ", ";
      }
      $block['content'] .= "<a href=\"".RCX_URL."/userinfo.php?uid=$memuid\">".$myts->makeTboxData4Show($memusername)."</a>";
      $first= 1;
    }
  }

if ($rcxUser) {
  if ( ($member_online_num <= 3) && $rcxUser->isAdmin() ) {
    $block['content'] .= ", <a href=\"javascript:openWithSelfMain('".RCX_URL."/modules/whosonline/popup/online.php?t=".time()."','Online',220,350);\">"._MB_WHOSONLINE_MORE."</a>";
    }
  $block['content'] .= "<br /><br />";
  $block['content'] .= sprintf(_MB_WHOSONLINE_URLAS, $rcxUser->getVar("uname"));
  $block['content'] .= "<br />";
  } else {
    $block['content'] .= "<br /><br />";
    $block['content'] .= sprintf(_MB_WHOSONLINE_URAU, $rcxConfig['anonymous']);
    $block['content'] .= "<br /><a href='".RCX_URL."/register.php'>"._MB_WHOSONLINE_RNOW."</a><br />";
  }

if ( $options[0] == 1 ) {
  $myID = "";
    if ( $rcxUser ) {
      $myID = $rcxUser->getVar("uid");
    }
  $mintime = (time() - ($options[1] * 86400));

$result = $db->query("SELECT uid, username, time FROM ".$db->prefix("lastseen")." WHERE (uid > 0) AND (time > $mintime) AND (online = 0) ORDER BY time DESC", $options[2], 0);
$content='';
while (list($uid, $uname, $time) = $db->fetch_row($result)) {
  if ($uid != $myID) {
    $lastvisit = b_whosonline_create($time);
    $content  .= "<br />";
    $content  .= "<img src='".RCX_URL."/modules/whosonline/images/pointer.gif' border='0' alt='#' /> <a href=\"".RCX_URL."/userinfo.php?uid=".$uid."\">".$myts->makeTboxData4Show($uname)."</a>";
    $content  .= ": $lastvisit";
  }
}
  if ( !empty($content) ) {
    $block['content'] .= "<br />"._MB_WHOSONLINE_LASTSEEN;
    $block['content'] .= $content;
  }
}

return $block;
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function b_whosonline_create($date) {

$realtime  = time() - $date;
$lastvisit = "";
$days      = "";
$hours     = "";
$mins      = "";

// how many days ago?
if ($realtime >= 86400) {
  $days = floor($realtime / 86400);
  $realtime -= (86400 * $days);
}

// how many hours ago?
if ($realtime >= 3600) {
  $hours = floor($realtime / 3600);
  $realtime -= (3600 * $hours);
}

// how many minutes ago?
if ($realtime >= 60) {
  $mins = floor($realtime / 60);
  $realtime -= (60 * $mins);
}

// just a little precation, although I don't *think* mins will ever be 60...
if ($mins == 60) {
  $mins   = 0;
  $hours += 1;
}

if ($days > 1) {
  $lastvisit .= sprintf(_MB_WHOSONLINE_DAYS, $days);
  } elseif($days == 1) {
    $lastvisit .= _MB_WHOSONLINE_1DAY;
  }

if ($hours > 0) {
  if ($hours == 1) {
    $lastvisit .= _MB_WHOSONLINE_1HR;
    } else {
      $lastvisit .= sprintf(_MB_WHOSONLINE_HRS, $hours);
    }
}

if ($mins > 0) {
  if ($mins == 1) {
    $lastvisit .= _MB_WHOSONLINE_1MIN;
    } else {
      $lastvisit .= sprintf(_MB_WHOSONLINE_MINS, $mins);
    }
}

$lastvisit .= _MB_WHOSONLINE_AGO;

return trim($lastvisit);
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function b_whosonline_edit($options) {

$form = _MB_WHOSONLINE_SLAST."&nbsp;";

if ( $options[0] == 1 ) {
  $chk = " checked='checked'";
}

$form .= "<input type='radio' class='radio' name='options[]' value='1'".$chk." />&nbsp;"._YES."";
$chk = "";

if ( $options[0] == 0 ) {
  $chk = " checked='checked'";
}

$form .= "&nbsp;<input type='radio' class='radio' name='options[]' value='0'".$chk." />"._NO."<br />";
$form .= _MB_WHOSONLINE_MDAYS."&nbsp;<input type='text' class='text' name='options[]' value='".$options[1]."' size='2' />";
$form .= "<br />"._MB_WHOSONLINE_MMEM."&nbsp;<input type='text' class='text' name='options[]' value='".$options[2]."' size='2' />";

return $form;
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function b_whosonline_update($days) {
global $rcxConfig, $rcxUser, $db;

$time     = time();
$anonpast = ($time - 300);
$userpast = ($time - (86400 * $days));

$db->query("DELETE FROM ".$db->prefix("lastseen")." WHERE (uid=0 AND time<$anonpast) OR (time<$userpast)");
$db->query("UPDATE ".$db->prefix("lastseen")." SET online=0 WHERE time<$anonpast");

$ip = _REMOTE_ADDR;

if ($rcxUser) {
  $uid   = $rcxUser->getVar("uid");
  $uname = $rcxUser->getVar("uname");
  } else {
    $uid   = 0;
    $uname = $rcxConfig['anonymous'];
  }

$sql = "SELECT COUNT(*) FROM ".$db->prefix("lastseen")." WHERE uid=$uid";

if ($uid == 0) {
  $sql .= " AND ip='$ip'";
}

$result         = $db->query($sql);
list($num_rows) = $db->fetch_row($result);

if ( $num_rows > 0) {
  $sql = "UPDATE ".$db->prefix("lastseen")." SET time='$time', ip='$ip', online=1 WHERE uid=$uid";

  if ($uid == 0) {
    $sql .= " AND ip='$ip'";
  }
  $db->query($sql);

  } else {
    $sql = "INSERT INTO ".$db->prefix("lastseen")." SET uid=$uid, username='$uname', time='$time', ip='$ip', online=1";
    $db->query($sql);
  }

}
?>
