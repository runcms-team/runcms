<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALLI_ACCESS') ) {
        include_once(GALLI_PATH . '/class/gall_img.php');
        $co_img = new GallImg($img_id);
        if ( preg_match('"/admin/"i', _PHP_SELF) ) {
            $co_image = "../galerie/".$co_img->img();
        }else{
            $co_image = "./galerie/".$co_img->img();
        }
        if ($galerieConfig['logotyp'] == 0){
            $copy_ok = gall_function("makeUploadCopyToImg", array ($co_image, 1));
        }else{
            if ( preg_match('"/admin/"i', _PHP_SELF) ) {
                $logo_pfad = "../images/copyright/".$galerieConfig['logo'];
            }else{
                $logo_pfad = "./images/copyright/".$galerieConfig['logo'];
            }
            $copy_ok = gall_function("makeUploadImgCopyToImg", array ($co_image, 1, $logo_pfad));
        }
        if ($copy_ok == 1){
            $co_img->setVar("copy",1);
            $store_ok = $co_img->store();
        }
    }
?>