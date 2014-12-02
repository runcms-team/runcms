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

if ( !empty($_POST['delete']) ) {
	$pm = new PM(intval($_POST['msg_id']));
	if ($pm->getVar('to_userid') == $rcxUser->getVar('uid')) {
		$pm->delete();
		redirect_header('index.php', 1, _PM_DELETED);
		exit();
	}
}

$start          = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$total_pm = !empty($_GET['total_pm']) ? intval($_GET['total_pm']) : 0;
$sort 			= $myts->oopsAddSlashesGPC(preg_replace("/[^a-z_]/i", "", $_GET['sort']));
$by 			= $myts->oopsAddSlashesGPC(preg_replace("/[^a-z_]/i", "", $_GET['by']));
$pm_arr         =& PM::getAllPM(array("to_userid=".$rcxUser->getVar("uid").""), true, $sort, $by, 1, $start);
include_once('../../header.php');
OpenTable();
?>
<h4><?php echo _PM_PRIVATEMESSAGE;?></h4>
<br /><a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $rcxUser->getVar("uid");?>"><?php echo _PM_PROFILE;?></a>
<b>&raquo;&raquo;</b>
<a href="index.php"><?php echo _PM_INBOX;?></a>
<b>&raquo;&raquo;</b>
<?php echo _PM_PRIVATEMESSAGE;?>
<br /><br />
<table border="0" cellpadding="1" cellpadding="2"  width="100%"><tr class="bg2">
<td colspan="2" align="left"><b><?php echo _PM_FROM;?>:</b></td>
</tr>
<?php
if ( empty($pm_arr) ) {
	echo "<tr><td class='bg3' colspan='2' align='center'>"._PM_YOUDONTHAVE."</td></tr>";
	} else {
		$pm_arr[0]->setRead();
		$allow_html = $rcxConfig['allow_html'] ? 1 : 0;
		$pm_arr[0]->setVar('allow_html', $allow_html);
		$pm_arr[0]->setVar('allow_smileys', 1);
		$pm_arr[0]->setVar('allow_bbcode', 1);

		echo "<tr class='bg3' align='left'>";
		$poster = new RcxUser($pm_arr[0]->getVar("from_userid"));
		if ( !$poster->isActive() ) {
			$poster = false;
		}
		echo "<td class='bg2' valign='top' width='1%' nowrap>";
		if ($poster != false) {
			echo "<b>".$poster->getVar("uname")."</b><br />";
			$userrank = $poster->rank();
			if ( $userrank['image'] ) {
				echo "<img src='".RCX_URL."/images/ranks/".$userrank['image']."' alt='".$userrank['title']."' /><br />";
			}
			if ( $poster->getVar("user_avatar") != "" ) {
				echo "<img src='".RCX_URL."/images/avatar/".$poster->getVar("user_avatar")."' alt='' /><br />";
			}
			if ( $poster->getVar("user_from") != "" ) {
				echo _PM_FROMC."".$poster->getVar("user_from")."<br /><br />";
			}
			if ( $poster->isOnline() ) {
				echo "<span style='color:#ee0000;font-weight:bold;'>"._ONLINE."</span><br /><br />";
			}
			} else {
				echo $rcxConfig['anonymous']; // we need to do this for deleted users
			}
		echo "
		</td><td>
		<img src='".RCX_URL."/images/subject/".$pm_arr[0]->getVar("msg_image", "E")."' alt='' />
		"._PM_SENTC."".formatTimestamp($pm_arr[0]->getVar("msg_time"), 'm')."
		<hr /><b>".$pm_arr[0]->getVar("subject")."</b>
		<br /><br />".$pm_arr[0]->getVar("msg_text")."<br /><hr />";
		//***************************
		$file = $pm_arr[0]->getVar("msg_attachment");
		if ($file != '')
{
	$file_csv = explode("|",$file);
	echo "<size='1' noshade='noshade'>";
	echo "<b>"._PM_UPLOAD."<br><br></b>";

	// If it's an image... display it!
	$info = pathinfo(RCX_URL.'/modules/pm/cache/files/'.$file_csv[1]);
	if($info && ($info["extension"] == 'gif' || $info["extension"] == 'jpg' || $info["extension"] == 'png' || $info["extension"] == 'jpeg'))
	{
		echo '<br><img src="'.RCX_URL.'/modules/pm/cache/files/'.$file_csv[1].'" alt="" border="0"><br><br>';	
	}

	// Download Link
	echo "<img src=".RCX_URL."/modules/pm/images/attachment.gif> <b><a href=".RCX_URL."/modules/pm/cache/files/".$file_csv[1].">".$file_csv[0]."</a></b> " ;	
	echo "<i>"._PM_FILESIZE." ".$file_csv[2]." ". _BYTES."</i>";
	echo "<br><br>";
}
		//***************************

		if ( $poster != false ) {
			echo "<a href='".RCX_URL."/userinfo.php?uid=".$poster->getVar("uid")."'><img src='".RCX_URL."/images/icons/profile.gif' alt='"._PM_PROFILE."' /></a>";
			if ( $poster->getVar("user_viewemail") == 1 ) {
				echo "<a href='mailto:".$poster->getVar("email", "E")."'><img src='".RCX_URL."/images/icons/email.gif' alt='";
				printf(_PM_SENDEMAIL, $poster->getVar("uname"));
				echo "' /></a>";
			}
			$posterurl = $poster->getVar("url");
			if ( $posterurl != "" ) {
				echo "<a href='".$posterurl."' target='_blank'><img src='".RCX_URL."/images/icons/www.gif' alt='www' /></a>\n";
			}
			if ( $poster->getVar("user_icq") != "" ) {
				echo "<a href='http://wwp.icq.com/scripts/search.dll?to=".$poster->getVar("user_icq", "E")."'><img src='".RCX_URL."/images/icons/icq_add.gif' alt='"._PM_ADDTOLIST."' /></a>";
			}
			if ( $poster->getVar("user_aim") != "" ) {
				echo "<a href='aim:goim?screenname=".$poster->getVar("user_aim", "E")."&amp;message=Hi+".$poster->getVar("user_aim", "E")."+Are+you+there?'><img src='".RCX_URL."/images/icons/aim.gif' alt='aim' /></a>";
			}
			if ( $poster->getVar("user_yim") != "" ) {
				echo "<a href='http://edit.yahoo.com/config/send_webmesg?.target=".$poster->getVar("user_yim","E")."&.src=pg'><img src='".RCX_URL."/images/icons/yim.gif' alt='yim' /></a>";
			}
			if ( $poster->getVar("user_msnm") != "" ) {
				echo "<a href='".RCX_URL."/userinfo.php?uid=".$poster->getVar("uid")."'><img src='".RCX_URL."/images/icons/msnm.gif' alt='msnm' /></a>";
			}
			} else {
				echo "&nbsp;";
			}
		echo "
		</td></tr>
		<tr class='bg1' align='right'><td colspan='2' align='right'>";

		$previous = ($start - 1);
		$next     = ($start + 1);

		if ( $previous >= 0 ) {
			echo "<a href='read.php?start=".$previous."&amp;total_pm=".$total_pm."&amp;sort=".$sort."&amp;by=".$by."'>"._PM_PREVIOUS."</a> | ";
			} else {
				echo _PM_PREVIOUS." | ";
			}
		if ($next < $total_pm) {
			echo "<a href='read.php?start=".$next."&amp;total_pm=".$total_pm."&amp;sort=".$sort."&amp;by=".$by."'>"._PM_NEXT."</a>";
			} else {
				echo _PM_NEXT;
			}
		echo "
		</td>
		</tr><tr class='bg2' align='left'>
		<td colspan='2' align='left'>
		<form action='read.php' method='post' name='delete".$pm_arr[0]->getVar("msg_id")."'>";
		if ( $poster != false ) {
			echo "<a href='pmlite.php?reply=1&to_userid=".$poster->getVar("uid")."&amp;msg_id=".$pm_arr[0]->getVar("msg_id")."'><img src='".RCX_URL."/images/icons/reply.gif' alt='"._REPLY."' /></a>";
		}
		echo "
		<input type='hidden' name='delete' value='1' />
		<input type='hidden' name='msg_id' value='".$pm_arr[0]->getVar("msg_id")."' />
		<input type='image' class='image' src='".RCX_URL."/images/icons/delete.gif' name='submit' alt='"._DELETE."' />
		&nbsp;&nbsp;<img style='cursor: hand;' onClick='javascript:openWithSelfMain(\"print.php?msg_id=".$pm_arr[0]->getVar("msg_id")."&op=print_pn\",\"Drucken\",700,500)' src='".RCX_URL."/modules/pm/images/print.gif' alt='"._PM_PRINT."' >   
		</td></tr></form>";
	}
echo '</table>';
CloseTable();
include_once('../../footer.php');
?>
