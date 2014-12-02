<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

	if ( !defined('RCX_MAINFILE_INCLUDED') ) {
		include("mainfile.php");}
	$rcxOption['show_rblock'] =1;
	if ( !defined('RCX_HEADER_INCLUDED') ) {
		include(RCX_ROOT_PATH."/header.php");}
	WhyRegTop(_WHYREG1);
	OpenTable();
	echo "<table width='100%' cellpadding='5' cellspacing='0' align='center' border='0'><tr><td>";
	echo "<fieldset style='padding: 10px;'>";	
	echo "<div class='more'>"._WHYREG2;
	echo _WHYREG3;
	echo "<a href='".RCX_URL."/user.php'><b>"._WHYREG4."</b></a>"._WHYREG5;
	echo _WHYREG6."<a href='".RCX_URL."/register.php'><b>&nbsp;"._WHYREG7.",</a></b><br /><br />";
	echo _WHYREG8.$meta['title'].":<br><br />";
	echo "<b>"._WHYREG9."</b><br />";
	echo "<li>"._WHYREG10."</li>";
	echo "<li>"._WHYREG11."</li>";
	echo "<li>"._WHYREG12."</li>";
	echo "<li> "._WHYREG13."</li>";
	echo "<li> "._WHYREG14."</li>";	
	echo "<br><br><b>"._WHYREG15."</b><br />";
	echo "<li>"._WHYREG16."</li>";
	echo "<li>"._WHYREG17."</li>";
	echo "<li>"._WHYREG18."</li>";
	echo "<li>"._WHYREG19."</li><br /><br />";
	echo "<br><b>"._WHYREG20." <br />".$meta['title']."</b>";
	echo "</div></fieldset>";	
	echo "</td></tr></table>";
	CloseTable();
    include_once("footer.php");
?>
