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
defined( 'RCX_ROOT_PATH' ) or exit( '<h1>Forbidden</h1> You don\'t have permission to access' );

function tpl_list()
{
    include_once(RCX_ROOT_PATH . "/class/rcxlists.php");
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");

    rcx_cp_header();
    OpenTable();

    $form = new ThemeForm(_TE_LIST_TEMPLATES, "themeform", "admin.php?fct=tpleditor", true, "post", true);
    $form->setExtra("enctype='multipart/form-data'");
    $dir = RCX_ROOT_PATH . "/themes/";
    $themes_list = &RcxLists::getDirListAsArray($dir);
    $form->addElement(new FormHeadingRow(_TE_TEMPLATES));
    if ($themes_list) {
        foreach($themes_list as $theme) {
			$themelinc = "<a href='admin.php?fct=tpleditor&op=tpl_edit&tpl=" . $theme . "'>" . _TE_EDIT . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='". RCX_URL."/themes/".$theme ."/". $theme. ".php' >" . _TE_DELETE ."</a>
<br> <img style='width: 100px; height: 100px; float: right;' alt='".$theme."' src='". RCX_URL ."/themes/". $theme ."/images/". $theme .".jpg' /></a>";
            $form->addElement(new RcxFormLabel('<b>' . $theme . '</b>', $themelinc));
  				} 
    } else {
        $form->addElement(new FormHeadingRow(_TE_NOT_TEMPLATES, "center", "bg3"));
    } 

    $form->addElement(new FormHeadingRow(_TE_LOAD_TEMPLATE));
    $form->addElement(new RcxFormFile(_TE_LOAD_FILE, "download", 600000));
    $submit_button = new RcxFormButton("", "submit", _TE_LOAD, "submit");
    $s_button = $submit_button->render();
    $form->addElement(new FormHeadingRow($s_button, "center", "bg3"));
    $form->addElement(new RcxFormHidden("op", "tpl_extract"));

    $form->display();

    CloseTable();
    inc_function('show_copyright');
	rcx_cp_footer();
} 

?>
