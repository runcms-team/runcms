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

if (!defined("ERCX_RCXFORMELEMENTTRAY_INCLUDED")) {
	define("ERCX_RCXFORMELEMENTTRAY_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormElementTray extends RcxFormElement {

	// array of form element objects
	var $elements = array();
	var $delimeter;

	function RcxFormElementTray($caption, $delimeter="&nbsp;") {
		$this->setCaption($caption);
		$this->delimeter = $delimeter;
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addElement($ele) {
	$this->elements[] = $ele;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getElements() {
	return $this->elements;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getDelimeter() {
	return $this->delimeter;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {

$count = 0;
$ret   = "";

foreach ( $this->getElements() as $ele ) {
	if ($count > 0) {
		$ret .= $this->getDelimeter();
	}
	$ret .= $ele->getCaption()."&nbsp;".$ele->render();
	$count++;
}

return $ret;
}
} // END CLASS
} // END DEFINED
?>
