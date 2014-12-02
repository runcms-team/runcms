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
        
          case "typ_aendern":
          $upd_conf = new GalliConf(7);
                if ($galerieConfig['test_logotyp'] == 0){
              $upd_conf->setVar("parm6", 1);
          }else{
                    $upd_conf->setVar("parm6", 0);
                }
                $upd_conf->store();
                redirect_header("index.php?op=solo_img_copyr&img_id=".$img_id, 1, _AD_MA_DBUPDATED);
          break;
        
          case "save":
          $upd_conf = new GalliConf(7);          
          
          $upd_conf->setVar("parm3",$_POST['test_wz_li_re']);
          $upd_conf->setVar("parm4",$_POST['test_wz_ob_un']);
                if ($galerieConfig['test_logotyp'] == 0){
                    $upd_conf->setVar("parm1",$_POST['test_wz_font']);
                    $upd_conf->setVar("parm2",$_POST['test_wz_richtung']);
              $upd_conf->setVar("parm7",$_POST['test_wz_font_r']);
              $upd_conf->setVar("parm8",$_POST['test_wz_font_g']);
              $upd_conf->setVar("parm9",$_POST['test_wz_text']);
              $upd_conf->setVar("parm16",$_POST['test_wz_font_b']);
                }else{
                    $upd_conf->setVar("parm10",$_POST['test_logo']);
                }
          $upd_conf->store();
                redirect_header("index.php?op=solo_img_copyr&img_id=".$img_id, 1, _AD_MA_DBUPDATED);
          break;
    
          default:
        
                gall_cp_header();
            $galerieConfig['page_type'] = "gall_page";
                include_once(GALLI_PATH."/class/gall_img.php"); 
            $co_img = new GallImg($img_id);
            $co_image = "../galerie/".$co_img->img();
            $img_size = @GetImageSize($co_image);
            $img_width = $img_size[0];
            $img_height = $img_size[1];
            echo "<h4 style='text-align:left;'>"._AD_MA_COPYRTEXT2."</h4>";
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td valign='top'>";
            include(INCL_PATH."/copy_solo_sel_form.php");
            echo _AD_MA_COPYRTEXT3;
            echo "<br><br>"._AD_MA_COPYRTEXT13;
            include(INCL_PATH."/copy_one_img.php");
            echo "</td><td width='".$img_width."' valign='top'>";
            echo "<iframe name='img_copyright' src='".INCL_URL."/copy_solo_frame.php?image=".$co_image."' marginwidth='0' marginheight='0' height='".$img_height."' width='".$img_width."' scrolling='no' align='middle' border='0' frameborder='0'></iframe>";
            echo "</td></tr></table>";
                gall_cp_footer();
          break;
        }
    }
?>