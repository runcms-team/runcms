<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
Class GallCat extends RcxObject{
  var $inactive = false;

  function GallCat($cid=NULL){
    $this->RcxObject();
    $this->initVar("cid", "int", NULL, false);
    $this->initVar("scid", "int", NULL, false);
    $this->initVar("cname", "textbox", NULL, false, 40, true);
    $this->initVar("img", "textbox", NULL, false, 40, true);
    $this->initVar("coment", "textbox", NULL, false, 50, true);
    $this->initVar("button", "textbox", NULL, false, 40, true);
        $this->initVar("date", "int", 0, false);
    if ( !empty($cid) ) {
      if ( is_array($cid) ) {
        $this->set($cid);
      } else {
        $this->load(intval($cid));
      }
    }
    
  }


  function load($cid){
    global $db;
    $sql = "SELECT * FROM ".$db->prefix("galli_category")." WHERE cid=".$cid."";
    if ( !$result = $db->query($sql) ) {
      die($sql);      
    }
    $numrows = $db->num_rows($result);
    if ( $numrows == 1 ) {
      $myrow = $db->fetch_array($result);
      $this->set($myrow);
    } elseif ( $numrows == 0 ) {
      $this->inactive = true;
    } else {
      die("Duplicate User Entries!");
    }
  }

  function store(){
    global $db;
    if ( !$this->isCleaned() ) {
      if ( !$this->cleanVars() ) {
        return false;
      }
    }   
    foreach ( $this->cleanVars as $k=>$v ) {
      $$k = $v;
    }
    if ( empty($cid) ) {
      $cid = $db->genId($db->prefix("galli_category")."_cid_seq");
      $sql = "INSERT INTO ".$db->prefix("galli_category")." (cid, scid, cname, img, coment, button, date) VALUES ($cid, $scid, '$cname', '$img', '$coment', 'no_button.gif', '$date')";
    }  else {
        
      $sql ="UPDATE ".$db->prefix("galli_category")." SET cid='$cid', scid='$scid', cname='$cname', img='$img', coment='$coment', button='$button', date='$date' WHERE cid=$cid";
    }
//    echo $sql;
    if ( !$result = $db->queryF($sql) ) {
      $this->setErrors("Could not store data in database.");
      return false;
    }
    if ( empty($cid) ) {
      $cid = $db->insert_id();
    }
        
    return $cid;
  }

  function delete(){
    global $db;
    if ( $this->getVar("cid") > 0 ) {
      $sql = "DELETE FROM ".$db->prefix("galli_category")." WHERE cid=".$this->getVar("cid")."";
      if ( !$result = $db->query($sql) ) {
        return false;
      }
    }
    return true;
  }

  static function getAllCat($criteria=array(), $asobject=false, $orderby="scid ASC", $limit=0, $start=0){
    global $db;
    $ret = array();
    $where_query = "";
    if ( is_array($criteria) && count($criteria) > 0 ) {
      $where_query = " WHERE";
      foreach ( $criteria as $c ) {
        $where_query .= " $c AND";
      }
      $where_query = substr($where_query, 0, -4);
    }
    if ( !$asobject ) {
      $sql = "SELECT cid FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
      $result = $db->query($sql,$limit,$start);
      while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = $myrow['cid'];
      }
    } else {
      $sql = "SELECT * FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
      $result = $db->query($sql,$limit,$start);
      while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = new GallCat($myrow);
      }
    }
//echo $sql;
    return $ret;
  }

  function getAllCatList($criteria=array(), $orderby="cname ASC", $limit=0, $start=0){
    global $db, $myts;
    $ret = array();
    $where_query = "";
    if ( is_array($criteria) && count($criteria) > 0 ) {
      $where_query = " WHERE";
      foreach ( $criteria as $c ) {
        $where_query .= " $c AND";
      }
      $where_query = substr($where_query, 0, -4);
    }
    $sql = "SELECT cid, cname FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
    $result = $db->query($sql,$limit,$start);
    while ( $myrow = $db->fetch_array($result) ) {
      $ret[$myrow['cid']] = $myts->makeTboxData4Show($myrow['cname']);
    }
    return $ret;
  }

  static function countAllCat($criteria=array()){
    global $db;
    $where_query = "";
    if ( is_array($criteria) && count($criteria) > 0 ) {
      $where_query = " WHERE";
      foreach ( $criteria as $c ) {
        $where_query .= " $c AND";
      }
      $where_query = substr($where_query, 0, -4);
    }
    $sql = "SELECT COUNT(*) FROM ".$db->prefix("galli_category")."".$where_query."";
    $result = $db->query($sql);
    list($ret) = $db->fetch_row($result);
//    echo $sql."<br>";
    return $ret;
  }

  function cid(){
    return $this->getVar("cid");
  }
  function scid(){
    return $this->getVar("scid");
  }
  function cname($format="S"){
    return $this->getVar("cname", $format);
  }
  function img($format="S"){
    return $this->getVar("img", $format);
  }
  function coment($format="S"){
    return $this->getVar("coment", $format);
  }
  function button($format="S"){
    return $this->getVar("button", $format);
  }
  function date(){
    return $this->getVar("date");
  }
}

?>
