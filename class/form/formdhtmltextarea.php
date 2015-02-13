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

if (!defined("ERCX_RCXFORMDHTMLTEXTAREA_INCLUDED")) {
        define("ERCX_RCXFORMDHTMLTEXTAREA_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formtextarea.php");

class RcxFormDhtmlTextArea extends RcxFormTextArea
{

  var $no_smile = false;
    
  function RcxFormDhtmlTextArea($caption, $name, $value="", $rows=10, $cols=80, $no_smile = false)
  {
      $this->no_smile = $no_smile;
      $this->RcxFormTextArea($caption, $name, $value, $rows, $cols);
  }

  /**
  * Description
  *
  * @param type $var description
  * @return type description
  */
  function render()
  {
    global $myts, $rcxUser;

    include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.js.php");

    $admin = 0;
    if ($rcxUser && $rcxUser->isAdmin())
    {
      $admin = 1;
    }

    $ret  = "
  <div class='controlbar'>
      <table width='100%' border='0' cellspacing='1' cellpadding='0' class='rcxformdhtmltextarea'>
        <tr class='bg2'>
                <td style='vertical-align: top;'>
            <table width='100%' border='0' cellspacing='1' cellpadding='1'>
              <tr class='bg1'>
                <td style='vertical-align: top;' colspan='2' class='bg3'>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/bold.gif' alt='"._BOLD."' title='"._BOLD."' onclick='rcxCodeBold(\"".$this->getName()."\");'  /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/italic.gif' alt='"._ITALIC."' title='"._ITALIC."' onclick='rcxCodeItalic(\"".$this->getName()."\");'  /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/underline.gif' alt='"._UNDERLINE."' title='"._UNDERLINE."' onclick='rcxCodeUnderline(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/strike.gif' alt='"._STRIKE."' title='"._STRIKE."' onclick='rcxCodeStrike(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/overline.gif' alt='"._OVERLINE."' title='"._OVERLINE."' onclick='rcxCodeOverline(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/right.gif' alt='"._RIGHT."' title='"._RIGHT."' onclick='rcxCodeRight(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/center.gif' alt='"._CENTER."' title='"._CENTER."' onclick='rcxCodeCenter(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/left.gif' alt='"._LEFT."' title='"._LEFT."' onclick='rcxCodeLeft(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/justify.gif' alt='"._JUSTIFY."' title='"._JUSTIFY."' onclick='rcxCodeJustify(\"".$this->getName()."\");' /></a>
                  
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/list.gif' alt='"._LIST."' title='"._LIST."' onclick='rcxCodeList(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/hr.gif' alt='"._HLINE."' title='"._HLINE."' onclick='rcxCodeHr(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marqd.gif' alt='"._MARQD."' title='"._MARQD."' onclick='rcxCodeMarqd(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marqu.gif' alt='"._MARQU."' title='"._MARQU."' onclick='rcxCodeMarqu(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marql.gif' alt='"._MARQL."' title='"._MARQL."' onclick='rcxCodeMarql(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marqr.gif' alt='"._MARQR."' title='"._MARQR."' onclick='rcxCodeMarqr(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marqh.gif' alt='"._MARQH."' title='"._MARQH."' onclick='rcxCodeMarqh(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/marqv.gif' alt='"._MARQV."' title='"._MARQV."' onclick='rcxCodeMarqv(\"".$this->getName()."\");' /></a>
                  
                  </td>
              </tr>
              <tr class='bg3'>
                  <td style='vertical-align: top;' width='140px'>
                 
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/link.gif' alt='"._URL."' title='"._URL."' onclick='rcxCodeUrl(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/image.gif' alt='"._IMG."' title='"._IMG."' onclick='rcxCodeImg(\"".$this->getName()."\");' /></a>";
    if ($admin || $myts->allowLibrary == 1)
    {
      $ret .= "
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/image-m.gif' alt='"._LIB."' title='"._LIB."' onclick='openWithSelfMain(\"".RCX_URL."/misc.php?action=showpopups&type=images&target=".$this->getName()."\", \"images\", 350, 450);' /></a>";
    }
    $ret .= "
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/email.gif' alt='"._EMAIL."' title='"._EMAIL."' onclick='rcxCodeEmail(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/quote.gif' alt='"._QUOTE."' title='"._QUOTE."' onclick='rcxCodeQuote(\"".$this->getName()."\");' /></a>
                  <a href='javascript:justReturn();'><img src='".RCX_URL."/images/editor/code.gif' alt='"._CODE."' title='"._CODE."' onclick='rcxCodeCode(\"".$this->getName()."\");' /></a>
                  
                  </td>
                  <td style='vertical-align: top;'>
                  
                  <select class='select' id='".$this->getName()."Size' onchange='rcxCodeSize(\"".$this->getName()."\");'></a>
                    <option value='SIZE'>"._SIZE."</option>";
    $sizearray = array("xx-small", "x-small", "small", "medium", "large", "x-large", "xx-large");
    foreach ($sizearray as $size)
    {
      $ret .=  "
                    <option value='$size'>$size</option>";
    }
    $ret .= "
                  </select> ";
    
    $fontarray = array("Arabic Transparent", "Arial", "Comic Sans MS", "Courier", "Georgia", "Helvetica", "Impact", "MS Sans Serif", "Monotype Corsiva", "Simplified Arabic", "Tahoma", "Times New Roman", "Traditional Arabic", "Verdana", "Wingdings", "Wingdings 2", "Wingdings 3");
    $ret      .= "
                  <select class='select' id='".$this->getName()."Font' onchange='rcxCodeFont(\"".$this->getName()."\");'>
                    <option value='FONT'>"._FONT."</option>";
    foreach ($fontarray as $font)
    {
      $ret .= "
                    <option value='$font'>$font</option>";
    }
    $ret .= "
                  </select> ";
    $ret .= "
                  <select class='select' id='".$this->getName()."Color' onchange='rcxCodeColor(\"".$this->getName()."\");'>
                    <option value='COLOR'>"._COLOR."</option>";
//    $colorarray = array("00", "33", "66", "99", "CC", "FF");
    $colorarray = array("00", "40", "80", "BF", "FF");
    foreach ($colorarray as $color1)
    {
      foreach ($colorarray as $color2)
      {
        foreach ($colorarray as $color3)
        {
          $ret .= "
                    <option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'>#".$color1.$color2.$color3."</option>";
        }
      }
    }
    $ret .= "
                  </select>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <textarea class='textarea' style='width:100%' id='".$this->getName()."' name='".$this->getName()."' cols='".$this->getCols()."' rows='".$this->getRows()."'".$this->getExtra().">".$this->getValue()."</textarea>
      <br />";
    $ret .= $this->renderSmileys();
    
    $ret .= "</div>";
    
    return $ret;
  }

  /**
  * Description
  *
  * @param type $var description
  * @return type description
  */
  function renderSmileys()
  {

      global $rcxConfig;
      
      //    $smileyPath = "images/smilies";

    if ($rcxConfig['no_smile'] || $this->no_smile == true) {
	    return '';
    }

    $ret  = "
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-) \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_smile.gif' border='0' alt=':-)' title=':-)' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-( \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_frown.gif' border='0' alt=':-(' title=':-(' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-D \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_biggrin.gif' border='0' alt=':-D' title=':-D' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" ;-) \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_wink.gif' border='0' alt=';-)' title=';-)' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-o \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_eek.gif' border='0' alt=':-o' title=':-o' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" 8-) \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_cool.gif' border='0' alt='8-)' title='8-)' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-? \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_confused.gif' border='0' alt=':-?' title=':-?' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-P \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_razz.gif' border='0' alt=':-P' title=':-P' /></a>
      <a href='javascript:justReturn()' onclick='rcxCodeSmilie(\"".$this->getName()."\", \" :-x \");'><img width='25' height='25' src='".RCX_URL."/images/smilies/icon_mad.gif' border='0' alt=':-x' title=':-x' /></a>
      &nbsp;&nbsp;
      [<a href='javascript:openWithSelfMain(\"".RCX_URL."/misc.php?action=showpopups&amp;type=smilies&amp;target=".$this->getName()."\",\"smilies\", 300, 535);'>"._MORE."</a>]";

    return $ret;
  }

} // END CLASS
} // END DEFINED
?>