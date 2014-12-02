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

include_once(RCX_ROOT_PATH . '/modules/system/admin/tpleditor/class/archive/pclzip.lib.php');

function tpl_extract()
{

    $rcx_token = & RcxToken::getInstance();

    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=tpleditor', 3, $rcx_token->getErrors(true));
        exit();
    }

    $tmp_dir = RCX_ROOT_PATH . '/cache/';
    $upload_dir = RCX_ROOT_PATH . '/themes/';
    if (!empty($_POST['submit'])) {
        if (!empty($_FILES['download']['name'])) {
            include_once(RCX_ROOT_PATH . "/class/fileupload.php");
            $upload = new fileupload();
            $upload->set_upload_dir($tmp_dir, 'download');
            $upload->set_accepted('.zip', 'download');
            $upload->set_overwrite(1, 'download');
            $result = $upload->upload();
            if ($result['download']['filename']) {
                $size = $result['download']['size'];
                $filename = $result['download']['filename'];
            } else {
                redirect_header('admin.php?fct=tpleditor', 3, $upload->errors());
                exit();
            }
        }

        $archive = new PclZip($tmp_dir . $filename);
        $extract = $archive->extract(PCLZIP_OPT_PATH, $upload_dir, PCLZIP_OPT_BY_PREG, '/theme_version\.php/');

        if (count($extract) == 0) {
            unlink($tmp_dir . $filename);
            redirect_header('admin.php?fct=tpleditor', 3, _TE_NO_TPL_VERSION2);
            exit();
        } else {
            $theme_version = $extract[0]['filename'];
        }

        $extract = $archive->extract(PCLZIP_OPT_PATH, $upload_dir);

        if ($extract == 0) {
            redirect_header('admin.php?fct=tpleditor', 3, $archive->errorInfo());
            exit();
        }
        unlink($tmp_dir . $filename);
        redirect_header("admin.php?fct=tpleditor", 4, _TE_TPL_IS_LOADED);
        exit();
    }
}

?>