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
if (!defined("RCX_THEMEFORM_INCLUDED")) {
    define("RCX_THEMEFORM_INCLUDED", 1);

    include_once(RCX_ROOT_PATH . "/class/form/form.php");

    class ThemeForm extends RcxForm {
        var $show_title;
        function ThemeForm($caption, $name, $action, $show_title = true, $method = "post", $addtoken = false)
        {
            $this->RcxForm($caption, $name, $action, $method, $addtoken);
            $this->setExtra("onsubmit='return rcxFormValidate_" . $this->getName() . "();'");
            $this->show_title = $show_title;
        } 

        function render($value = "")
        {
            $required = $this->getRequired();
            if ($this->show_title) {
                $ret = "
	<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'><tr><td class='bg2'>
	<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr><td class='bg3'><b>" . $this->getTitle() . "</b></td></tr>
	</table></td></tr></table><br>";
            } else {
                $ret = "";
            } 
            $ret .= "
			<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'><tr>
			<form name='" . $this->getName() . "' id='" . $this->getName() . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "'" . $this->getExtra() . ">
	        <td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>";

            foreach ($this->getElements() as $ele) {
                if (!$ele->isHidden()) {
                    $ret .= "<tr valign='top'><td class='bg3' width='35%'>" . $ele->getCaption() . "</td><td class='bg1'>" . $ele->render() . "</td></tr>";
                } else {
                    $ret .= $ele->render();
                } 
            } 
            $js = '
	<script type="text/javascript">
	<!--
	function rcxFormValidate_' . $this->getName() . '() {';
            foreach ($required as $req) {
                $js .= 'if ( rcxGetElementById("' . $this->getName() . '").' . $req . '.value == "" ) {
				alert("' . sprintf(_FORM_ENTER, $req) . '");
				rcxGetElementById("' . $this->getName() . '").' . $req . '.focus();
				return false;
			}';
            } 
            $js .= '}
	//--->
	</script>';

            $ret .= "</table></td></tr></form></table>";
            $ret = $js . $ret;

            return $ret;
        } 
        // END CLASS
    } 
    // END DEFINED
} 

?>