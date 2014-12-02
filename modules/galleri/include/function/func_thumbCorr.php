<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function thumbCorr($rueck="", $rueck_hidden=array()){
      global $_POST, $db, $galerieConfig, $ss_timing_start_times, $ss_timing_stop_times;
        include_once(INCL_PATH . '/function/func_ss_timing.php');
        include_once(GALLI_PATH . '/class/gall_img.php');
        include_once(INCL_PATH . '/function/func_ppm_do_thumb.php');
        $galerieConfig['ppm_tnheight'] = isset($_POST['ppm_tnheight']) ? $_POST['ppm_tnheight'] : $galerieConfig['ppm_tnheight'];
        $galerieConfig['ppm_jpegcomp'] = isset($_POST['ppm_jpegcomp']) ? $_POST['ppm_jpegcomp'] : $galerieConfig['ppm_jpegcomp'];
        ss_timing_start("galerie");
        $img_list = GallImg::getAllImg(array("thumbCorr <> 1"), true);        
        foreach ( $img_list as $img_Dat ) {
            $current = ss_timing_current("galerie");
            if ($current+3 >= get_cfg_var("max_execution_time")){
              ss_timing_stop("galerie");
              gall_cp_header();
                openTable();
                $meldung = "<h4>"._AD_MA_UPDATETITEL.$galerieConfig['old_Vers']."</h4>";
                $meldung .= "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'><br><br>";
                $meldung .= sprintf(_AD_MA_INSTALL5a, get_cfg_var("max_execution_time"));
                gall_function("admin_meldung_go_hidden", array ($meldung, $rueck, $rueck_hidden, "", _AD_MA_NEXT));
                closeTable();
                gall_cp_footer();
                exit();
            }
        $name = "../galerie/".$img_Dat->img();
        $th_name = "../thumbnails/".$img_Dat->img();
        if (@is_file($name)) {
            @chmod($name, 0666);
          @chmod($th_name, 0666);
        }   
            $size = explode("|",$img_Dat->size());
            $store_img = new GallImg($img_Dat->id());
        if ($size[1] < $galerieConfig['ppm_tnheight']){
                if (!@copy($name, $th_name)){
            $eh->show("0117");
          }else{
                    $store_img->setVar("thumbCorr", 1);
                }
          }else{
          $ThumbResult = ppm_do_thumb($name,$th_name,$galerieConfig['ppm_tnheight']);
          if ($ThumbResult != 1){
            $eh->show("0115");
          }else{
                    $store_img->setVar("thumbCorr", 1);
                }
        }
        if (@is_file($name)) {
          @chmod($th_name, 0666);
        }
            $store = $store_img->store();         
      }
    }
?>
