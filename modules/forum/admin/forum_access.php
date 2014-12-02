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
include_once("../functions.php");
include_once("../config.php");


switch($op)
{
  case 'add_group':
  {
  	add_group($group_id, $forum);
  	break;
  }
  case 'revoke_group':
  {
  	revoke_group($group_id, $forum);
  	break;
  }
  case _MD_A_UPDATE_GROUPS:
  {
  	update_groups();
  	break;
  }
  case 'add_user':
  {
  	add_user($user_id, $forum);
  	break;
  }
  case 'revoke_user':
  {
  	revoke_user($user_id, $forum);
  	break;
  }
  case _MD_A_UPDATE_USERS:
  {
  	update_users();
  	break;
  }
  case 'copy_permissions':
  {
  	copy_permissions();
  }
}

function isChecked($value)
{
	if ($value == 1)
		return "checked";

	return '';
}

function add_group($group_id, $forum)
{
	global $db, $bbTable;
	
	$sql = "INSERT INTO ".$bbTable['forum_group_access']." (forum_id, can_view, group_id) VALUES($forum, 1, $group_id)";
	if (!$db->query($sql))
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_ERR_GROUP_ADD);
	}
	else
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_GROUP_ADD);
	}
	die();
}

function revoke_group($group_id, $forum)
{
	global $db, $bbTable;
	
	$sql = "DELETE FROM ".$bbTable['forum_group_access']." WHERE group_id=$group_id AND forum_id=$forum";
	if (!$db->query($sql))
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_ERR_GROUP_REVOKE);
	}
	else
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_GROUP_REVOKE);
	}
	die();
}

function update_groups()
{
	global $db, $bbTable, $_POST;
	
	for($i = 0; $i<count($_POST['group_id']); $i++)
	{
		$sql = "UPDATE ".$bbTable['forum_group_access']." ";
		$sql .= " SET can_view=".intval($_POST['can_view'][$i] == 'on');
		$sql .= ", can_post=".intval($_POST['can_post'][$i] == 'on');
		$sql .= ", can_reply=".intval($_POST['can_reply'][$i] == 'on');
		$sql .= ", can_edit=".intval($_POST['can_edit'][$i] == 'on');
		$sql .= ", can_delete=".intval($_POST['can_delete'][$i] == 'on');
		$sql .= ", can_addpoll=".intval($_POST['can_addpoll'][$i] == 'on');
		$sql .= ", can_vote=".intval($_POST['can_vote'][$i] == 'on');
		$sql .= ", can_attach=".intval($_POST['can_attach'][$i] == 'on');
		$sql .= ", autoapprove_post=".intval($_POST['autoapprove_post'][$i] == 'on');
		$sql .= ", autoapprove_attach=".intval($_POST['autoapprove_attach'][$i] == 'on');
		$sql .= " WHERE group_id=".$_POST['group_id'][$i]." AND forum_id=".$_POST['forum'];

		$db->query($sql);
		unset($sql);
	}
	redirect_header("./forum_access.php?forum=".$_POST['forum'],2,_MD_A_MSG_GROUPS_UPDATED);
	die();
}

function add_user($user_id, $forum)
{
	global $db, $bbTable;
	
	$sql = "INSERT INTO ".$bbTable['forum_access']." SET user_id=$user_id, can_view=1, forum_id=$forum";
	if (!$db->query($sql))
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_ERR_USER_ADD);
	}
	else
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_USER_ADD);
	}
	die();
}

function revoke_user($user_id, $forum)
{
	global $db, $bbTable;
	
	$sql = "DELETE FROM ".$bbTable['forum_access']." WHERE user_id=$user_id AND forum_id=$forum";
	if (!$db->query($sql))
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_ERR_USER_REVOKE);
	}
	else
	{
		redirect_header("./forum_access.php?forum=$forum",2,_MD_A_MSG_USER_REVOKE);
	}
	die();
}

