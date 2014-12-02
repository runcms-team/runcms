<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

class RcxFormTextDateSelect extends RcxFormText
{

  function RcxFormTextDateSelect($caption, $name, $size = 15, $value= 0)
  {
    $value = !is_numeric($value) ? time() : intval($value);
    $this->RcxFormText($caption, $name, $size, 25, $value);
  }

  function render()
  {
//    $jstime = formatTimestamp('F j Y, H:i:s', $this->getValue());
    $jstime = $this->value;
    include_once RCX_ROOT_PATH.'/include/calendarjs.php';
    return "<input type='text' name='".$this->getName()."' id='".$this->getName()."' size='".$this->getSize()."' maxlength='".$this->getMaxlength()."' value='".date("Y-m-d", $this->getValue())."'".$this->getExtra()." /><input type='reset' value=' ... ' onclick='return showCalendar(\"".$this->getName()."\");'>";
  }
}
?>