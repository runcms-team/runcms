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

function lang_save()
{

    $rcx_token = & RcxToken::getInstance();

    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl='.$_POST['tpl'], 3, $rcx_token->getErrors(true));
        exit();
    }

    $lng_file = basename('lang-' . $_POST['langf'] . '.php');
    $define = file_start($lng_file);
    foreach($_POST['lang'] as $lang) {
        $define .= 'define("' . $lang['name'] . '","' . preg_replace("/\"|'/", "", $GLOBALS['myts']->oopsStripSlashesGPC($lang['value'])) . '");' . "\r\n";
    }
    $define .= '?>';
    $filename = RCX_ROOT_PATH . '/themes/'.$_POST['tpl'].'/language/'.$lng_file;
    $f_open = fopen($filename, "w");
    fwrite($f_open, $define);
    fclose($f_open);
    redirect_header("admin.php?fct=tpleditor&op=tpl_edit&tpl=".$_POST['tpl'], 3, sprintf(_TE_WRITTEN_FILE, basename($lng_file)));
    exit();
}

function file_start($lng_file)
{
    global $rcxUser;
    return '<?php
// $Id: '.$lng_file.',v 1.0 '.date('d.m.Y H:i.s').' '.$rcxUser->uname().' Exp $
// ************************************************************/
// *                        RUNCMS                            */
// *               Simplicity & ease off use                  */
// *               < http://www.runcms.org >                  */
// ************************************************************/
// File created by RunCms 2 Template Editor
// ************************************************************/

';
}

?>