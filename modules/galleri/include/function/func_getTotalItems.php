<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function getTotalItems($sel_id, $status=""){
      global $db, $galltree;
      $count = 0;
      $arr = array();
      $query = "select count(*) from ".$db->prefix("galli_img")." where cid=".$sel_id."";
      if($status!=""){
        $query .= " and free>=$status";
      }
      $result = $db->query($query);
      list($thing) = $db->fetch_row($result);
      $count = $thing;
      $arr = $galltree->getAllChildId($sel_id);
      $size = sizeof($arr);
      for($i=0;$i<$size;$i++){
        $query2 = "select count(*) from ".$db->prefix("galli_img")." where cid=".$arr[$i]."";
        if($status!=""){
          $query2 .= " and free>=$status";
        }
        $result2 = $db->query($query2);
        list($thing) = $db->fetch_row($result2);
        $count += $thing;
      }
      return $count;
    }
?>
