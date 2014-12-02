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

if (!defined("ERCX_RCXSIMPLEFORM_INCLUDED")) {
	define("ERCX_RCXSIMPLEFORM_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/form.php");

class RcxSimpleForm extends RcxForm {

	function RcxSimpleForm($title, $name, $action, $method="post", $addtoken = false) {
		$this->RcxForm($title, $name, $action, $method, $addtoken);
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {

$ret = $this->getTitle()."<form name='".$this->getName()."' id='".$this->getName()."' action='".$this->getAction()."' method='".$this->getMethod()."'".$this->getExtra().">";

foreach ( $this->getElements() as $ele ) {
	if ( !$ele->isHidden() ) {
		$ret .= "<b>".$ele->getCaption()."</b><br />".$ele->render()."<br />";
		} else {
			$ret .= $ele->render();
		}
}
$ret .= "</form>";

return $ret;
}
} // END CLASS
} // END DEFINED
?>
