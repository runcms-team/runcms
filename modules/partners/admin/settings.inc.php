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
if ( preg_match("/settings\.inc\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}

include_once(RCX_ROOT_PATH . "/class/rcxformloader.php");
$form = new RcxThemeForm("", "settings", "./index.php");

// COMMON
$cookietime = new RcxFormText(_AM_CRECLICK, "partners_cookietime", 6, 6, $partners_cookietime);

// MAIN
$randomize  = new RcxFormRadioYN(_AM_MRAND, "partners_randomize", $partners_randomize);
$limit      = new RcxFormText(_AM_MLIMIT, "partners_limit", 3, 3, $partners_limit);

$show       = new RcxFormSelect(_AM_MSHOW, "partners_show", $partners_show);
$show->addOptionArray(array("1"=>_AM_CIMAGES, "2"=>_AM_CTEXT, "3"=>_AM_CBOTH));

$order      = new RcxFormSelect("", "partners_order", $partners_order);
$order->addOptionArray(array("id"=>_AM_CID, "hits"=>_AM_CHITS, "title"=>_AM_CTITLE, "weight"=>_AM_CWEIGHT));

$orderd     = new RcxFormSelect("", "partners_orderd", $partners_orderd);
$orderd->addOptionArray(array("ASC"=>_AM_CASC, "DESC"=>_AM_CDESC));

$tray      = new RcxFormElementTray(_AM_MORDER, "&nbsp;");
$tray->addElement($order);
$tray->addElement($orderd);

// BLOCKS
$brandomize = new RcxFormRadioYN(_AM_BRAND, "partners_brandomize", $partners_brandomize);
$blimit     = new RcxFormText(_AM_BLIMIT, "partners_blimit", 3, 3, $partners_blimit);

$bshow      = new RcxFormSelect(_AM_BSHOW, "partners_bshow", $partners_bshow);
$bshow->addOptionArray(array("1"=>_AM_CIMAGES, "2"=>_AM_CTEXT, "3"=>_AM_CBOTH));

$border     = new RcxFormSelect("", "partners_border", $partners_border);
$border->addOptionArray(array("id"=>_AM_CID, "hits"=>_AM_CHITS, "title"=>_AM_CTITLE, "weight"=>_AM_CWEIGHT));

$borderd    = new RcxFormSelect("", "partners_borderd", $partners_borderd);
$borderd->addOptionArray(array("ASC"=>_AM_CASC, "DESC"=>_AM_CDESC));

$btray      = new RcxFormElementTray(_AM_BORDER, "&nbsp;");
$btray->addElement($border);
$btray->addElement($borderd);

// FINISH
$hidden     = new RcxFormHidden("op", "save_partners");
$submit_button = new RcxFormButton("", "submit", _AM_CUPDATE, "submit");

$form->addElement($cookietime);

$form->addElement($randomize);
$form->addElement($limit);
$form->addElement($show);
$form->addElement($tray);

$form->addElement($brandomize);
$form->addElement($blimit);
$form->addElement($bshow);
$form->addElement($btray);

$form->addElement($hidden);
$form->addElement($submit_button);

$form->display();
?>
