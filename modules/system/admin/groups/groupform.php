<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

global $_SERVER;
if ( preg_match("/groupform\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}

include_once(RCX_ROOT_PATH."/class/rcxformloader.php");

$name_text      = new RcxFormText(_AM_NAME, "name", 30, 50, $name_value);
$desc_text      = new RcxFormTextArea(_AM_DESCRIPTION, "desc", $desc_value);


// GET modules with admin rights
$modules_array  = array();
$modules_array  = RcxModule::getHasAdminModulesList();
$a_mod_checkbox = new RcxFormCheckBox(_AM_ACTIVERIGHTS, "admin_mids[]", $a_mod_value);
foreach ($modules_array as $key=>$value) {
	$modules_array[$key] = $value."<br />";
}
$a_mod_checkbox->addOptionArray($modules_array);


// GET normal modules
$modules_array  = array();
$modules_array  = RcxModule::getHasMainModulesList();
$r_mod_checkbox = new RcxFormCheckBox(_AM_ACCESSRIGHTS, "read_mids[]", $r_mod_value);
foreach ($modules_array as $key=>$value) {
	$modules_array[$key] = "$value<br />";
}
$r_mod_checkbox->addOptionArray($modules_array);


// GET leftblocks
$new_blocks_array  = array();
$r_lblock_checkbox = new RcxFormCheckBox(_AM_BLOCKRIGHTS.":<br /><i>"._LEFT."</i>", "read_bids[]", $r_block_value);
$blocks_array      = RcxBlock::getAllBlocks("list", RCX_SIDEBLOCK_LEFT, 1, "weight", 1);
foreach ($blocks_array as $key=>$value) {
	$new_blocks_array[$key] = "<a href='".RCX_URL."/modules/system/admin.php?fct=blocksadmin&op=edit&bid=".$key."'>".$value."</a><br />";
}
$r_lblock_checkbox->addOptionArray($new_blocks_array);


// GET top-centerblocks
$new_blocks_array   = array();
$r_tcblock_checkbox = new RcxFormCheckBox(_AM_BLOCKRIGHTS.":<br /><i>"._TOP."-"._CENTER."</i>", "read_bids[]", $r_block_value);
$blocks_array       = RcxBlock::getAllBlocks("list", RCX_CENTERBLOCK_TOPALL, 1, "weight", 1);
foreach ($blocks_array as $key=>$value) {
	$new_blocks_array[$key] = "<a href='".RCX_URL."/modules/system/admin.php?fct=blocksadmin&op=edit&bid=".$key."'>".$value."</a><br />";
}
$r_tcblock_checkbox->addOptionArray($new_blocks_array);


// GET bottom-centerblocks
$new_blocks_array   = array();
$r_bcblock_checkbox = new RcxFormCheckBox(_AM_BLOCKRIGHTS.":<br /><i>"._BOTTOM."-"._CENTER."</i>", "read_bids[]", $r_block_value);
$blocks_array       = RcxBlock::getAllBlocks("list", RCX_CENTERBLOCK_BOTTOMALL, 1, "weight", 1);
foreach ($blocks_array as $key=>$value) {
	$new_blocks_array[$key] = "<a href='".RCX_URL."/modules/system/admin.php?fct=blocksadmin&op=edit&bid=".$key."'>".$value."</a><br />";
}
$r_bcblock_checkbox->addOptionArray($new_blocks_array);


// GET rightblocks
$new_blocks_array  = array();
$r_rblock_checkbox = new RcxFormCheckBox(_AM_BLOCKRIGHTS.":<br /><i>"._RIGHT."</i>", "read_bids[]", $r_block_value);
$blocks_array      = RcxBlock::getAllBlocks("list", RCX_SIDEBLOCK_RIGHT, 1, "weight", 1);
foreach ($blocks_array as $key=>$value) {
	$new_blocks_array[$key] = "<a href='".RCX_URL."/modules/system/admin.php?fct=blocksadmin&op=edit&bid=".$key."'>".$value."</a><br />";
}
$r_rblock_checkbox->addOptionArray($new_blocks_array);


$op_hidden     = new RcxFormHidden("op", $op_value);
$fct_hidden    = new RcxFormHidden("fct", "groups");
$submit_button = new RcxFormButton("", "groupsubmit", $submit_value, "submit");

$form = new RcxThemeForm('', "groupform", "admin.php", "post", true);
$form->addElement($name_text);
$form->addElement($desc_text);
$form->addElement($a_mod_checkbox);
$form->addElement($r_mod_checkbox);
$form->addElement($r_lblock_checkbox);
$form->addElement($r_tcblock_checkbox);
$form->addElement($r_bcblock_checkbox);
$form->addElement($r_rblock_checkbox);

$form->addElement($op_hidden);
$form->addElement($fct_hidden);


if ( !empty($g_id_value) ) {
	$g_id_hidden = new RcxFormHidden("g_id", $g_id_value);
	$form->addElement($g_id_hidden);
}


$form->addElement($submit_button);
$form->setRequired("name");
$form->display();
?>
