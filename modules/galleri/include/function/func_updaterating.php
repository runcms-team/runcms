<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function updaterating($sel_id){
      global $db, $eh;
      $query = "select rating FROM ".$db->prefix("galli_vote")." WHERE id = ".$sel_id."";
      $voteresult = $db->query($query);
        $voteDB = $db->num_rows($voteresult);
      $totalrating = 0;
        while(list($rating)=$db->fetch_row($voteresult)){
        $totalrating += $rating;
      }
      $finalrating = $totalrating/$voteDB;
      $finalrating = number_format($finalrating, 4);
      $query = "UPDATE ".$db->prefix("galli_img")." SET rating=".$finalrating.", vote=".$voteDB." WHERE id = ".$sel_id." ";
        $db->query($query) or $eh->show("0013");
    }
?>
