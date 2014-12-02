<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function add_cat_submit()
{
  global $db, $myts, $_POST, $bbTable;

  if ($_POST['new_cat'] != '')
  {
	  $cat_order = 0;
	  $sql = "SELECT max(cat_order) from ".$bbTable['categories'];
	  if($result = $db->query($sql))
	  {
		$row = $db->fetch_array($result);
		$cat_order = $row['0'] + 1;
	  }

	  $sql = "INSERT INTO ".$bbTable['categories']." SET cat_title='".$myts->makeTboxData4Save($_POST['new_cat'])."', cat_order=$cat_order";
	  if($db->query($sql))
		redirect_header('./forum_manager.php?',2,_MD_A_MSG_CAT_CREATED);
	  else
	  {
		redirect_header('./forum_manager.php?',2,_MD_A_MSG_ERR_CAT_CREATED);
	  }
  }
  else
  {
	redirect_header('./forum_manager.php?',2,_MD_A_MSG_ERR_CAT_NO_TITLE);
  }
}

function delete_cat($cat_id)
{
  global $db, $bbTable, $_POST;

  if ($_POST['confirm_delete'] == _YES || $bCommit)
  {
	  $sql = "DELETE FROM ".$bbTable['categories']." WHERE cat_id=$cat_id";
	  if($db->query($sql))
	  {
	  	// Ok... deleted the Category now delete the forums of this category
		$sql = "SELECT forum_id from ".$bbTable['forums']." WHERE cat_id=$cat_id";
		if($result = $db->query($sql))
		{
			while($row = $db->fetch_object($result))
			{
				delete_forum($row->forum_id, true);
			}
		}
		
		redirect_header('./forum_manager.php?',2,_MD_A_MSG_CAT_DELETED);
	  }
	  else
	  {
		redirect_header('./forum_manager.php?',2,_MD_A_MSG_ERR_CAT_DELETED);
	  }
   }
   else if ($_POST['confirm_delete'] == _NO)
   {
 		  redirect_header('./forum_manager.php?',0,_MD_A_MSG_RETURN_TO_FM);
   }
   else
   {
  $cat_name = '';
  $sql = "SELECT * FROM ".$bbTable['categories']." WHERE cat_id=$cat_id";
  if($result = $db->query($sql))
  {
  	if($row = $db->fetch_object($result))
	{
		$cat_name = $row->cat_title;
	}
  }   
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg1" align="center">
<td><b><?php echo _MD_A_DELETECATEGORY.'&nbsp;'.$cat_name; ?></b></td>
</tr>
</table>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg2" align="left">
<td><b><?php echo _MD_A_WARNING; ?></b></td>
</tr>
<tr class="bg1" align="left">
<td><b><font color='#FF0000' size='+1'><?php echo _MD_A_WARNING_DEL_CAT; ?></font></b></td>
</tr>
<tr class="bg1" align="center">
<td>
<form method="post" action="forum_manager.php">
<input type='hidden' name='op' value='del_cat'>
<input type='hidden' name='cat_id' value='<?php echo $cat_id;?>'>
<input type='submit' name='confirm_delete' value='<?php echo _YES;?>' class='button'>
<input type='submit' name='confirm_delete' value='<?php echo _NO;?>' class='button'>
</td>
</tr>
</form>
<?php
   }
}

function edit_cat($cat_id)
{
  global $db, $myts, $_POST, $bbTable;
  
  if($_POST['submit'] == _SAVE)
  {
  	$new_title = $myts->makeTboxData4Save($_POST['new_title']);
	if($new_title != '')
	{
	  	$sql = "UPDATE ".$bbTable['categories']." SET cat_title='$new_title' WHERE cat_id=$cat_id";  
		if($db->query($sql))
			redirect_header('./forum_manager.php?',2,_MD_A_MSG_CAT_UPDATED);
		else
			redirect_header('./forum_manager.php?',2,'Failed to update category.');
	}
	else
	{
		redirect_header('./forum_manager.php?',2,_MD_A_MSG_ERR_CAT_NO_TITLE);	
	}
  }
  else
  {
  	$current_title = '';
  	$sql = "SELECT cat_title from ".$bbTable['categories']." WHERE cat_id=$cat_id";
  	if($result = $db->query($sql))
	{
		$row = $db->fetch_object($result);
		$current_title = $row->cat_title;
	}
	  echo '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">';
	  echo '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
	  echo '<tr class="bg3" align="center"><td colspan=7><div style="text-align: center;" class="KPmellem"><b>'._MD_A_EDITCATEGORY.'&nbsp;'.$current_title.'</b></td></tr>';
	  echo "</table>";
	  echo "</table>";
	  echo "<br><br>";

?>	
		<form action="./forum_manager.php" method="post">
		<input type="hidden" name="op" value="edit_cat" />		
		<input type="hidden" name="cat_id" value="<?php echo $cat_id?>" />
		<table border="0" cellpadding="1" cellspacing="0" align="center" valign="TOP" width="75%"><tr><td class="bg2">
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class="bg1" align="left">
		<td><?php echo _MD_A_CATEGORYTITLE;?></td>
		<td><input type="text" class="text" name="new_title" value="<?php echo $current_title; ?>" size="45" maxlength="100">&nbsp;&nbsp;<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" /></td>
		</tr></tr></table></td></tr></table></form>
<?php
	echo "<br><br>";
	echo '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">';
	echo '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
	echo '<tr class="bg3" align="center"><td><br /><center><input type="button" value="'._MD_A_BACK_TO_FM.'" class="button" onclick="javascript:window.location=\'forum_manager.php\'"></center><br /></td></tr>';
	echo '</table></table>';
  }
}

function move_cat_up($cat_id)
{
  global $db, $bbTable;

  $sql = "UPDATE ".$bbTable['categories']." SET cat_order=cat_order-1 WHERE cat_id=$cat_id";
  if($db->query($sql))
	  redirect_header('forum_manager.php', 2, _MD_A_MSG_CAT_MOVED);
  else
	  redirect_header('forum_manager.php', 2, _MD_A_MSG_ERR_CAT_MOVED);
}

function move_cat_down($cat_id)
{
  global $db, $bbTable;

  $sql = "UPDATE ".$bbTable['categories']." SET cat_order=cat_order+1 WHERE cat_id=$cat_id";
  if($db->query($sql))
	  redirect_header('forum_manager.php', 2, _MD_A_MSG_CAT_MOVED);
  else
	  redirect_header('forum_manager.php', 2, _MD_A_MSG_ERR_CAT_MOVED);
}

?>
