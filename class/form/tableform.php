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

if (!defined("ERCX_RCXTABLEFORM_INCLUDED")) {
	define("ERCX_RCXTABLEFORM_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/form.php");

class RcxTableForm extends RcxForm {

	function RcxTableForm($title, $name, $action, $method="post", $addtoken = false) {
		$this->RcxForm($title, $name, $action, $method, $addtoken);
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function render() {

$ret = $this->getTitle()."<form name='".$this->getName()."' id='".$this->getName()."' action='".$this->getAction()."' method='".$this->getMethod()."'".$this->getExtra()."><table border='0' width='100%'>";

foreach ( $this->getElements() as $ele ) {
	if ( !$ele->isHidden() ) {
		$ret .= "<tr valign='top'><td nowrap='nowrap'>".$ele->getCaption()."</td><td>".$ele->render()."</td></tr>";
		} else {
			$ret .= $ele->render();
		}
}
$ret .= "</table></form>";

return $ret;
}
} // END CLASS
} // END DEFINED
?>
