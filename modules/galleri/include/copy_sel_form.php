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
    include_once(RCX_ROOT_PATH."/class/form/formtext.php");
    include_once(RCX_ROOT_PATH."/class/form/formselect.php");
    include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
    include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
    include_once(RCX_ROOT_PATH."/class/form/formbutton.php");

  if ($galerieConfig['wz_text'] == ""){$galerieConfig['wz_text'] = "(C) by ";}
  if ($galerieConfig['wz_font'] == ""){$galerieConfig['wz_font'] = 5;}

    $form =  new RcxThemeForm("", "copy_type_sel_form", "index.php");
    if ($galerieConfig['logotyp'] == 0){
        $submit_button = new RcxFormButton(_AD_WZ_LOGOTYP, "button", _AD_WZ_IMGLOGO, "submit");
    }else{
        $submit_button = new RcxFormButton(_AD_WZ_LOGOTYP, "button", _AD_WZ_TEXTLOGO, "submit");
    }
    $op_hidden = new RcxFormHidden("op","img_copyr");
    $op_pref_hidden = new RcxFormHidden("op_pref","typ_aendern");
    $form->addElement($op_hidden);
    $form->addElement($op_pref_hidden);
    $form->addElement($submit_button);  
    $form->display();

    $form =  new RcxThemeForm("", "copy_sel_form", "index.php");
  $wz_ok_select = new RcxFormSelect(_AD_WZ_TYP, "wz_typ", $galerieConfig['wz_typ']);
  $wz_ok_select->addOptionArray(array("0"=>_AD_WZ_OK0, "1"=>_AD_WZ_OK1, "2"=>_AD_WZ_OK2, "3"=>_AD_WZ_OK3));
  $form->addElement($wz_ok_select);
    
    if ($galerieConfig['logotyp'] == 1){
        if (stristr($galerieConfig['img_format'], "jpg") || stristr($galerieConfig['img_format'], "gif") ||stristr($galerieConfig['img_format'], "png") ||stristr($galerieConfig['img_format'], "wbmp") ){
            $logo_list = gall_function("getLogoFileListAsArray", array ("../images/copyright/", $galerieConfig['img_format']));
        }
        if ( count($logo_list) > 0){
            $logo_select = new RcxFormSelect(_AD_WZ_LOGO, "logo", $galerieConfig['logo']);
          $logo_select->addOptionArray($logo_list);
          $form->addElement($logo_select);
        }else{
            $nologotext = new RcxFormLabel("<center><img src='".IMG_URL."/achtung.gif' alt='"._AD_MA_COPYRTEXT14."' width='20' height='20' border='0'></center>", "<font color='red'>"._AD_MA_NOFORMAT."</font>");
          $form->addElement($nologotext);
        }    
    }
    $helptext2 = new RcxFormLabel("", _AD_WZ_HELPTEXT2);
  $form->addElement($helptext2);
    if ($galerieConfig['logotyp'] == 0){
      $wz_richtung_select = new RcxFormSelect(_AD_WZ_ANZ, "wz_richtung", $galerieConfig['wz_richtung']);
      $wz_richtung_select->addOptionArray(array("0"=>_AD_WZ_HOR, "1"=>_AD_WZ_VERT));
      $form->addElement($wz_richtung_select);
    }
  $wz_li_re_select = new RcxFormSelect(_AD_WZ_HELPTEXT2." 1", "wz_li_re", $galerieConfig['wz_li_re']);
  $wz_li_re_select->addOptionArray(array("0"=>_AD_WZ_LINKS, "1"=>_AD_WZ_CENTER, "2"=>_AD_WZ_RECHTS));
  $form->addElement($wz_li_re_select);
  $wz_ob_un_select = new RcxFormSelect(_AD_WZ_HELPTEXT2." 2", "wz_ob_un", $galerieConfig['wz_ob_un']);
  $wz_ob_un_select->addOptionArray(array("0"=>_AD_WZ_OBEN, "1"=>_AD_WZ_CENTER, "2"=>_AD_WZ_UNTEN));
  $form->addElement($wz_ob_un_select);
    if ($galerieConfig['logotyp'] == 0){
      $wz_text_text = new RcxFormText(_AD_WZ_TEXT, "wz_text", 30, 40, $galerieConfig['wz_text']);
        $form->addElement($wz_text_text);
      $wz_font_select = new RcxFormSelect(_AD_WZ_FONT, "wz_font", $galerieConfig['wz_font']);
      $wz_font_select->addOptionArray(array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5"));
      $form->addElement($wz_font_select);
      $helptext1 = new RcxFormLabel("", _AD_WZ_HELPTEXT1);
      $form->addElement($helptext1);
      $wz_font_r_text = new RcxFormText(_AD_WZ_FONTR, "wz_font_r", 4, 3, $galerieConfig['wz_font_r']);
        $form->addElement($wz_font_r_text);
      $wz_font_g_text = new RcxFormText(_AD_WZ_FONTG, "wz_font_g", 4, 3, $galerieConfig['wz_font_g']);
        $form->addElement($wz_font_g_text);
      $wz_font_b_text = new RcxFormText(_AD_WZ_FONTB, "wz_font_b", 4, 3, $galerieConfig['wz_font_b']);
        $form->addElement($wz_font_b_text);
    }
    $op_hidden = new RcxFormHidden("op","img_copyr");
    $op_pref_hidden = new RcxFormHidden("op_pref","save");
    $submit_button = new RcxFormButton("", "button", _AD_MA_SAVE, "submit");
    $form->addElement($op_hidden);
    $form->addElement($op_pref_hidden);
    $form->addElement($submit_button);  
  $form->setRequired(array("wz_text", "wz_font_r", "wz_font_g", "wz_font_b"));
    $form->display();
?>