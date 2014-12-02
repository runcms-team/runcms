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
               switch($action){
        
          case "add_select":
              switch($op_pref){
                
                  case "save":
                    global $db, $_POST, $myts, $eh;
                        include_once(GALLI_PATH."/class/gall_cat.php");     
                        include_once(GALLI_PATH."/class/gall_img.php"); 
                      $cid =  $_POST['cid'];
                    $nom = $myts->makeTboxData4Save($_POST['nom']);
                    $email = $myts->makeTboxData4Save($_POST['email']);
                    $titre = $myts->makeTboxData4Save($_POST['titre']);
                    $img = $myts->makeTboxData4Save($_POST['img']);
                    $coment = $myts->makeTboxData4Save($_POST['coment']);
                    $alt = $myts->makeTboxData4Save($_POST['alt']);
                    $free = $_POST['free'];
                        $store_img = new GallImg();
                        $store_img->setVar("nom", $nom);
                        $store_img->setVar("email", $email);
                        $store_img->setVar("titre", $titre);
                        $store_img->setVar("img", $img);
                        $store_img->setVar("coment", $coment);
                        $store_img->setVar("alt", $alt);

                        $store_img->setVar("free", $free);
                        $store_img->setVar("new_img", 0);
                        $new_cat = new GallCat($cid);
                        $store_img->setVar("cid", $cid);
                        $store_img->setVar("cname", $new_cat->cname());
                        $store_img->setVar("date", @filemtime("../galerie/".$img));
                        $size = @getimagesize("../galerie/".$img);
                        $store_img->setVar("size", implode("|", $size));
                        $store_img->setVar("byte", @filesize("../galerie/".$img));

                    $result = $store_img->store();
                        if (!$result){
                            gall_function("admin_meldung", array (_AD_MA_NOSTOREIMGDB));
                            exit();
                        }else{
                            gall_function("ppm_do_thumb", array ("../galerie/".$img, "../thumbnails/".$img, $galerieConfig['ppm_tnheight']));
                            redirect_header(GAL_ADMIN_URL."/index.php?op=ftp_upload", 1, _AD_MA_DBUPDATED);
                        }
                  break;
            
            default:
                gall_cp_header();
                OpenTable();
                    include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                    include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                    include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                    include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                    include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
                    include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
                    include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                    include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                    include_once(RCX_ROOT_PATH."/class/form/formbutton.php");  
                echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
                echo "<tr><td>";
                echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
                echo "<tr><td>";
                $form = new RcxThemeForm("<h5>"._AD_MA_SELECTFTPUPLOAD."</h5>", "editImgftpupload", "index.php");
                $nom_text = new RcxFormText(_AD_MA_AUTOR, "nom", 33, 30, $rcxUser->uname());
                    $form->addElement($nom_text);
                $email_text = new RcxFormText(_AD_MA_AUTORMAIL2, "email", 53, 50, $rcxUser->email());
                    $form->addElement($email_text);
                $cid_select = new RcxFormSelect(_AD_MA_INCAT, "cid", $cid);
                    $cid_select->addOptionArray(gall_function("makeCnameSelectArray", array ("galli_category", "cname", "cname", "cid", "scid")));
                $form->addElement($cid_select);
                    $titre_text = new RcxFormText(_AD_MA_IMGTITEL, "titre", 43, 40, $titre);
                    $form->addElement($titre_text);
                    $img_label = new RcxFormLabel(_Filename, "<b>".$img."</b>");
                    $form->addElement($img_label);
                    $img_hidden = new RcxFormHidden("img",$img);
                    $form->addElement($img_hidden);
                $coment_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment", $coment);
                    $form->addElement($coment_tarea);
                $alt_text = new RcxFormText(_AD_MA_ALT, "alt", 53, 255, $alt);
                    $form->addElement($alt_text);

                $date_label = new RcxFormLabel(_AD_MA_DATEUPLOAD, formatTimestamp(filemtime(GAL_PATH."/".$img),"m"));
                    $form->addElement($date_label);
                $free_radio = new RcxFormRadioYN(_AD_MA_IMGFREE, "free", 1, _AD_MA_YES,_AD_MA_NO);
                    $form->addElement($free_radio);
                $op_hidden = new RcxFormHidden("op","ftp_upload");
                    $form->addElement($op_hidden);
                    $action_hidden = new RcxFormHidden("action","add_select");
                    $form->addElement($action_hidden);
                    $op_pref_hidden = new RcxFormHidden("op_pref","save");
                    $form->addElement($op_pref_hidden);
                $button_tray = new RcxFormElementTray("", "");
                $submit_button = new RcxFormButton("", "button", _AD_MA_ALLFTPSTAR, "submit");
                $button_tray->addElement($submit_button);
                $retour_button = new RcxFormLabel("", "<input type='button' class='button' value='"._AD_MA_GOBACK."' onClick=\"self.location.href='index.php?op=ftp_upload'\">");
                $button_tray->addElement($retour_button);
                $form->addElement($button_tray);  
                $form->display();
                echo "</td></tr></table>";                    
                echo "</td><td align='center' valign='middle' class='bg1'>";
                    gall_function("makeThumbnailFrame", array (GAL_PATH."/".$img));
                  echo "</td></tr></table>";                    
                  CloseTable();
                gall_cp_footer();
                  break;
                }

          break;

          case "fpt_add_all":
                $cid =  $_POST['cid'];
                if ($cid > 0){
                global $db, $_POST, $myts, $eh;
                    include_once(GALLI_PATH."/class/gall_cat.php");     
                    include_once(GALLI_PATH."/class/gall_img.php"); 
                    include_once(INCL_PATH . '/function/func_ss_timing.php');
                  ss_timing_start("galerie");
                    $serv_img = gall_function("getFileListAsArray", array (GAL_PATH, $galerieConfig['img_format']));
                    $db_img = GallImg::getAllImgList();
                    $fpt_img = array_diff ($serv_img, $db_img);
                    $new_cat = new GallCat($cid);
                    while(list($key, $val) = each($fpt_img)) {                    
                        $current = ss_timing_current("galerie");
                        if ($current+3 >= get_cfg_var("max_execution_time")){
                          ss_timing_stop("galerie");
                          gall_cp_header();
                            openTable();
                            $meldung = "<h5>"._AD_MA_FTPTEXT2."</h5>";
                            $meldung .= "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'><br><br>";
                            $meldung .= sprintf(_AD_MA_INSTALL5a, get_cfg_var("max_execution_time"));
                            gall_function("admin_meldung_go_hidden", array ($meldung, GAL_ADMIN_URL."/index.php", array("name='op' value='ftp_upload'", "name='action' value='fpt_add_all'", "name='cid' value='".$cid."'"), "", _AD_MA_NEXT));
                            closeTable();
                            gall_cp_footer();
                            exit();
                        }
                        $store_img = new GallImg();
                        $store_img->setVar("nom", $rcxUser->uname());
                        $store_img->setVar("email", $rcxUser->email());
                        $store_img->setVar("img", $val);
                        $store_img->setVar("free", 1);
                        $store_img->setVar("new_img", 0);                    
                        $store_img->setVar("cid", $cid);
                        $store_img->setVar("cname", $new_cat->cname());
                        $store_img->setVar("alt", $alt);

                        $store_img->setVar("date", @filemtime(GAL_PATH."/".$val));
                        $size = @getimagesize("../galerie/".$val);
                        $store_img->setVar("size", implode("|", $size));
                        $store_img->setVar("byte", @filesize("../galerie/".$val));
                    $result = $store_img->store();
                        if (!$result){
                            gall_function("admin_meldung", array (_AD_MA_NOSTOREIMGDB));
                            exit();
                        }else{
                            gall_function("ppm_do_thumb", array ("../galerie/".$val, "../thumbnails/".$val, $galerieConfig['ppm_tnheight']));                        
                        }
                        clearstatcache();
                    }
                    redirect_header(GAL_ADMIN_URL."/index.php", 1, _AD_MA_FTPOK);
                }else{
                    gall_cp_header();
                    openTable();
                    $meldung .= "<b>"._AD_MA_NOFTPCAT."</b>";
                    gall_function("admin_meldung_go_hidden", array ($meldung, GAL_ADMIN_URL."/index.php", array("name='op' value='ftp_upload'"), "", _AD_MA_RETOUR));
                    closeTable();
                    gall_cp_footer();  
                }
          break;
            
            case "del_img":
                if(@file_exists("../galerie/".$img)){
                    @unlink("../galerie/".$img);
                    if(@file_exists("../galerie/".$img)){
                        gall_function("admin_meldung", array (_Selectedfile." ".$img." "._AD_SYSTEST5));
                        exit();
                    }
                }
                if(@file_exists("../thumbnails/".$img)){
                    @unlink("../thumbnails/".$img);
                    if(@file_exists("../thumbnails/".$img)){
                        gall_function("admin_meldung", array (_AD_MA_THUMB." ".$img." "._AD_SYSTEST5));
                        exit();
                    }
                }
                clearstatcache();
                redirect_header(GAL_ADMIN_URL."/index.php?op=ftp_upload", 2, _Thefile." \"".$img."\" "._deleted);
          break;
    
          default:
                include_once(GALLI_PATH . '/class/gall_img.php');
                include_once(GALLI_PATH . '/class/gall_cat.php');
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
                include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                $serv_img = gall_function("getFileListAsArray", array (GAL_PATH, $galerieConfig['img_format']));
                $db_img = GallImg::getAllImgList();
                $fpt_img = array_diff ($serv_img, $db_img);
                $anzahl = count($fpt_img);
                if ($anzahl > 0){
                    gall_cp_header(); 
                    OpenTable();
                    $text = "<h5>"._AD_MA_FTPTEXT2."</h5>";
                    $text .= "<b>"._AD_MA_FTPTEXT."</b><br><br>";
                    gall_function("meldung", array ($text, 1));
                    $form = new RcxThemeForm("<h5>"._AD_MA_SELECTFTPUPLOAD." (".$anzahl." "._AD_MA_IMG.")</h5>", "fpt_add_select", "index.php");  
                    $spalten_label = new RcxFormLabel("<b>"._AD_MA_FILENAME."</b>", "");
                    $form->addElement($spalten_label);
                    while(list($key, $val) = each($fpt_img)) {    
                        $size = @getimagesize("../galerie/".$val);
                        $br = $size[0]+5; $ho = $size[1]+5;
                        $button_tray = new RcxFormElementTray($val, "");
                        $select_button = new RcxFormLabel("", "<input type='button' class='button' value='"._AD_MA_ALLFTPSTAR."' onClick=\"self.location.href='index.php?op=ftp_upload&action=add_select&img=".$val."'\">");
                    $button_tray->addElement($select_button);
                        $delete_button = new RcxFormLabel("&nbsp;", "<input type='button' class='button' value='"._AD_MA_DEL."' onClick=\"self.location.href='index.php?op=ftp_upload&action=del_img&img=".$val."'\">");
                    $button_tray->addElement($delete_button);
                        $anz_button = new RcxFormLabel("&nbsp;", "<input type='button' class='button' value='"._AD_MA_IMGSEE."' onClick='javascript:openImgPopup(\"../show-pop.php?id=".GAL_URL."/".$val."&img=".$val."\",\"popup\",".$br.",".$ho.")'>");
                    $button_tray->addElement($anz_button);
                        $form->addElement($button_tray);
                    }
                    $op_hidden = new RcxFormHidden("op", "ftp_upload");
                    $form->addElement($op_hidden);
                    $action_hidden = new RcxFormHidden("action","add_select");
                    $form->addElement($action_hidden);
                    $form->display();

                    $form = new RcxThemeForm("<h5>"._AD_MA_ALLFTPUPLOAD."</h5>", "add_all", "index.php"); 
                    $all_select = new RcxFormSelect(_AD_MA_CNAME, "cid");
                    $all_select->addOptionArray(array ("0" => _AD_MA_ALLFTPCAT));
                    $all_select->addOptionArray(gall_function("makeCnameSelectArray", array ("galli_category", "cname", "cname", "cid", "scid")));
                  $form->addElement($all_select);
                    $op_hidden = new RcxFormHidden("op", "ftp_upload");
                    $form->addElement($op_hidden);
                    $action_hidden = new RcxFormHidden("action","fpt_add_all");
                    $form->addElement($action_hidden);
                $submit_button = new RcxFormButton("", "submit", _AD_MA_ALLFTPSTAR, "submit");  
                $form->addElement($submit_button);
                    $form->display();
                    CloseTable();
                  gall_cp_footer();
                    break;
                }else{
                    gall_cp_header(); 
                    OpenTable();
                    $meldung = "<h5>"._AD_MA_FTPTEXT2."</h5>";
                    $meldung .= "<b>"._AD_MA_NOFTPT."</b><br><br>";

                    gall_function("meldung", array ($meldung, 1));
                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
                    CloseTable();
                  gall_cp_footer();
                    break;
                }
          break;
        }
    }
?>
