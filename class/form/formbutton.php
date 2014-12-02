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

if (!defined("ERCX_RCXFORMBUTTON_INCLUDED")) {
	define("ERCX_RCXFORMBUTTON_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormButton extends RcxFormElement {

	var $value;
	// this could be either "button", "submit", or "reset"
	var $type;

	function RcxFormButton($caption, $name, $value="", $type="button", $extra="") {
		$this->setCaption($caption);
		$this->setName($name);
		$this->type  = $type;
		$this->value = $value;
		$this->extra = $extra;
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
function getType() {
	return $this->type;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getExtra() {
	return $this->extra;

}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {
	return "<input type='".$this->getType()."' class='button' name='".$this->getName()."' id='".$this->getName()."' value='".$this->getValue()."'".$this->getExtra()." />";
}

} // END CLASS
} // END DEFINED
?>
