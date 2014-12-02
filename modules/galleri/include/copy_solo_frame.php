<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
   
    include("../../../mainfile.php");
    define("GALLI_ACCESS", 1);
    include_once(RCX_ROOT_PATH."/modules/galleri/class/gall_conf.php");
    
  $galerieConfig = array();
    $parm_conf = new GalliConf(3);
    $galerieConfig['img_format'] = $parm_conf->parm9();
    
    $parm_conf = new GalliConf(2);
    $galerieConfig['gd2'] = $parm_conf->parm5();

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

    if ($galerieConfig['test_logotyp'] == 0){
        include(RCX_ROOT_PATH."/modules/galleri/include/function/func_makeTestCopyToImg.php");
        makeTestCopyToImg($image, 0);
    }else{
        if ( $galerieConfig['img_format'] != ""){
            include(RCX_ROOT_PATH."/modules/galleri/include/function/func_makeImgCopyToImg.php");
            makeImgCopyToImg($image, 0, "../images/copyright/".$galerieConfig['test_logo']);
        }
  }
  
?>