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

if (!defined("ERCX_RCXTHEMEFORM_INCLUDED")) {
  define("ERCX_RCXTHEMEFORM_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/form.php");

class RcxThemeForm extends RcxForm {

  function RcxThemeForm($caption, $name, $action, $method="post", $addtoken = false) {
    $this->RcxForm($caption, $name, $action, $method, $addtoken);
    $this->setExtra("onsubmit='return rcxFormValidate_".$this->getName()."();'");
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function render($value="") {

$required = $this->getRequired();
$ret = "
  <h4 style='text-align:left;'>".$this->getTitle()."</h4>
  <form name='".$this->getName()."' id='".$this->getName()."' action='".$this->getAction()."' method='".$this->getMethod()."'".$this->getExtra().">
  <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
  <td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>";

foreach ($this->getElements() as $ele)
{
  if (!$ele->isHidden() && !$ele->isColspan())
    $ret .= "<tr valign='top'><td class='bg3'><b>".$ele->getCaption()."</b></td><td class='bg1'>".$ele->render()."</td></tr>";
  elseif (!$ele->isHidden() && $ele->isColspan())
    $ret .= "<tr valign='top'><td colspan='2' class='bg1'>".$ele->render()."</td></tr>";
  else
    $ret .= $ele->render();
}

$js = '
  <script type="text/javascript">
  <!--
  function rcxFormValidate_'.$this->getName().'() {';
  foreach ($required as $req) {
    $js .= 'if ( rcxGetElementById("'.$this->getName().'").'.$req.'.value == "" ) {
        alert("'.sprintf(_FORM_ENTER, $req).'");
        rcxGetElementById("'.$this->getName().'").'.$req.'.focus();
        return false;
      }';
  }
  $js .= '}
  //--->
  </script>';

$ret .= "</table></td></tr></table></form>";
$ret = $js.$ret;

return $ret;
}
} // END CLASS
} // END DEFINED
?>
