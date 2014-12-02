<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("GALL_GALLOBJECT_INCLUDED")) {
  define("GALL_GALLOBJECT_INCLUDED", 1);

  class GallObjekt {
  
    // private
    var $db;
  
    // private
    var $vars = array();
  
    // private
    // variables cleaned for store in DB
    var $cleanVars = array();
  
    // private
    var $errors = array();
  
    // private
    // is it already cleaned?
    var $isCleaned = false;
  
    function GallObjekt(){
      $this->db =& Datenbank::getInstance();
    }
  
    // public
    function initVar($key, $type, $value=NULL, $required=false, $maxlength=NULL, $filter= false){
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
  
    // public
    function setVar($key, $value, $changed=true){
      $this->vars[$key]['value'] = $value;
      $this->vars[$key]['changed'] = $changed;
    }
  
    // private
    function set($arr){
      foreach ( $arr as $key => $value ) {
        $this->setVar($key, $value, false);
      }
    }
  
    // public
    function getVar($key, $format="S"){
      if ( $this->vars[$key]['type'] == "textbox" ) {
        $myts =& MyTextSanitizer::getInstance();
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
          case "N": return $this->vars[$key]['value'];
            break;
        }
      } elseif ( $this->vars[$key]['type'] == "textarea" ) {
        $myts =& MyTextSanitizer::getInstance();
        switch ($format) {
          case "S":
            $html = (!isset($this->vars['nohtml']['value']) || intval($this->vars['nohtml']['value']) > 0) ? 0 : 1;
            $smiley = (!empty($this->vars['nosmiley']['value'])) ? 0 : 1;
  
            $xcode = (!empty($this->vars['noxcode']['value'])) ? 0 : 1;
            return $myts->makeTareaData4Show($this->vars[$key]['value'], $html, $smiley, $xcode);
            break;
          case "E":
            return $myts->makeTareaData4Edit($this->vars[$key]['value']);
            break;
          case "P":
            $html = (!empty($this->vars['nohtml']['value'])) ? 0 :1;
            $smiley = (!empty($this->vars['nosmiley']['value'])) ? 0 : 1;
  
            $xcode = (!empty($this->vars['noxcode']['value'])) ? 0 : 1;
            return $myts->makeTareaData4Preview($this->vars[$key]['value'], $html, $smiley, $xcode);
            break;
          case "F":
            return $myts->makeTareaData4PreviewInForm($this->vars[$key]['value']);
            break;
          case "N": return $this->vars[$key]['value'];
            break;
        }
      } else {
        return $this->vars[$key]['value'];
      }
    }
  
    // public
    // prepare the variables to be stored in DB
    function cleanVars(){
      $ts =& MyTextSanitizer::getInstance();
      foreach ( $this->vars as $k => $v ) {
        if ( !$v['changed'] ) {
          $cleanv = addslashes($v['value']);
        } else {
          $v['value'] = trim($v['value']);
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
                $cleanv = $ts->makeTboxData4Save($ts->censorString($v['value']));
              } else {
                $cleanv = $ts->makeTboxData4Save($v['value']);
              }
              break;
            case "textarea":
              if ( $v['filter'] == true ) {
                $cleanv = $ts->makeTareaData4Save($ts->censorString($v['value']));
              } else {
                $cleanv = $ts->makeTareaData4Save($v['value']);
              }
              break;
            case "int":
              $cleanv = intval($v['value']);
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
  
    // public
    function isCleaned(){
      return $this->isCleaned;
    }
  
    //public
    function setErrors($value){
      $this->errors[] = trim($value);
    }
  
    // public
    function getErrors($ashtml = true){
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
  }
}

?>
