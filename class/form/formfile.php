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

if (!defined("ERCX_RCXFORMFILE_INCLUDED")) {
	define("ERCX_RCXFORMFILE_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormFile extends RcxFormElement {

	var $maxFileSize;

	function RcxFormFile($caption, $name, $maxfilesize) {
		$this->setCaption($caption);
		$this->setName($name);
		$this->maxFileSize = intval($maxfilesize);
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getMaxFileSize() {
	return $this->maxFileSize;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {
	return "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' /><input type='file' class='file' name='".$this->getName()."' id='".$this->getName()."'".$this->getExtra()." /><input type='hidden' name='rcx_upload_file[]' id='rcx_upload_file[]' value='".$this->getName()."' />";
}
} // END CLASS
} // END DEFINED
?>
