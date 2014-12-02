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

if (!defined("ERCX_RCXFORMRADIO_INCLUDED")) {
	define("ERCX_RCXFORMRADIO_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormRadio extends RcxFormElement {

	var $options = array();
	// pre-selected value
	var $value;

	function RcxFormRadio($caption, $name, $value=NULL) {
		$this->setCaption($caption);
		$this->setName($name);
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

foreach ( $this->getOptions() as $value => $name ) {
	$ret .= "<input type='radio' class='radio' name='".$this->getName()."' id='".$this->getName()."' value='".$value."'";
	$selected = $this->getValue();
	if ( isset($selected) && ($value == $selected) ) {
		$ret .= " checked='checked'";
	}
	$ret .= $this->getExtra()." />".$name;
}

return $ret;
}
} // END CLASS
} // END DEFINED
?>
