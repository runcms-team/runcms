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
                $upd_conf = new GalliConf(1);
                $upd_conf->setVar("parm1",$_POST['popdruck']);
/*                $upd_conf->setVar("parm2",$_POST['imgversand']);
                $upd_conf->setVar("parm7",$_POST['anonym_mail']);
                $upd_conf->setVar("parm3",$_POST['mailmusik']);*/
                $upd_conf->setVar("parm6",$_POST['votum']);
                $upd_conf->store();
                $upd_conf = new GalliConf(8);
                $upd_conf->setVar("parm1",$_POST['coment']);
                $upd_conf->setVar("parm2",$_POST['coment_anon']);
                $upd_conf->setVar("parm3",$_POST['img_back']);
                $upd_conf->store();
                redirect_header("index.php?op=allg_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_ALLGEINST, "allg", "index.php");
                $popdruck_radio = new RcxFormRadioYN(_AD_MA_POPDRUCK, "popdruck", $galerieConfig['popdruck'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($popdruck_radio);
/*               $imgversand_radio = new RcxFormRadioYN(_AD_MA_IMGVERSAND, "imgversand", $galerieConfig['imgversand'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($imgversand_radio);
                $anonym_mail_radio = new RcxFormRadioYN(_AD_MA_anonym_mail, "anonym_mail", $galerieConfig['anonym_mail'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($anonym_mail_radio);
                $mailmusik_radio = new RcxFormRadioYN(_AD_MA_MAILMUSIK, "mailmusik", $galerieConfig['mailmusik'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($mailmusik_radio);*/
                $votum_radio = new RcxFormRadioYN(_AD_MA_VOTUM, "votum", $galerieConfig['votum'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($votum_radio);
                $coment_radio = new RcxFormRadioYN(_AD_MA_COMENT, "coment", $galerieConfig['coment'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($coment_radio);
                $coment_anon_radio = new RcxFormRadioYN(_AD_MA_COMENT_ANON, "coment_anon", $galerieConfig['coment_anon'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($coment_anon_radio);


                $img_back = new RcxFormRadioYN(_AD_MA_IMG_BACK, "img_back", $galerieConfig['img_back'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($img_back);
                $op_hidden = new RcxFormHidden("op","allg_einst");
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