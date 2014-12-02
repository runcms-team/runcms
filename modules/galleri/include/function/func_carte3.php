<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function carte3() {
      global $id, $db, $rcxConfig, $myts, $police, $taille, $color, $bodycolor, $bordercolor;
      global $nom1, $email1, $nom2, $email2, $sujet, $message, $music, $image, $galerieConfig, $rcxUser, $eh, $meta;
        
        $card_store = new GallMail();
        $card_store->setVar("nom1", $myts->makeTboxData4Save($nom1));
        if($rcxUser){$x_uid = $rcxUser->uid();}else{$x_uid = 0;}
        $card_store->setVar("uid", $x_uid);
    $card_store->setVar("nom2", $myts->makeTboxData4Save($nom2));
    $card_store->setVar("email1", $myts->makeTboxData4Save($email1));
    $card_store->setVar("email2", $myts->makeTboxData4Save($email2));
    $card_store->setVar("sujet", $myts->makeTboxData4Save($sujet));
        $actkey = substr(md5(makepass()), 0, 20);
    $card_store->setVar("actkey", $actkey);
    $card_store->setVar("message", $myts->makeTareaData4Save($message));
    $card_store->setVar("image", $myts->makeTboxData4Save($id));
    $card_store->setVar("music", $myts->makeTboxData4Save($music));
    $card_store->setVar("body", $myts->makeTboxData4Save($bodycolor));
    $card_store->setVar("border", $myts->makeTboxData4Save($bordercolor));
    $card_store->setVar("color", $myts->makeTboxData4Save($color));
    $card_store->setVar("poli", $myts->makeTboxData4Save($police));
    $card_store->setVar("tail", $myts->makeTboxData4Save($taille));
        $card_store->setVar("date", time());
        $mail_ID = $card_store->store();
        if ( $mail_ID == 0 ) {
      $eh->show("0013", "carte.php", array("name='op' value='carte1'"));
    }else{
            if ( $rcxUser || $galerieConfig['anonym_mail'] == 0 ){
                $subject = _ECARDTITEL." ".$meta['title'];
                $message = "Hallo ".$nom2."\n\n";
            $message .= sprintf(_ECARDTEXTN1,$nom1);
          $message .= "\n\n"._ECARDTEXTN2."\n\n";
            $message .= RCX_URL."/modules/galleri/carte.php?op=visit&id=".$mail_ID."&key=".$actkey."\n\n";
                $message .= _ECARDTEXT6."\n\n";
                $message .= "\n\n"._ECARDTEXT5."\n\n";
          $message .= "\n".$meta['title']."\n";
          $message .= RCX_URL."\n";
          $message .= $rcxConfig['adminmail'];
            $rcxMailer =& getMailer();
            $rcxMailer->useMail();
            $rcxMailer->setToEmails($email2);
            $rcxMailer->setFromEmail($rcxConfig['adminmail']);
            $rcxMailer->setFromName($meta['title']);
            $rcxMailer->setSubject($subject);
            $rcxMailer->setBody($message);
                if ( !$rcxMailer->send() ) {
            redirect_header("index.php", 2, _ECARDNO);
            exit();
          } else {
                    $card_store = new GallMail($mail_ID);
                    $card_store->setVar("status", 2);                                 // E-Cardbenachrichtigung versandt 
                    $card_store->setVar("date_vers", time());
                    $card_store->store();
            redirect_header("index.php", 2, _ECARDGO.$email2);
                    
            exit();
          }
            }else{
                $subject = _ECARDTITEL." ".$meta['title'];
                $message = "Hello ".$nom1."\n\n";
            $message .= sprintf(_ECARDTEXT1,$email1);
          $message .= "\n\n"._ECARDTEXT3."\n\n";
            $message .= RCX_URL."/modules/galleri/carte.php?op=actv&id=".$mail_ID."&key=".$actkey."";
          $message .= "\n\n"._ECARDTEXT4."\n\n";
          $message .= "\n".$meta['title']."\n";
          $message .= RCX_URL."\n";
          $message .= $rcxConfig['adminmail'];
            $rcxMailer =& getMailer();
            $rcxMailer->useMail();
            $rcxMailer->setToEmails($email1);
            $rcxMailer->setFromEmail($rcxConfig['adminmail']);
            $rcxMailer->setFromName($meta['title']);
            $rcxMailer->setSubject(""._ECARDTITEL."".$meta['title']."");
            $rcxMailer->setBody($message);
                if ( !$rcxMailer->send() ) {
            redirect_header("index.php", 2, _ECARDNO);
            exit();
          } else {
            $card_store = new GallMail($mail_ID);
                    $card_store->setVar("status", 1);                                 // Aktivierungscode versandt
                    $card_store->store();
                    redirect_header("index.php", 2, _ECARDANON);
            exit();
          }
            }
    }
    }
?>
