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

function lang_edit()
{

    if (check_theme($_GET['tpl']) == false) {
        redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
        exit();
    }

    $lng_file = basename('lang-' . $_GET['lang'] . '.php');
    $lng_path = RCX_ROOT_PATH . '/themes/' . $_GET['tpl'] . '/language/' . $lng_file;

    if (!is_file($lng_path)) {
        redirect_header('admin.php?fct=tpleditor', 5, _TE_NO_FILE);
        exit();
    }

    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");

    rcx_cp_header();
    OpenTable();
    $form = new ThemeForm(get_main_link() . get_tpl_link($_GET['tpl']) . sprintf(_TE_LANGUAGE_EDITOR, $lng_file), "themeform", "admin.php?fct=tpleditor", true, "post", true);
    $form->addElement(new FormHeadingRow(_TE_CONST_DEF));

    $i = 1;
    $f_open = fopen($lng_path, 'rb');
    while ($line = fgets($f_open)) {
        $line = trim($line);
        if (preg_match('/^define/i', $line)) {
            $c_array = preg_split('/[\'"]/i', $line);
            if (sizeof($c_array) == 5) {
                $name_text = new RcxFormText('', 'lang[' . $i . '][name]', 40, 100, $c_array[1]);
                $c_name = $name_text->render();
                $value_text = new RcxFormText('', 'lang[' . $i . '][value]', 40, 100, $c_array[3]);
                $c_value = $value_text->render();
                $form->addElement(new RcxFormLabel($c_name, $c_value));
                $i++;
            }
        }
    }

    $form->addElement(new FormHeadingRow("&nbsp;"));
    $form_buttons = new RcxFormElementTray('<b>' . _ACTION . '</b>', "&nbsp;");
    $submit_button = new RcxFormButton("", "submit", _TE_EDIT, "submit");
    $form_buttons->addElement($submit_button);
    $cancel_button = new RcxFormButton("", "cancel", _CANCEL, "button");
    $cancel_button->setExtra("onclick='javascript:history.go(-1)'");
    $form_buttons->addElement($cancel_button);
    $form->addElement($form_buttons);
    $form->addElement(new RcxFormHidden("op", "lang_save"));
    preg_match('/lang-([a-z]+).php/', $lng_file, $matches);
    $form->addElement(new RcxFormHidden("langf", $matches[1]));
    $form->addElement(new RcxFormHidden("tpl", $_GET['tpl']));

    $form->display();
    CloseTable();
    inc_function('show_copyright');
    rcx_cp_footer();
}

?>