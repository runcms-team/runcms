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

if (!defined("ERCX_RCXFORMSELECTGROUP_INCLUDED")) {
	define("ERCX_RCXFORMSELECTGROUP_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectGroup extends RcxFormSelect {

	function RcxFormSelectGroup($caption, $name, $include_anon=false, $value="", $size=1, $multiple=false) {
		$this->RcxFormSelect($caption, $name, $value, $size, $multiple);
		if ( !$include_anon ) {
			$this->addOptionArray(RcxGroup::getAllGroupsList(array("type!='Anonymous'")));
			} else {
				$this->addOptionArray(RcxGroup::getAllGroupsList());
			}
	}
} // END CLASS
} // END DEFINED
?>
