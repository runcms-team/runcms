<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    define("GALL_PAGE", "index.php");
    include("admin_header.php");
    
    switch($op){
    
      case "admin_design":
        include(INCL_PATH."/admin_design_einst.php");
      break;
    
      case "allg_einst":
        include(INCL_PATH."/admin_allg_einst.php");
      break;
    
      case "cat_conf":
        include(INCL_PATH."/admin_cat_conf.php");
      break;
    
      case "cat_einst":
        include(INCL_PATH."/admin_cat_einst.php");
      break;
    
      case "CoAdmin_config":
        include(INCL_PATH."/admin_CoAdmin_config.php");
      break;
    
      case "delCat":
        include(INCL_PATH."/admin_cat_del.php");
      break;
    
      case "delImg":
        include(INCL_PATH."/admin_img_del.php");
      break;
    
      case "design_block":
        include(INCL_PATH."/admin_design_block.php");
      break;
    
      case "editImg":
        include(INCL_PATH."/admin_edit_img.php");
      break;
    
      case "extra_einst":
        include(INCL_PATH."/admin_extra_einst.php");
      break;
    
      case "ftp_upload":
        include(INCL_PATH."/uebern_images_ftp_upload.php");
      break;
    
      case "gd_info":
            gall_cp_header();
            OpenTable();
            gall_function("meldung", array ("<h5>"._AD_MA_GDINFO."</h5><br>".gall_function("gd_table")."<br><br>", 1));
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>--->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
            CloseTable();
            gall_cp_footer();
      break;

    case "gen_solo_img_copyr":
      include(INCL_PATH."/gen_solo_img_copyr.php");
    break;
    
      case "img_conf":
        include(INCL_PATH."/datei_manager.php");
      break;
    
      case "img_copyr":
        include(INCL_PATH."/admin_menue_copyr.php");
      break;
    
      case "haupts_einst":
        include(INCL_PATH."/admin_haupts_einst.php");
      break;
        
        case "menue_copyr":
            gall_cp_header();
            OpenTable();
            gall_function("meldung", array (_AD_WZ_HELPTEXT4."<br><br>"._AD_WZ_HELPTEXT5."<br><br>", 1));
		
             include_once(RCX_ROOT_PATH."/class/rcxformloader.php");

					$form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>--->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 

            CloseTable();
            gall_cp_footer();
        break;
    
      case "modCat":
        include(INCL_PATH."/admin_cat_mod.php");
      break;
      
    case "modNewImg":   
      $db->query("update ".$db->prefix("galli_img")." set new_img='0' where cid='".$cid."'") or $eh->show("0013");
      redirect_header("index.php?op=img_conf&cid=".$cid, 1, _AD_MA_DBUPDATED);
      break;
    
      case "online_help":
            gall_cp_header();
            OpenTable();
            include(INCL_PATH."/online_help.php");
            CloseTable();
            gall_cp_footer();
      break;
    
      case "rahmen_einst":
        include(INCL_PATH."/admin_rahmen_einst.php");
      break;
    
      case "solo_img_copyr":
        include(INCL_PATH."/admin_solo_img_copyr.php");
      break;
    
      case "system_test":
        include(INCL_PATH."/admin_system_test.php");
      break;
    
      case "upload_einst":
        include(INCL_PATH."/admin_user_upload_einst.php");
      break;
    
      case "User_config":
        include(INCL_PATH."/admin_user_config.php");
      break;

      default:
        
            if ($galerieConfig['install'] == 0){
                gall_cp_header();
                OpenTable();
                gall_function("admin_sys_test");
                CloseTable();
                gall_cp_footer();        
            }elseif ($galerieConfig['update'] < 4){
                include(INCL_PATH."/admin_update.php");               
            }else{
                gall_cp_header();
                OpenTable();
                echo "<br>";
                include(INCL_PATH."/admin_index.php");
                echo "<br>";
                CloseTable();
                gall_cp_footer();
            }
            
      break;
    }
    
?>