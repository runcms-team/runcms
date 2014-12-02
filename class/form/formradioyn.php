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

if (!defined("ERCX_RCXFORMRADIOYN_INCLUDED")) {
	define("ERCX_RCXFORMRADIOYN_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formradio.php");

class RcxFormRadioYN extends RcxFormRadio {

	function RcxFormRadioYN($caption, $name, $value=NULL, $yes=_YES, $no=_NO) {
		$this->RcxFormRadio($caption, $name, $value);
		$this->addOption(1, $yes);
		$this->addOption(0, $no);
	}
} // END CLASS
} // END DEFINED
?>
