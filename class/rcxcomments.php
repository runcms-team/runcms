<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

if (!defined("RCX_RCXCOMMENTS_INCLUDED")) {
  define("RCX_RCXCOMMENTS_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
include_once(RCX_ROOT_PATH."/class/rcxtree.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxComments extends RcxObject {

  var $ctable;

  function RcxComments($ctable, $id=NULL) {
    $this->ctable = $ctable;
    $this->RcxObject();
    $this->initVar("item_id", "int", NULL, false);
    $this->initVar("order", "int", NULL, false);
    $this->initVar("mode", "other", NULL, false);
    $this->initVar("subject", "textbox", NULL, false, 255, false);
    $this->initVar("comment", "textarea", NULL, false, NULL, false);
    $this->initVar("ip", "other", NULL, false);
    $this->initVar("comment_id", "int", NULL, false);
    $this->initVar("pid", "int", 0, false);
    $this->initVar("date", "int", NULL, false);
    $this->initVar("allow_html", "int", 0, false);
    $this->initVar("allow_smileys", "int", 1, false);
    $this->initVar("allow_bbcode", "int", 1, false);
    $this->initVar("type", "other", "user", false);
    $this->initVar("user_id", "int", NULL, false);
    $this->initVar("icon", "other", NULL, false);
    $this->initVar("prefix", "other", NULL, false);
    if ( !empty($id) ) {
      if ( is_array($id) ) {
        $this->set($id);
      } else {
        $this->load(intval($id));
      }
    }
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db;

$sql = "SELECT * FROM ".$this->ctable." WHERE comment_id=".intval($id)."";
$result= $db->query($sql);
$arr = $db->fetch_assoc($result);
$this->set($arr);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $db, $rcxUser;

if ( !$this->isCleaned() ) {
  if ( !$this->cleanVars() ) {
    return false;
  }
}

foreach ( $this->cleanVars as $k=>$v ) {
  $$k = $v;
}

$isnew = false;

if ( empty($comment_id ) ) {
  $isnew = true;
  $comment_id = $db->genId($this->ctable."_comment_id_seq");

  $sql = "
    INSERT INTO ".$this->ctable." SET
    comment_id=".intval($comment_id).",
    pid=".intval($pid).",
    item_id=".intval($item_id).",
    date=".time().",
    user_id=".intval($user_id).",
    ip='".$ip."',
    subject='".$subject."',
    comment='".$comment."',
    allow_html=".intval($allow_html).",
    allow_smileys=".intval($allow_smileys).",
    allow_bbcode=".intval($allow_bbcode).",
    type='".$type."',
    icon='".$icon."'";

  } else {
    if ($rcxUser) {
      $editor   = $rcxUser->getVar("uname");
      $on_date  = _ON." ".formatTimestamp(time(), _MEDIUMDATESTRING);
      $comment .= "\n\n[ "._EDITEDBY." ".$editor." ".$on_date." ]";
    }
    $sql = "
      UPDATE ".$this->ctable." SET
      subject='".$subject."',
      comment='".$comment."',
      allow_html=".intval($allow_html).",
      allow_smileys=".intval($allow_smileys).",
      allow_bbcode=".intval($allow_bbcode).",
      icon='".$icon."'
      WHERE comment_id=".intval($comment_id)."";
  }

if ( !$result = $db->query($sql) ) {
  return false;
}

if ( empty($comment_id) ) {
  $comment_id = $db->insert_id();
}

if ( $isnew != false ) {
  $sql = "UPDATE ".$db->prefix("users")." SET posts=posts+1 WHERE uid=".intval($user_id)."";
  if (!$result = $db->query($sql)) {
    echo _NOTUPDATED;
  }
}

return $comment_id;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db;

$sql = "DELETE FROM ".$this->ctable." WHERE comment_id=".$this->getVar("comment_id")."";
if ( !$result = $db->query($sql) ) {
  return false;
}

$sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".$this->getVar("user_id")."";
if ( !$result = $db->query($sql) ) {
  echo _NOTUPDATED;
}

$mytree = new RcxTree($this->ctable, "comment_id", "pid");
$arr    = $mytree->getAllChild($this->getVar("comment_id"), "comment_id");
$size   = count($arr);

if ( $size > 0 ) {
  for ( $i = 0; $i < $size; $i++ ) {
    $sql = "DELETE FROM ".$this->ctable." WHERE comment_id=".intval($arr[$i]['comment_id'])."";
    if ( !$result = $db->query($sql) ) {
      echo _NOTUPDATED;
    }
    $sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".intval($arr[$i]['user_id'])."";
    if ( !$result = $db->query($sql) ) {
      echo _NOTUPDATED;
    }
  }
}

return ($size + 1);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getCommentTree() {

$mytree = new RcxTree($this->ctable, "comment_id", "pid");
$ret    = array();
$tarray = $mytree->getChildTreeArray($this->getVar("comment_id"), "comment_id");

foreach ( $tarray as $ele ) {
  $ret[] = new RcxComments($this->ctable, $ele);
}

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getAllComments($criteria=array(), $asobject=true, $orderby="comment_id ASC", $limit=0, $start=0) {
global $db;

$ret         = array();
$where_query = "";

if ( is_array($criteria) && count($criteria) > 0 ) {
  $where_query = " WHERE";
  foreach ( $criteria as $c ) {
    $where_query .= " $c AND";
  }
  $where_query = substr($where_query, 0, -4);
}

if ( !$asobject ) {
  $sql    = "SELECT comment_id FROM ".$this->ctable."".$where_query." ORDER BY $orderby";
  $result = $db->query($sql,$limit, $start);
  while ( $myrow = $db->fetch_array($result) ) {
    $ret[] = $myrow['comment_id'];
  }
  } else {
    $sql = "SELECT * FROM ".$this->ctable."".$where_query." ORDER BY $orderby";
    $result = $db->query($sql, $limit, $start);
//    while ( $myrow = $db->fetch_array($result) ) {
    while ($myrow = $db->fetch_assoc($result))
    {
      $ret[] = new RcxComments($this->ctable, $myrow);
    }
  }

//echo $sql;
return $ret;
}


/* Methods below will be moved to maybe another class? */

/**
* Description
*
* @param type $var description
* @return type description
*/
function printNavBar($item_id, $mode="flat", $order=1) {
global $rcxConfig, $rcxUser;

echo "
<form method='get' action='"._PHP_SELF."'>
<table width='100%' border='0' cellspacing='1' cellpadding='2'><tr>
<td class='bg1' align='center'><select class='select' name='mode'><option value='0'";

if ( $mode == "0" ) {
  echo " selected='selected'";
}
echo ">"._NOCOMMENTS."</option><option value='flat'";

if ($mode == 'flat') {
  echo " selected='selected'";
}
echo ">"._FLAT."</option><option value='thread'";

if ( $mode == "thread" || $mode == "" ) {
  echo " selected='selected'";
}
echo ">"._THREADED."</option></select> <select class='select' name='order'><option value='0'";

if ( $order != 1 ) {
  echo " selected='selected'";
}
echo ">"._OLDESTFIRST."</option><option value='1'";

if ( $order == 1 ) {
  echo " selected='selected'";
}
echo ">"._NEWESTFIRST."</option></select><input type='hidden' name='item_id' value='".intval($item_id)."' /> <input type='submit' class='button' value='". _REFRESH ."' />";

if ( $rcxConfig['anonpost'] == 1 || $rcxUser ) {
  if ($mode != "flat" || $mode != 0 || $mode != "thread" ) {
    $mode = "flat";
  }
  echo "&nbsp;<input type='button' class='button' onclick='location=\"newcomment.php?item_id=".intval($item_id)."&amp;order=".intval($order)."&amp;mode=".$mode."\"' value='"._POSTCOMMENT."' />";
}

echo "</td></tr></table></form>";
}

/**
* Depracted
*/
function showThreadHead() {
}
/**
* Depracted
*/
function showThreadFoot() {
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function showThreadPost($order, $mode, $adminview=0, $color_num=1) {
global $rcxConfig, $rcxUser, $myts;

$edit_image   = "";
$reply_image  = "";
$delete_image = "";
$post_date    = formatTimestamp($this->getVar("date"), "m");

if ( $this->getVar("user_id") != 0 ) {
  $poster = new RcxUser($this->getVar("user_id"));
  if ( !$poster->isActive() ) {
    $poster = 0;
  }
  } else {
    $poster = 0;
  }

if ( $this->getVar("icon") != NULL && $this->getVar("icon") != "" ) {
  $subject_image = "<a name='".$this->getVar("comment_id")."' id='".$this->getVar("comment_id")."'></a><img src='".RCX_URL."/images/subject/".$this->getVar("icon")."' alt='' />";
  } else {
    $subject_image =  "<a name='".$this->getVar("comment_id")."' id='".$this->getVar("comment_id")."'></a><img src='".RCX_URL."/images/icons/posticon.gif' alt='' />";
  }

if ( $adminview ) {
  $ip_image = "<a href='".RCX_URL."/modules/system/admin.php?fct=filter&op=ips&add_ip=".$this->getVar("ip")."'><img src='".RCX_URL."/images/icons/ip.gif' alt='".$this->getVar("ip")."' border='0' /></a>";
}

if ( $adminview || ($rcxUser && $this->getVar("user_id") == $rcxUser->getVar("uid")) ) {
  $edit_image = "<a href='editcomment.php?comment_id=".$this->getVar("comment_id")."&amp;mode=".$mode."&amp;order=".intval($order)."'><img src='".RCX_URL."/images/icons/edit.gif' alt='"._EDITTHISPOST."' /></a>";
}

if ( $rcxConfig['anonpost'] || $rcxUser ) {
  $reply_image = "<a href='replycomment.php?comment_id=".$this->getVar("comment_id")."&amp;mode=".$mode."&amp;order=".intval($order)."'><img src='".RCX_URL."/images/icons/reply.gif' alt='"._REPLY."' /></a>";
}

if ( $adminview ) {
  $delete_image = "<a href='deletecomment.php?comment_id=".$this->getVar("comment_id")."&amp;mode=".$mode."&amp;order=".intval($order)."'><img src='".RCX_URL."/images/icons/delete.gif' alt='"._DELETETHISPOST."' /></a>";
}

if ($poster) {
  $reg_date   = _JOINED;
  $reg_date  .= formatTimestamp($poster->getVar("user_regdate"), "s");
  $posts      = _POSTS;
  $posts     .= $poster->getVar("posts");
  $user_from  = _FROM;
  $user_from .= $poster->getVar("user_from");

  $rank = $poster->rank();
  if ($rank['image'] != "") {
    $rank['image'] = "<img src='".RCX_URL."/images/ranks/".$rank['image']."' alt='' vspace='2' />";
  }

  $avatar_image = $poster->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$poster->getVar("user_avatar")."' alt='' />" : '';

  if ( $poster->isOnline() ) {
    $online_image = "<span style='font-weight:bold;'>"._ONLINE."</span>";
    } else {
      $online_image = "";
    }

  $profile_image = "<a href='".RCX_URL."/userinfo.php?uid=".$poster->getVar("uid")."'><img src='".RCX_URL."/images/icons/profile.gif' alt='"._PROFILE."' /></a>";
  $module = RcxModule::getByDirname('pm');
  if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups()) && RcxGroup::checkRight('module', $module->mid(), $poster->groups()) )  {
    $pm_image =  "<a href='".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$poster->getVar("uid")."'><img src='".RCX_URL."/images/icons/pm.gif' alt='".sprintf(_SENDPMTO, $poster->getVar("uname", "E"))."' /></a>";
  }

  if ( $adminview || ($rcxUser && $poster->getVar("user_viewemail")) ) {
    $email_image = "<a href='mailto:".$poster->getVar("email")."'><img src='".RCX_URL."/images/icons/email.gif' alt='".sprintf(_SENDEMAILTO, $poster->getVar("uname"))."' /></a>";
  }

  if ($poster->getVar("url") != "") {
      
      if ($rcxConfig['hide_external_links']) {
         $www_image = $myts->checkGoodUrl($poster->getVar("url"), "<img src='".RCX_URL."/images/icons/www.gif' alt='"._VISITWEBSITE."' target='_blank' />", false); 
      } else {
      	 $www_image = "<a href='".$poster->getVar("url")."'><img src='".RCX_URL."/images/icons/www.gif' alt='"._VISITWEBSITE."' target='_blank' /></a>";
      }
   }

  if ( $rcxUser && ($poster->getVar("user_icq") != "") ) {
    $icq_image = "<a href='http://wwp.icq.com/scripts/search.dll?to=".$poster->getVar("user_icq")."'><img src='".RCX_URL."/images/icons/icq_add.gif' alt='"._ADDTOLIST."' /></a>";
  }
  if ( $rcxUser && ($poster->getVar("user_aim") != "") ) {
    $aim_image = "<a href='aim:goim?screenname=".$poster->getVar("user_aim")."&message=Hi+".$poster->getVar("user_aim")."+Are+you+there?'><img src='".RCX_URL."/images/icons/aim.gif' alt='aim' /></a>";
  }

  if ( $rcxUser && ($poster->getVar("user_yim") != "") ) {
    $yim_image = "<a href='http://edit.yahoo.com/config/send_webmesg?.target=".$poster->getVar("user_yim")."&.src=pg'><img src='".RCX_URL."/images/icons/yim.gif' alt='yim' /></a>";




  }

  if ( $rcxUser && ($poster->getVar("user_msnm") != "") ) {
    $msnm_image = "<a href='".RCX_URL."/userinfo.php?uid=".$poster->getVar("uid")."'><img src='".RCX_URL."/images/icons/msnm.gif' alt='msnm' /></a>";
  }

  $subject = $this->getVar("subject");
  $comment = $this->getVar("comment");

  if ( ($poster->getVar("attachsig") == 1) && ($poster->getVar("user_sig") != "") ) {
    $comment .= "<br /><br />--<br />";
    $comment .= $myts->makeTareaData4Show($poster->getVar("user_sig", "N"), 0, 1, 1);
  }

  $username = '<a href="'.RCX_URL.'/userinfo.php?uid='.$poster->getVar("uid").'">'.$poster->getVar("uname").'</a>';
  showThread($color_num, $subject_image, $subject, $comment, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $username, $rank['title'], $rank['image'], $avatar_image, $reg_date, $posts, $user_from, $online_image, $profile_image, $pm_image, $email_image, $www_image, $icq_image, $aim_image, $yim_image, $msnm_image);
  } else {
    $subject = $this->getVar("subject");
    $comment = $this->getVar("comment");
    showThread($color_num, $subject_image, $subject, $comment, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $rcxConfig['anonymous']);
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeHead($width="100%") {
OpenTable();
echo "
  <table border='0' cellpadding='3' cellspacing='0' width='$width'>
  <tr class='bg2' align='left'>
  <td width='60%'>"._REPLIES."</td>
  <td width='20%'>"._POSTER."</td>
  <td>"._DATE."</td></tr>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeItem($order, $mode, $color_num) {

if ( $color_num == 1 ) {
  $bg1 = 'bg1';
  } else {
    $bg1 = 'bg3';
  }

$prefix = str_replace(".", "&nbsp;&nbsp;&nbsp;&nbsp;", $this->getVar("prefix"));
$date   = formatTimestamp($this->getVar("date"), "m");

if ( $this->getVar("icon") != "" ) {
  $icon = "subject/".$this->getVar("icon", "E");
  } else {
    $icon = "icons/posticon.gif";
  }

echo "
  <tr class='$bg1' align='left'>
  <td>".$prefix."<img src='".RCX_URL."/images/".$icon."'>&nbsp;<a href='"._PHP_SELF."?item_id=".$this->getVar("item_id")."&comment_id=".$this->getVar("comment_id")."&mode=".$mode."&order=".$order."#".$this->getVar("comment_id")."'>".$this->getVar("subject")."</a></td>
  <td><a href='".RCX_URL."/userinfo.php?uid=".$this->getVar("user_id")."'>".RcxUser::getUnameFromId($this->getVar("user_id"))."</a></td>
  <td>".$date."</td></tr>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeFoot() {
  echo "</table>";
  CloseTable();
}

} // END RCXCOMMENTS
}
?>
