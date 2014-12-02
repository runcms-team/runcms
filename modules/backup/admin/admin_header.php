<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include "../../../mainfile.php";
include_once RCX_ROOT_PATH."/class/rcxmodule.php";
include RCX_ROOT_PATH."/include/cp_functions.php";
if ( $rcxUser ) {
	$rcxModule = RcxModule::getByDirname("backup");
	if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
		redirect_header(RCX_URL."/",3,_NOPERM);;
		exit();
	}
} else {
	redirect_header(RCX_URL."/",3,_NOPERM);
	exit();
}
if ( file_exists("../language/".$rcxConfig['language']."/admin.php") ) {
	include "../language/".$rcxConfig['language']."/admin.php";
} else {
	include "../language/english/admin.php";
}
?>
