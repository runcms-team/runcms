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

include_once(RCX_ROOT_PATH . "/class/rcxlists.php");

function inc_function($func, $parm = array(), $file = '')
{
    $file = ($file) ? $file : $func;
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/functions/" . $file . ".php");
    $ret = call_user_func_array($func, $parm);
    return $ret;
}

function get_files_list($dirname, $prefix = "", $include_indexhtml = false)
{
    $filelist = array();

    if ($handle = @opendir($dirname)) {
        while (false !== ($file = readdir($handle))) {
            if ($include_indexhtml == false) {
                if ($file != "index.html" && $file != "index.htm") {
                    if ($file != "." && $file != "..") {
                        $file = $prefix . $file;
                        $filelist[$file] = $file;
                    }
                }
            } else {
                if ($file != "." && $file != "..") {
                    $file = $prefix . $file;
                    $filelist[$file] = $file;
                }
            }
        }
        closedir($handle);
        asort($filelist);
        reset($filelist);
    }

    return $filelist;
}

function get_tpl_block_list($dirname)
{
    $filelist = array();

    if ($handle = @opendir($dirname)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && substr($file, 0, 6) == "block_") {
                $filelist[$file] = $file;
            }
        }
        closedir($handle);
    }
    return $filelist;
}

function get_main_link()
{
    return '<a href="admin.php?fct=tpleditor">' . _TE_MAIN_LINK . '</a> &raquo; ';
}

function get_tpl_link($tpl)
{
    return '<a href="admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl . '">' . sprintf(_TE_TPL_LINK, $tpl) . '</a> &raquo; ';
}

function get_tpl_mod_link($tpl, $module)
{
    return '<a href="admin.php?fct=tpleditor&op=tpl_module_edit&tpl=' . $tpl . '&module=' . $module . '">' . sprintf(_TE_TPL_MOD_LINK, $module) . '</a> &raquo; ';
}

function check_module($module)
{
    $installed_mods =& RcxModule::getInstalledModules();

    $module_dir_arr = array();

    foreach ( $installed_mods as $module_obj ) {
        $module_dir_arr[] = $module_obj->dirname();
    }

    if (!in_array($module, $module_dir_arr)) {
        return false;
    }

    return true;
}

function check_theme($tpl)
{
    $themes_list = & RcxLists::getDirListAsArray(RCX_ROOT_PATH . '/themes/');

    if (!in_array($tpl, $themes_list)) {
        return false;
    }

    return true;
}

function check_type($type)
{
    if (!in_array($type, array('tpl', 'css', 'js'))) {
        return false;
    }

    return true;
}
?>