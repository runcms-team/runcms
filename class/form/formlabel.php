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

if (!defined("ERCX_RCXFORMLABEL_INCLUDED")) {
	define("ERCX_RCXFORMLABEL_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormLabel extends RcxFormElement {

	var $value;

	function RcxFormLabel($caption="", $value="") {
		$this->setCaption($caption);
		$this->value = $value;
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getValue() {
	return $this->value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {
	return $this->getValue();
}
} // END CLASS
} // END DEFINED
?>
