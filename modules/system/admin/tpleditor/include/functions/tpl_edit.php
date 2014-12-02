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

function tpl_edit()
{
    global $db, $rcxConfig;

    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/tpl_files_config.php");

    $tpl = $_GET['tpl'];

    if (check_theme($tpl) == false) {
        redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
        exit();
    }

    $dir = RCX_ROOT_PATH . "/themes/" . $tpl . "/";
    $theme_version = $dir . "theme_version.php";

    if (is_file($theme_version)) {
        include_once($theme_version);
    } else {
        redirect_header('admin.php?fct=tpleditor', 5, _TE_NO_TPL_VERSION);
        exit();
    }

    rcx_cp_header();
    OpenTable();

    $form = new ThemeForm(get_main_link() . sprintf(_TE_EDITOR_TEMPLATE, $tpl), "themeform", "admin.php?fct=tpleditor", true, "post", true);

    $form->addElement(new FormHeadingRow(_TE_GENERAL_DATA));
    $form->addElement(new RcxFormText(_TE_TPL_NAME, 'tpl_info[theme_name]', 40, 100, $tpl_info['theme_name']));
    $form->addElement(new RcxFormText(_TE_TPL_AUTHOR, 'tpl_info[author]', 40, 100, $tpl_info['author']));
    $form->addElement(new RcxFormText(_TE_TPL_AUTHOR_SITE, 'tpl_info[website]', 40, 100, $tpl_info['website']));
    $form->addElement(new RcxFormText(_TE_TPL_LICENSE, 'tpl_info[license]', 40, 100, $tpl_info['license']));
    $form->addElement(new RcxFormText(_TE_TPL_DESCRIPTION, 'tpl_info[details]', 40, 100, $tpl_info['details']));
    $form->addElement(new RcxFormText(_TE_TPL_VERSION, 'tpl_info[revison]', 40, 100, $tpl_info['revison']));
    $form->addElement(new RcxFormHidden("tpl_info[foldername]", $tpl_info['foldername']));

    $form->addElement(new FormHeadingRow("&nbsp;"));
    $form_buttons = new RcxFormElementTray('<b>' . _ACTION . '</b>', "&nbsp;");
    $submit_button = new RcxFormButton("", "submit", _TE_EDIT, "submit");
    $form_buttons->addElement($submit_button);
    $cancel_button = new RcxFormButton("", "cancel", _CANCEL, "button");
    $cancel_button->setExtra("onclick='javascript:history.go(-1)'");
    $form_buttons->addElement($cancel_button);
    $form->addElement($form_buttons);
    $form->addElement(new RcxFormHidden("op", "tpl_info_save"));
    $form->addElement(new RcxFormHidden("tpl", $tpl));

    $form->display();
    echo '<br>';
    $form = new ThemeForm("", "themeform", "", false);
    //$form->addElement(new FormHeadingRow(_TE_TPL_OF_MODULES));
    include_once(RCX_ROOT_PATH . "/class/rcxlists.php");
    $themes_list = &RcxLists::getDirListAsArray($dir);

    if ($themes_list) {

        $installed_mods =& RcxModule::getInstalledModules();

        $module_dir_arr = array();

        foreach ( $installed_mods as $module_obj ) {
            $module_dir_arr[] = $module_obj->dirname();
        }

        foreach($themes_list as $theme) {
            if (preg_match("/^module_(.*)/i", $theme, $matches)) {

                if (!in_array($matches[1], $module_dir_arr)) {
                    continue;
                }

                $themelinc = "<a href='admin.php?fct=tpleditor&op=tpl_module_edit&tpl=" . $tpl . "&module=" . $matches[1] . "'>" . _TE_EDIT . "</a>";
                $m_tpl_list = get_files_list($dir . 'module_'.$matches[1]);
                $form->addElement(new RcxFormLabel('<b>' . $matches[1] . '</b> '.sprintf(_TE_HOW_MANY_TPL, count($m_tpl_list)), $themelinc));
            }
        }
    } else {
        $form->addElement(new FormHeadingRow(_TE_NOT_TEMPLATES, "center", "bg3"));
    }

    $form->display();
    echo '<br>';
    $form = new ThemeForm("", "themeform", "", false);

    $headings = array('tpl' => _TE_TPL_PATTERNS, 'css' => _TE_TPL_CSS, 'js' => _TE_TPL_JAVA_SCRIPT);

    foreach($tpl_files as $t => $tpl_file) {
        $form->addElement(new FormHeadingRow($headings[$t]));
        foreach($tpl_file as $k => $file) {
            $file = $file['name'];
            if (is_file($dir . $file)) {
                $filelinc = "<a href='admin.php?fct=tpleditor&op=file_edit&tpl=" . $tpl . "&type=" . $t . "&file=" . $k . "'>" . _TE_EDIT . "</a>";
                if ($t == 'css')$filelinc .= " | <a href='admin.php?fct=tpleditor&op=css_edit&tpl=" . $tpl . "&file=" . $k . "'>" . _TE_CLASSES_MANAGER . "</a>";
                $filelinc .= " | <a href='javascript:justReturn();' onclick='openWithSelfMain(\"" . RCX_URL . "/modules/system/admin.php?fct=tpleditor&op=file_popup&tpl=" . $tpl . "&type=" . $t . "&file=" . $k . "\",\"file_popup\",500,400);'>" . _TE_SHOW . "</a>";
                $filelinc = new RcxFormLabel('<b>' . basename($file) . '</b>', $filelinc);
            } else {
                $filelinc = new RcxFormLabel('<font color="#FF0000"><b>' . basename($file) . '</b></font>', _TE_NO_FILE);
            }
            $form->addElement($filelinc);
        }
    }

    $form->addElement(new FormHeadingRow(_TE_LANGUAGE_FILES));

    $lang_list = get_files_list($dir . 'language');

    if (!in_array('lang-' . $rcxConfig['language'] . '.php', $lang_list)) {
        $filelinc = new RcxFormLabel('<font color="#FF0000"><b>lang-' . $rcxConfig['language'] . '.php</b></font>', _TE_NO_FILE);
        $form->addElement($filelinc);
    }

    foreach($lang_list as $lang_file) {
        preg_match('/lang-([a-z]+).php/', $lang_file, $matches);
        $lang = "<a href='admin.php?fct=tpleditor&op=lang_edit&tpl=" . $tpl . "&lang=" . $matches[1] . "'>" . _TE_EDIT . "</a>";
        $filelinc = new RcxFormLabel('<b>' . basename($lang_file) . '</b>', $lang);
        $form->addElement($filelinc);
    }

    $blocks_list = get_tpl_block_list($dir);
    if ($blocks_list) {
        $form->addElement(new FormHeadingRow(_TE_TPL_BLOCKS));
        foreach($blocks_list as $block_file) {
            $block = "<a href='admin.php?fct=tpleditor&op=file_edit&tpl=" . $tpl . "&type=tpl&block=" . basename($block_file, '.html') . "'>" . _TE_EDIT . "</a>";
            $block .= " | <a href='javascript:justReturn();' onclick='openWithSelfMain(\"" . RCX_URL . "/modules/system/admin.php?fct=tpleditor&op=file_popup&tpl=" . $tpl . "&type=tpl&block=" . basename($block_file, '.html') . "\",\"file_popup\",500,400);'>" . _TE_SHOW . "</a>";
            $filelinc = new RcxFormLabel('<b>' . basename($block_file) . '</b>', $block);
            $form->addElement($filelinc);
        }
    }

    if (is_dir($dir . 'images')) {
        $form->addElement(new FormHeadingRow(_TE_GRAPHIC_FILES));
        $img_list = get_files_list($dir . 'images');
        $img_linc1 = sprintf(_TE_HOW_MANY_FILES, count($img_list));
        $img_linc2 = " <a href='admin.php?fct=tpleditor&op=img_edit&tpl=" . $tpl . "'>" . _TE_IMAGES_MANAGER . "</a>";
        $form->addElement(new RcxFormLabel($img_linc1, $img_linc2));
    }

    $form->display();

    CloseTable();
    inc_function('show_copyright');
    rcx_cp_footer();
}

?>