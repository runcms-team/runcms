<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* converted to Runcms2 serie by Farsus Design www.farsus.dk
*
* Original Author: LaRok (larok@bk.ru)
* Author Website : http://www.e-xoops.ru
* License Type   : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 LaRok. All rights reserved
*
*/ 

if (!defined("RCX_FORMHEADINGROW_INCLUDED")) {
	define("RCX_FORMHEADINGROW_INCLUDED", 1);

	include_once(RCX_ROOT_PATH . "/class/form/formelement.php");

	class FormHeadingRow extends RcxFormElement {
		var $align;
		var $bgclass;

		function FormHeadingRow($caption = '', $align = 'right', $class = 'bg2')
		{
			$this->setHidden();
			$this->caption = $caption;
			$this->align = $align;
			$this->bgclass = $class;
		} 

		function render()
		{
			return "<tr valign='top' align='{$this->align}'><td nowrap='nowrap' colspan='2' class='{$this->bgclass}'><b>{$this->caption}</b></td></tr>";
		} 
	} 
} 

?> 