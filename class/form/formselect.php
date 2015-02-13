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

if (!defined("ERCX_RCXFORMSELECT_INCLUDED")) {
	define("ERCX_RCXFORMSELECT_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormSelect extends RcxFormElement {

	var $size;
	// pre-selected values in array
	var $value    = array();
	var $options  = array();
	var $multiple = false;
	var $disabled = array();

	function RcxFormSelect($caption, $name, $value="", $size=1, $multiple=false) {
		$this->setCaption($caption);
		$this->setName($name);
		$this->multiple = $multiple;
		$this->size     = intval($size);
		$this->setValue($value);
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isMultiple() {
	return $this->multiple;
}

/**
 * Enter description here...
 *
 * @param unknown_type $value
 */
function setDisabled($value)
{
    if ($value != "") {
        if (is_array($value)) {
            foreach ( $value as $v ) {
                $this->disabled[] = $v;
            }
        } else {
        	$this->disabled[] = $value;
        }
    }
}

/**
 * Enter description here...
 *
 * @return unknown
 */
function getDisabled() {
	return $this->disabled;
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
function setValue($value) {

if ( $value != "" ) {
	$this->value = '';
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
function addOptionArray($arr) {

if ( is_array($arr) ) {
	foreach ($arr as $k=>$v) {
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

$ret = "<select class='select' size='".$this->getSize()."'".$this->getExtra()."";

if ( $this->isMultiple() != false ) {
	$ret .= " name='".$this->getName()."[]' id='".$this->getName()."[]' multiple='multiple'>";
	} else {
		$ret .= " name='".$this->getName()."' id='".$this->getName()."'>";
	}
	

foreach ( $this->getOptions() as $value => $name ) {
	$ret .= "<option value='".htmlspecialchars($value, ENT_QUOTES)."'";
	$count = count($this->getValue());
	if ( $count > 0 && in_array($value, $this->getValue()) ) {
		$ret .= " selected='selected'";
	}
	
	if (in_array($value, $this->getDisabled())) {
		$ret .= " disabled";
	}
	
	$ret .= ">".$name."</option>";
}
$ret .= "</select>";

return $ret;
}
} // END CLASS
} // END DEFINED
?>