function update_users()
{
	global $db, $bbTable, $_POST;

	for($i = 0; $i<count($_POST['user_id']); $i++)
	{
		$sql = "UPDATE ".$bbTable['forum_access']." ";
		$sql .= " SET can_view=".intval($_POST['can_view'][$i] == 'on');
		$sql .= ", can_post=".intval($_POST['can_post'][$i] == 'on');
		$sql .= ", can_reply=".intval($_POST['can_reply'][$i] == 'on');
		$sql .= ", can_edit=".intval($_POST['can_edit'][$i] == 'on');
		$sql .= ", can_delete=".intval($_POST['can_delete'][$i] == 'on');
		$sql .= ", can_addpoll=".intval($_POST['can_addpoll'][$i] == 'on');
		$sql .= ", can_vote=".intval($_POST['can_vote'][$i] == 'on');
		$sql .= ", can_attach=".intval($_POST['can_attach'][$i] == 'on');
		$sql .= ", autoapprove_post=".intval($_POST['autoapprove_post'][$i] == 'on');
		$sql .= ", autoapprove_attach=".intval($_POST['autoapprove_attach'][$i] == 'on');
		$sql .= " WHERE user_id=".$_POST['user_id'][$i]." AND forum_id=".$_POST['forum'];
		
		$db->query($sql);
		unset($sql);
	}
	redirect_header("./forum_access.php?forum=".$_POST['forum'],2,_MD_A_MSG_USERS_UPDATED);
	die();
}

function copy_permissions()
{
	global $db, $bbTable, $_POST;
	
	if (isset($_POST['forum']) && isset($_POST['copy_fid']))
	{
		// Remove all permissions for this forum
		$sql = "DELETE FROM ".$bbTable['forum_access']." WHERE forum_id=".$_POST['forum'];
		$db->query($sql);
		$sql = "DELETE FROM ".$bbTable['forum_group_access']." WHERE forum_id=".$_POST['forum'];
		$db->query($sql);
		
		// Copy the permissions from specified forum
		$sql = "SELECT * FROM ".$bbTable['forum_access']." WHERE forum_id=".$_POST['copy_fid'];
		if($result = $db->query($sql))
		{
			while($row = $db->fetch_object($result))
			{
				$sql_insert = "INSERT INTO ".$bbTable['forum_access']." SET ";
				$sql_insert .= "forum_id=".$_POST['forum'];
				$sql_insert .= ", user_id=".$row->user_id;
				$sql_insert .= ", can_view=".$row->can_view;
				$sql_insert .= ", can_post=".$row->can_post;
				$sql_insert .= ", can_reply=".$row->can_reply;
				$sql_insert .= ", can_edit=".$row->can_edit;
				$sql_insert .= ", can_delete=".$row->can_delete;
				$sql_insert .= ", can_addpoll=".$row->can_addpoll;
				$sql_insert .= ", can_vote=".$row->can_vote;
				$sql_insert .= ", can_attach=".$row->can_attach;
				$sql_insert .= ", autoapprove_post=".$row->autoapprove_post;
				$sql_insert .= ", autoapprove_attach=".$row->autoapprove_attach;
				$db->query($sql_insert);
			}
		}
		$sql = "SELECT * FROM ".$bbTable['forum_group_access']." WHERE forum_id=".$_POST['copy_fid'];
		if($result = $db->query($sql))
		{
			while($row = $db->fetch_object($result))
			{
				$sql_insert = "INSERT INTO ".$bbTable['forum_group_access']." SET ";
				$sql_insert .= "forum_id=".$_POST['forum'];
				$sql_insert .= ", group_id=".$row->group_id;
				$sql_insert .= ", can_view=".$row->can_view;
				$sql_insert .= ", can_post=".$row->can_post;
				$sql_insert .= ", can_reply=".$row->can_reply;
				$sql_insert .= ", can_edit=".$row->can_edit;
				$sql_insert .= ", can_delete=".$row->can_delete;
				$sql_insert .= ", can_addpoll=".$row->can_addpoll;
				$sql_insert .= ", can_vote=".$row->can_vote;
				$sql_insert .= ", can_attach=".$row->can_attach;
				$sql_insert .= ", autoapprove_post=".$row->autoapprove_post;
				$sql_insert .= ", autoapprove_attach=".$row->autoapprove_attach;
				$db->query($sql_insert);
			}
		}
	}
}

