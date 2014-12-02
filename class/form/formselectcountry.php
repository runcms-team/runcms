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

if (!defined("ERCX_RCXFORMSELECTCOUNTRY_INCLUDED")) {
	define("ERCX_RCXFORMSELECTCOUNTRY_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectCountry extends RcxFormSelect {

	function RcxFormSelectCountry($caption, $name, $value="", $size=1) {
		$this->RcxFormSelect($caption, $name, $value, $size);
		$this->addOptionArray(RcxLists::getCountryList());
	}
} // END CLASS
} // END DEFINED
?>
