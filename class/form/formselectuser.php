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

if (!defined("ERCX_RCXFORMSELECTUSER_INCLUDED")) {
	define("ERCX_RCXFORMSELECTUSER_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/form/formselect.php");

class RcxFormSelectUser extends RcxFormSelect {

	function RcxFormSelectUser($caption, $name, $include_anon=false, $value="", $size=1, $multiple=false) {
		$this->RcxFormSelect($caption, $name, $value, $size, $multiple);
		if ($include_anon) {
			global $rcxConfig;
			$this->addOption(0, $rcxConfig['anonymous']);
		}
		
				$this->addOptionArray(RcxUser::getAllUsersList($criteria=array(), $orderby="uname ASC", $limit=0, $start=0));
			
	}
} // END CLASS
} // END DEFINED
?>
