<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALL_ADMIN') ) {
        include_once(GALLI_PATH . '/class/gall_img.php');
        $co_img = new GallImg($img_id);
        $co_image = "../galerie/".$co_img->img();
        if ($galerieConfig['test_logotyp'] == 0){
            gall_function("makeTestCopyToImg", array ($co_image, 1));
        }else{
            gall_function("makeImgCopyToImg", array ($co_image, 1, "../images/copyright/".$galerieConfig['test_logo']));
        }
        $co_img->setVar("copy",1);
        $store_ok = $co_img->store();
        if ( !$store_ok ) {
            gall_cp_header();
          OpenTable();
            echo _AD_MA_NOSTOREIMGDB;
            CloseTable();
            gall_cp_footer();
        }else{
            redirect_header("index.php?op=img_conf&cid=".$co_img->cid(), 2, _AD_MA_COPYRTEXT4);
        }
    }
?>