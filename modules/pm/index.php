<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('header.php');
include_once('class/pm.class.php');
include_once('cache/config.php');

if (!$rcxUser) {
      header("Location:".RCX_URL."/whyregister.php");

exit();
}

// delete massages----------------------------------------- //

if ( !empty($_POST['delete_pm']) ) {
  $size = count($_POST['msg_id']);
  $msg  = $_POST['msg_id'];
  for ($i=0; $i<$size; $i++) {
    $pm = new PM($msg[$i]);
    if ($pm->getVar('to_userid') == $rcxUser->getVar('uid')) {
      $pm->delete();
    }
  }
redirect_header('index.php', 1, _PM_DELETED);
exit();
}

$sql = "SELECT msg_showsend FROM ".$db->prefix("pm_msgs_config")." WHERE msg_uid=".$rcxUser->getVar('uid')."";
$result = $db->query($sql);
while ( $myrow = $db->fetch_array($result) ) {
    $showsend[0] = $myrow['msg_showsend'];
    }
include_once('../../header.php');

if ( isset($_GET['sort']) ) {
  $sort = $_GET['sort'];
  $by = $_GET['by'];
  } else {
    $sort = "msg_time";
    $by = "ASC";
  }

$pm_arr =& PM::getAllPM(array("to_userid='".$rcxUser->getVar("uid")."'"), true, $sort, $by);
$total_pm = count($pm_arr);
//**********************

$max_pms        = intval($pmConfig['max_pms']);
if (!empty($total_pm)) {
  $percent = empty($max_pms) ? 0 : round(($total_pm/$max_pms) * 100);
  } else {
    $percent = 0;
  }

if ( !empty($pmConfig['max_pms']) && ($total_pm >= intval($pmConfig['max_pms'])) ) {
  $full=1;
}
//************************
OpenTable();
?>
<table align="right"><tr>
<td width="150"><span style="font-size: xx-small"><?php echo _PM_USAGE;?>: <?php echo sprintf("%d %%", $percent);?></span></td>
</tr><tr>
<td class="bg2" width="150"><img src="<?php echo RCX_URL;?>/images/pm_bg.gif" height="10" width="<?php echo $percent;?>%" /></td>
<?php
if ($full == 1) {
echo "</tr><tr><td><font color='#FF0000'<b>"._PM_FULL1."</b></font></td>";
}
?>
</tr></table>
<h4><?php echo _MI_PMS_NAME;?></h4>
<a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $rcxUser->getVar("uid");?>"><?php echo _PM_PROFILE;?></a>
<b>&raquo;&raquo;</b>
<?php
echo _PM_INBOX;
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if ($showsend[0] == 1) {
  echo "<b>&raquo;&raquo;</b>";
    echo "&nbsp;<a href='".RCX_URL."/modules/pm/pmsend.php'>"._PM_OUTBOX."</a>";
}
?>
<br /><br />
<form method="post" name="config" action="conf.php"><input type="submit" class="button" value="<?php echo _PM_CONFIG; ?>"></form>
<table border="0" align="center" cellspacing="1" cellpadding="2" width="100%"><tr class="bg2">
<form name="prvmsg" method="post" action="index.php">
<td class="bg2" width="2%" align="center"><input name="allbox" id="allbox" onclick="rcxCheckAll('prvmsg', 'allbox');" type="checkbox" class="checkbox" value="<?php echo _ALL;?>" /></td>
<td class="bg2" width="2%" align="center"><img src="images/arrow.gif" alt="" border="0" /></td>
<td class="bg2" width="2%" align="center"><img src="images/attachment.gif" alt="" border="0" /></td>
<td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><?php echo _PM_FROM;?>:</b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=from_userid&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=from_userid&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><b><?php echo _PM_SUBJECT;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=subject&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=subject&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td align="center" width="1%">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><b><?php echo _PM_DATE;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=msg_time&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=msg_time&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
</tr>
<?php
if ($total_pm == 0) {
  echo "<tr><td class='bg3' colspan='7' align='center'>"._PM_YOUDONTHAVE."</td></tr>";
  $display = 0;
  } else {
    $display = 1;
  }
