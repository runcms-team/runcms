<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    if ( defined('GALL_ADMIN') || defined('GALL_CO_ADMIN') ) {

        include_once(RCX_ROOT_PATH."/class/form/themeform.php");
        include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
        include_once(RCX_ROOT_PATH."/class/form/formtext.php");
        include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
        include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
        include_once(RCX_ROOT_PATH."/class/form/formfile.php");
        include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
        include_once(GALLI_PATH."/class/gall_cat.php");
        $max_byte = $galerieConfig['admin_picuplkb'] * 1024;
        $cat_info = new GallCat($cid);
        $form_titel = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='tb_tabletitle'><img src='".IMG_URL."/upload.gif' align='absmiddle'>&nbsp;"._AD_MA_Uploaddir.$cat_info->coment()."</td></tr></table>";
        $form = new RcxThemeForm($form_titel, "img_upload", GALL_PAGE);
        $form->setExtra("enctype='multipart/form-data'");
        $text1_label = new RcxFormLabel(_AD_MA_MAXUPLTEXT.":", _AD_MA_MAXWIDTH.": ".$galerieConfig['admin_picmaxwidth'].", "._AD_MA_MAXHIGHT.": ".$galerieConfig['admin_picmaxhight'].", "._AD_MA_PLKB.": ".$galerieConfig['admin_picuplkb']);
        $form->addElement($text1_label);
        $text2_label = new RcxFormLabel(_AD_MA_IMGFORMAT, $galerieConfig['img_format']);
        $form->addElement($text2_label);
        
        if ( $galerieConfig['max_anz_upload'] >= 1 ){
            $file1_form = new RcxFormFile(_AD_MA_PIC."&nbsp;1", 'userfile1', $max_byte);
            $file1_form->setExtra("size='50'");
            $form->addElement($file1_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre1_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre1_text);
                $coment1_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment1_tarea);
            }
        }
        if ( $galerieConfig['max_anz_upload'] >= 2 ){
            $file2_form = new RcxFormFile(_AD_MA_PIC."&nbsp;2", 'userfile2', $max_byte);
            $file2_form->setExtra("size='50'");
            $form->addElement($file2_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre2_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre2_text);
                $coment2_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment2_tarea);
            }
        }
        if ( $galerieConfig['max_anz_upload'] >= 3 ){
            $file3_form = new RcxFormFile(_AD_MA_PIC."&nbsp;3", 'userfile3', $max_byte);
            $file3_form->setExtra("size='50'");
            $form->addElement($file3_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre3_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre3_text);
                $coment3_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment3_tarea);
            }
        }
        if ( $galerieConfig['max_anz_upload'] >= 4 ){
            $file4_form = new RcxFormFile(_AD_MA_PIC."&nbsp;4", 'userfile4', $max_byte);
            $file4_form->setExtra("size='50'");
            $form->addElement($file4_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre4_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre4_text);
                $coment4_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment4_tarea);
            }
        }
        if ( $galerieConfig['max_anz_upload'] >= 5 ){
            $file5_form = new RcxFormFile(_AD_MA_PIC."&nbsp;5", 'userfile5', $max_byte);
            $file5_form->setExtra("size='50'");
            $form->addElement($file5_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre5_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre5_text);
                $coment5_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment5_tarea);
            }
        }
        if ( $galerieConfig['max_anz_upload'] >= 6 ){
            $file6_form = new RcxFormFile(_AD_MA_PIC."&nbsp;6", 'userfile6', $max_byte);
            $file6_form->setExtra("size='50'");
            $form->addElement($file6_form );
            if ($galerieConfig['zdat_adm_upload'] == 1){
                $titre6_text = new RcxFormText(_AD_MA_IMGTITEL, "titre[]", 43, 40, "");
            $form->addElement($titre6_text);
                $coment6_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment[]", "");
                $form->addElement($coment6_tarea);
            }
        }

        $op_hidden = new RcxFormHidden("op", "img_conf");
        $form->addElement($op_hidden);
        $op_pref_hidden = new RcxFormHidden("op_pref", "file_upload");
        $form->addElement($op_pref_hidden);
        $cid_hidden = new RcxFormHidden("cid", $cid);
        $form->addElement($cid_hidden);
        $op_coad_hidden = new RcxFormHidden("op_coad",$op_coad);
        $form->addElement($op_coad_hidden);                
        $submit_button = new RcxFormButton("", "button", _BA_UPLOAD, "submit");
        $form->addElement($submit_button);
         $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display();
    }        
?>