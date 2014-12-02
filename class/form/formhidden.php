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

if (!defined("ERCX_RCXFORMHIDDEN_INCLUDED")) {
	define("ERCX_RCXFORMHIDDEN_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormHidden extends RcxFormElement {

	var $value;

	function RcxFormHidden($name, $value) {
		$this->setName($name);
		$this->setHidden();
		$this->value = $value;
		$this->setCaption("");
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
function render($value="") {
	return "<input type='hidden' name='".$this->getName()."' id='".$this->getName()."' value='".$this->getValue()."' />";
}
} // END CLASS
} // END DEFINED
?>
