<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function test_member($aut_email){
      global $db, $rcxConfig, $member;
      $member = 0;
      $user_dat = $db->fetch_array($db->query("SELECT * FROM ".$db->prefix("users")." WHERE email='$aut_email'"));
      $db_email = $user_dat[email];
      if ($aut_email == $db_email){$member = $user_dat[uid];}
//      return $member;
    }
?>
