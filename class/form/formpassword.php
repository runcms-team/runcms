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

if (!defined("ERCX_RCXFORMPASSWORD_INCLUDED")) {
	define("ERCX_RCXFORMPASSWORD_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormPassword extends RcxFormElement {

	var $size;
	var $maxlength;
	var $value;

	function RcxFormPassword($caption, $name, $size, $maxlength, $value="") {
		$this->setCaption($caption);
		$this->setName($name);
		$this->size      = intval($size);
		$this->maxlength = intval($maxlength);
		$this->value     = $value;
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getSize() {
	return $this->size;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getMaxlength() {
	return $this->maxlength;
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
	return "<input type='password' class='text' name='".$this->getName()."' id='".$this->getName()."' size='".$this->getSize()."' maxlength='".$this->getMaxlength()."' value='".$this->getValue()."'".$this->getExtra()." />";
}
} // END CLASS
} // END DEFINED
?>
