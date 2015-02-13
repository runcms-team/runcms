<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {


/**
* Description
*
* @param type $var description
* @return type description
*/
function displayGroups() {
global $db, $myts, $rcxConfig, $rcxModule;

rcx_cp_header();
OpenTable();

echo "<h4 style='text-align:left'>"._AM_EDITADG."</h4>";
$result = $db->query("SELECT groupid, name, type FROM ".$db->prefix("groups")."");
echo "
<table border='0' cellpadding='0' cellspacing='0' width='40%'>
<tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'>";

while(list($a_groupid, $name, $type) = $db->fetch_row($result)) {
  $name = $myts->makeTboxData4Save($name);
  echo "<tr><td class='sysbg3'>$name</td>";
  echo "<td class='sysbg1'><a href='admin.php?fct=groups&amp;op=modify&amp;g_id=$a_groupid'>"._MODIFY."</a>";
  if ( $a_groupid == 1 || $type == "Anonymous" || $type == "User" ) {
    echo "</td></tr>";
    } else {
      echo "&nbsp;<a href='admin.php?fct=groups&amp;op=del&amp;g_id=$a_groupid&amp;name=$name'>"._DELETE."</a></td></tr>";
    }
}

echo "</table></td></tr></table>";

$name_value    = "";
$desc_value    = "";
$a_mod_value   = array();
$r_mod_value   = array();
$r_block_value = array();
$op_value      = "add";
$submit_value  = _AM_CREATENEWADG;
$g_id_value    = "";
$type_value    = "";
$form_title    = _AM_CREATENEWADG;

include_once(RCX_ROOT_PATH."/modules/system/admin/groups/groupform.php");

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function modifyGroup($g_id) {
global $_GET, $_POST, $rcxUser, $db, $myts, $rcxConfig, $rcxModule;

$userstart = $adminstart = 0;

if ( !empty($_POST['userstart']) ) {
  $userstart = intval($_POST['userstart']);
  } elseif (!empty($_GET['userstart'])) {
    $userstart = intval($_GET['userstart']);
  }

if ( !empty($_POST['adminstart']) ) {
  $adminstart = intval($_POST['adminstart']);
  } elseif (!empty($_GET['adminstart'])) {
    $adminstart = intval($_GET['adminstart']);
  }

rcx_cp_header();
OpenTable();

echo '<a href="admin.php?fct=groups">'. _AM_GROUPSMAIN .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'. _AM_MODIFYADG.'<br /><br />';

$thisgroup     = new RcxGroup($g_id);
$name_value    = $thisgroup->getVar("name", "E");
$desc_value    = $thisgroup->getVar("description", "E");
$a_mod_value   =& RcxModule::getByRight($thisgroup->getVar("groupid"),"A");
$r_mod_value   =& RcxModule::getByRight($thisgroup->getVar("groupid"),"R");
$r_block_value =& RcxBlock::getAllBlocksByGroup($thisgroup->getVar("groupid"), false);
$op_value      = "update";
$submit_value  = _UPDATE;
$g_id_value    = $thisgroup->getVar("groupid");
$type_value    = $thisgroup->getVar("type", "E");
$form_title    = _AM_MODIFYADG;

include_once(RCX_ROOT_PATH."/modules/system/admin/groups/groupform.php");
echo "<br /><h4 style='text-align:left'>"._AM_EDITMEMBER."</h4>";

$usercount = RcxUser::countAllUsers('level>0');
$sql       = "SELECT COUNT(*) FROM ".$db->prefix("groups_users_link")." l, ".$db->prefix("users")." u WHERE l.groupid = ".$g_id." AND l.uid=u.uid";
list($admincount) = $db->fetch_row($db->query($sql));

if ( $usercount < 1000 && $admincount < 1000 ) {
  $sql    = "SELECT l.uid, u.uname FROM ".$db->prefix("groups_users_link")." l, ".$db->prefix("users")." u WHERE l.groupid = ".$g_id." AND l.uid=u.uid ORDER BY uname";
  $result = $db->query($sql);
  $admins = array();
  while ( $myrow = $db->fetch_array($result) ) {
    $admins[$myrow['uid']] = $myts->makeTboxData4Show($myrow['uname']);
  }
  $userslist =& RcxUser::getAllUsersList('level>0', 'uname ASC');
  $users     =& array_diff($userslist, $admins);

?>
<table align=center border="0"><tr>
<td align="center"><?php echo _AM_NONMEMBERS;?></td>
<td></td>
<td align="center"><?php echo _AM_MEMBERS;?></td>
</tr><tr>
<td><form action="admin.php" method="post">
<select class="select" name="uids[]" size="10" multiple="multiple">
<?php

$size = count($userids);

foreach ($users as $u_id => $u_name) {
  echo '<option value="'.$u_id.'">'.$u_name.'</option>'."";
}

$rcx_token = & RcxToken::getInstance();

?>
</select></td>
<td align="center">
<input type="hidden" name="op" value="addUser" />
<input type="hidden" name="fct" value="groups" />
<?php echo $rcx_token->getTokenHTML();?>
<input type="hidden" name="groupid" value="<?php echo $thisgroup->getVar("groupid");?>" />
<input type="submit" class="button" name="submit" value="<?php echo _ADD;?> --&gt;" />
</form>
<form action="admin.php" method="post" />
<input type="hidden" name="op" value="delUser" />
<input type="hidden" name="fct" value="groups" />
<?php echo $rcx_token->getTokenHTML();?>
<input type="hidden" name="groupid" value="<?php echo $thisgroup->getVar("groupid");?>" />
<input type="submit" class="button" name="submit" value="&lt;-- <?php echo _REMOVE;?>" />
</td>
<td><select class="select" name="uids[]" size="10" multiple="multiple">
<?php

foreach ( $admins as $a_id => $a_name ) {
  echo '<option value="'.$a_id.'">'.$a_name.'</option>';
}

?>
</select></td></tr></form></table>
<?php

} else {

$sql    = "SELECT l.uid, u.uname FROM ".$db->prefix("groups_users_link")." l, ".$db->prefix("users")." u WHERE l.groupid = ".$g_id." AND l.uid=u.uid ORDER BY uname";
$result = $db->query($sql, 1000, $adminstart);
$admins = array();

while ( $myrow = $db->fetch_array($result) ) {
  $admins[$myrow['uid']] = $myts->makeTboxData4Show($myrow['uname']);
}

?>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=findusers&amp;group=<?php echo $g_id;?>"><?php echo _AM_FINDU4GROUP;?></a><br />
<form action="admin.php" method="post">
<table border="0"><tr>
<td align="center"><?php echo _AM_MEMBERS;?><br />
<?php

$nav = new RcxPageNav($admincount, 1000, $adminstart, "adminstart", "fct=groups&op=modify&g_id=".$g_id);
echo $nav->renderNav(4);

$rcx_token = & RcxToken::getInstance();

?>
</td>
</tr><tr>
<td align="center">
<input type="hidden" name="op" value="delUser" />
<input type="hidden" name="fct" value="groups" />
<?php echo $rcx_token->getTokenHTML();?>
<input type="hidden" name="groupid" value="<?php echo $thisgroup->getVar("groupid");?>" />
<input type="hidden" name="adminstart" value="<?php echo $adminstart;?>" />
<select class="select" name="uids[]" size="10" multiple="multiple">
<?php

foreach ( $admins as $a_id => $a_name ) {
  echo '<option value="'.$a_id.'">'.$a_name.'</option>';
}

?>
</select><br />
<input type="submit" class="button" name="submit" value="<?php echo _DELETE;?>" />
</td></tr></table></form>
<?php

}

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function updateGroup($g_id, $name, $desc, $admin_mids, $read_mids, $read_bids) {
global $db;

if (!$g_id || !$name) {
  redirect_header("admin.php?fct=groups&op=adminMain", 2, _AM_UNEED2ENTER);
  exit();
}

$rcxgroup = new RcxGroup($g_id);
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
    redirect_header("admin.php?fct=groups&op=adminMain", 1, _UPDATED);
  }
exit();
}
} else {
  echo "Access Denied";
}
?>
