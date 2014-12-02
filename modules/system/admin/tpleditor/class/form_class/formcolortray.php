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
* Original Author: LARK (balnov@kaluga.net)
* Support of the module : http://www.runcms.ru
* License Type : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 Vladislav Balnov. All rights reserved
*
*/ 
if (!defined("FORM_COLOR_TRAY_INCLUDED")) {
    define("FORM_COLOR_TRAY_INCLUDED", 1);

    include_once(RCX_ROOT_PATH . "/class/form/formtext.php");

    class FormColorTray extends RcxFormText {
        var $id;
        function FormColorTray($caption, $name, $size, $maxlength, $value, $id)
        {
            $this->RcxFormText($caption, $name, $size, $maxlength, $value);
            $this->id = $id;
        } 

        function render()
        {
            $ret = "&nbsp;<input type='text' class='text' name='" . $this->getName() . "' id='" . $this->id . "' size='" . $this->getSize() . "' maxlength='" . $this->getMaxlength() . "' value='" . $this->getValue() . "'" . $this->getExtra() . " />&nbsp;&nbsp;";
            $ret .= "<input type='text' id='" . $this->id . "ShowColor' class='text' style='border:1px solid black;background-color: " . $this->getValue() . "' readonly='readonly' size='6'  />&nbsp;&nbsp;";
            $ret .= "<a href='javascript:justReturn();' onclick='openWithSelfMain(\"" . RCX_URL . "/modules/system/admin.php?fct=tpleditor&op=colors_popup&id=" . $this->id . "\",\"colors_popup\", 400, 185);'><img src='" . RCX_URL . "/modules/system/admin/tpleditor/images/colorselect.png' width='17' height='17' align='top' alt='" . _TE_COLORS_TABLE . "' title='" . _TE_COLORS_TABLE . "'></a>";

            return $ret;
        } 
    } 
} 

?>
