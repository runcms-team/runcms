<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function add_forum($cat_id, $parent_forum = 0)
{
  global $_POST, $db, $myts, $bbTable;
  
  if($_POST['submit'] == _SAVE)
  {
    if ( empty($_POST['name']) || empty($_POST['desc']) || !is_array($_POST['mods'])) {
      echo _MD_A_YDNFOATPOTFDYAA;
      CloseTable();
      rcx_cp_footer();
      exit();
    }

    $name         = $myts->makeTboxData4Save($_POST['name']);
    $desc         = $myts->makeTboxData4Save($_POST['desc']);
    $html         = intval($_POST['html']);
    $sig          = intval($_POST['sig']);
    $ppp          = intval($_POST['ppp']);
    $hot          = intval($_POST['hot']);
    $tpp          = intval($_POST['tpp']);
    $attach       = intval($_POST['attach']);
    $attach_maxkb = intval($_POST['attach_maxkb']);
    $attach_ext   = $myts->makeTboxData4Save($_POST['attach_ext']);
    $poll         = intval($_POST['poll']);
  
    $nextid = $db->genId($bbTable['forums']."_forum_id_seq");
    $sql    = "
      INSERT INTO ".$bbTable['forums']." SET
      forum_id=$nextid,
      forum_name='$name',
      forum_desc='$desc',
      cat_id=$cat_id,
      allow_html='$html',
      allow_sig='$sig',
      posts_per_page=$ppp,
      hot_threshold=$hot,
      topics_per_page=$tpp,
      allow_attachments=$attach,
      attach_maxkb=$attach_maxkb,
      attach_ext='$attach_ext',
      allow_polls=$poll,
      parent_forum=$parent_forum";
    
    if (!$result = $db->query($sql))
    {
      CloseTable();
      rcx_cp_footer();
      exit();
    }

    // If it's a subforum, increment the parents subforum_count
    if($parent_forum>0)
    {
      $sql = "UPDATE ".$bbTable['forums']." SET subforum_count=subforum_count+1 where forum_id=$parent_forum";
      $db->query($sql);
    }

    if ($nextid == 0) {
      $nextid = $db->insert_id();
    }
    
    $count = 0;
    while (list($mod_number, $mod) = each($_POST["mods"])) {
      $mod_data = new RcxUser($mod);

      if ($mod_data->isActive() && $mod_data->level() < 2) {
        if (!isset($user_query)) {
          $user_query = "UPDATE ".$db->prefix("users")." SET level=2 WHERE ";
        }
        if ($count > 0) {
          $user_query .= " OR";
          }
          $user_query .= " uid=$mod";
          $count++;
      }
      $mod_query = "INSERT INTO ".$bbTable['forum_mods']." SET forum_id=$nextid, user_id=$mod";
      if (!$db->query($mod_query)) {
        CloseTable();
        rcx_cp_footer();
        exit();
      }
    }
    if (isset($user_query)) {
      if (!$db->query($user_query)) {
        CloseTable();
        rcx_cp_footer();
        exit();
      }
    }
  redirect_header('./forum_manager.php?',2,_MD_A_MSG_FORUM_ADD);
  }
  else
  {
?>
<form action="./forum_manager.php" method="post">
<input type="hidden" name="op" value="add_subforum">
<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
<input type="hidden" name="parent_forum" value="<?php echo $parent_forum; ?>">
<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="95%"><tr>
<td class="bg2">
<table border="0" cellpadding="1" cellspacing="1" width="100%"><tr class="bg3">
<td align="center" colspan="2"><b><?php echo _MD_A_CREATENEWFORUM;?></b></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_FORUMNAME;?></td>
<td><input type="text" class="text" name="name" size="40" maxlength="150"></td>
</tr><tr class="bg1">
<td valign="top"><?php echo _MD_A_FORUMDESCRIPTION;?></td>
<td nowrap>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'desc', '', 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'desc', '');
echo $desc->render();
?>
</td>
</tr><tr class="bg1">
<td valign="top"><?php echo _MD_A_MODERATOR;?></td>
<td><select class="select" name="mods[]" size="5" multiple="multiple">
<?php
$sql = "SELECT uid, uname FROM ".$db->prefix("users")." WHERE uid != 0 AND level > 0 ORDER BY uname";
if (!$result = $db->query($sql)) {
    CloseTable();
    rcx_cp_footer();
    exit();
  }

if ($myrow = $db->fetch_array($result)) {
  do {
    echo "<option value='".$myrow['uid']."'>".$myrow['uname']."</option>";
  } while ($myrow = $db->fetch_array($result));
  } else {
    echo "<option value='0'>"._NONE."</option>";
  }
?>

</select></td>
</tr>
<tr class="bg1">
<td><?php echo _MD_A_ALLOWHTML;?></td>
<td><input type="radio" class="radio" name="html" value="1" /><?php echo _YES;?><input type="radio" name="html" value="0" checked="checked"  /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOWSIGNATURES;?></td>
<td><input type="radio" class="radio" name="sig" value="1" checked="checked" /><?php echo _YES;?><input type="radio" name="sig" value="0" /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_HOTTOPICTHRESHOLD;?></td><td><input type="text" class="text" name="hot" size="3" maxlength="3" value="10" /></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_POSTPERPAGE;?><br /><i><?php echo _MD_A_TITNOPPTTWBDPPOT;?></i></td>
<td><input type="text" class="text" name="ppp" size="3" maxlength="3" value="10" /></td></tr>
<tr class="bg1"><td><?php echo _MD_A_TOPICPERFORUM;?><br /><i><?php echo _MD_A_TITNOTPFTWBDPPOAF;?></i></td><td><input type="text" class="text" name="tpp" size="3" maxlength="3" value="20" /></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOW_ATTACHMENTS;?></td>
<td><input type="radio" class="radio" name="attach" value="1" /><?php echo _YES;?><input type="radio" name="attach" value="0" checked="checked"  /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ATTACHMENT_SIZE;?></td>
<td><input type="text" class="text" name="attach_maxkb" value=""/></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOWED_EXTENSIONS;?></td>
<td><input type="text" class="text" name="attach_ext" value=""/><br><?php echo _MD_A_EXTENSIONS_DELIMITED_BY;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOW_POLL;?></td>
<td><input type="radio" class="radio" name="poll" value="1" /><?php echo _YES;?><input type="radio" name="poll" value="0" checked="checked"  /><?php echo _NO;?></td>
</tr><tr class="bg3">
<td align="center" colspan="2">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" />
</td>
</tr></table></td></tr></table>
<?php
  }
}