$sql = "SELECT * from ".$bbTable['forums']." WHERE forum_id=$forum";
if($result = $db->query($sql))
{
	$row = $db->fetch_object($result);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="center"><td><div class="KPmellem" /><center>
<b><?php echo _MD_A_PERMISSIONS_FORUM;?> <?php echo $row->forum_name;?></b></center><br /></td></tr>
</table></table><br><br>
<?php
}
else
{
	CloseTable();
	rcx_cp_footer();
	exit();
}


// Groups
$groups_with_access = array();

// Get groups with access
$sql = "SELECT g.groupid FROM ".$db->prefix("groups")." g, ".$bbTable['forum_group_access']." f WHERE g.groupid = f.group_id AND f.forum_id = $forum";
if (!$result = $db->query($sql))
{
	CloseTable();
	rcx_cp_footer();
	exit();
}
while ($row = $db->fetch_array($result))
{
	$groups_with_access[] = $row[groupid];
}
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg2" align="left"><td colspan=10><b><?php echo _MD_A_PERMISSIONS_GROUP;?></b></td></tr>
<tr class="bg1" align="left">
<td><b><?php echo _MD_A_ALLOW_GROUP;?></b></td>
<td colspan=11><form method="post" action="forum_access.php">
<input type="hidden" name="forum" value="<?php echo $forum;?>">
<input type="hidden" name="op" value="add_group">
<?php
$sql = "SELECT groupid, name FROM ".$db->prefix("groups")." WHERE groupid > 1 ";
?>
<select name="group_id" style="width: 30%;">
<?php
for($i=0; $i<count($groups_with_access); $i++)
{
	 $sql .= "AND (groupid != ".$groups_with_access[$i].") ";
}

$sql .= "ORDER BY name ASC";
echo $sql;

