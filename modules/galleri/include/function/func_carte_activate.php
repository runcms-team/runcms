<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function carte_activate($id, $key) {
      global $db, $rcxConfig, $myts, $eh, $meta;
        $numrows = GallMail::countAllMail(array("id = ".$id, "actkey = '".$key."' "));
        if ($numrows == 1){
            $card_store = new GallMail($id);
        if ( $card_store->status() >= 2 ) {
          redirect_header("index.php",5,sprintf(_CARTVERS, formatTimestamp($card_store->date_vers(),"m")));
          exit();
        }else{
                $subject = _ECARDTITEL." ".$meta['title'];
                $message = "Hallo ".$card_store->nom2()."\n\n";
            $message .= sprintf(_ECARDTEXTN1,$card_store->nom1());
          $message .= "\n\n"._ECARDTEXTN2."\n\n";
            $message .= RCX_URL."/modules/galleri/carte.php?op=visit&id=".$card_store->id()."&key=".$card_store->actkey()."\n\n";
                $message .= _ECARDTEXT6."\n\n";
                $message .= "\n\n"._ECARDTEXT5."\n\n";
          $message .= "\n".$meta['title']."\n";
          $message .= RCX_URL."\n";
          $message .= $rcxConfig['adminmail'];
            $rcxMailer =& getMailer();
            $rcxMailer->useMail();
            $rcxMailer->setToEmails($card_store->email2());
            $rcxMailer->setFromEmail($rcxConfig['adminmail']);
            $rcxMailer->setFromName($meta['title']);
            $rcxMailer->setSubject($subject);
            $rcxMailer->setBody($message);
                if ( !$rcxMailer->send() ) {
            redirect_header("index.php", 2, _ECARDNO);
            exit();
          } else {
                    $card_store->setVar("status", 2);                                 // E-Cardbenachrichtigung versandt 
                    $card_store->setVar("date_vers", time());
                    $card_store->store();
            redirect_header("index.php", 2, _ECARDGO.$card_store->email2());
                    
            exit();
          }
        }   
      }else{
            redirect_header("index.php",5,_NOACTKEY);
          exit();
        }
    }
?>
