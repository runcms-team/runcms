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

if (!defined("ERCX_RCXFORMCHECKBOX_INCLUDED")) {
	define("ERCX_RCXFORMCHECKBOX_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormCheckBox extends RcxFormElement {

	var $options = array();
	// pre-selected values in array
	var $value = array();

	function RcxFormCheckBox($caption, $name, $value="") {
		$this->setCaption($caption);
		$this->setName($name);
		if ( $value != "" ) {
			if ( is_array($value) ) {
				foreach ( $value as $v ) {
					$this->value[] = $v;
				}
				} else {
					$this->value[] = $value;
				}
		}
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
function addOption($value, $name="") {

if ( $name != "" ) {
	$this->options[$value] = $name;
	} else {
		$this->options[$value] = $value;
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addOptionArray($arr) {

if ( is_array($arr) ) {
	foreach ( $arr as $k=>$v ) {
		$this->addOption($k, $v);
	}
}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getOptions() {
	return $this->options;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {

$ret = "";

if ( count($this->getOptions()) > 1 && substr($this->getName(), -2, 2) != "[]" ) {
	$newname = $this->getName()."[]";
	$this->setName($newname);
}

foreach ( $this->getOptions() as $value => $name ) {
	$ret .= "<input type='checkbox' class='checkbox' name='".$this->getName()."' id='".$this->getName()."' value='".$value."'";
	$count = count($this->getValue());
	if ( $count > 0 && in_array($value, $this->getValue()) ) {
		$ret .= " checked='checked'";
	}
	$ret .= $this->getExtra()." />".$name;
}

return $ret;
}

} // END CLASS
} // END DEFINED
?>
