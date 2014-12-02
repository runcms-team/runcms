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
          $upd_conf = new GalliConf(6);
                if ($galerieConfig['logotyp'] == 0){
              $upd_conf->setVar("parm6", 1);
          }else{
                    $upd_conf->setVar("parm6", 0);
                }
                $upd_conf->store();
                redirect_header("index.php?op=img_copyr", 1, _AD_MA_DBUPDATED);
          break;
        
          case "save":
          $upd_conf = new GalliConf(6);
          $upd_conf->setVar("parm3",$_POST['wz_li_re']);
          $upd_conf->setVar("parm4",$_POST['wz_ob_un']);
                $upd_conf->setVar("parm5",$_POST['wz_typ']);
                if ($galerieConfig['logotyp'] == 0){
                    $upd_conf->setVar("parm1",$_POST['wz_font']);
                    $upd_conf->setVar("parm2",$_POST['wz_richtung']);
              $upd_conf->setVar("parm7",$_POST['wz_font_r']);
              $upd_conf->setVar("parm8",$_POST['wz_font_g']);
              $upd_conf->setVar("parm9",$_POST['wz_text']);
              $upd_conf->setVar("parm16",$_POST['wz_font_b']);
          }else{
                    $upd_conf->setVar("parm10",$_POST['logo']);
                }
                $upd_conf->store();
                redirect_header("index.php?op=img_copyr", 1, _AD_MA_DBUPDATED);
          break;
    
          default:
                gall_cp_header();
              $galerieConfig['page_type'] = "gall_page";
                $co_image = "../images/testbild.jpg";
              $img_size = @GetImageSize($co_image);
              $img_width = $img_size[0];
              $img_height = $img_size[1];
              echo "<h4 style='text-align:left;'>"._AD_MA_COPYRTEXT1."</h4>";
              echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td valign='top'>";
              include(INCL_PATH."/copy_sel_form.php");
              echo _AD_WZ_HELPTEXT3;
			  echo"<br>";
                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 

              echo "</td><td width='615'>";
              echo "<iframe name='img_copyright' src='".INCL_URL."/copy_frame.php?image=".$co_image."' marginwidth='0' marginheight='0' height='".$img_height."' width='".$img_width."' scrolling='no' align='middle' border='0' frameborder='0'></iframe>";
              echo "</td></tr></table>";
                gall_cp_footer();
          break;
        }
    }
?>