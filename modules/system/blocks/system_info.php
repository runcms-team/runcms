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
function b_system_info_show($options) {
global $rcxConfig, $rcxUser, $db, $myts, $meta;
$block = array();
$block['title'] = _MB_SYSTEM_INFO;
$block['content'] = "<div style='text-align: center;'>";
if (isset($options[3]) && $options[3] == 1)
{
  $result = $db->query("SELECT u.uid, u.uname, u.email, u.user_viewemail, g.name AS groupname FROM ".$db->prefix("groups_users_link")." l LEFT JOIN ".$db->prefix("users")." u ON l.uid=u.uid LEFT JOIN ".$db->prefix("groups")." g ON l.groupid=g.groupid WHERE g.type='Admin' ORDER BY l.groupid");
  if ($db->num_rows($result) > 0)
  {
    $block['content'] .= "<center><table width='92%' border='0' cellspacing='1' cellpadding='0'><tr><td>\n";
    $block['content'] .= "<table width='100%' border='0' cellspacing='1' cellpadding='8' >\n";
    $prev_caption = "";
    while ($userinfo = $db->fetch_array($result))
    {
      if ($prev_caption != $userinfo['groupname'])
      {
        $prev_caption      = $userinfo['groupname'];
        $block['content'] .= "<tr><td colspan='2'>";
        $block['content'] .= "<small>";
        $block['content'] .= "<b>".$myts->makeTboxData4Show($prev_caption)."</b>";
        $block['content'] .= "</small>";
        $block['content'] .= "</td></tr>";
      }
      $userinfo['uname'] = $myts->makeTboxData4Show($userinfo['uname']);
      $block['content'] .= "<tr><td width='80%'>";
      $block['content'] .= "<small>";
      $block['content'] .= "<a href='".RCX_URL."/userinfo.php?uid=".$userinfo['uid']."'>".$userinfo['uname']."</a>";
      $block['content'] .= "</small>";
      $block['content'] .= "</td><td width='20%' align='right'>";
     if ($rcxUser)
      {
        $block['content'] .= "<a href='".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$userinfo['uid']."'>";
        $block['content'] .= "<img src='".RCX_URL."/images/icons/pm_small.gif' border='0' width='27' height='17' alt='";
        $block['content'] .= sprintf(_MB_SYSTEM_SPMTO,$userinfo['uname']);
        $block['content'] .= "' /></a>";
      }
      else
      {
        if ($userinfo['user_viewemail'])
        {
          $block['content'] .= "<a href='mailto:".$userinfo['email']."'><img src='".RCX_URL."/images/icons/em_small.gif' border='0' width='16' height='14' alt='";
          $block['content'] .= sprintf(_MB_SYSTEM_SEMTO,$userinfo['uname']);
          $block['content'] .= "' /></a>";
        }
        else
          $block['content'] .= "&nbsp;";
      }
      $block['content'] .= "</td></tr>";
    }
    $block['content'] .= "</table></td></tr></table></center><br />";
  }
}
$block['content'] .= "<img src='".RCX_URL."/images/".$options[2]."' alt='".$meta['keywords']."' border='0' />";
  $block['content'] .= "<br /><a href='mailto:?subject=".rawurlencode( sprintf(_MB_INTSITE, $meta['title']) )."&amp;body=".rawurlencode( _MB_INTSITEFOUND."\r\n".$meta['title'].": ".RCX_URL )."'>"._MB_SYSTEM_RECO."</a>";

$block['content'] .= "</div>";
return $block;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_system_info_edit($options) {
$form = ""._MB_SYSTEM_PWWIDTH."&nbsp;";
$form .= "<input type='text' class='text' name='options[]' value='".$options[0]."' />";
$form .= "<br />"._MB_SYSTEM_PWHEIGHT."&nbsp;";
$form .= "<input type='text' class='text' name='options[]' value='".$options[1]."' />";
$form .= "<br />".sprintf(_MB_SYSTEM_LOGO,RCX_URL."/images/")."&nbsp;";
$form .= "<input type='text' class='text' name='options[]' value='".$options[2]."' />";
$form .= "<br />"._MB_SYSTEM_SADMIN."&nbsp;";
$chk = "";
if ( $options[3] == 1 ) {
    $chk = " checked='checked'";
}
$form .= "<input type='radio' class='radio' name='options[3]' value='1'".$chk." />&nbsp;"._YES."";
$chk = "";
if ( $options[3] == 0 ) {
  $chk = " checked=\"checked\"";
}
$form .= "&nbsp;<input type='radio' class='radio' name='options[3]' value='0'".$chk." />"._NO."";
return $form;
}
?>
