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
                $upd_conf = new GalliConf(2);
                $upd_conf->setVar("parm2",$_POST['perpage_width']);
                $upd_conf->setVar("parm8",$_POST['perpage_height']);
                $upd_conf->setVar("parm12",$_POST['tb_view2_bgcol']);
                $upd_conf->setVar("parm15",$_POST['imgcat_sort']);
                $upd_conf->store();
                $upd_conf = new GalliConf(8);
                $upd_conf->setVar("parm6",$_POST['hase_yn']);
                $upd_conf->store();
                redirect_header("index.php?op=cat_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                include_once(FUNC_INCL_PATH."/func_zahlen_array.php");
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_CATSEITE, "cat_einst", "index.php");
                $perpage_width_select = new RcxFormSelect(_AD_MA_TNwidth, "perpage_width", $galerieConfig['perpage_width']);
                $perpage_width_select->addOptionArray(arr1_3());
                $form->addElement($perpage_width_select);
                $perpage_height_select = new RcxFormSelect(_AD_MA_TN_height, "perpage_height", $galerieConfig['perpage_height']);
                $perpage_height_select->addOptionArray(arr1_10());
                $form->addElement($perpage_height_select);      
                $imgcat_sort_select = new RcxFormSelect(_AD_MA_newimg_sort, "imgcat_sort", $galerieConfig['imgcat_sort']);
                $imgcat_sort_select->addOptionArray(array("date DESC"=>_MD_DATENEW, "date ASC"=>_MD_DATEOLD, "titre ASC"=>_MD_TITLEATOZ, "titre DESC"=>_MD_TITLEZTOA, "clic DESC"=>_MD_POPULARITYMTOL, "clic ASC"=>_MD_POPULARITYLTOM, "rating DESC"=>_MD_RATINGHTOL, "rating ASC"=>_MD_RATINGLTOH));
                $form->addElement($imgcat_sort_select);
              $tb_view2_bgcol_text = new RcxFormText(_tb_view2_bgcol, "tb_view2_bgcol", 6, 6, $galerieConfig['tb_view2_bgcol']);
                $form->addElement($tb_view2_bgcol_text);
                $hase_yn_radio = new RcxFormRadioYN(_AD_MA_HASEYN, "hase_yn", $galerieConfig['hase_yn'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($hase_yn_radio);
                $op_hidden = new RcxFormHidden("op","cat_einst");
                $op_pref_hidden = new RcxFormHidden("op_pref","save");
                $submit_button = new RcxFormButton("", "button", _AD_MA_SAVE, "submit");
                $form->addElement($op_hidden);
                $form->addElement($op_pref_hidden);

                $form->addElement($submit_button);  
		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 
                $form->display();
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>