function delete_forum($forum_id, $bCommit=false)
{
  global $db, $bbTable, $_POST;

  if ($_POST['confirm_delete'] == _YES || $bCommit)
  {
    $sql = "SELECT * from ".$bbTable['forums']." WHERE forum_id=$forum_id";
    $res = $db->query($sql);
    $row = $db->fetch_array($res);
    if($row['parent_forum'] > 0)
    {
      $sql = "UPDATE ".$bbTable['forums']." SET subforum_count=subforum_count-1 where forum_id=".$row['parent_forum'];
      $db->query($sql);
    }

    $sql = "DELETE FROM ".$bbTable['forums']." WHERE forum_id=$forum_id OR parent_forum=$forum_id";
    if($db->query($sql))
    {
        // Ok, thats the forum deleted! Now need to clean up the other tables
      $sql = "DELETE FROM ".$bbTable['forum_access']." WHERE forum_id=$forum_id";
      $db->query($sql);
      $sql = "DELETE FROM ".$bbTable['forum_group_access']." WHERE forum_id=$forum_id";
      $db->query($sql);
      $sql = "DELETE FROM ".$bbTable['forum_mods']." WHERE forum_id=$forum_id";
      $db->query($sql);
      $sql = "DELETE FROM ".$bbTable['posts']." WHERE forum_id=$forum_id";
      $db->query($sql);
      $sql = "DELETE FROM ".$bbTable['topics']." WHERE forum_id=$forum_id";
      $db->query($sql);
    
        if (!$bCommit)
        redirect_header('./forum_manager.php?',2,_MD_A_MSG_FORUM_DEL);
    }
    else
    {
    redirect_header('./forum_manager.php?',2,_MD_A_MSG_ERR_FORUM_DEL);
    }
  }
  else if ($_POST['confirm_delete'] == _NO)
  {
      redirect_header('./forum_manager.php?',0,_MD_A_MSG_RETURN_TO_FM);
  }
  else
  {
  $forum_name = '';
  $sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id=$forum_id";
  if($result = $db->query($sql))
  {
    if($row = $db->fetch_object($result))
  {
    $forum_name = $row->forum_name;
  }
  }
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg1" align="center">
<td><b><?php echo _MD_A_DELETEFORUM.'&nbsp;'.$forum_name; ?></b></td>
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
<td><b><font color='#FF0000' size='+1'><?php echo _MD_A_WARNING_DEL_FORUM; ?></font></b></td>
</tr>
<tr class="bg1" align="center">
<td>
<form method="post" action="forum_manager.php">
<input type='hidden' name='op' value='del_forum'>
<input type='hidden' name='forum_id' value='<?php echo $forum_id;?>'>
<input type='submit' name='confirm_delete' value='<?php echo _YES;?>' class='button'>
<input type='submit' name='confirm_delete' value='<?php echo _NO;?>' class='button'>
</td>
</tr>
</form>
<?php
  }
}

