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

        switch($op_pref){
        
          case "yes":
                include_once(GALLI_PATH."/class/gall_cat.php");  
                include_once(GALLI_PATH.'/class/gall_img.php');    
                include_once(GALLI_PATH.'/class/galltree.php');  
                $galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
                $del_pfad = $galltree->getAllChild($cid);
                foreach ( $del_pfad as $del_Det ) {
                    $img_count = GallImg::countAllImg(array("cid = ".$del_Det[0]." "));
                    if ($img_count >= 1){
                        $del_img_list = GallImg::getAllImg(array("cid = ".$del_Det[0]." "), true);
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
                    $del_cat = new GallCat($del_Det[0]);
                    $result = $del_cat->delete();
                    if (!$result){
                        gall_function("admin_meldung", array (_AD_MA_NODELIMGDB));
                        exit();
                    }
                }
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
                }
                redirect_header("index.php?op=cat_conf",1,_AD_MA_CATDELETED);
          break;
    
          default:
        gall_cp_header();
          include_once(GALLI_PATH."/class/gall_cat.php");    
            include_once(GALLI_PATH. '/class/gall_img.php');  
            $del_cat = new GallCat($cid);
            $u_cat_count = GallCat::countAllCat(array("scid = ".$cid." "));
            $img_count = GallImg::countAllImg(array("cid = ".$cid." "));
            if ($u_cat_count == 0 && $img_count == 0){
                header("Location: ".GAL_ADMIN_URL."/index.php?op=delCat&cid=".$cid."&op_pref=yes");
            }else{
                gall_function("yes_no_hidden", array (_AD_MA_WARNINGC, GAL_ADMIN_URL."/index.php?op=delCat&cid=".$cid, array("name='op_pref' value='yes'"), "", _AD_MA_YES, GAL_ADMIN_URL."/index.php?op=cat_conf", "", "", _AD_MA_NO));
            }
        gall_cp_footer();
          break;
        }
    }

?>