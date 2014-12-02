<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/

function b_system_user_show() {
global $db, $rcxUser, $rcxConfig, $rcxUserConf;
if (!$rcxUser) {
	return FALSE;
	}
$module = RcxModule::getByDirname('pm');
define("_IMG_POINTER","<img src='".RCX_URL."/images/menu/pointer.gif' border='0' style='vertical-align: middle ;' alt='' />&nbsp;");
$block             = array();
$block['title']    = sprintf(_MB_SYSTEM_MENU4, $rcxUser->uname());
$block['content']  = _IMG_POINTER."<a href='".RCX_URL."/user.php'>"._MB_SYSTEM_VACNT."</a><br />";
$block['content'] .= _IMG_POINTER."<a href='".RCX_URL."/edituser.php'>"._MB_SYSTEM_PROFEDIT."</a><br />";
if ( $rcxConfig['avatar_allow_upload'] == 1 ) {
	$block['content'] .= _IMG_POINTER."<a href='".RCX_URL."/edituser.php?op=avatarform'>"._MB_SYSTEM_UPLOADMYAVATAR."</a><br />";
}
if ( $rcxConfig['self_delete'] ) {
	$block['content'] .= _IMG_POINTER."<a href='".RCX_URL."/user.php?op=delete'>"._MB_SYSTEM_DELACCOUNT."</a><br />";
}	
$block['content'] .= _IMG_POINTER."<a href='".RCX_URL."/user.php?op=logout'>"._MB_SYSTEM_LOUT."</a><br /><br />";
if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups()) ) {
list($total_pm) = $db->fetch_row($db->query("SELECT COUNT(*) FROM ".$db->prefix("pm_msgs")." WHERE to_userid = ".$rcxUser->getVar("uid").""));
list($new_pm)   = $db->fetch_row($db->query("SELECT COUNT(*) FROM ".$db->prefix("pm_msgs")." WHERE to_userid = ".$rcxUser->getVar("uid")." AND read_msg=0"));
if ($total_pm > 0) 
	{
	if ($new_pm > 0) 
		{
		$block['content'] .= "<img src='".RCX_URL."/modules/pm/images/more.gif' alt='' />".$new_pm." <a id='msgtxt' href='".RCX_URL."/modules/pm/index.php' onmouseover='setBlink(0);' onmouseout='setBlink(1);'><b>"._MB_SYSTEM_NMSGS."</b></a><br />";
		if ( defined('RCX_USER_CONF_INCLUDED') ) 
			{
			if ($rcxUserConf->klingel() == 1)
				{
				$block['content'] .= "<bgsound src='".RCX_URL."/images/msg.wav' loop='false'>";
			}
		}
		else
			{
			$block['content'] .= "<bgsound src='".RCX_URL."/images/msg.wav' loop='false'>";
		}
		$block['content'] .= '
					<script type="text/javascript">
					<!--
					var blink    = 1;
					var blinkdom = rcxGetElementById("msgtxt");
					function blink1() {
					blinkdom.style.visibility = "hidden";
					if (blink == 1) {
						setTimeout("blink2()", 500);
						} else {
							blinkdom.style.visibility = "visible";
						}
					}
					function blink2() {
					blinkdom.style.visibility = "visible";
					if (blink == 1) {
						setTimeout("blink1()", 1000);
					}
					}
					function setBlink(val) {
					blink = val;
					blink1();
					}
					setBlink(1);
					//-->
					</script>';
	} else {
			$block['content'] .=  _MB_SYSTEM_NNMSG." <br /> ";
		}
	$block['content'] .= "<img src='".RCX_URL."/modules/pm/images/new.gif' alt='' />".$total_pm." <a href='".RCX_URL."/modules/pm/'>"._MB_SYSTEM_TMSGS."</a>";
	} else {
		$block['content'] .= "<a href='".RCX_URL."/modules/pm/'>". _MB_SYSTEM_NNMSG."</a>";
	}
$block['content'] .= "<br /><br /><img src='".RCX_URL."/modules/pm/images/em.gif' alt='' />&nbsp;<a href='".RCX_URL."/modules/pm/index.php'>&nbsp;"._MB_SYSTEM_SENDMSG."</a>";
}
if ($rcxUser->isAdmin()) {
	$block['content'] .= "<br /><br /><img src='".RCX_URL."/images/menu/pointer.gif' border='0' alt='' />";
	$block['content'] .= "&nbsp;<a href='".RCX_URL."/admin.php'>"._MB_SYSTEM_ADMENU."</a>";
}
return $block;
}
?>
