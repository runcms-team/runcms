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
           
            global $db, $_POST, $gallts, $eh;
                include_once(GALLI_PATH."/class/gall_cat.php");  
                include_once(GALLI_PATH."/class/gall_img.php");  
                $del_img = new GallImg($img_id);
                $cat_img_count = GallCat::countAllCat(array("img = '".$del_img->img()."' "));
                if ($cat_img_count >= 1){
                    $del_cat_list = GallCat::getAllCat(array("img = '".$del_img->img()."' "));
                    $store_cat = new GallCat($del_cat_list[0]);
                    $img_count = GallImg::countAllImg(array("cid = ".$cid." ", "img <> '".$del_img->img()."' "));
                    if ($img_count >= 1){
                        $img_list = GallImg::getAllImg(array("cid = ".$cid." ", "img <> '".$del_img->img()."' "), true,"date ASC");
                        foreach ( $img_list as $img_dat ) {
                            if ( $del_img->id() != $img_dat->id() ){
                                $store_cat->setVar("img",$img_dat->img());
                            }else{
                                $store_cat->setVar("img","");
                            }
                        }
                        $result = $store_cat->store();
                        if (!$result){
                            gall_function("admin_meldung", array (_AD_MA_NOSTORECATDB));
                            exit();
                        }
                    }
                }
                if(@file_exists("../galerie/".$del_img->img())){
                    @unlink("../galerie/".$del_img->img());
                    if(@file_exists("../galerie/".$del_img->img())){
                        gall_function("admin_meldung", array (_Selectedfile." ".$del_img->img()." "._AD_SYSTEST5));
                        exit();
                    }
                }
                if(@file_exists("../thumbnails/".$del_img->img())){
                    @unlink("../thumbnails/".$del_img->img());
                    if(@file_exists("../thumbnails/".$del_img->img())){
                        gall_function("admin_meldung", array (_AD_MA_THUMB." ".$del_img->img()." "._AD_SYSTEST5));
                        exit();
                    }
                }
                $delete_img = new GallImg($del_img->id());
                $result = $delete_img->delete();
                if (!$result){
                    gall_function("admin_meldung", array (_AD_MA_NODELIMGDB));
                    exit();
                }else{
                    redirect_header(GALL_PAGE."?op=img_conf&cid=".$cid."&op_coad=".$op_coad, 1 ,_Selectedfile." ".$del_img->img()." "._deleted);
                }
          break;
    
          default:
        gall_cp_header();
            include_once(GALLI_PATH . '/class/gall_img.php');  
            $del_img = new GallImg($img_id);
            $text = _really1.$del_img->img()._really2;
            gall_function("yes_no_hidden", array ($text, GAL_ADMIN_URL."/".GALL_PAGE."", array("name='op' value='delImg'", "name='op_pref' value='yes'", "name='img_id' value='".$img_id."'", "name='cid' value='".$cid."'", "name='op_coad' value='".$op_coad."'"), "", _AD_MA_YES, GAL_ADMIN_URL."/".GALL_PAGE."", array("name='op' value='img_conf'", "name='cid' value='".$cid."'", "name='op_coad' value='".$op_coad."'"), "", _AD_MA_NO));
        gall_cp_footer();
          break;
        }
    }

?>