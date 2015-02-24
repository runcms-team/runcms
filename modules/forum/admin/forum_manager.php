<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('./admin_header.php');
include_once("../config.php");
include './cat_functions.php';
include './forum_functions.php';

switch($op)
{
  case 'add_cat':
  {
	if ($_POST['submit'])
	{
		add_cat_submit();
	}
	else
	{
	    show_forum_manager();
	}
    break;
  }
  case 'edit_cat':
  {
	edit_cat($cat_id);  
    break;
  }
  case 'del_cat':
  {
	delete_cat($cat_id);
    break;
  }
  case 'cat_up':
  {
	move_cat_up($cat_id);
    break;
  }
  case 'cat_down':
  {
	move_cat_down($cat_id);
    break;
  }
  case 'add_forum':
  {
  	add_forum($cat_id);
  	break;
  }
  case 'add_subforum':
  {
  	add_forum($cat_id, $parent_forum);
  	break;
  }
  case 'del_forum':
  {
  	delete_forum($forum_id);
  	break;
  }
  case 'forum_up':
  {
    move_forum_up($forum_id);
  	break;
  }
  case 'forum_down':
  {
    move_forum_down($forum_id);
	break;
  }
  case 'edit_forum':
  {
	edit_forum($forum_id);
	break;
  }
  case 'move_forum':
  {
    move_forum($forum_id);
	break;
  }
  default:
  {
    show_forum_manager();
  }
}

