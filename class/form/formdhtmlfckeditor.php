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

if (!defined("ERCX_RCXFORDHTMLFCKEDITOR_INCLUDED")) {
	define("ERCX_RCXFORDHTMLFCKEDITOR_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formelement.php");

class RcxFormFckeditor extends RcxFormElement {

	var $caption;
	var $name;
	var $value;
	var $width ;
	var $height ;
	var $rctest = true;

	function RcxFormFckeditor($caption, $name, $value="", $width="100%", $height="500", $rows=10, $cols=80) {
		$this->setCaption($caption);
		$this->setName($name);
		$this->value = $value;
		$this->width = $width;
		$this->height = $height;
		$this->rows = intval($rows);
		$this->cols = intval($cols);
		
  include(RCX_ROOT_PATH.'/class/fckeditor/fckeditor.php');
	include_once(RCX_ROOT_PATH.'/modules/system/cache/editor.php');
	
	global $myts, $rcxUser, $rcxConfig, $editorConfig;
	
			
$runFCKeditor = new FCKeditor($name);
$admin = 0;
if ($rcxUser && $rcxUser->isAdmin()) {
  $admin = 1;
}
if($admin == 1 ){
  $toolbar = 'runcms_lib' ;
  }else{
  $toolbar = 'UserToolbar';
  }

if ($runFCKeditor->IsCompatible() && $editorConfig["displayeditor"] == 1 && $rcxUser && $rcxUser->isAdmin())
{
 $this->rc_editor = true;
	
	}else{
	
	if ($runFCKeditor->IsCompatible() && $editorConfig["displayeditor"] == 1 && $editorConfig["displayforuser"] == 1 && $rcxUser)
{
 $this->rc_editor = true;
 }else{
	$this->rc_editor = false;
}
}
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function isActive() {

  if ($this->rc_editor == false)
  {
    return false;
  }

return true;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getCaption() {
	return $this->caption;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getName() {
	return $this->name;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getValue() {
	return $this->value;
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getWidth() {
	return $this->width;
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getHeight() {
	return $this->height;
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getRows() {
	return $this->rows;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getCols() {
	return $this->cols;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function render($value="") {
	
	$caption = $this->getCaption();
	$name = $this->getName();
	$value = $this->getValue();
	$width = $this->getWidth();
	$height = $this->getHeight();
			
if ($this->rc_editor == true){	
 $ret = "<div>";
 $ret .= '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'" style="display:none" />';
 $ret .= '<input type="hidden" id="fckeditor___Config" value="" style="display:none" />';
 $ret .= '<iframe id="fckeditor___Frame" src="'.RCX_URL.'/class/fckeditor/editor/fckeditor.html?InstanceName='.$name.'&amp;Toolbar='.$toolbar.'" width="'.$width.'" height="'.$height.'" frameborder="no" scrolling="no">';
 $ret .= '</iframe>';
 $ret .= '</div>';
  
 return $ret;
 
}else{
	$this->rc_editor = false;
	$desc = new RcxFormDhtmlTextArea('', $name, $value, $this->getRows(), $this->getCols());
	return $desc->render();
		
	}
}


//---------------------------------------------------------------------------------------//
} // END CLASS
} // END DEFINED
?>