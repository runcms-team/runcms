<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function carte1() {
      global $id, $cid, $db, $rcxConfig, $rcxUser, $eh, $galerieConfig, $meta, $bodycolor, $bordercolor, $police, $taille, $color;
        global $nom1, $email1, $nom2, $email2, $sujet, $message, $music, $myts;
        include_once(RCX_ROOT_PATH."/class/form/themeform.php");
        include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
        include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
        include_once(RCX_ROOT_PATH."/class/form/formtext.php");
        include_once(RCX_ROOT_PATH."/class/form/formselect.php");
        include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
        include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
        include_once (RCX_ROOT_PATH."/include/rcxcodes.php");
        include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
        include_once (INCL_PATH."/form_gallcolorselect.php");
        if ( $id > 0 ){     
            $img_Dat = new GallImg($id);
            $size = explode("|",$img_Dat->size());   
          OpenTable();
          echo "<center><h3>"._ECARDTITEL."".$meta['title']."</h3></center>";
          echo "<table border='0' cellspacing='0' cellpadding='0' align='center' class='bg2'><tr>";
          if ($galerieConfig['img_back'] == 1){
          echo "<td style='background-image:url(".GAL_URL."/".$img_Dat->img().")'>";
          echo "<img src='".IMG_URL."/blank.gif' border='0' width='".$size[0]."' height='".$size[1]."' alt='".$img_Dat->alt()."'>";
        }else{            
                echo "<td align='center'><img border='0' src='".GAL_URL."/".$img_Dat->img()."' alt='".$img_Dat->alt()."'>";
            }
            echo "</td></tr></table>";        
        $carte_form = new RcxThemeForm("<h4>"._FILDFULL."</h4>", "carte1", "carte.php");
        $sujet_text = new RcxFormText(_ECARDSUBJECT, "sujet", 50, 50, $sujet);
        $carte_form->addElement($sujet_text);
        $nom1_text = new RcxFormText(_ECARDNAME, "nom1", 40, 40, $nom1);
        $carte_form->addElement($nom1_text);
          if ( $rcxUser ) {
            $user = new RcxUser();
          $email1_label = new RcxFormLabel(_ECARDMAIL1, $rcxUser->getVar("email"));
          $carte_form->addElement($email1_label);
          $email1_text = new RcxFormHidden("email1", $rcxUser->getVar("email"));
          $carte_form->addElement($email1_text);
          }else{
          $email1_tray = new RcxFormElementTray(_ECARDMAIL1, "");
          $email1_text = new RcxFormText("", "email1", 40, 40, $email1);
          $email1_tray->addElement($email1_text);
          if ( $galerieConfig['anonym_mail'] == 1 ){
            $email1_label = new RcxFormLabel("", "<br>"._ECARDTIPP);
            $email1_tray->addElement($email1_label);
          }
          $carte_form->addElement($email1_tray);
          }
        $nom2_text = new RcxFormText(_ECARDRECIP, "nom2", 40, 40, $nom2);
        $carte_form->addElement($nom2_text);
        $email2_text = new RcxFormText(_ECARDMAIL2, "email2", 40, 40, $email2);
        $carte_form->addElement($email2_text);
        $message_tarea = new RcxFormDhtmlTextArea(_ECARDMASSAGE, "message", $message, 15, 70);
        $carte_form->addElement($message_tarea);        
        if ($galerieConfig['mailmusik'] == 1){
          $musik_select = new RcxFormSelect(_ECARDMUSIC, 'music', $music);
          $musik_select->addOptionArray(gall_function("getMusicArr"));
          $carte_form->addElement($musik_select);
        }
            $bodycolor_select = new GallFormColorSelect(_ECARDFOND, 'bodycolor', $bodycolor, "FFFFFF");
      $carte_form->addElement($bodycolor_select);
            $bordercolor_select = new GallFormColorSelect(_ECARDBORDER, 'bordercolor', $bordercolor, "FFFFFF");
      $carte_form->addElement($bordercolor_select);
            $color_select = new GallFormColorSelect(_ECARDTEXTCOLOR, 'color', $color, "000000");
      $carte_form->addElement($color_select);
        $op_hidden = new RcxFormHidden('op', 'carte2');
        $carte_form->addElement($op_hidden);
        $id_hidden = new RcxFormHidden('id', $id);
        $carte_form->addElement($id_hidden);
            $button_tray = new RcxFormElementTray("", "");
        $submit_button = new RcxFormButton('', 'submit', _ECARDPREVIEW, 'submit');  
            $button_tray->addElement($submit_button);
            $retour_button = new RcxFormLabel("", "<input type='button' class='button' value='"._MD_CANCEL."' onClick=\"self.location.href='viewcat.php?id=".$img_Dat->id()."&cid=".$img_Dat->cid()."'\">");
            $button_tray->addElement($retour_button);
        $carte_form->addElement($button_tray);
            $carte_form->setRequired("sujet", "nom1", "email1", "email1", "nom2", "email2", "message");
        $carte_form->display();
          CloseTable();
      }else{
        echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
        exit();
      }
    } 
?>
