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

if (!defined("ERCX_RCXFORMSELECTMODULE_INCLUDED")) {
	define("ERCX_RCXFORMSELECTMODULE_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectModule extends RcxFormSelect {

	function RcxFormSelectmodule($caption, $name, $include_system=false, $value=0, $size=1, $multiple=false) {
		$this->RcxFormSelect($caption, $name, $value, $size, $multiple);
		$this->addOption(0, '--'._ALL.'--');
		$this->addOption(-1, '--'._NONE.'--');
		if (!$include_system) {
			$this->addOptionArray(RcxModule::getAllModulesList(array("dirname != 'system'", "hasmain = '1'")));
			} else {
				$this->addOptionArray(RcxModule::getAllModulesList(array("hasmain = '1'")));
			}
	}
} // END CLASS
} // END DEFINED
?>
