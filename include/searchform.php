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

global $myts;
// initialize form vars
$query = $myts->makeTboxData4PreviewInForm($query);
// create form elements
$query_text  = new RcxFormText(_SR_KEYWORDS, "query", 30, 255, $query);
$type_select = new RcxFormSelect(_TYPE, "andor", $andor);
$type_select->addOptionArray(array("AND"=>_SR_ALL, "OR"=>_SR_ANY, "exact"=>_SR_EXACT));
$mods_checkbox = new RcxFormCheckBox(_SR_SEARCHIN, "mids[]", $mids);
$mods_checkbox->addOptionArray(RcxModule::getHasSearchModulesList());
$action_hidden = new RcxFormHidden("action", "results");
$submit_button = new RcxFormButton("", "submit", _SR_SEARCH, "submit");
// create form
$search_form = new RcxThemeForm(_SR_SEARCH, "search", "search.php");
$search_form->addElement($query_text);
$search_form->addElement($type_select);
$search_form->addElement($mods_checkbox);
$search_form->addElement($action_hidden);
$search_form->addElement($submit_button);
?>
