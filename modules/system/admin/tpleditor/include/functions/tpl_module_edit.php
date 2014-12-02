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

function tpl_module_edit()
{
    global $db, $rcxConfig;

    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");
    $tpl = $_GET['tpl'];
    $module = $_GET['module'];

    if (!empty($module) && !empty($tpl)) {
        include_once(RCX_ROOT_PATH . "/modules/" . $module . "/include/rcxv.php");
        if (empty($modversion['tpl'])) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, sprintf(_TE_NO_DATA_ON_TPL, $module));
            exit();
        } 
        $tpl_files['tpl'] = $modversion['tpl'];
        $tpl_files['css'] = $modversion['css'];
        unset($modversion);
    } else {
        redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3);
        exit();
    } 

    $dir = RCX_ROOT_PATH . "/themes/" . $tpl . "/";

    rcx_cp_header();
    OpenTable();

    $form = new ThemeForm(get_main_link() . get_tpl_link($tpl).sprintf(_TE_EDIT_MOD_TPL, $module), "themeform", "");

    $headings = array('tpl' => _TE_TPL_OF_MODULE, 'css' => _TE_MODULE_CSS);

    foreach($tpl_files as $t => $tpl_file) {
        $form->addElement(new FormHeadingRow($headings[$t]));
        foreach($tpl_file as $k => $file) {
            $file = $file['name'];
            if (is_file($dir . $file)) {
                $filelinc = "<a href='admin.php?fct=tpleditor&op=file_edit&tpl=" . $tpl . "&type=" . $t . "&file=" . $k . "&module=" . $module . "'>" . _TE_EDIT . "</a>";
                if ($t == 'css')$filelinc .= " | <a href='admin.php?fct=tpleditor&op=css_edit&tpl=" . $tpl . "&file=" . $k . "&module=" . $module . "'>" . _TE_CLASSES_MANAGER . "</a>";
                $filelinc .= " | <a href='javascript:justReturn();' onclick='openWithSelfMain(\"" . RCX_URL . "/modules/system/admin.php?fct=tpleditor&op=file_popup&tpl=" . $tpl . "&type=" . $t . "&file=" . $k . "&module=" . $module . "\",\"file_popup\",500,400);'>" . _TE_SHOW . "</a>";
                $filelinc = new RcxFormLabel('<b>' . basename($file) . '</b>', $filelinc);
            } else {
                $filelinc = new RcxFormLabel('<font color="#FF0000"><b>' . basename($file) . '</b></font>', _TE_NO_FILE);
            } 
            $form->addElement($filelinc);
        } 
    } 
    $form->display();

    CloseTable();
    inc_function('show_copyright');
    rcx_cp_footer();
} 

?>