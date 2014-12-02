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
        
          case "update_no":
                $upd_conf = new GalliConf(2);
                $upd_conf->setVar("parm4", 3);
                $upd_conf->store();                
                header("Location: index.php");
          break;
        
          case "update_yes":
                
                switch($galerieConfig['old_Vers']){
                    case 2.20:
                    case 2.30:
                    case 2.40:
                        if ($galerieConfig['update'] < 1){
                            include(INCL_PATH."/admin_update_conf.php");
                            if ($error != ""){
                                $text = _AD_MA_UPDATEERROR.$error;
                            }else{
                                $upd_conf = new GalliConf(2);
                                $upd_conf->setVar("parm4", 1);
                                $upd_conf->store();                                           
                                $text = _AD_MA_UPDATEOK1;
                            }
                        }elseif ($galerieConfig['update'] < 2){
                            include(INCL_PATH."/update/uebern_tab_aus_2_2.php");
                            if ($error != ""){
                                $text = _AD_MA_UPDATEERROR.$error;
                            }else{
                                $upd_conf = new GalliConf(2);
                                $upd_conf->setVar("parm4", 2);
                                $upd_conf->store();                
                                $text = _AD_MA_UPDATEOK2;
                            }
                        }elseif ($galerieConfig['update'] < 3){
                            include(INCL_PATH."/update/uebern_images_aus_2_2.php");
                        }elseif ($galerieConfig['update'] < 4){
                            include(INCL_PATH."/update/erstelle_thumbnails_aus_2_2.php");
                        }else{
                            $text = "Update Version: ".$galerieConfig['old_Vers'].", Stand: galerieConfig(update) = ".$galerieConfig['update'];
                        }
                        if ( !headers_sent() ) {
                        gall_cp_header();
                        openTable();
                        if ($error != ""){
                            gall_function("meldung", array ($text, 1));
                        }else{
                            $meldung = "<h4>"._AD_MA_UPDATETITEL.$galerieConfig['old_Vers']."</h4>";
                            $meldung .= "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'><br><br>";
                            $meldung .= $text;
                            gall_function("admin_meldung_go_hidden", array ($meldung, GAL_ADMIN_URL."/index.php", array("name='op_pref' value='update_yes'"), "", _AD_MA_NEXT));
                        }
                        closeTable();
                        gall_cp_footer();  
                        }                  
                    break;
                    
                    default:
                        gall_cp_header();
                        openTable();                        
                        $text = sprintf(_AD_MA_NOUPDATE, $modversion['version']);
                        gall_function("meldung", array ($text, 1));
                        closeTable();
                        gall_cp_footer();
                    break;
                }
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/rcxmodule.php");
                if (RcxModule::moduleExists("galleri")){
                    include_once(RCX_ROOT_PATH."/modules/galleri/include/rcxv.php");
                    $upd_conf = new GalliConf(2);
                    $upd_conf->setVar("parm19", $modversion['version']);
                    $upd_conf->store(); 
                    gall_cp_header();
                    openTable();
                    $text = "<h4>"._AD_MA_UPDATETITEL.$modversion['version']."</h4>";
                    $text .= "<img src='".IMG_URL."/galleri_logo.png' width='1209' height='116' border='0'><br><br>";
                    $text .= sprintf(_AD_MA_INSTALL2, $modversion['version']);
                    gall_function("yes_no_hidden", array ($text, GAL_ADMIN_URL."/index.php", array("name='op_pref' value='update_yes'"), "", _AD_MA_YES, GAL_ADMIN_URL."/index.php", array("name='op_pref' value='update_no'"), "", _AD_MA_NO));
                    closeTable();
                    gall_cp_footer();
               }else{
                    $upd_conf = new GalliConf(2);
                    $upd_conf->setVar("parm4", 4);
                    $upd_conf->store();                
                    header("Location: index.php");
               }
          break;
        }
    }
?>