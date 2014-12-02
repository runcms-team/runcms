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
if (!preg_match("/admin\.php/i", _PHP_SELF)) {
    exit();
} 
if ($rcxUser->isAdmin($rcxModule->mid())) {
    include (RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/functions.inc.php");
    $op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

    switch ($op) {
        case "tpl_edit":
            inc_function('tpl_edit');
            break;

        case "file_edit":
            inc_function('file_edit');
            break;

        case "lang_edit":
            inc_function('lang_edit');
            break;

        case "lang_save":
            inc_function('lang_save');
            break;

        case "tpl_extract":
            inc_function('tpl_extract');
            break;

        case "css_edit":
            inc_function('css_edit');
            break;

        case "img_edit":
            inc_function('img_edit');
            break;

        case "tpl_info_save":
            inc_function('tpl_info_save');
            break;

        case "file_popup":
            inc_function('file_popup');
            break;

        case "colors_popup":
            inc_function('colors_popup');
            break;

        case "tpl_module_edit":
            inc_function('tpl_module_edit');
            break;

        default:
            inc_function('tpl_list');
            break;
    } 
} else {
    echo "Access Denied";
} 

?>
