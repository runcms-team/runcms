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
    include(GALLI_PATH."/class/gall_mail.php");
    include(GALLI_PATH."/class/gall_img.php");   
    include(INCL_PATH."/user.errorhandler.php");
    $eh = new ErrorHandler;

// add by SVL for get correctly $key value & $id in int value
    $key = !empty($_POST['key']) ? $_POST['key'] : $_GET['key'];
    $id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
    $id = intval ($id);
    $key = $myts->makeTboxData4Save($key);

    switch($op) {
    
      case "carte2":
        include(RCX_ROOT_PATH."/header.php");
        gall_function("carte2");
        include("footer.php");
        include(RCX_ROOT_PATH."/footer.php");
        break;
        
      case "carte3":
        gall_function("carte3");
        break;
        
      case "actv":
            gall_function("carte_activate", array($id, $key));    
        break;    
        
      case "visit":
            gall_function("carte_visit", array($id, $key)); 
        break;    
    
      default:
        global $eh, $db;
        if ( $galerieConfig['imgversand'] == 1 ){
            $temp_time = time()-691200; // 8 Tage, löschen der Karten, die nicht aktiviert sind
            $sql = "SELECT id FROM ".$db->prefix("galli_mail")." WHERE status < '2' and date <'$temp_time'";
            $result = $db->query($sql);
            while(list($temp_id) = $db->fetch_row($result)){
              $db->query("delete from ".$db->prefix("galli_mail")." where id='$temp_id'");
            }
            $temp_time = time()-2592000;  // 30 Tage, löschen der gespeicherten Karten
            $sql = "SELECT id FROM ".$db->prefix("galli_mail")." WHERE status = '2' and date <'$temp_time'";
            $result = $db->query($sql);
            while(list($temp_id) = $db->fetch_row($result)){
              $db->query("delete from ".$db->prefix("galli_mail")." where id='$temp_id'");
            }
        
            include(RCX_ROOT_PATH."/header.php");
                gall_function("carte1");
                if ($rcxUser){
                    gall_function("carte_mail_table", array($rcxUser->uid()));
                }
            include("footer.php");
          include(RCX_ROOT_PATH."/footer.php");
        }else{
          redirect_header(RCX_URL."/",3,_NOPERM);
          exit();
        }
        break;
    } 

?>