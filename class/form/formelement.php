<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("ERCX_RCXFORMELEMENT_INCLUDED")) {
  define("ERCX_RCXFORMELEMENT_INCLUDED", 1);

// public abstract class
class RcxFormElement {

  var $name;
  var $caption;
  var $extra;
  var $hidden   = false;
  var $required = false;
  var $colspan  = false;

  function RcxFormElement() {
    die("This class cannot be instantiated!");
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function setName($name) {
  $this->name = $name;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getName($encode=true) {

if ($encode) {
  return str_replace("&amp;", "&", str_replace("'","&#039;",htmlspecialchars($this->name)));
}

return $this->name;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setCaption($caption) {
  $this->caption = $caption;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getCaption() {
  return $this->caption;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setHidden() {
  $this->hidden = true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isHidden() {
  return $this->hidden;
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
function render() {
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setColspan() {
  $this->colspan = true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isColspan() {
  return $this->colspan;
}
} // END CLASS
} // END DEFINED
?>
