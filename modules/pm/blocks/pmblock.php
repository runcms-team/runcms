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
function b_ppm_show() {
global $db, $rcxUser;

if (!$rcxUser) {
	return FALSE;
}

$block            = array();
$block['title']   = _PM_PRIVMSGS;

list($total_pm) = $db->fetch_row($db->query("SELECT COUNT(*) FROM ".$db->prefix("pm_msgs")." WHERE to_userid = ".$rcxUser->getVar("uid").""));
list($new_pm)   = $db->fetch_row($db->query("SELECT COUNT(*) FROM ".$db->prefix("pm_msgs")." WHERE to_userid = ".$rcxUser->getVar("uid")." AND read_msg=0"));

if ($total_pm > 0) {
	if ($new_pm > 0) {

		$block['content'] .= "<img src='".RCX_URL."/modules/pm/images/more.gif'>".$new_pm." <a id='msgtxt' href='".RCX_URL."/modules/pm/' onmouseover='setBlink(0);' onmouseout='setBlink(1);'><b>"._PM_NEW."</b></a><br />";
		if ( !defined('ERCX_PM_INCLUDED') ) {
			$block['content'] .= "<bgsound src='".RCX_URL."/modules/pm/images/msg.wav' loop='false'>";
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
			$block['content'] .= _PM_NONEW." <br /> ";
		}
	$block['content'] .= "<img src='".RCX_URL."/modules/pm/images/new.gif'>".$total_pm." <a href='".RCX_URL."/modules/pm/'>"._PM_TOT."</a>";
	} else {
		$block['content'] .= "<a href='".RCX_URL."/modules/pm/'>"._PM_NONEW."</a>";
	}
$block['content'] .= "<br /><br /><img src='".RCX_URL."/modules/pm/images/em.gif'>&nbsp;<a href='".RCX_URL."/modules/pm/index.php'>"._PM_SEND."</a>";

return $block;
}
?>