function show_forum_manager()
{
  global $db, $bbImage, $bbTable, $bbPath;
  
  echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_A_FORUM_MANAGER.'</div>
            <br />
            <br />';
  
  ?>


<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="left">
<td><b><?php echo _MD_A_NAME;?></b></td>
<td><b><?php echo _MD_A_EDIT;?></b></td>
<td><b><?php echo _MD_A_ACCESS;?></b></td>
<td><b><?php echo _MD_A_DELETE;?></b></td>
<td><b><?php echo _MD_A_ADD;?></b></td>
<td><b><?php echo _MD_A_MOVE;?></b></td>
<td><b><?php echo _MD_A_ORDER;?></b></td>
</tr>
<?php
  $sql = "SELECT * FROM ".$bbTable['categories']." ORDER BY cat_order";
  $tbl_cat = $db->query($sql);
  for($iCat=0; $iCat<$db->num_rows($tbl_cat); $iCat++)
  {
		// Display the Category
		$cat_row = $db->fetch_object($tbl_cat);
		$cat_link = '<a href="'.$bbPath['url'].'index.php?viewcat='.$cat_row->cat_id.'">'.$cat_row->cat_title.'</a>';
		$cat_edit_link = '<a href="forum_manager.php?op=edit_cat&cat_id='.$cat_row->cat_id.'"><img src="'.$bbImage['editicon'].'"></a>';
		$cat_del_link = '<a href="forum_manager.php?op=del_cat&cat_id='.$cat_row->cat_id.'"><img src="'.$bbImage['delete'].'"></a>';
		$forum_add_link = '<a href="forum_manager.php?op=add_forum&cat_id='.$cat_row->cat_id.'"><img src="'.$bbImage['new_forum'].'"></a>';
		$cat_move_up_link = '';
		$cat_move_down_link = '';
		if ($iCat > 0)
			$cat_move_up_link = '<a href="forum_manager.php?op=cat_up&cat_id='.$cat_row->cat_id.'"><img src="'.$bbImage['up_white'].'"></a>';
		if ($iCat < ($db->num_rows($tbl_cat)-1) )
			$cat_move_down_link = '<a href="forum_manager.php?op=cat_down&cat_id='.$cat_row->cat_id.'"><img src="'.$bbImage['down_white'].'"></a>';

		echo '<tr class="bg4" align="left">';
		echo '<td width="100%"><b>'.$cat_link.'</b></td>';
		echo '<td align="center">'.$cat_edit_link.'</td>';
		echo '<td></td>';
		echo '<td align="center">'.$cat_del_link.'</td>';
		echo '<td align="center">'.$forum_add_link.'</td>';
		echo '<td></td>';
		echo '<td><table width="100%"><tr><td>'.$cat_move_up_link.'</td><td align=right>'.$cat_move_down_link.'</td></tr></table></td>';
		echo '</tr>';

		// Display the forums belonging to this category
		$sql = "SELECT * from ".$bbTable['forums']." WHERE parent_forum=0 AND cat_id=".$cat_row->cat_id." ORDER BY forum_order";
		$tbl_forums = $db->query($sql);
		for($iForum=0; $iForum<$db->num_rows($tbl_forums); $iForum++)
		{
			$f_row = $db->fetch_object($tbl_forums);

			$f_link = '<a href="'.$bbPath['url'].'viewforum.php?forum='.$f_row->forum_id.'">'.$f_row->forum_name.'</a>';
			$f_edit_link = '<a href="forum_manager.php?op=edit_forum&amp;forum_id='.$f_row->forum_id.'"><img src="'.$bbImage['editicon'].'"></a>';
			$f_auth_link = '<a href="forum_access.php?op=showform&amp;forum='.$f_row->forum_id.'"><img src="'.$bbImage['private'].'"></a>';
			$f_del_link = '<a href="forum_manager.php?op=del_forum&amp;forum_id='.$f_row->forum_id.'"><img src="'.$bbImage['delete'].'"></a>';
			$sf_add_link = '<a href="forum_manager.php?op=add_subforum&amp;cat_id='.$f_row->cat_id.'&parent_forum='.$f_row->forum_id.'"><img src="'.$bbImage['new_subforum'].'"></a>';
			$f_move_link =  '<a href="forum_manager.php?op=move_forum&amp;forum_id='.$f_row->forum_id.'"><img src="'.$bbImage['move'].'"></a>';
			$f_move_up_link = '';
			$f_move_down_link = '';

			if ($iForum > 0)
				$f_move_up_link = '<a href="forum_manager.php?op=forum_up&amp;forum_id='.$f_row->forum_id.'"><img src="'.$bbImage['up_blue'].'"></a>';
			if ($iForum < ($db->num_rows($tbl_forums)-1) )
				$f_move_down_link = '<a href="forum_manager.php?op=forum_down&amp;forum_id='.$f_row->forum_id.'"><img src="'.$bbImage['down_blue'].'"></a>';

			echo '<tr class="bg1" align="left">';
			echo '<td><b>'.$f_link.'</b></td>';
			echo '<td align="center">'.$f_edit_link.'</td>';
			echo '<td align="center">'.$f_auth_link.'</td>';
			echo '<td align="center">'.$f_del_link.'</td>';
			echo '<td align="center">'.$sf_add_link.'</td>';
			echo '<td align="center">'.$f_move_link.'</td>';
			echo '<td><table width="100%"><tr><td>'.$f_move_up_link.'</td><td align=right>'.$f_move_down_link.'</td></tr></table></td>';
			echo '</tr>';

			// Display sub forums of this forum
			$sql = "SELECT * from ".$bbTable['forums']." WHERE parent_forum=".$f_row->forum_id." AND cat_id=".$cat_row->cat_id." ORDER BY forum_order";
			$tbl_subforums = $db->query($sql);
			for($iSubForum=0; $iSubForum<$db->num_rows($tbl_subforums); $iSubForum++)
			{
				$sf_row = $db->fetch_object($tbl_subforums);
				$sf_link = '<a href="'.$bbPath['url'].'viewforum.php?forum='.$sf_row->forum_id.'">'.$sf_row->forum_name.'</a>';
				$sf_edit_link = '<a href="forum_manager.php?op=edit_forum&amp;forum_id='.$sf_row->forum_id.'"><img src="'.$bbImage['editicon'].'"></a>';
				$sf_auth_link = '<a href="forum_access.php?op=showform&amp;forum='.$sf_row->forum_id.'"><img src="'.$bbImage['private'].'"></a>';
				$sf_del_link = '<a href="forum_manager.php?op=del_forum&amp;forum_id='.$sf_row->forum_id.'"><img src="'.$bbImage['delete'].'"></a>';
				$sf_move_link =  '<a href="forum_manager.php?op=move_forum&amp;forum_id='.$sf_row->forum_id.'"><img src="'.$bbImage['move'].'"></a>';
				$sf_move_up_link = '';
				$sf_move_down_link = '';

				if ($iSubForum > 0)
					$sf_move_up_link = '<a href="forum_manager.php?op=forum_up&amp;forum_id='.$sf_row->forum_id.'"><img src="'.$bbImage['up_red'].'"></a>';
				if ($iSubForum < ($db->num_rows($tbl_subforums)-1) )
					$sf_move_down_link = '<a href="forum_manager.php?op=forum_down&amp;forum_id='.$sf_row->forum_id.'"><img src="'.$bbImage['down_red'].'"></a>';
	
				echo '<tr class="bg1" align="left">';
				echo '<td><b>-->&nbsp;'.$sf_link.'</b></td>';
				echo '<td align="center">'.$sf_edit_link.'</td>';
				echo '<td align="center">'.$sf_auth_link.'</td>';
				echo '<td align="center">'.$sf_del_link.'</td>';
				echo '<td align="center"></td>';
				echo '<td align="center">'.$sf_move_link.'</td>';
				echo '<td><table width="100%"><tr><td>'.$sf_move_up_link.'</td><td align=right>'.$sf_move_down_link.'</td></tr></table></td>';
				echo '</tr>';
			}
		}
  }

  echo "</table>";
  echo "</table>";
  echo "<br>";

  // Add Category Box
  echo '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">';
  echo '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
  echo '<tr class="bg1" align="left">';
  echo '<td><b>'._MD_A_ADD_CATEGORY.'</b></td>';
  echo '<td><form method="post" action="forum_manager.php">';
  echo '<input type="hidden" name="op" value="add_cat"><br />';
  echo '<input type="text" name="new_cat" size=40 class="text">&nbsp;&nbsp;';
  echo '<input type="submit" name="submit" value="'._MD_A_ADD.'" class="button">';
  echo '</form></td>';
  echo '</tr>';
  echo "</table>";
  echo "</table>";
  
  echo "                        
        </td>
    </tr>
</table>";

}

CloseTable();
rcx_cp_footer();
?>
