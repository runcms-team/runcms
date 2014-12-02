<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function b_members_posters_show($options){
  $block = array();
  $block['content'] = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";
  $criteria = array("level>0");
  $limit = (!empty($options[0])) ? $options[0] : 10;
  $size = count($options);
  for ( $i = 2; $i < $size; $i++) {
    array_push($criteria, "rank<>".$options[$i]);
  }
  $topposters =& RcxUser::getAllUsers($criteria, true, "posts DESC", $limit);
  $count = 1;
  foreach ( $topposters as $tp ) {
    $block['content'] .= "<tr class='bg1'><td>".$count."</td>";
    if ( $options[1] == 1 ) {
      $avatar = $tp->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$tp->getVar("user_avatar")."' alt='' width='32' />" : "&nbsp;";
      $block['content'] .= "<td align='center'>$avatar</td>";
    }
    $block['content'] .= "<td><a href='".RCX_URL."/userinfo.php?uid=".$tp->getVar("uid")."'>".$tp->getVar("uname")."</a></td><td align='center'>".$tp->getVar("posts")."</td>";
    $count++;
  }
  $block['content'] .= "</tr></table></td></tr></table>\n";
  $block['title'] = _MB_MEMBERS_TITLE1;

  return $block;
}

function b_members_posters_edit($options) {
  include_once(RCX_ROOT_PATH."/class/rcxlists.php");
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
  $form .= "<br />"._MB_MEMBERS_NODISPGR."<br /><select class='select' id='options[]' name='options[]' multiple='multiple'>";
  $ranks =& RcxLists::getUserRankList();
  $size = count($options);
  foreach ($ranks as $k => $v) {
    $sel = "";
    for ( $i = 2; $i < $size; $i++ ) {
      if ($k == $options[$i]) {
        $sel = " selected='selected'";
      }
    }
    $form .= "<option value='$k'$sel>$v</option>";
  }
  $form .= "</select>";
  return $form;
}
?>
