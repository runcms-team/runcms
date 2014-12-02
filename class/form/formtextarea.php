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

if (!defined("ERCX_RCXFORMTEXTAREA_INCLUDED")) {
	define("ERCX_RCXFORMTEXTAREA_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormTextArea extends RcxFormElement {

	var $cols;
	var $rows;
	var $value;

	function RcxFormTextArea($caption, $name, $value="", $rows=10, $cols=58) {
		$this->setCaption($caption);
		$this->setName($name);
		$this->rows = intval($rows);
		$this->cols = intval($cols);
		$this->value = $value;
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getRows() {
	return $this->rows;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getCols() {
	return $this->cols;
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
	return "<textarea class='textarea' name='".$this->getName()."' id='".$this->getName()."' rows='".$this->getRows()."' cols='".$this->getCols()."'".$this->getExtra().">".$this->getValue()."</textarea>";
}
} // END CLASS
} // END DEFINED
?>
