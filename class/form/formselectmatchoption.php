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

if (!defined("ERCX_RCXFORMSELECTMATCHOPTION_INCLUDED")) {
	define("ERCX_RCXFORMSELECTMATCHOPTION_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectMatchOption extends RcxFormSelect {

	function RcxFormSelectMatchOption($caption, $name, $value="", $size=1) {
		$this->RcxFormSelect($caption, $name, $value, $size, false);
		$this->addOption(RCX_MATCH_START, _STARTSWITH);
		$this->addOption(RCX_MATCH_END, _ENDSWITH);
		$this->addOption(RCX_MATCH_EQUAL, _MATCHES);
		$this->addOption(RCX_MATCH_CONTAIN, _CONTAINS);
	}
} // END CLASS
} // END DEFINED
?>