$count = 0;
foreach ($pm_arr as $pm_ele) {
  echo "<tr align='left'><td class='bg1' valign='middle' align='center' width='2%'><input type='checkbox' class='checkbox' id='msg_id[]' name='msg_id[]' value='".$pm_ele->getVar("msg_id")."' /></td>";
  if ($pm_ele->getVar("msg_replay") == "1" and $pm_ele->getVar("read_msg") == "1") {
    echo "<td valign='middle' align='center' class='bg1' width='2%'><img src='images/mail_replay.gif' alt='"._PM_READREPLAY."' border='0' /></td>";
    }
    elseif ($pm_ele->getVar("read_msg") == "1") {
        echo "<td valign='middle' align='center' class='bg1' width='2%'><img src='images/mail_read.gif' alt='"._PM_READ."' border='0' /></td>";
        }
     else {
      echo "<td valign='middle' align='center' class='bg1' width='2%'><img src='images/mail.gif' alt='"._PM_NOTREAD."' border='0' /></td>";
    }
  if ($pm_ele->getVar("msg_attachment")) {
      echo "<td valign='middle' class='bg1' align'center' width='2%'><div align='center'><img src='images/anlage.gif' alt='"._PM_UPLOAD."' border='0' /></div></td>";
  } else {
    echo "<td valign='middle' class='bg1' align'center' width='2%'>&nbsp;</td>";
  }
  echo "<td class='bg3' valign='middle' align='center' width='2%'><img src='".RCX_URL."/images/subject/".$pm_ele->getVar("msg_image", "E")."' alt='' border='0' /></td>";
    $postername = RcxUser::getUnameFromId($pm_ele->getVar("from_userid"));
  echo "<td class='bg1' valign='middle' nowrap>";
  // no need to show deleted users
  if ($postername) {
    echo "<a href='".RCX_URL."/userinfo.php?uid=".$pm_ele->getVar("from_userid")."'>".$postername."</a>";
    } else {
      echo $rcxConfig['anonymous'];
    }
  echo "</td>";
  echo "<td class='bg3' valign='middle'><a href='read.php?start=$count&amp;total_pm=$total_pm&amp;sort=$sort&amp;by=$by'>".$pm_ele->getVar("subject")."</a></td>";
  echo "<td class='bg1' valign='middle' align='center' nowrap>".formatTimestamp($pm_ele->getVar("msg_time"), 'm')."</td></tr>";
$count++;
}
echo "<tr class='bg2' align='left'>";
echo "<td colspan='7' align='left'>";
echo "<table  border='0'><tr>";
if ($display == 1) {
  echo "<td  width='100' valign='top'>";
  echo "<input type='hidden' name='delete_pm' value='1' />";
  echo "<input type='image' class='image' src='".RCX_URL."/images/icons/delete.gif' name='submit' alt='"._DELETE."' /></td>";
}
echo "</form>";
if ($full != 1) {
  echo "<td valign='top'>";
  echo "<form name='send' method='post' action='pmlite.php'>";
  echo _PM_SENDPM;
  echo "<select class='select' name='to_userid'>";
  $result = $db->query("SELECT uid, uname FROM ".$db->prefix("users")." WHERE level > 0 ORDER BY uname");
    while ( list($ftouid, $ftouname) = $db->fetch_row($result) ) {
      echo "<option value='".$ftouid."'>".$myts->makeTboxData4Show($ftouname)."</option>";
    } 
  echo "</select></td><td valign='top'>
  <input type='hidden' name='send' value='1' />
  <input type='hidden' name='allow_bbcode' value='1' />
  <input type='hidden' name='allow_smileys' value='1' />
  <input type='image' class='image' src='".RCX_URL."/images/icons/pm.gif' name='submit' alt='"._SEND."' /></td></form>";
}
echo "</tr></table>";
echo "</td></tr></table><br><br>";
//*************************************************************+
if ($showsend[0] == 0) {
$pm_send =& PM::getAllPM(array("from_userid='".$rcxUser->getVar("uid")."'"), true, $sort, $by);
$total_pm_send = count($pm_send);   
?>
<a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $rcxUser->getVar("uid");?>"><?php echo _PM_PROFILE;?></a>
<b>&raquo;&raquo;</b>
<?php echo _PM_OUTBOX;?><br /><br />
<table border="0" align="center" cellspacing="1" cellpadding="3" width="100%"><tr class="bg2">
<form name="prvmsg1" method="post" action="index.php">
<td class="bg2" width="2%" align="center">&nbsp;&nbsp;</td>
<td class="bg2" width="2%" align="center"><img src="images/arrow.gif" alt="" border="0" /></td>
<td class="bg2" width="2%" align="center"><img src="images/attachment.gif" alt="" border="0" /></td>
<td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><?php echo _PM_TO;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=to_userid&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=to_userid&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><?php echo _PM_SUBJECT;?>:</b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=subject&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=subject&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td align="center" width="1%">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><b><?php echo _PM_DATE;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=msg_time&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/index.php?sort=msg_time&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
</tr>
<?php
if ($total_pm_send == 0) {
  echo "<tr><td class='bg3' colspan='7' align='center'>"._PM_YOUDONTHAVE1."</td></tr>";
  $display = 0;
  } else {
    $display = 1;
  }
$count = 0;
foreach ($pm_send as $pm_ele) {
  echo "<tr align='left'><td class='bg1' valign='top' align='center' width='2%'>&nbsp;</td>";
  if ( $pm_ele->getVar("read_msg") == "1" ) {
    echo "<td valign='middle' align='center' class='bg1' width='2%'><img src='images/mail_read.gif' alt='"._PM_READ."' border='0' /></td>";
    } else {
      echo "<td valign='middle' align='center' class='bg1' width='2%'><img src='images/mail.gif' alt='"._PM_NOTREAD."' border='0' /></td>";
    }
  if ($pm_ele->getVar("msg_attachment")) {
      echo "<td valign='middle' class='bg1' align'center' width='2%'><div align='center'><img src='images/anlage.gif' alt='"._PM_UPLOAD."' border='0' /></div></td>";
  } else {
    echo "<td valign='middle' class='bg1' align'center' width='2%'>&nbsp;</td>";
  }
  echo "<td class='bg3' valign='middle' align='center' width='2%'><img src='".RCX_URL."/images/subject/".$pm_ele->getVar("msg_image", "E")."' alt='' border='0' /></td>";
  $postername = RcxUser::getUnameFromId($pm_ele->getVar("to_userid"));
  echo "<td class='bg1' valign='middle' nowrap>";

  // no need to show deleted users
  if ($postername) {
    echo "<a href='".RCX_URL."/userinfo.php?uid=".$pm_ele->getVar("to_userid")."'>".$postername."</a>";
    } else {
      echo $rcxConfig['anonymous'];
    }
  echo "</td>";
  echo "<td class='bg3' valign='middle'><a href='readsend.php?start=$count&amp;total_pm=$total_pm_send&amp;sort=$sort&amp;by=$by'>".$pm_ele->getVar("subject")."</a></td>";
  echo "<td class='bg1' valign='middle' align='center' nowrap>".formatTimestamp($pm_ele->getVar("msg_time"), 'm')."</td></tr>";
$count++;
}
echo "
<tr class='bg2' align='left'>
<td colspan='7' align='left'>
</td></tr></form></table><br><br>";
} 
CloseTable();
include_once('../../footer.php');
?>
