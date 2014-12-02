<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

if (!defined("ERCX_RCXFORMSELECTLANG_INCLUDED")) {
	define("ERCX_RCXFORMSELECTLANG_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectLang extends RcxFormSelect {

	function RcxFormSelectLang($caption, $name, $value="", $size=1) {
		$this->RcxFormSelect($caption, $name, $value, $size);
		$this->addOptionArray(RcxLists::getLangList());
	}
} // END CLASS
} // END DEFINED
?>
