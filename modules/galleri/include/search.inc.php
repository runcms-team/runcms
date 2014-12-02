<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function galli_search($queryarray, $andor, $limit, $offset, $userid){
  global $rcxDB, $rcxUser, $db;
  
  if ( defined("ERCX_ABSDATABASE_INCLUDED") ) {$rcxDB = $db;}
  
  $sql = "SELECT id,cid,nom,cname,titre,img,coment,date FROM ".$rcxDB->prefix("galli_img")." WHERE free > '0' ";
  if ( $userid != 0 ) {
    $thisUser= new RcxUser($userid);
    $sql .= " AND nom='".$thisUser->getVar("uname")."'";
  } 
  if ( is_array($queryarray) && $count = count($queryarray) ) {
    $sql .= " AND ((cname LIKE '%$queryarray[0]%' OR titre LIKE '%$queryarray[0]%' OR img LIKE '%$queryarray[0]%' OR coment LIKE '%$queryarray[0]%')";
    for($i=1;$i<$count;$i++){
      $sql .= " $andor ";
      $sql .= "(cname LIKE '%$queryarray[$i]%' OR titre LIKE '%$queryarray[$i]%' OR img LIKE '%$queryarray[$i]%' OR coment LIKE '%$queryarray[$i]%')";
    }
    $sql .= ") ";
  }
  $sql .= "ORDER BY date DESC";
  $result = $rcxDB->query($sql,$limit,$offset);
  $ret = array();
  $i = 0;
  if ( defined("ERCX_ABSDATABASE_INCLUDED") ) {
    while($myrow = $rcxDB->fetch_array($result)){
      $ret[$i]['image'] = "images/jpg.gif";
      $ret[$i]['link'] = "viewcat.php?id=".$myrow['id']."&cid=".$myrow['cid']."";
      if ( $myrow['titre'] != "" ){
        $ret[$i]['title'] = $myrow['titre'];
      }else{
        $ret[$i]['title'] = $myrow['img'];
      }
      $ret[$i]['time'] = $myrow['date'];
      $i++;
    }
  }else{
    while($myrow = $rcxDB->fetchArray($result)){
      $ret[$i]['image'] = "images/jpg.gif";
      $ret[$i]['link'] = "viewcat.php?id=".$myrow['id']."&cid=".$myrow['cid']."";
      if ( $myrow['titre'] != "" ){
        $ret[$i]['title'] = $myrow['titre'];
      }else{
        $ret[$i]['title'] = $myrow['img'];
      }
      $ret[$i]['time'] = $myrow['date'];
      $i++;
    }
  }
  return $ret;
}
?>