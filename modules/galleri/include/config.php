<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !defined('GALLI_ACCESS') ) {?>  <script>history.go(-1);</script> <?php }
                    
      define("GALLI_PATH",RCX_ROOT_PATH."/modules/galleri");
        define("GALL_URL",RCX_URL."/modules/galleri");
      define("GAL_ADMIN_PATH","".GALLI_PATH."/admin");
        define("GAL_ADMIN_URL","".GALL_URL."/admin");
      define("GAL_PATH",GALLI_PATH."/galerie");
        define("GAL_URL",GALL_URL."/galerie");
        define("THUMB_PATH",GALLI_PATH."/thumbnails");
        define("THUMB_URL",GALL_URL."/thumbnails");
      define("IMG_PATH",GALLI_PATH."/images");
      define("IMG_URL",GALL_URL."/images");     
      define("INCL_PATH",GALLI_PATH."/include");
        define("INCL_URL",GALL_URL."/include");
        define("FUNC_INCL_PATH",GALLI_PATH."/include/function");
        define("IMG_VZAUF","<img src='".IMG_URL."/vzauf.gif' width='16' height='16' align='absmiddle'>");
      define("IMG_LEER","<img src='".IMG_URL."/leer.gif' width='19' height='16' align='absmiddle'>");
      define("IMG_HELP","<img src='".IMG_URL."/help.gif' border=0 alt='"._AD_MA_Help."'>");
      include_once(GALLI_PATH."/class/gall_conf.php");

      $galerieConfig = array();
      $parm_conf = new GalliConf(1);
      $galerieConfig['popdruck'] = intval($parm_conf->parm1());
      $galerieConfig['imgversand'] = intval($parm_conf->parm2());
      $galerieConfig['mailmusik'] = intval($parm_conf->parm3());
      $galerieConfig['imguploadano'] = intval($parm_conf->parm4());
      $galerieConfig['imguploadreg'] = intval($parm_conf->parm5());
      $galerieConfig['votum'] = intval($parm_conf->parm6());
      $galerieConfig['anonym_mail'] = intval($parm_conf->parm7());
      $galerieConfig['ppm_tnheight'] = $parm_conf->parm8();
      $galerieConfig['ppm_jpegcomp'] = $parm_conf->parm16();
      $galerieConfig['img_up_mail'] = intval($parm_conf->parm17());
      
      $parm_conf = new GalliConf(2);
      $galerieConfig['titelimg_yes_no'] = intval($parm_conf->parm1());
      $galerieConfig['perpage_width'] = $parm_conf->parm2();
      $galerieConfig['install'] = $parm_conf->parm3();
      $galerieConfig['update'] = $parm_conf->parm4();
      $galerieConfig['gd2'] = $parm_conf->parm5();
      $galerieConfig['safe_mode'] = $parm_conf->parm6();
      $galerieConfig['newimg'] = $parm_conf->parm7();
      $galerieConfig['perpage_height'] = $parm_conf->parm8();
        $galerieConfig['template_haupt'] = $parm_conf->parm10();
      $galerieConfig['tb_view2_bgcol'] = $parm_conf->parm12();
      $galerieConfig['titelimg'] = $parm_conf->parm13();
      $galerieConfig['newimg_sort'] = $parm_conf->parm14();
      $galerieConfig['imgcat_sort'] = $parm_conf->parm15();
        $galerieConfig['temp_haupt_width'] = $parm_conf->parm16();
        $galerieConfig['old_Vers'] = $parm_conf->parm19();
      
      $parm_conf = new GalliConf(3);
      $galerieConfig['user_autoupload'] = intval($parm_conf->parm1());
      $galerieConfig['admin_autoupload'] = intval($parm_conf->parm2());
      $galerieConfig['gif_ok'] = $parm_conf->parm3();
        $galerieConfig['img_in_tab'] = $parm_conf->parm4();
        $galerieConfig['zdat_adm_upload'] = $parm_conf->parm5();
        $galerieConfig['sort_admin_tablead'] = $parm_conf->parm6();
      $galerieConfig['picmaxwidth'] = $parm_conf->parm7();
      $galerieConfig['picmaxhight'] = $parm_conf->parm8();
        $galerieConfig['img_format'] = $parm_conf->parm9();
        $galerieConfig['template_cat'] = $parm_conf->parm10();
        $galerieConfig['sort_admin_table'] = $parm_conf->parm11();
      $galerieConfig['tab_titel'] = $parm_conf->parm12();
      $galerieConfig['picuplkb'] = $parm_conf->parm16();
      $galerieConfig['imgfree'] = intval($parm_conf->parm17());
      
      $parm_conf = new GalliConf(4);
      $galerieConfig['block_tb1_bo'] = $parm_conf->parm1();
      $galerieConfig['block_tb1_cspa'] = $parm_conf->parm2();
      $galerieConfig['block_tb1_cpad'] = $parm_conf->parm3();
      $galerieConfig['block_tb2_bo'] = $parm_conf->parm4();
      $galerieConfig['block_tb2_cspa'] = $parm_conf->parm5();
      $galerieConfig['block_tb2_cpad'] = $parm_conf->parm6();
        $galerieConfig['haupt_perpage_width'] = $parm_conf->parm7();
      $galerieConfig['tnwidthblock'] = $parm_conf->parm8();
      $galerieConfig['imgblock_sort'] = $parm_conf->parm9();
      $galerieConfig['block_tb1_bordcol'] = $parm_conf->parm10();
      $galerieConfig['block_tb1_bgcol'] = $parm_conf->parm11();
      $galerieConfig['block_tb2_bordcol'] = $parm_conf->parm12();
      $galerieConfig['block_tb2_bgcol'] = $parm_conf->parm13();
      
      $parm_conf = new GalliConf(5);
      $galerieConfig['haupt_tb1_bo'] = $parm_conf->parm1();
      $galerieConfig['haupt_tb1_cspa'] = $parm_conf->parm2();
      $galerieConfig['haupt_tb1_cpad'] = $parm_conf->parm3();
      $galerieConfig['haupt_tb2_bo'] = $parm_conf->parm4();
      $galerieConfig['haupt_tb2_cspa'] = $parm_conf->parm5();
      $galerieConfig['haupt_tb2_cpad'] = $parm_conf->parm6();
      $galerieConfig['haupt_egal'] = $parm_conf->parm7();
      $galerieConfig['haupt_hgtrans'] = $parm_conf->parm8();
      $galerieConfig['haupt_tb1_bordcol'] = $parm_conf->parm10();
      $galerieConfig['haupt_tb1_bgcol'] = $parm_conf->parm11();
      $galerieConfig['haupt_tb2_bordcol'] = $parm_conf->parm12();
      $galerieConfig['haupt_tb2_bgcol'] = $parm_conf->parm13();
      $galerieConfig['haupt_hgclass'] = $parm_conf->parm14();
      
      $parm_conf = new GalliConf(6);
      $galerieConfig['wz_font'] = intval($parm_conf->parm1());
      $galerieConfig['wz_richtung'] = intval($parm_conf->parm2());
      $galerieConfig['wz_li_re'] = intval($parm_conf->parm3());
      $galerieConfig['wz_ob_un'] = intval($parm_conf->parm4());
      $galerieConfig['wz_typ'] = intval($parm_conf->parm5());
        $galerieConfig['logotyp'] = intval($parm_conf->parm6());
      $galerieConfig['wz_font_r'] = intval($parm_conf->parm7());
      $galerieConfig['wz_font_g'] = intval($parm_conf->parm8());
      $galerieConfig['wz_text'] = $parm_conf->parm9();
        $galerieConfig['logo'] = $parm_conf->parm10();
      $galerieConfig['wz_font_b'] = intval($parm_conf->parm16());
      
      $parm_conf = new GalliConf(7);
      $galerieConfig['test_wz_font'] = intval($parm_conf->parm1());
      $galerieConfig['test_wz_richtung'] = intval($parm_conf->parm2());
      $galerieConfig['test_wz_li_re'] = intval($parm_conf->parm3());
      $galerieConfig['test_wz_ob_un'] = intval($parm_conf->parm4());
        $galerieConfig['test_logotyp'] = intval($parm_conf->parm6());
      $galerieConfig['test_wz_font_r'] = intval($parm_conf->parm7());
      $galerieConfig['test_wz_font_g'] = intval($parm_conf->parm8());
      $galerieConfig['test_wz_text'] = $parm_conf->parm9();
        $galerieConfig['test_logo'] = $parm_conf->parm10();
      $galerieConfig['test_wz_font_b'] = intval($parm_conf->parm16());
      
        $parm_conf = new GalliConf(8);
      $galerieConfig['coment'] = intval($parm_conf->parm1());
      $galerieConfig['coment_anon'] = intval($parm_conf->parm2());
      $galerieConfig['img_back'] = intval($parm_conf->parm3());
        $galerieConfig['max_anz_upload'] = intval($parm_conf->parm4());
        $galerieConfig['link_yn'] = intval($parm_conf->parm5());
        $galerieConfig['hase_yn'] = intval($parm_conf->parm6());
        $galerieConfig['admin_picmaxwidth'] = $parm_conf->parm7();
      $galerieConfig['admin_picmaxhight'] = $parm_conf->parm8();
        $galerieConfig['link_text'] = $parm_conf->parm13(); 
      $galerieConfig['admin_picuplkb'] = $parm_conf->parm16();    
        $galerieConfig['link_url'] = $parm_conf->parm18();    
 ?>            