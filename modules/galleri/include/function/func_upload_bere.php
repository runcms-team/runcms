<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function upload_bere($t_cid){
      global $db, $rcxUser;
      if (!$rcxUser){return false;}
      $result=$db->query("select cid, uid from ".$db->prefix("galli_user")." where uid='".$rcxUser->uid()."'");
      while(list($cid, $uid) = $db->fetch_row($result)){
        if ( $cid == 0 && $uid == $rcxUser->uid() || $cid == $t_cid && $uid == $rcxUser->uid() ){
          return true;
        }
      }
      return false;
    }
?>
