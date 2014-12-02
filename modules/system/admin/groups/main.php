<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

include_once(RCX_ROOT_PATH."/modules/system/admin/groups/groups.php");
include_once(RCX_ROOT_PATH."/class/rcxgroup.php");

if( $rcxUser->isAdmin($rcxModule->mid()) ) {

$op = "display";

if ( isset($_POST) ) {
  foreach ( $_POST as $k => $v ) {
    $$k = $v;
  }
}

if ( isset($_GET['op']) ) {
  if ( $_GET['op'] == "modify" || $_GET['op'] == "del" || $_GET['op'] == "delConf" ) {
    $op   = $_GET['op'];
    $g_id = $_GET['g_id'];
  }
}

// from finduser section
if ( !empty($memberslist_id) && is_array($memberslist_id) ) {
  $op   = "addUser";
  $uids =& $memberslist_id;
}

if (in_array($op, array("update", "add", "delConf", "addUser", "delUser"))) {
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=groups', 3, $rcx_token->getErrors(true));
        exit();
    }
}

switch($op) {

case "modify":
  include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
  modifyGroup($g_id);
  break;

case "update":
  $admin_mids = empty($admin_mids) ? array() : $admin_mids;
  $read_mids  = empty($read_mids)  ? array() : $read_mids;
  $read_bids  = empty($read_bids)  ? array() : $read_bids;
  updateGroup($g_id, $name, $desc, $admin_mids, $read_mids, $read_bids);
  break;

case "add":
  if (!$name) {
    rcx_cp_header();
    echo _AM_UNEED2ENTER;
    rcx_cp_footer();
    exit();
  }
  $admin_mids = empty($admin_mids) ? array() : $admin_mids;
  $read_mids  = empty($read_mids)  ? array() : $read_mids;
  $read_bids  = empty($read_bids)  ? array() : $read_bids;
  $rcxgroup = new RcxGroup();
  $rcxgroup->setVar("name", $name);
  $rcxgroup->setVar("description", $desc);
  $rcxgroup->setAdminRightModules($admin_mids);
  array_push($read_mids, 1);
  $rcxgroup->setReadRightModules($read_mids);
  $rcxgroup->setReadRightBlocks($read_bids);
  if (!$rcxgroup->store()) {
    rcx_cp_header();
    echo $rcxgroup->getErrors();
    rcx_cp_footer();
    } else {
      redirect_header("admin.php?fct=groups&op=adminMain",1,_UPDATED);
    }
  break;

case "del":
  rcx_cp_header();
  echo "<b> "._AM_DELETEADG."</b><br /><br />";
  printf(_AM_AREUSUREDEL,$name);
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=groups&op=delConf&g_id=$g_id", _YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?fct=groups&op=adminMain" , _NO);
  echo "</td></tr></table>";
  rcx_cp_footer();
  break;

case "delConf":
  $rcxgroup = new RcxGroup($g_id);
  $rcxgroup->delete();
  redirect_header("admin.php?fct=groups&op=adminMain",1,_UPDATED);
  break;

case "addUser":
  $size = count($uids);
  for ( $i = 0; $i < $size; $i++ ) {
    $sql = "INSERT INTO ".$db->prefix("groups_users_link")." SET groupid=".$groupid.", uid=".$uids[$i]."";
    $db->query($sql);
  }
  redirect_header("admin.php?fct=groups&op=modify&g_id=".$groupid."",0,_UPDATED);
  break;

case "delUser":
  $size = count($uids);
  for ( $i = 0; $i < $size; $i++ ) {
    $sql = "DELETE FROM ".$db->prefix("groups_users_link")." WHERE uid=".$uids[$i]." AND groupid=".$groupid."";
    $db->query($sql);
  }
  redirect_header('admin.php?fct=groups&op=modify&g_id='.$groupid.'&amp;adminstart='.$adminstart,0,_UPDATED);
  break;

case "display":
  default:
  displayGroups();
  break;
}
} else {
  echo "Access Denied";
}
?>
