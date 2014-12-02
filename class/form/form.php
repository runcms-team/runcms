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

if (!defined("ERCX_RCXFORM_INCLUDED")) {
	define("ERCX_RCXFORM_INCLUDED", 1);
	
include_once(RCX_ROOT_PATH . "/class/form/formhiddentoken.php");
	
class RcxForm {

	var $action;
	var $method;
	var $name;
	var $title;
	var $extra;
	var $elements = array();
	var $required = array();

	function RcxForm($title, $name, $action, $method="post", $addtoken = false) {
		$this->title  = $title;
		$this->name   = $name;
		$this->action = $action;
		$this->method = $method;
		if ($addtoken != false) {
		    $this->addElement(new RcxFormHiddenToken());
        }
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getTitle() {
	return $this->title;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getName() {
	return $this->name;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getAction() {
	return $this->action;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getMethod() {
	return $this->method;
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
function setExtra($extra) {
	$this->extra .= " ".$extra;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getExtra() {

if (isset($this->extra)) {
	return $this->extra;
}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setRequired($required) {

if ( is_array($required) ) {
	foreach ( $required as $req ) {
		$this->required[] = $req;
	}
	} else {
		$this->required[] = $required;
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getRequired() {
	return $this->required;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function display() {
	echo $this->render();
}

} // END CLASS
} // END DEFINED
?>
