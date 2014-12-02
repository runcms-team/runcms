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

if (!defined("ERCX_FORMHEADINGROW_INCLUDED")) {
    define("ERCX_FORMHEADINGROW_INCLUDED", 1);

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