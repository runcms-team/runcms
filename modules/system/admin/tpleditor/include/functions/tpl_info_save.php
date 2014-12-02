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

function tpl_info_save()
{
    global $myts;

    $rcx_token = & RcxToken::getInstance();

    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $_POST['tpl'], 3, $rcx_token->getErrors(true));
        exit();
    }

    $tpl_path = RCX_ROOT_PATH . '/themes/' . $_POST['tpl'] . '/';

    $content = file_start();
    $content .= "\$tpl_info['theme_name'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['theme_name']) . "';\r\n";
    $content .= "\$tpl_info['foldername'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['foldername']) . "';\r\n";
    $content .= "\$tpl_info['author'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['author']) . "';\r\n";
    $content .= "\$tpl_info['website'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['website']) . "';\r\n";
    $content .= "\$tpl_info['license'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['license']) . "';\r\n";
    $content .= "\$tpl_info['details'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['details']) . "';\r\n";
    $content .= "\$tpl_info['revison'] = '" . $myts->oopsStripSlashesGPC($_POST['tpl_info']['revison']) . "';\r\n";
    $content .= "?>";

    $filename = $tpl_path . "theme_version.php";
    if ($file = fopen($filename, "w")) {
        fwrite($file, $content);
        fclose($file);
    }

    redirect_header("admin.php?fct=tpleditor&op=tpl_edit&tpl=" . $_POST['tpl'], 3, sprintf(_TE_TPL_INFO_SAVE, $_POST['tpl']));
    exit();
}

function file_start()
{
    global $rcxUser;
    return '<?php
// $Id: theme_version.php,v 1.1 '.date('d.m.Y H:i.s').' '.$rcxUser->uname().' Exp $
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
*
* this file was made by RunCms Theme Editor
*
*/


';
}

?>