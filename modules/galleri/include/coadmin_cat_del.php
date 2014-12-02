<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALL_ADMIN') || defined('GALL_CO_ADMIN') ) {

        switch($op_pref){
        
          case "yes":
                include_once(GALLI_PATH."/class/gall_cat.php");  
                include_once(GALLI_PATH . '/class/gall_img.php');      
                $img_count = GallImg::countAllImg(array("cid = ".$cid." "));
                if ($img_count >= 1){
                    $del_img_list = GallImg::getAllImg(array("cid = ".$cid." "), true);
                    foreach ( $del_img_list as $del_img ) {
                        if(@file_exists("../galerie/".$del_img->img())){
                            @unlink("../galerie/".$del_img->img());
                        }
                        if(@file_exists("../thumbnails/".$del_img->img())){
                            @unlink("../thumbnails/".$del_img->img());
                        }
                        $delete_img = new GallImg($del_img->id());
                        $delete_img->delete();
                    }
                }
                $del_cat = new GallCat($cid);
                $result = $del_cat->delete();
                if (!$result){
                    gall_function("admin_meldung", array (_AD_MA_NODELIMGDB));
                    exit();
                }else{
                    redirect_header("".GALL_PAGE."?op=cat_conf&op_coad=".$op_coad, 1, _AD_MA_CATDELETED);
                }
          break;
    
          default:
        gall_cp_header();
          include_once(GALLI_PATH."/class/gall_cat.php");    
            include_once(GALLI_PATH . '/class/gall_img.php');  
            $del_cat = new GallCat($cid);
            $u_cat_count = GallCat::countAllCat(array("scid = ".$cid." "));
            $img_count = GallImg::countAllImg(array("cid = ".$cid." "));
            if ($u_cat_count == 0 && $img_count == 0){
                header("Location: ".GAL_ADMIN_URL."/".GALL_PAGE."?op=delCat&cid=".$cid."&op_coad=".$op_coad."&op_pref=yes");
            }else{
                gall_function("yes_no_hidden", array (_AD_MA_WARNINGC, GAL_ADMIN_URL."/".GALL_PAGE."?op=delCat", array("name='op_pref' value='yes'", "name='cid' value='".$cid."'", "name='op_coad' value='".$op_coad."'"), "", _AD_MA_YES, GAL_ADMIN_URL."/".GALL_PAGE."?op=cat_conf", array("name='cid' value='".$cid."'", "name='op_coad' value='".$op_coad."'"), "", _AD_MA_NO));
            }
        gall_cp_footer();
          break;
        }
    }

?>