if (!$result = $db->query($sql)) {
	CloseTable();
	rcx_cp_footer();
	exit();
}
while ($row = $db->fetch_array($result)) {
?>
	<option value="<?php echo $row['groupid'] ?>"><?php echo $row['name'] ?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<input type="submit" name="submit" value="<?php echo _ADD;?>" class="button">
</form></td>
</tr>
<tr class="bg2">
<td><b><?php echo _MD_A_GROUP_NAME;?></b></td>
<td><b><?php echo _MD_A_CAN_VIEW;?></b></td>
<td><b><?php echo _MD_A_CAN_POST;?></b></td>
<td><b><?php echo _MD_A_CAN_REPLY;?></b></td>
<td><b><?php echo _MD_A_CAN_EDIT;?></b></td>
<td><b><?php echo _MD_A_CAN_DELETE;?></b></td>
<td><b><?php echo _MD_A_CAN_ADDPOLL;?></b></td>
<td><b><?php echo _MD_A_CAN_VOTE;?></b></td>
<td><b><?php echo _MD_A_CAN_ATTACH;?></b></td>
<td><b><?php echo _MD_A_APPR_POST;?></b></td>
<td><b><?php echo _MD_A_APPR_ATTACH;?></b></td>
<td><b><?php echo _MD_A_ACTION;?></b></td>
<tr>
<?php
$sql = "SELECT * FROM ".$db->prefix("groups")." g, ".$bbTable['forum_group_access']." f WHERE g.groupid = f.group_id AND f.forum_id = $forum";
if ($result = $db->query($sql))
{
	echo '<form method="post" action="forum_access.php" name="grp_form">';
	echo '<input type="hidden" name="forum" value="'.$forum.'">';
	$i=0;
	while($row = $db->fetch_object($result))
	{
		echo '<input type="hidden" name="group_id[]" value="'.$row->group_id.'">';
		echo '<tr class="bg1">';
		echo '<td>'.$row->name.'</td>';
		echo '<td><input type="checkbox" name="can_view['.$i.']" '.isChecked($row->can_view).'></td>';
		echo '<td><input type="checkbox" name="can_post['.$i.']" '.isChecked($row->can_post).'></td>';
		echo '<td><input type="checkbox" name="can_reply['.$i.']" '.isChecked($row->can_reply).'></td>';
		echo '<td><input type="checkbox" name="can_edit['.$i.']" '.isChecked($row->can_edit).'></td>';
		echo '<td><input type="checkbox" name="can_delete['.$i.']" '.isChecked($row->can_delete).'></td>';
		echo '<td><input type="checkbox" name="can_addpoll['.$i.']" '.isChecked($row->can_addpoll).'></td>';
		echo '<td><input type="checkbox" name="can_vote['.$i.']" '.isChecked($row->can_vote).'></td>';
		echo '<td><input type="checkbox" name="can_attach['.$i.']" '.isChecked($row->can_attach).'></td>';
		echo '<td><input type="checkbox" name="autoapprove_post['.$i.']" '.isChecked($row->autoapprove_post).'></td>';
		echo '<td><input type="checkbox" name="autoapprove_attach['.$i.']" '.isChecked($row->autoapprove_attach).'></td>';
		echo '<td><input type="button" value="'._MD_A_REVOKE.'" class="button" onclick="javascript:window.location=\'forum_access.php?op=revoke_group&group_id='.$row->group_id.'&amp;forum='.$forum.'\'"></td>';
		echo '<tr>';
		$i++;
	}
	echo '<tr><td colspan=10 align="center"><input type="submit" name="op" value="'._MD_A_UPDATE_GROUPS.'" class="button"></td></tr>';
	echo '</form>';
}

echo "</table>";
echo "</table>";
echo "<br><br>";
// Users
$users_with_access = array();

// Get groups with access
$sql = "SELECT u.uid FROM ".$db->prefix("users")." u, ".$bbTable['forum_access']." f WHERE u.uid = f.user_id AND f.forum_id = $forum";
if (!$result = $db->query($sql))
{
	CloseTable();
	rcx_cp_footer();
	exit();
}
while ($row = $db->fetch_array($result))
{
	$users_with_access[] = $row[uid];
}
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg2" align="left"><td colspan=10><b><?php echo _MD_A_PERMISSIONS_USER;?></b></td></tr>
<tr class="bg1" align="left">
<td><b><?php echo _MD_A_ALLOW_USER;?></b></td>
<td colspan=11><form method="post" action="forum_access.php">
<input type="hidden" name="forum" value="<?php echo $forum;?>">
<input type="hidden" name="op" value="add_user">
<?php
$sql = "SELECT uid, uname FROM ".$db->prefix("users")." WHERE uid <> 0 ";
echo '<select name="user_id"  style="width: 30%;">';

for($i=0; $i<count($users_with_access); $i++)
{
	 $sql .= "AND (uid != ".$users_with_access[$i].") ";
}

$sql .= "ORDER BY uname ASC";
echo $sql;

if (!$result = $db->query($sql)) {
	CloseTable();
	rcx_cp_footer();
	exit();
}
while ($row = $db->fetch_array($result)) {
?>
	<option value="<?php echo $row['uid'] ?>"><?php echo $row['uname'] ?></option>
<?php
}
?>
</select>&nbsp;&nbsp;

<input type="submit" name="submit" value="<?php echo _ADD;?>" class="button">
</form></td>
</tr>
<tr class="bg2">
<td><b><?php echo _MD_A_USER_NAME;?></b></td>
<td><b><?php echo _MD_A_CAN_VIEW;?></b></td>
<td><b><?php echo _MD_A_CAN_POST;?></b></td>
<td><b><?php echo _MD_A_CAN_REPLY;?></b></td>
<td><b><?php echo _MD_A_CAN_EDIT;?></b></td>
<td><b><?php echo _MD_A_CAN_DELETE;?></b></td>
<td><b><?php echo _MD_A_CAN_ADDPOLL;?></b></td>
<td><b><?php echo _MD_A_CAN_VOTE;?></b></td>
<td><b><?php echo _MD_A_CAN_ATTACH;?></b></td>
<td><b><?php echo _MD_A_APPR_POST;?></b></td>
<td><b><?php echo _MD_A_APPR_ATTACH;?></b></td>
<td><b><?php echo _MD_A_ACTION;?></b></td>
<tr>
<?php
$sql = "SELECT * FROM ".$db->prefix("users")." u, ".$bbTable['forum_access']." f WHERE u.uid = f.user_id AND f.forum_id = $forum";
if ($result = $db->query($sql))
{
	echo '<form method="post" action="forum_access.php">';
	echo '<input type="hidden" name="forum" value="'.$forum.'">';
	$i=0;
	while($row = $db->fetch_object($result))
	{
		echo '<input type="hidden" name="user_id[]" value="'.$row->user_id.'">';
		echo '<tr class="bg1">';
		echo '<td>'.$row->uname.'</td>';
		echo '<td><input type="checkbox" name="can_view['.$i.']" '.isChecked($row->can_view).'></td>';
		echo '<td><input type="checkbox" name="can_post['.$i.']" '.isChecked($row->can_post).'></td>';
		echo '<td><input type="checkbox" name="can_reply['.$i.']" '.isChecked($row->can_reply).'></td>';
		echo '<td><input type="checkbox" name="can_edit['.$i.']" '.isChecked($row->can_edit).'></td>';
		echo '<td><input type="checkbox" name="can_delete['.$i.']" '.isChecked($row->can_delete).'></td>';
		echo '<td><input type="checkbox" name="can_addpoll['.$i.']" '.isChecked($row->can_addpoll).'></td>';
		echo '<td><input type="checkbox" name="can_vote['.$i.']" '.isChecked($row->can_vote).'></td>';
		echo '<td><input type="checkbox" name="can_attach['.$i.']" '.isChecked($row->can_attach).'></td>';
		echo '<td><input type="checkbox" name="autoapprove_post['.$i.']" '.isChecked($row->autoapprove_post).'></td>';
		echo '<td><input type="checkbox" name="autoapprove_attach['.$i.']" '.isChecked($row->autoapprove_attach).'></td>';
		echo '<td><input type="button" value="'._MD_A_REVOKEUSER.'" class="button" onclick="javascript:window.location=\'forum_access.php?op=revoke_user&user_id='.$row->user_id.'&amp;forum='.$forum.'\'"></td>';
		echo '<tr>';
		$i++;
	} ?>

<td colspan=10 align=center><input type="submit" name="op" value="<?php echo _MD_A_UPDATE_USERS;?>" class="button"></td>
</form>
<?php
}
// Copy From Box ---->

?>
</table>
</table><br><br>

<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg1" align="left">
<td width="30%"><b><?php echo _MD_A_COPY_PERMISSIONS;?></b></td>
<td width="70%"><form method="post" action="forum_access.php">
<input type="hidden" name="op" value="copy_permissions">
<input type="hidden" name="forum" value="<?php echo $forum;?>">
<select name="copy_fid" style="width: 30%;">
<?php
$sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id!=$forum ORDER BY forum_name";
if($result = $db->query($sql))
{
	while($row = $db->fetch_object($result))
	{
		echo '<option value="'.$row->forum_id.'">'.$row->forum_name.'</option>';
	}
}
?>
</select>
&nbsp;&nbsp;<input type="submit" name="submit" value="<?php echo _MD_A_COPY;?>" class="button">
</form></td>
</tr>
</table>
</table><br><br>


<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="center"><td><br /><center><input type="button" value="<?php echo _MD_A_BACK_TO_FM;?>" class="button" onclick="javascript:window.location='forum_manager.php'"></center><br /></td></tr>
</table></table>
<?php
CloseTable();
rcx_cp_footer();
?>
