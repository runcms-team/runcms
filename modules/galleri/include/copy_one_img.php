<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !eregi("gall_page", $galerieConfig['page_type']) ) {
  include("../../../mainfile.php");
  redirect_header(RCX_URL."/index.php",3,"Access Denied");
  exit();
}
    include_once(RCX_ROOT_PATH."/class/form/themeform.php");
    include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
    include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
    include_once(RCX_ROOT_PATH."/class/form/formbutton.php");  
    $form =  new RcxThemeForm("", "copy_one_img_form", "index.php");
  
    $op_hidden = new RcxFormHidden("op","gen_solo_img_copyr");
  $imgid_hidden = new RcxFormHidden("img_id",$img_id);
    $button_tray = new RcxFormElementTray("<img src='".IMG_URL."/achtung.gif' alt='"._AD_MA_COPYRTEXT14."' width='20' height='20' border='0'>", "");
    if ($galerieConfig['test_logotyp'] == 0 || count($logo_list) > 0){
        $submit_button = new RcxFormButton("", "button", _AD_MA_COPYRGEN, "submit");
        $button_tray->addElement($submit_button);
    }
    $retour_button = new RcxFormButton("", "button", _AD_MA_GOBACK, "button");
    if ($ret == 1){
        $retour_button->setExtra("onclick=\"location='index.php?op=editImg&img_id=".$img_id."&op_coad='\"");
    }else{
        $retour_button->setExtra("onclick=\"location='index.php?op=img_conf&cid=".$co_img->cid()."'\"");
    }
    $button_tray->addElement($retour_button);
    $form->addElement($op_hidden);
  $form->addElement($imgid_hidden);
    $form->addElement($button_tray);  
    $form->display();
?>