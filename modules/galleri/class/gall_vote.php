<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
//include_once(RCX_ROOT_PATH."/modules/galleri/class/rcxobject.php");


Class GallVote extends RcxObject{

  var $inactive = false;

  function GallVote($ratingid=NULL){
  
    $this->RcxObject();
    $this->initVar("ratingid", "int", NULL, false);
    $this->initVar("id", "int", NULL, false);
    $this->initVar("ratinguser", "int", NULL, false);
    $this->initVar("rating", "int", NULL, false);
    $this->initVar("ratinghostname", "int", NULL, false);
        $this->initVar("ratingtimestamp", "int", 0, false);
    if ( !empty($ratingid) ) {
      if ( is_array($ratingid) ) {
        $this->set($ratingid);
      } else {
        $this->load(intval($ratingid));
      }
    }
    
  }


  function load($ratingid){
    global $db;
    $sql = "SELECT * FROM ".$db->prefix("galli_category")." WHERE ratingid=".$ratingid."";
    if ( !$result = $db->query($sql) ) {
      die($sql);      
    }
//echo $sql;
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
    if ( empty($ratingid) ) {
      $ratingid = $db->genId($db->prefix("galli_category")."_ratingid_seq");
      $sql = "INSERT INTO ".$db->prefix("galli_category")." (ratingid, id, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES ($ratingid, $id, '$ratinguser', '$rating', '$ratinghostname', '$ratingtimestamp')";
    }  else {
        
      $sql ="UPDATE ".$db->prefix("galli_category")." SET ratingid='$ratingid', id='$id', ratinguser='$ratinguser', rating='$rating', ratinghostname='$ratinghostname', ratingtimestamp='$ratingtimestamp' WHERE ratingid=$ratingid";
    }
//    echo $sql;
    if ( !$result = $db->queryF($sql) ) {
      $this->setErrors("Could not store data in database.");
      return false;
    }
    if ( empty($ratingid) ) {
      $ratingid = $db->insert_id();
    }
        
    return $ratingid;
  }

  function delete(){
    global $db;
    if ( $this->getVar("ratingid") > 0 ) {
      $sql = "DELETE FROM ".$db->prefix("galli_category")." WHERE ratingid=".$this->getVar("ratingid")."";
      if ( !$result = $db->query($sql) ) {
        return false;
      }
    }
    return true;
  }

  function getAllVote($criteria=array(), $asobject=false, $orderby="id ASC", $limit=0, $start=0){
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
      $sql = "SELECT ratingid FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
      $result = $db->query($sql,$limit,$start);
      while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = $myrow['ratingid'];
      }
    } else {
      $sql = "SELECT * FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
      $result = $db->query($sql,$limit,$start);
      while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = new GallVote($myrow);
      }
    }
    //echo $sql;
    return $ret;
  }

/*
  function getAllVoteList($criteria=array(), $orderby="id ASC", $limit=0, $start=0){
    global $db;
    $myts =& MyTextSanitizer::getInstance();
    $ret = array();
    $where_query = "";
    if ( is_array($criteria) && count($criteria) > 0 ) {
      $where_query = " WHERE";
      foreach ( $criteria as $c ) {
        $where_query .= " $c AND";
      }
      $where_query = substr($where_query, 0, -4);
    }
    $sql = "SELECT ratingid, id FROM ".$db->prefix("galli_category")."".$where_query." ORDER BY $orderby";
    $result = $db->query($sql,$limit,$start);
    while ( $myrow = $db->fetch_array($result) ) {
      $ret[$myrow['ratingid']] = $myts->makeTboxData4Show($myrow['id']);
    }
    return $ret;
  }
*/
  function countAllVote($criteria=array()){
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

  function ratingid(){
    return $this->getVar("ratingid");
  }
  function id(){
    return $this->getVar("id");
  }
  function ratinguser(){
    return $this->getVar("ratinguser");
  }
  function rating(){
    return $this->getVar("rating");
  }
  function ratinghostname(){
    return $this->getVar("ratinghostname");
  }
  function ratingtimestamp(){
    return $this->getVar("ratingtimestamp");
  }
}
?>