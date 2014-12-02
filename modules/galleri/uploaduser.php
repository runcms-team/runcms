<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    include ("header.php");
    if ( $galerieConfig['imguploadano'] == 1  || ( $galerieConfig['imguploadreg'] == 1 and $rcxUser) || gall_function("upload_bere", array ($cid)) ){

        switch($op_pref){

          case "file_upload":

                include_once(GALLI_PATH . '/class/fileupload.php');
                include_once(GALLI_PATH . '/class/gall_img.php');
                include_once(GALLI_PATH . '/class/gall_cat.php');
                $cat_name = new GallCat($cid);
                $x=0;
                while($x < count($GLOBALS['rcx_upload_file'])){
                    $userfile = $GLOBALS['rcx_upload_file'][$x];
                    if ($_FILES[$userfile]['name'] != ""){
                      $upload = new fileupload();
                        $tempx = $x+1;
                      $upload->set_upload_dir("./galerie", $userfile);  
						$basename = str_replace(array(".jpg",".jpeg",".gif",".png",".wbmp",".JPG",".JPEG",".GIF",".PNG",".WBMP",".mov",".wmv",".mpg",".mpeg",".avi",".asf",".swf",".MOV",".WMV",".MPG",".MPEG",".AVI",".ASF",".SWF"), array("","","","","","","","","","","","","","","","","","","","","","","","") ,$_FILES[$userfile]['name']);  
                        if (strlen($basename) > 35){$basename = substr($basename, -35);}                    
                      $upload->set_basename($basename , $userfile);
                        $upload->set_accepted($galerieConfig['img_format'], $userfile);
                      $upload->set_overwrite(1, $userfile);
                        $upload->set_chmod(0777, $userfile);
                      $upload->set_max_image_height($galerieConfig['picmaxhight'], $userfile);
                      $upload->set_max_image_width($galerieConfig['picmaxwidth'], $userfile);        
                      $result = $upload->upload();     
                        if ($result[$userfile]['filename']) {
                            $store_img = new GallImg();
                        $store_img->setVar("cid", $cid);
                        $store_img->setVar("nom", $myts->makeTboxData4Save($_POST['nom']));
                        $store_img->setVar("email", $myts->makeTboxData4Save($_POST['email']));
                        $store_img->setVar("cname", $cat_name->cname());
                        $store_img->setVar("titre", $myts->makeTboxData4Save($_POST['titre']));
                        $store_img->setVar("img", $result[$userfile]['filename']);
                        $store_img->setVar("coment", $myts->makeTboxData4Save($_POST['coment']));
// ALT tag
                        $store_img->setVar("alt", $myts->makeTboxData4Save($_POST['alt']));
                            if ($galerieConfig['imgfree'] == 1){
                                $free = 1;
                            }else{
                                if ( defined('GALL_CO_ADMIN') && gall_function("coadmin_bere", array($cid)) ) {$free = 1;}else{$free = 0;}
                        }
                            $store_img->setVar("free", $free);
                        $store_img->setVar("copy", 0);
                            if ( defined('GALL_ADMIN') ) {$new = 0;}else{$new = 1;}
                        $store_img->setVar("new_img", $new);
                            $store_img->setVar("date", time());
                            $size = getimagesize("./galerie/".$result[$userfile]['filename']);
                            $store_img->setVar("size", implode("|", $size));
                            $store_img->setVar("byte", $result[$userfile]['size']);
                            $store = $store_img->store();
                            if (!$store){
                                include(RCX_ROOT_PATH."/header.php");
                                OpenTable();
                                gall_function("admin_meldung_go_hidden", array(_ERROR_FONT._AD_MA_NOSTOREIMGDB."</font>", GALL_URL."/viewcat.php", array("name='cid' value='".$cid."'"), "", _AD_MA_NEXT));
                                CloseTable();
                              include(RCX_ROOT_PATH."/footer.php");
                                exit();                            
                            }else{
                                if ($cat_name->img() == ""){
                                    $cat_name->setVar("img", $result[$userfile]['filename']);
                                    $store = $cat_name->store();
                                }
                                if ($size[1] < $galerieConfig['ppm_tnheight']){
                                    if (!@copy("./galerie/".$result[$userfile]['filename'], "./thumbnails/".$result[$userfile]['filename'])){
                                $eh->show("0117");
                              }
                              }else{
                                    gall_function("ppm_do_thumb", array ("./galerie/".$result[$userfile]['filename'], "./thumbnails/".$result[$userfile]['filename'], $galerieConfig['ppm_tnheight']));
                                    if ($galerieConfig['wz_typ'] == 1||$galerieConfig['wz_typ'] == 3){
                                        $img_id = $store;
                                        include(INCL_PATH."/upload_solo_img_copyr.php");
                                    }
                                }
                            }
                        }else{
                            include(RCX_ROOT_PATH."/header.php");
                            gall_function("admin_meldung_go_hidden", array(_ERROR_FONT._Errorup.": ".$result[$userfile]['basename']."<br>".$upload->errors()."</font>", GALL_URL."/viewcat.php", array("name='cid' value='".$cid."'"), "", _AD_MA_NEXT));
                          include(RCX_ROOT_PATH."/footer.php");
                            exit();
                        }
                    }
                    $x++;
                }  
                if ($new == 1 && $galerieConfig['img_up_mail'] == 1){
//Admin Mailbenachrichtigung                
                    $subject = sprintf(_MD_MAIL1, RCX_URL);
                    $text = _MD_MAIL2."\n\n";
                    $text .= GALL_URL."/viewcat.php?id=".$store."&cid=".$cid."\n\n";
                    $text .= RCX_URL."/user.php";
                    include_once(RCX_ROOT_PATH."/class/rcxmailer.php");
                    $mail = new RcxMailer();
                  $mail->useMail();
                    $mail->setFromName($meta['title']);
                  $mail->setFromEmail($rcxConfig['adminmail']);
                  $mail->setToEmails($rcxConfig['adminmail']);
                  $mail->setSubject($subject);
                    $mail->setBody($text);
                  $mail->send();                
                }              
                redirect_header("viewcat.php?cid=".$cid, 1, _AD_MA_DBUPDATED);

          break;
    
          default:
            include RCX_ROOT_PATH.'/header.php';  
            OpenTable();
            gall_function("mainheader2");
            include_once(RCX_ROOT_PATH."/class/form/themeform.php");
            include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
            include_once(RCX_ROOT_PATH."/class/form/formtext.php");
            include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
            include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
            include_once(RCX_ROOT_PATH."/class/form/formfile.php");
            include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
            include_once(GALLI_PATH."/class/gall_cat.php");
            $max_byte = $galerieConfig['picuplkb'] * 1024;
            $cat_info = new GallCat($cid);            
            if ($rcxUser){
                $nom = isset($_POST['nom']) ? $_POST['nom'] : $rcxUser->uname();
                $email = isset($_POST['nom']) ? $_POST['nom'] : $rcxUser->email();
            }else{
                $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
                $email = isset($_POST['nom']) ? $_POST['nom'] : "";
            }
            $form_titel = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='tb_tabletitle'><img src='".IMG_URL."/upload.gif' align='absmiddle'>&nbsp;"._AD_MA_Uploaddir.$cat_info->coment()."</td></tr></table>";
            $form = new RcxThemeForm($form_titel, "img_upload", "uploaduser.php");
            $form->setExtra("enctype='multipart/form-data'");
            if (!$rcxUser){
                $nom_text = new RcxFormText(_AD_MA_AUTOR, "nom", 33, 30, $nom);
                $form->addElement($nom_text);
            $email_text = new RcxFormText(_AD_MA_AUTORMAIL2, "email", 53, 50, $email);
            $form->addElement($email_text);
            }else{
                $nom_label = new RcxFormLabel(_AD_MA_AUTOR, $nom);
                $form->addElement($nom_label);
                $nom_hidden = new RcxFormHidden("nom", $nom);
                $form->addElement($nom_hidden);
                $email_label = new RcxFormLabel(_AD_MA_AUTORMAIL2, $email);
                $form->addElement($email_label);
                $email_hidden = new RcxFormHidden("email", $email);
                $form->addElement($email_hidden);
            }            
            $text1_label = new RcxFormLabel(_AD_MA_MAXUPLTEXT.":", _AD_MA_MAXWIDTH.": ".$galerieConfig['picmaxwidth'].", "._AD_MA_MAXHIGHT.": ".$galerieConfig['picmaxhight'].", "._AD_MA_PLKB.": ".$galerieConfig['picuplkb']);
            $form->addElement($text1_label);
            $text2_label = new RcxFormLabel(_AD_MA_IMGFORMAT, $galerieConfig['img_format']);
            $form->addElement($text2_label);            
            $file1_form = new RcxFormFile(_AD_MA_PIC, 'userfile1', $max_byte);
            $file1_form->setExtra("size='50'");
            $form->addElement($file1_form );
            $titre1_text = new RcxFormText(_AD_MA_IMGTITEL, "titre", 43, 40, "");
        $form->addElement($titre1_text);
            $coment1_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment", "");
            $form->addElement($coment1_tarea);            
            $op_pref_hidden = new RcxFormHidden("op_pref", "file_upload");
            $form->addElement($op_pref_hidden);
            $cid_hidden = new RcxFormHidden("cid", $cid);
            $form->addElement($cid_hidden);            
            $submit_button = new RcxFormButton("", "button", _BA_UPLOAD, "submit");
            $form->addElement($submit_button);
            $form->setRequired(array("nom", "email","titre", "coment"));
            $form->display();
            CloseTable();
          include ("footer.php");
          include(RCX_ROOT_PATH."/footer.php");
          break;
        }
    }
?>