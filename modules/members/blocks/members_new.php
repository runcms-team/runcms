<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function b_members_new_show($options){
  $block = array();
  $block['content'] = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";
  $criteria = array("level>0");
  $limit = (!empty($options[0])) ? $options[0] : 10;
  $newmembers =& RcxUser::getAllUsers($criteria, true, "user_regdate DESC", $limit);
  foreach ( $newmembers as $nb ) {
    $block['content'] .= "<tr class='bg1'>";
    if ( $options[1] == 1 ) {
      $avatar = $nb->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$nb->getVar("user_avatar")."' alt='' width='32' />" : "&nbsp;";
      $block['content'] .= "<td align='center'>$avatar</td>";
    }
    $block['content'] .= "<td><a href='".RCX_URL."/userinfo.php?uid=".$nb->getVar("uid")."'>".$nb->getVar("uname")."</a></td><td align='center'>".formatTimestamp($nb->getVar("user_regdate"), "s")."</td>";
  }
  $block['content'] .= "</tr></table></td></tr></table>\n";
  $block['title'] = _MB_MEMBERS_TITLE2;

  return $block;
}

function b_members_new_edit($options) {
  $inputtag = "<input type='text' class='text' name='options[]' value='".$options[0]."' />";
  $form = sprintf(_MB_MEMBERS_DISPLAY,$inputtag);
  $form .= "<br />"._MB_MEMBERS_DISPLAYA."&nbsp;<input type='radio' class='radio' id='options[]' name='options[]' value='1'";
  if ( $options[1] == 1 ) {
    $form .= " checked='checked'";
  }
  $form .= " />&nbsp;"._YES."<input type='radio' class='radio' id='options[]' name='options[]' value='0'";
  if ( $options[1] == 0 ) {
    $form .= " checked='checked'";
  }
  $form .= " />&nbsp;"._NO."";
  return $form;
}
?>
