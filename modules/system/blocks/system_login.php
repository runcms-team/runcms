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
function b_system_login_show() {
global $rcxUser, $rcxConfig, $_COOKIE;
if (!$rcxUser) {
	$block             = array();
	$block['title']    = _MB_SYSTEM_LOGIN;
	$block['content']  = "<form action='".RCX_URL."/user.php' method='post'>";
	$block['content'] .= _MB_SYSTEM_NICK."<br />";
	$block['content'] .= "<input type='text' class='text' name='uname' size='12' maxlength='25'";
	if ( isset($_COOKIE[$rcxConfig['cookie_name']]) && empty($rcxConfig['cache_time']) ) {
		$block['content'] .= " value='".$_COOKIE[$rcxConfig['cookie_name']]."'";
	}
	$block['content'] .= " /><br />";
	$block['content'] .= _MB_SYSTEM_PASS."<br />";
	$block['content'] .= "<input type='password' class='text' name='pass' size='12' maxlength='20' /><br />";
	$block['content'] .= "<input type='hidden' name='op' value='login' /><br />";
	$block['content'] .= "<input type='submit' class='button' value='"._MB_SYSTEM_LOGIN."' /></form>";
	$block['content'] .= "<a href='".RCX_URL."/user.php#lost'>"._MB_SYSTEM_LPASS."</a><br /><br />";
	$block['content'] .= _MB_SYSTEM_DHAAY."<br />";
	$block['content'] .= " <a href='".RCX_URL."/register.php'>"._MB_SYSTEM_RNOW."</a>";
	return $block;
}
return FALSE;
}
?>
