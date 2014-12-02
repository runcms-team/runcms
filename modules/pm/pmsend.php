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
include_once('../../header.php');
if ( isset($_GET['sort']) ) {
	$sort = $_GET['sort'];
	$by = $_GET['by'];
	} else {
		$sort = "msg_time";
		$by = "ASC";
	}
$pm_send =& PM::getAllPM(array("from_userid='".$rcxUser->getVar("uid")."'"), true, $sort, $by);
$total_pm_send = count($pm_send);   
OpenTable();
?>
<a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $rcxUser->getVar("uid");?>"><?php echo _PM_PROFILE;?></a>
<b>&raquo;&raquo;</b>
<?php
echo _PM_OUTBOX;
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<b>&raquo;&raquo;</b>";
echo "&nbsp;<a href='".RCX_URL."/modules/pm/'>"._PM_INBOX."</a>";
?><br /><br />
<table border="0" align="center" cellspacing="1" cellpadding="3" width="100%"><tr class="bg2">
<form name="prvmsg1" method="post" action="index.php">
<td class="bg2" width="2%" align="center">&nbsp;&nbsp;</td>
<td class="bg2" width="2%" align="center"><img src="images/arrow.gif" alt="" border="0" /></td>
<td class="bg2" width="2%" align="center"><img src="images/attachment.gif" alt="" border="0" /></td>
<td colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><?php echo _PM_TO;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=to_userid&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=to_userid&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><?php echo _PM_SUBJECT;?>:</b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=subject&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=subject&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
        </tr>
    </table>
</td>
<td align="center" width="1%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><b><b><?php echo _PM_DATE;?></b></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=msg_time&by=ASC"><img src="images/down.gif" alt="" border="0" width="16" height="18"></a></td>
          <td width="20"><a href="<?php echo RCX_URL;?>/modules/pm/pmsend.php?sort=msg_time&by=DESC"><img src="images/up.gif" alt="" border="0" width="16" height="18"></a></td>
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
<td colspan='7' align='left'>";
echo '</td></tr></form></table><br><br>';
CloseTable();
include_once('../../footer.php');
?>
