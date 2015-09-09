<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("RCX_RCXOBJECT_INCLUDED")) {
  define("RCX_RCXOBJECT_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxObject {

  var $db;
  var $vars      = array();
  var $cleanVars = array();
  var $errors    = array();
  var $isCleaned = false;

  function RcxObject() {
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function initVar($key, $type, $value=NULL, $required=false, $maxlength=NULL, $filter=false) {

$this->vars[$key]['value'] = $value;

// require html form input?
$this->vars[$key]['required'] = $required;

// int, textbox, textarea, or other
// set to 'other' if no data type ckecking is required
$this->vars[$key]['type'] = $type;

// for textbox type only
$this->vars[$key]['maxlength'] = $maxlength;

// perform words check to the data?
$this->vars[$key]['filter'] = $filter;

// the data has been updated?
$this->vars[$key]['changed'] = false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setVar($key, $value, $changed=true) {

  if ($this->vars[$key]['value'] == $value)
    $this->vars[$key]['changed'] = false;
  else
    $this->vars[$key]['changed'] = $changed;

  if ($this->vars[$key]['type'] == 'int')
    $value = intval($value);

  $this->vars[$key]['value'] = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function set(&$arr) {

  if (is_array($arr))
  {
    foreach ($arr as $key => $value)
    {
      $this->setVar($key, $value, false);
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getVar($key, $format="S") {
global $myts;

if (!empty($this->vars['type'])) {
    $myts->setType($this->vars['type']['value']); // Fix LARK (28.06.2010)
}

if ( $this->vars[$key]['type'] == "textbox" ) {
  switch ($format) {
    case "S":
      return $myts->makeTboxData4Show($this->vars[$key]['value']);
      break;

    case "E":
      return $myts->makeTboxData4Edit($this->vars[$key]['value']);
      break;

    case "P":
      return $myts->makeTboxData4Preview($this->vars[$key]['value']);
      break;

    case "F":
      return $myts->makeTboxData4PreviewInForm($this->vars[$key]['value']);
      break;

    case "N":
      return $this->vars[$key]['value'];
      break;
    }

  } elseif ( $this->vars[$key]['type'] == "textarea" ) {
    switch ($format) {
      case "S":
        $allow_html    = intval($this->vars['allow_html']['value']);
        $allow_smileys = intval($this->vars['allow_smileys']['value']);
        $allow_bbcode  = intval($this->vars['allow_bbcode']['value']);
        return $myts->makeTareaData4Show($this->vars[$key]['value'], $allow_html, $allow_smileys, $allow_bbcode);
        break;

      case "E":
        return $myts->makeTboxData4Edit($this->vars[$key]['value']);
        break;

      case "P":
        $allow_html    = intval($this->vars['allow_html']['value']);
        $allow_smileys = intval($this->vars['allow_smileys']['value']);
        $allow_bbcode  = intval($this->vars['allow_bbcode']['value']);
        return $myts->makeTareaData4Preview($this->vars[$key]['value'], $allow_html, $allow_smileys, $allow_bbcode);
        break;

      case "F":
        return $myts->makeTboxData4PreviewInForm($this->vars[$key]['value']);
        break;

      case "N":
        return $this->vars[$key]['value'];
        break;
    }
    
  } elseif ( $this->vars[$key]['type'] == "array" ) {  
       
      if (!is_array($this->vars[$key]['value'])) {
          if ($this->vars[$key]['value'] != '') {
              $ret = unserialize($this->vars[$key]['value']);
          }
          return is_array($ret) ? $ret : array();
      }

  } else {
    return $this->vars[$key]['value'];
  }
}

/**
* prepare the variables to be stored in DB
*
* @param type $var description
* @return type description
*/
function cleanVars() {
global $myts;

  foreach ( $this->vars as $k => $v ) {
    if ( !$v['changed'] ) {
      $cleanv = addslashes($v['value']);
      } else {
          
        $v['value'] = is_string($v['value']) ? trim($v['value']) : $v['value'];
        
        if ( isset($v['required']) && $v['required'] == true && empty($v['value']) ) {
          $this->setErrors("$k is required.");
          continue;
        }

        switch($v['type']) {
          case "textbox":
            if ( isset($v['maxlength']) && strlen($v['value']) > $v['maxlength'] ) {
              $this->setErrors("$k must be shorter than ".$v['maxlength']." characters.");
              continue;
            }
            if ( $v['filter'] == true ) {
              $cleanv = $myts->makeTboxData4Save($myts->censorString($v['value']));
              } else {
                $cleanv = $myts->makeTboxData4Save($v['value']);
              }
            break;

          case "textarea":
            if ( $v['filter'] == true ) {
              $cleanv = $myts->makeTboxData4Save($myts->censorString($v['value']));
              } else {
                $cleanv = $myts->makeTboxData4Save($v['value']);
              }
              break;

          case "int":
            $cleanv = intval($v['value']);
            break;
            
          case "array":
            $cleanv = serialize($v['value']);
            break;

          default:
            $cleanv = $v['value'];
            break;
        }
      }

    $this->cleanVars[$k] = $cleanv;
    unset($cleanv);
  }

  if ( count($this->errors) ) {
    return false;
  }

$this->isCleaned = true;

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isCleaned() {
  return $this->isCleaned;
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function setErrors($value) {
  $this->errors[] = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getErrors($ashtml = true) {

if ( !$ashtml ) {
  return $this->errors;
  } else {
    $ret = "<h4>Errors</h4>";
    if ( !empty($this->errors) ) {
      foreach ( $this->errors as $error ) {
        $ret .= $error."<br />";
      }
      } else {
        $ret .= "None<br />";
      }
  return $ret;
  }
}
} // END RCXOBJECT
}
?>