function move_forum_up($forum_id)
{
  global $db, $bbTable;

  $sql = "UPDATE ".$bbTable['forums']." SET forum_order=forum_order-1 WHERE forum_id=$forum_id";
  if($db->query($sql))
    redirect_header('forum_manager.php', 2, _MD_A_MSG_FORUM_MOVED);
  else
    redirect_header('forum_manager.php', 2, _MD_A_MSG_ERR_FORUM_MOVED);
}

function move_forum_down($forum_id)
{
  global $db, $bbTable;

  $sql = "UPDATE ".$bbTable['forums']." SET forum_order=forum_order+1 WHERE forum_id=$forum_id";
  if($db->query($sql))
    redirect_header('forum_manager.php', 2, _MD_A_MSG_FORUM_MOVED);
  else
    redirect_header('forum_manager.php', 2, _MD_A_MSG_ERR_FORUM_MOVED);
}

function edit_forum($forum_id)
{
  global $db, $bbTable, $myts, $_POST;

  if($_POST['submit'] == _SAVE)
  {
    $name         = $myts->makeTboxData4Save($_POST['name']);
    $desc         = $myts->makeTboxData4Save($_POST['desc']);
    $html         = intval($_POST['html']);
    $sig          = intval($_POST['sig']);
    $ppp          = intval($_POST['ppp']);
    $hot          = intval($_POST['hot']);
    $tpp          = intval($_POST['tpp']);
    $attach       = intval($_POST['attach']);
    $attach_maxkb = intval($_POST['attach_maxkb']);
    $attach_ext   = $myts->makeTboxData4Save($_POST['attach_ext']);
    $poll         = intval($_POST['poll']);

    $sql = "
      UPDATE
      ".$bbTable['forums']."
      SET
      forum_name='$name',
      forum_desc='$desc',
      allow_html='$html',
      allow_sig='$sig',
      posts_per_page='$ppp',
      hot_threshold='$hot',
      topics_per_page='$tpp',
      allow_attachments = '$attach',
      attach_maxkb = '$attach_maxkb',
      attach_ext = '$attach_ext',
      allow_polls = '$poll'
      WHERE
      forum_id=$forum_id";

    if (!$r = $db->query($sql))
    {
      CloseTable();
      rcx_cp_footer();
      exit();
    }

    $count = 0;
    if ( isset($_POST["mods"]) ) {
      while (list($null, $mod) = each($_POST["mods"])) {
        $mod_data = new RcxUser($mod);
        if ($mod_data->isActive()) {
          $mod_query = "INSERT INTO ".$bbTable['forum_mods']." SET forum_id=$forum_id, user_id=$mod";
          if (!$db->query($mod_query)) {
            CloseTable();
            rcx_cp_footer();
            exit();
          }
        }
      }
    }

  if ( !isset($_POST["mods"]) ) {
    $current_mods = "SELECT count(*) AS total FROM ".$bbTable['forum_mods']." WHERE forum_id=$forum_id";
    $r = $db->query($current_mods);
    list($total) = $db->fetch_row($r);
    } else {
      $total = count($_POST["mods"]);
    }

  if ( isset($_POST["rem_mods"]) && ($total != count($_POST["rem_mods"])) ) {
    while (list($null, $mod) = each($_POST["rem_mods"])) {
      $rem_query = "DELETE FROM ".$bbTable['forum_mods']." WHERE forum_id=$forum_id AND user_id=$mod";
      if (!$db->query($rem_query)) {
        CloseTable();
        rcx_cp_footer();
        exit();
      }
    }
    } else {
      if ( isset($_POST["rem_mods"]) ) {
        $mod_not_removed = 1;
        }
  }

  redirect_header('./forum_manager.php',2,_MD_A_MSG_FORUM_UPDATED);

  }
  else
  {
  $sql   = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id=$forum_id";
  if (!$result = $db->query($sql))
  {
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  if (!$myrow = $db->fetch_array($result))
  {
    echo _MD_A_NOSUCHFORUM;
  }
  $name = $myts->makeTboxData4Edit($myrow['forum_name']);
  $desc = $myts->makeTboxData4Edit($myrow['forum_desc']);
?>

<form action="./forum_manager.php" method="post">
<input type="hidden" name="op" value="edit_forum" />
<input type="hidden" name="forum_id" value="<?php echo $forum_id;?>" />
<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="95%"><tr>
<td class="bg2">
<table border="0" cellpadding="1" cellspacing="1" width="100%"><tr class="bg3">
<td align="center" colspan="2"><b><?php echo _MD_A_EDITTHISFORUM;?></b></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_FORUMNAME;?></td>
<td><input type="text" class="text" name="name" size="40" maxlength="150" value="<?php echo $name?>"></td>
</tr><tr class="bg1">
<td valign="top"><?php echo _MD_A_FORUMDESCRIPTION;?></td>
<td nowrap>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'desc', $desc, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'desc', $desc);
echo $desc->render();
?>
</td>
</tr><tr class="bg1">
<td valign="top"><?php echo _MD_A_MODERATOR;?></td>
<td><b><?php echo _MD_A_MODERATORCURRENT;?></b><br />

<?php
$sql = "
  SELECT
  u.uname,
  u.uid
  FROM
  ".$db->prefix("users")." u,
  ".$bbTable['forum_mods']." f
  WHERE
  f.forum_id=$forum_id
  AND
  u.uid=f.user_id";

if (!$r = $db->query($sql))
{
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ($row = $db->fetch_array($r)) {
  do {
    echo $row['uname']." (<input type='checkbox' class='checkbox' name='rem_mods[]' value='".$row['uid']."'> "._MD_A_REMOVE.")<br />";
    $current_mods[] = $row['uid'];
    } while ($row = $db->fetch_array($r));
  echo "<br />";
  } else {
    echo _MD_A_NOMODERATORASSIGNED."<br /><br />";
  }
?>

<b><?php echo _MD_A_MODERATORASSIGNEDADD;?></b><br />

<select class="select" name="mods[]" size="5" multiple>
<?php

$sql = "SELECT uid, uname FROM ".$db->prefix("users")." WHERE uid != 0 AND level > 0 ";

while (list($null, $currMod) = each($current_mods)) {
$sql .= "AND uid != $currMod ";
}

$sql .= "ORDER BY uname";

if (!$r = $db->query($sql)) {
  CloseTable();
  rcx_cp_footer();
  exit();
}

while (list($uid, $uname) = $db->fetch_row($r)) {
  echo "<option value='".$uid."'>".$uname."</option>";
}
?>

</select></td>
</tr>
<?php
$html_yes = $html_no = $sig_yes = $sig_no = "";
$attach_yes = $attach_no = $poll_yes = $poll_no = "";
if ( $myrow['allow_html'] == 1 ) {
  $html_yes = "checked='checked'";
  } else {
    $html_no = "checked='checked'";
  }

if ( $myrow['allow_sig'] == 1) {
  $sig_yes = "checked='checked'";
  } else {
    $sig_no = "checked='checked'";
  }

if ( $myrow['allow_attachments'] == 1 ) {
  $attach_yes = "checked='checked'";
  } else {
    $attach_no = "checked='checked'";
  }

if ( $myrow['allow_polls'] == 1) {
  $poll_yes = "checked='checked'";
  } else {
    $poll_no = "checked='checked'";
  }
?>

<tr class="bg1">
<td><?php echo _MD_A_ALLOWHTML;?></td>
<td><input type="radio" class="radio" name="html" value="1" <?php echo $html_yes;?> /><?php echo _YES;?><input type="radio" name="html" value="0" <?php echo $html_no;?> /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOWSIGNATURES;?></td>
<td><input type="radio" class="radio" name="sig" value="1" <?php echo $sig_yes;?> /><?php echo _YES;?><input type="radio" name="sig" value="0" <?php echo $sig_no;?> /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_HOTTOPICTHRESHOLD;?></td>
<td><input type="text" class="text" name="hot" size="3" maxlength="3" value="<?php echo $myrow["hot_threshold"];?>" /></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_POSTPERPAGE;?><br /><i><?php echo _MD_A_TITNOPPTTWBDPPOT;?></i></td>
<td><input type="text" class="text" name="ppp" size="3" maxlength="3" value="<?php echo $myrow["posts_per_page"];?>" /></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_TOPICPERFORUM;?><br /><i><?php echo _MD_A_TITNOTPFTWBDPPOAF;?></i></td>
<td><input type="text" class="text" name="tpp" size="3" maxlength="3" value="<?php echo $myrow["topics_per_page"];?>" /></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOW_ATTACHMENTS;?></td>
<td><input type="radio" class="radio" name="attach" value="1" <?php echo $attach_yes;?> /><?php echo _YES;?><input type="radio" name="attach" value="0" <?php echo $attach_no;?> /><?php echo _NO;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ATTACHMENT_SIZE;?></td>
<td><input type="text" class="text" name="attach_maxkb" value="<?php echo $myrow["attach_maxkb"];?>"/></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOWED_EXTENSIONS;?></td>
<td><input type="text" class="text" name="attach_ext" value="<?php echo $myrow["attach_ext"];?>"/><br><?php echo _MD_A_EXTENSIONS_DELIMITED_BY;?></td>
</tr><tr class="bg1">
<td><?php echo _MD_A_ALLOW_POLL;?></td>
<td><input type="radio" class="radio" name="poll" value="1" <?php echo $poll_yes;?> /><?php echo _YES;?><input type="radio" name="poll" value="0" <?php echo $poll_no;?> /><?php echo _NO;?></td>
</tr><tr class="bg3">
<td align="center" colspan="2">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" />
<input type="reset" class="button" value="<?php echo _MD_A_CLEAR;?>" />
</td>
</tr></tr></table></td></tr></table>
</form>
<?php

  }
}

function move_forum($forum_id)
{
  global $db, $bbTable, $myts, $_POST;

  if($_POST['save'] == _SAVE)
  {
    $bMoved = 0;
    $errString = '';
    // Look for subforums
    $sql = "SELECT * from ".$bbTable['forums']." WHERE parent_forum=$forum_id";
    if ($result = $db->query($sql))
    {
      if ($db->num_rows($result) == 0)
      {
        $sql_move = "UPDATE ".$bbTable['forums']." SET cat_id=".$_POST['cat_id'].", parent_forum=".$_POST['parent_forum']." WHERE forum_id=$forum_id";
        if($db->query($sql_move))
          $bMoved = 1;
      }
      else
      {
        // Are we trying to move this
        if ($_POST['parent_forum'] != 0)
        {
          $errString = "This forum cannot be made as a subforum.<br>Multi-level subforums are not allowed.";
        }
        else
        {
          $sql_move = "UPDATE ".$bbTable['forums']." SET cat_id=".$_POST['cat_id'].", parent_forum=".$_POST['parent_forum']." WHERE forum_id=$forum_id";
          if($db->query($sql_move))
          {
            $bMoved = 1;
            while($row = $db->fetch_object($result))
            {
              $sql_move_sub = "UPDATE ".$bbTable['forums']." SET cat_id=".$_POST['cat_id']." WHERE forum_id=".$row->forum_id;
              $db->query($sql_move_sub);
            }
          }
        }
      }
    }

    $sql = "UPDATE ".$bbTable['forums']." SET cat_id=".$_POST['cat_id'].", parent_forum=".$_POST['parent_forum']." WHERE forum_id=$forum_id";
    if (!$bMoved)
    {
      redirect_header('./forum_manager.php',2,_MD_A_MSG_ERR_FORUM_MOVED.'<br>'.$errString);
    }
    else
    {
      redirect_header('./forum_manager.php',2,_MD_A_MSG_FORUM_MOVED);
    }
    die();
  }
  else
  {
  $sql   = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id=$forum_id";
  if (!$result = $db->query($sql))
  {
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  if (!$myrow = $db->fetch_array($result))
  {
    echo _MD_A_NOSUCHFORUM;
  }
  $name = $myts->makeTboxData4Edit($myrow['forum_name']);
  $desc = $myts->makeTboxData4Edit($myrow['forum_desc']);

  $sql = "select * from ".$bbTable['categories'];
  $cat_list="<select name=\"cat_id\" onchange='document.forummove.submit();'>";
  $cat_list.='<option value="0">'._MD_A_SELECT.'</option>';
  if (!$result = $db->query($sql))
  {
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  while ($row = $db->fetch_object($result))
  {
    $selected = '';
    if (isset($_POST['cat_id']) && $_POST['cat_id'] == $row->cat_id) $selected = 'selected';
    $cat_list .= "<option value='".$row->cat_id."' $selected>".$row->cat_title."</option>";
  }
  $cat_list.='</select>';

  $sf_list='<select name="parent_forum">';
  $sf_list.='<option value="0" selected>'._MD_A_SELECT.'</option>';
  $sf_list.='<option value="0">'._NONE.'</option>';
  if(isset($_POST['cat_id']))
  {
    $sql = "SELECT * FROM ".$bbTable['forums']." WHERE cat_id=".$_POST['cat_id']." AND forum_id!=$forum_id";
    if ($result = $db->query($sql))
    while ($row = $db->fetch_object($result))
    {
      $sf_list .= "<option value='".$row->forum_id."'>".$row->forum_name."</option>";
    }
  }
  $sf_list.='</select>';

?>

<form action="./forum_manager.php" method="post" name="forummove" id="forummove">
<input type="hidden" name="op" value="move_forum" />
<input type="hidden" name="forum_id" value="<?php echo $forum_id;?>" /><br />
<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="75%"><tr>
<td class="bg2">
<table border="0" cellpadding="1" cellspacing="1" width="100%"><tr class="bg3">
<td align="center" colspan="2"><div class='KPmellem' />
<b><?php echo _MD_A_MOVETHISFORUM;?></b><br /><br /></td>
</tr>
<tr><td class="bg1"><?php echo _MD_A_MOVE2CAT; ?></td><td class="bg1"><?php echo $cat_list;?></td></tr>
<tr><td class="bg1"><?php echo _MD_A_MAKE_SUBFORUM_OF; ?></td><td class="bg1"><?php echo $sf_list;?></td></tr>
<tr><td colspan="2" align="center" class="bg1"><br /><center><input type="submit" name="save" value="<?php echo _SAVE;?>" class="button"></center><br /></td></tr>
</form>
<?php
  }
}
?>
