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

if (!defined("ERCX_RCXCODES_INCLUDED")) {
	define("ERCX_RCXCODES_INCLUDED", 1);
include_once(RCX_ROOT_PATH . "/class/form/formdhtmltextarea.php");
/**
* Depracted, use as follows:

include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');

$desc = new RcxFormDhtmlTextArea('', 'message', $message, 10, 50);
echo $desc->render();
*/
function rcxCodeTarea($textarea_id, $cols=50, $rows=10) {
global $$textarea_id;
$textarea = new RcxFormDhtmlTextArea("", $textarea_id, $$textarea_id, $rows, $cols);
echo $textarea->render();
}
/**
* Depracted, the above function automaticly renders this already
*/
function rcxSmilies($textarea_id) {
}
}
?>
