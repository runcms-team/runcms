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
        
          case "save":
                $upd_conf = new GalliConf(3);
                $upd_conf->setVar("parm12",$_POST['tab_titel']);
                $upd_conf->setVar("parm4",$_POST['img_in_tab']);
                $upd_conf->setVar("parm11",$_POST['sort_admin_table']);
                $upd_conf->setVar("parm6",$_POST['sort_admin_tablead']);
                $upd_conf->store();
                
                redirect_header("index.php?op=admin_design",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_ADMINSEITE, "admin_design_einst", "index.php");
              $tab_titel_text = new RcxFormText(_tab_titel, "tab_titel", 6, 6, $galerieConfig['tab_titel']);
                $form->addElement($tab_titel_text);
                $max_anzImgInTable_select = new RcxFormSelect(_AD_MA_DATMNGIMGINTABLE, "img_in_tab", $galerieConfig['img_in_tab']);
                $max_anzImgInTable_select->addOptionArray(array("5"=>"5","10"=>"10","15"=>"15","20"=>"20", "25"=>"25","30"=>"30","35"=>"35","40"=>"40","45"=>"45","50"=>"50","60"=>"60","70"=>"70","80"=>"80","90"=>"90","100"=>"100"));
                $form->addElement($max_anzImgInTable_select);
                $sort_admin_table_select = new RcxFormSelect(_AD_MA_SORTADMINTABLE, "sort_admin_table", $galerieConfig['sort_admin_table']);
                $sort_admin_table_select->addOptionArray(array("img"=>_Filename, "titre"=>_AD_MA_IMGTITEL, "byte"=>_fSize, "date"=>_AD_MA_PROVIDED));
                $form->addElement($sort_admin_table_select);
                $sort_admin_tablead_select = new RcxFormSelect(_AD_MA_SORTAD, "sort_admin_tablead", $galerieConfig['sort_admin_tablead']);
                $sort_admin_tablead_select->addOptionArray(array("0"=>_AD_MA_SORTAD0, "1"=>_AD_MA_SORTAD1));
                $form->addElement($sort_admin_tablead_select);
                $op_hidden = new RcxFormHidden("op","admin_design");
                $op_pref_hidden = new RcxFormHidden("op_pref","save");
                $submit_button = new RcxFormButton("", "button", _AD_MA_SAVE, "submit");
                $form->addElement($op_hidden);
                $form->addElement($op_pref_hidden);
                $form->addElement($submit_button);
						 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button","->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

                $form->display();
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>