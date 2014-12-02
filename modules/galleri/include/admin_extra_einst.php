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
                $upd_conf = new GalliConf(8);
                $upd_conf->setVar("parm5",$_POST['link_yn']);
                $upd_conf->setVar("parm13", $_POST['link_text']);
                $upd_conf->setVar("parm18", formatURL($_POST['link_url']));
                $upd_conf->store(); 
                redirect_header("index.php?op=extra_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_EXTRAEINST, "extra_einst", "index.php");
              $link_yn_radio = new RcxFormRadioYN(_AD_MA_LINKYN, "link_yn", $galerieConfig['link_yn'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($link_yn_radio);
                $link_url_tray = new RcxFormElementTray(_AD_MA_LINK, "");
                $link_url_text = new RcxFormText("", "link_url", 70, 250, $galerieConfig['link_url']);
                $link_url_tray->addElement($link_url_text);
                $link_url_label = new RcxFormLabel("", "<br>"._AD_MA_LINKTEXT);
                $link_url_tray->addElement($link_url_label);
                $form->addElement($link_url_tray);
                $link_text = new RcxFormText(_AD_MA_LINKTEXT2, "link_text", 40, 40, $galerieConfig['link_text']);
                $form->addElement($link_text);
                $op_hidden = new RcxFormHidden("op","extra_einst");
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