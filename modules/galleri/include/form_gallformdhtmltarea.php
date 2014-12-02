<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once RCX_ROOT_PATH."/class/form/formtextarea.php";

// Make sure you have included /include/rcxcodes.php, otherwise DHTML will not work properly!

class GallFormDhtmlTarea extends RcxFormTextArea
{
  var $_hiddenText;

  function GallFormDhtmlTarea($caption, $name, $values, $rows=5, $cols=50, $taille="x-small", $police="Verdana", $color="000000", $hiddentext="rcxHiddenText")
  {
    $this->RcxFormTextArea($caption, $name, $values, $rows, $cols);
    $this->_hiddenText = $hiddentext;
        $this->police = $police;
        $this->taille = $taille;
        $this->color = $color;
  }

  function render()
  {
    $sizearray = array("xx-small", "x-small", "small", "medium", "large", "x-large", "xx-large");
    $ret = "<select name='taille' id='".$this->getName()."Size' onchange='setVisible(\"rcxHiddenText\");setElementSize(\"".$this->_hiddenText."\",this.options[this.selectedIndex].value);'>\n";
    $ret .= "<option value='small'>"._SIZE."</option>\n";
    foreach ( $sizearray as $size ) {
      $ret .= "<option value='$size'";
            if ( $size == $this->taille ) {
            $ret .= " selected='selected'";
          }
            $ret .= ">$size</option>\n";
    }
    $ret .= "</select>\n";
    $fontarray = array("Arial", "Courier", "Georgia", "Helvetica", "Impact", "Verdana");
    $ret .= "<select name='police' id='".$this->getName()."Font' onchange='setVisible(\"".$this->_hiddenText."\");setElementFont(\"".$this->_hiddenText."\",this.options[this.selectedIndex].value);'>\n";
    $ret .= "<option value='Verdana'>"._FONT."</option>\n";
    foreach ( $fontarray as $font ) {
      $ret .= "<option value='$font'>$font</option>\n";
    }
    $ret .= "</select>\n";
    $colorarray = array("00", "33", "66", "99", "CC", "FF");
    $ret .= "<select name='color' id='".$this->getName()."Color' onchange='setVisible(\"".$this->_hiddenText."\");setElementColor(\"".$this->_hiddenText."\",this.options[this.selectedIndex].value);'>\n";
    $ret .= "<option value='000000'>"._COLOR."</option>\n";
    foreach ( $colorarray as $color1 ) {
      foreach ( $colorarray as $color2 ) {
        foreach ( $colorarray as $color3 ) {
          $ret .= "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'>#".$color1.$color2.$color3."</option>\n";
        }
      }
    }
    $ret .= "</select><span id='".$this->_hiddenText."'>"._EXAMPLE."</span>\n";
    $ret .= "<br /><br />\n";
    $ret .= "<a href='javascript:setVisible(\"".$this->_hiddenText."\");makeBold(\"".$this->_hiddenText."\");' /><img src='".IMG_URL."/bold.gif' alt='bold' align='absmiddle' /></a>&nbsp;";
    $ret .= "<a href='javascript:setVisible(\"".$this->_hiddenText."\");makeItalic(\"".$this->_hiddenText."\");' /><img src='".IMG_URL."/italic.gif' align='absmiddle' alt='italic' /></a>&nbsp;";
    $ret .= "<a href='javascript:setVisible(\"".$this->_hiddenText."\");makeUnderline(\"".$this->_hiddenText."\");'><img src='".IMG_URL."/underline.gif' align='absmiddle' alt='underline' /></a>&nbsp;&nbsp;";
    $ret .= "<input type='text' id='".$this->getName()."Addtext' size='20' />&nbsp;<input type='button' class='button' onclick='rcxCodeText(\"".$this->getName()."\", \"".$this->_hiddenText."\")' value='"._ADD."' /><br /><br /><textarea id='".$this->getName()."' name='".$this->getName()."' onselect=\"rcxSavePosition('".$this->getName()."');\" onclick=\"rcxSavePosition('".$this->getName()."');\" onkeyup=\"rcxSavePosition('".$this->getName()."');\" cols='".$this->getCols()."' rows='".$this->getRows()."'".$this->getExtra().">".$this->getValue()."</textarea><br />\n";
    return $ret;
  }

}
?>
