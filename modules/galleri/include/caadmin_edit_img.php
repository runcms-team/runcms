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

        switch($op_pref){
        
          case "save":
            global $db, $_POST, $gallts, $eh;
                include_once(GALLI_PATH."/class/module.textsanitizer.php");     
              $gallts =& GallTextSanitizer::getInstance();        
                include_once(GALLI_PATH."/class/gall_cat.php");     
                include_once(GALLI_PATH."/class/gall_img.php"); 
            $img_id =  $_POST['img_id'];
              $new_cid =  $_POST['cid'];
            $new_nom = $gallts->makeTboxData4Save($_POST['nom']);
            $new_email = $gallts->makeTboxData4Save($_POST['email']);
            $old_cname = $gallts->makeTboxData4Save($_POST['cname']);
            $cname = $old_cname;
            $new_titre = $gallts->makeTboxData4Save($_POST['titre']);
            $new_image = $gallts->makeTboxData4Save($_POST['img']);
                $new_image = gall_function("entfern_sonder", array ($new_image));
              $new_coment = $_POST['coment'];
            $new_clic = $gallts->makeTboxData4Save($_POST['clic']);
            $new_free = $_POST['free'];
                $img_olddat = new GallImg($img_id);
                $store_img = new GallImg($img_id);
            if ( $new_image != $img_olddat->img() ){
              $file_info1 = pathinfo($new_image);
              $file_ext1 = $file_info1["extension"];
              $file_info2 = pathinfo($img_olddat->img());
              $file_ext2 = $file_info2["extension"];    
              if ( $file_ext1 != $file_ext2 ) {$eh->show("0109");}  
              $new_image = strtolower($new_image);  
                    $test_count_new_img = GallImg::countAllImg(array("img = '".$new_image."' "));
              if ($test_count_new_img >0) {$eh->show("0110");}    
              if(!rename( "../galerie/".$img_olddat->img(), "../galerie/".$new_image )){$eh->show("0111");}
              if(!rename( "../thumbnails/".$img_olddat->img(), "../thumbnails/".$new_image )){$eh->show("0111");}
                    if (GallCat::countAllCat(array("img = '".$img_olddat->img()."' ") > 1)){
                        $cat_img = GallCat::getAllCat($criteria=array("img = '".$img_olddat->img()."' "));
                        $updat_cat = new GallCat($cat_img[0]);
                        $updat_cat->setVar("img",$new_image);
                        $updat_cat->store();
                    }
            }
                $store_img->setVar("nom",$new_nom);
                $store_img->setVar("email",$new_email);
                $store_img->setVar("titre",$new_titre);
                $store_img->setVar("img",$new_image);

                $store_img->setVar("alt", $new_alt);

                $store_img->setVar("clic",$new_clic);
                $store_img->setVar("free",$new_free);
            if ( $img_olddat->cid() != $new_cid ){
                    $new_cat = new GallCat($new_cid);
                    $store_img->setVar("cid",$new_cid);
                    $store_img->setVar("cname",$new_cat->cname());
            }
            $result = $store_img->store();
                if (!$result){
                    gall_function("admin_meldung", array (_AD_MA_NOSTOREIMGDB));
                    exit();
                }else{
                    redirect_header(GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&cid=".$new_cid."&op_coad=".$op_coad, 1, _AD_MA_DBUPDATED);
                }
          break;
    
          default:
        gall_cp_header();
          if ( isset($_POST['img_id']) ) {
          $img_id =  $_POST['img_id'];
        } elseif ( isset($_GET['img_id']) ) {
          $img_id =  $_GET['img_id'];
        }
        OpenTable();
            include_once(FUNC_INCL_PATH."/func_titel_Verz.php");
            include_once(GALLI_PATH."/class/galltree.php");
            include_once(GALLI_PATH."/class/gall_cat.php");     
            include_once(GALLI_PATH."/class/gall_img.php");  
            include_once(RCX_ROOT_PATH."/class/module.textsanitizer.php");  
            include_once(RCX_ROOT_PATH."/class/form/themeform.php");
            include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
            include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
            include_once(RCX_ROOT_PATH."/class/form/formtext.php");
            include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
            include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
            include_once(RCX_ROOT_PATH."/class/form/formselect.php");
            include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
            include_once(RCX_ROOT_PATH."/class/form/formbutton.php");  
          $gallts = new MyTextSanitizer; 
        titel_Verz(_AD_MA_TITEL, _AD_MA_TITEL2, "modImg");
        $galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
            $img_Dat = new GallImg($img_id);
        echo "<br>";
        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr><td>";
        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr><td>";
        $form = new RcxThemeForm(_AD_MA_EDITIMG, "editImgS", "".GALL_PAGE."");
        $nom_text = new RcxFormText(_AD_MA_AUTOR, "nom", 33, 30, $img_Dat->nom());
        $email_tray = new RcxFormElementTray(_AD_MA_AUTORMAIL2, "");
        $email_text = new RcxFormText("", "email", 53, 50, $img_Dat->email());
        $email_tray->addElement($email_text);
            gall_function("test_member", array ($img_Dat->email()));
          if ($member > 0){
          $a_link = "&nbsp;&nbsp;&nbsp;<a href='javascript:openWithSelfMain(\"".RCX_URL."/pmlite.php?send2=".$rcxUser->uid()."&amp;to_userid=".$member."\",\"pmlite\",550,410);'><img src='".RCX_URL."/images/icons/pm.gif' alt='' /></a>";
          $a_label = new RcxFormLabel("", $a_link);
          $email_tray->addElement($a_label);
        }
        $cid_select = new RcxFormSelect(_AD_MA_INCAT, "cid", $img_Dat->cid());
        $cid_select->addOptionArray(GallCat::getAllCatList());
        $titre_text = new RcxFormText(_AD_MA_IMGTITEL, "titre", 43, 40, $img_Dat->titre());
        $img_text = new RcxFormText("", "img", 43, 40, $img_Dat->img());
        $copy_tray = new RcxFormElementTray(_AD_MA_FILENAME, "");
        $copy_tray->addElement($img_text);
        if ( $galerieConfig['safe_mode'] == 0 ){
          if ($copy == 0){
            $copy_button = new RcxFormLabel("", "<img src='".IMG_URL."/pixel.gif' width='20' height='20'><a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=solo_img_copyr&img_id=".$img_Dat->id()."&ret=1'><img src='".IMG_URL."/copyr.jpg' alt='"._AD_MA_COPYRGEN."' width='20' height='20' border='0'></a>");
            $copy_tray->addElement($copy_button);
          }else{
            $copy_text = new RcxFormLabel("", "<img src='".IMG_URL."/pixel.gif' width='20' height='20'><img src='".IMG_URL."/copyr_trans.jpg' alt='"._AD_MA_COPYRTEXT6."' width='20' height='20' border='0'>");
            $copy_tray->addElement($copy_text);
          }
        }
        $coment_tarea = new RcxFormDhtmlTextArea(_AD_MA_DESCRIPTION, "coment", $img_Dat->coment());
        $clic_text = new RcxFormText(_AD_MA_CLICS, "clic", 33, 20, $img_Dat->clic());
        $rating_tray = new RcxFormElementTray(_AD_MA_RATING, "");
        $rating_text = new RcxFormLabel("", $img_Dat->rating());
        $rating_tray->addElement($rating_text);
        $vote_tray = new RcxFormElementTray(_AD_MA_VOTES, "");
        $vote_text = new RcxFormLabel("", $img_Dat->vote());
        $vote_tray->addElement($vote_text);
        $date_tray = new RcxFormElementTray(_AD_MA_DATEUPLOAD, "");
        $date_text = new RcxFormLabel("", formatTimestamp($img_Dat->date(),"m"));
        $date_tray->addElement($date_text);
        $free_tray = new RcxFormElementTray(_AD_MA_IMGFREE, "");
        $free_radio = new RcxFormRadioYN("", "free", intval($img_Dat->free()), _AD_MA_YES,_AD_MA_NO);
        $free_tray->addElement($free_radio);
        if ($img_Dat->free() == 2){
          $free_gif = "&nbsp;&nbsp;&nbsp;<img src='".IMG_URL."/new.gif' border=0 alt='"._AD_MA_NEW."'>";
          $free_img = new RcxFormLabel("", $free_gif);
            $free_tray->addElement($free_img);
          }
        $op_hidden = new RcxFormHidden("op","editImg");
            $op_pref_hidden = new RcxFormHidden("op_pref","save");
        $id_hidden = new RcxFormHidden("img_id",$img_Dat->id());
        $cname_hidden = new RcxFormHidden("cname",$img_Dat->cname());
            $op_coad_hidden = new RcxFormHidden("op_coad",$op_coad);                
        $button_tray = new RcxFormElementTray("", "");
        $submit_button = new RcxFormButton("", "button", "Update "._AD_MA_IMG, "submit");
        $button_tray->addElement($submit_button);
        $retour_button = new RcxFormLabel("", "<input type='button' class='button' value='"._AD_MA_GOBACK."' onClick=\"self.location.href='".GALL_PAGE."?op=img_conf&cid=".$img_Dat->cid()."&op_coad=".$op_coad."'\">");
        $button_tray->addElement($retour_button);
        $form->addElement($nom_text);
        $form->addElement($email_tray);
        $form->addElement($cid_select);
        $form->addElement($titre_text);
        $form->addElement($copy_tray);
        $form->addElement($coment_tarea);
        $form->addElement($clic_text);
        $form->addElement($rating_tray);
        $form->addElement($vote_tray);
        $form->addElement($date_tray);
        $form->addElement($free_tray);
        $form->addElement($op_hidden);
            $form->addElement($op_pref_hidden);
        $form->addElement($id_hidden);
        $form->addElement($cname_hidden);
            $form->addElement($op_coad_hidden);
        $form->addElement($button_tray);  
        $form->display();
        echo "</td></tr></table>";
        echo "</td><td align='center' valign='middle' class='bg1'>";
        if ($galerieConfig['safe_mode'] == 0){
          echo "<img src='../thumbnails/".$img_Dat->img()."' border='0'>";
        }else{
                gall_function("makeThumbnailFrame", array ("../galerie/".$img_Dat->img()));
        }
          echo "</td></tr></table>";
            
          CloseTable();
        gall_cp_footer();
          break;
        }
    }

?>