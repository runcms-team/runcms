<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    if (!defined("GALL_IMG_INCLUDED")) {
      define("GALL_IMG_INCLUDED", 1);
        
        include_once(RCX_ROOT_PATH."/class/rcxobject.php");
        Class GallImg extends RcxObject{
        
          var $inactive = false;
        
          function GallImg($id=NULL){
          
            $this->RcxObject();
            $this->initVar("id", "int", NULL, false);
            $this->initVar("cid", "int", NULL, false);
            $this->initVar("nom", "textbox", NULL, false, 30, true);
            $this->initVar("email", "textbox", NULL, false, 50, true);
            $this->initVar("cname", "textbox", NULL, false, 40, true);
            $this->initVar("titre", "textbox", NULL, false, 40, true);
            $this->initVar("img", "textbox", NULL, false, 40, true);
            $this->initVar("coment", "textarea", NULL, false, NULL, true);
// ALT tag
            $this->initVar("alt", "textbox", NULL, false, 255, true);

            $this->initVar("clic", "int", 0, false);
            $this->initVar("rating", "double", 0, false);
            $this->initVar("vote", "int", 0, false);
            $this->initVar("free", "int", 0, false);
            $this->initVar("copy", "int", 0, false);
            $this->initVar("new_img", "int", 0, false);
                $this->initVar("date", "int", 0, false);
                $this->initVar("byte", "int", 0, false);
                $this->initVar("size", "textbox", NULL, false, 100, true);
                $this->initVar("thumbCorr", "int", 0, false);
            if ( !empty($id) ) {
              if ( is_array($id) ) {
                $this->set($id);
              } else {
                $this->load(intval($id));
              }
            }   
          }
        
        
          function load($id){
            global $db;
            $sql = "SELECT * FROM ".$db->prefix("galli_img")." WHERE id=".$id."";
            if ( !$result = $db->query($sql) ) {
              die("ERROR");
            }
        //echo $sql;
            $numrows = $db->num_rows($result);
            if ( $numrows == 1 ) {
              $myrow = $db->fetch_array($result);
              $this->set($myrow);
              if ( $this->getVar("free") == 0 ) {
                $this->inactive = true;
              }
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
            if ( empty($id) ) {
              $id = $db->genId($db->prefix("galli_img")."_id_seq");
// ALT tag
              $sql = "INSERT INTO ".$db->prefix("galli_img")." (id, cid, nom, email, cname, titre, img, coment, clic, rating, vote, free, copy, new_img, date, byte, size, thumbCorr, alt) VALUES ($id, $cid, '$nom', '$email', '$cname', '$titre', '$img', '$coment', '$clic', '$rating', '$vote', '$free',  '$copy', '$new_img', '$date', '$byte', '$size', $thumbCorr, '$alt')";
      // echo $sql;
            }  else {
// ALT tag                
              $sql ="UPDATE ".$db->prefix("galli_img")." SET id='$id', cid='$cid', nom='$nom', email='$email', cname='$cname', titre='$titre', img='$img', coment='$coment', clic='$clic',  rating='$rating', vote='$vote', free='$free', copy='$copy', new_img='$new_img', date='$date', byte='$byte', size='$size', thumbCorr='$thumbCorr', alt='$alt' WHERE id=$id";
            }
      // echo $sql;
            if ( !$result = $db->queryF($sql) ) {
              $this->setErrors("Could not store data in database.");
              return false;
            }
            if ( empty($id) ) {
              $id = $db->insert_id();
            }
                
            return $id;
          }
        
          function delete(){
            global $db;
            if ( $this->getVar("id") > 0 ) {
              $sql = "DELETE FROM ".$db->prefix("galli_img")." WHERE id=".$this->getVar("id")."";
              if ( !$result = $db->query($sql) ) {
                return false;
              }
            }
            return true;
          }
        
          function getAllImg($criteria=array(), $asobject=false, $orderby="cid ASC", $limit=0, $start=0){
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
              $sql = "SELECT id FROM ".$db->prefix("galli_img")."".$where_query." ORDER BY $orderby";
              $result = $db->query($sql,$limit,$start);
              while ( $myrow = $db->fetch_array($result) ) {
                $ret[] = $myrow['id'];
              }
            } else {
              $sql = "SELECT * FROM ".$db->prefix("galli_img")."".$where_query." order by $orderby";
              $result = $db->query($sql,$limit,$start);
              while ( $myrow = $db->fetch_array($result) ) {
                $ret[] = new GallImg($myrow);
              }
            }
        //echo $sql;
            return $ret;
          }
        
          static function getAllImgList($criteria=array(), $orderby="cid ASC", $limit=0, $start=0){
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
            $sql = "SELECT id, img FROM ".$db->prefix("galli_img")."".$where_query." ORDER BY $orderby";
            $result = $db->query($sql,$limit,$start);
            while ( $myrow = $db->fetch_array($result) ) {
              $ret[$myrow['img']] = $myts->makeTboxData4Show($myrow['img']);
            }
            return $ret;
          }
        
          static function countAllImg($criteria=array()){
            global $db;
            $where_query = "";
            if ( is_array($criteria) && count($criteria) > 0 ) {
              $where_query = " WHERE";
              foreach ( $criteria as $c ) {
                $where_query .= " $c AND";
              }
              $where_query = substr($where_query, 0, -4);
            }
            $sql = "SELECT COUNT(*) FROM ".$db->prefix("galli_img")."".$where_query."";
            $result = $db->query($sql);
            list($ret) = $db->fetch_row($result);
        //    echo $sql."<br>";
            return $ret;
          }
        
          function id(){
            return $this->getVar("id");
          }
          function cid(){
            return $this->getVar("cid");
          }
          function nom($format="S"){
            return $this->getVar("nom", $format);
          }
          function email($format="S"){
            return $this->getVar("email", $format);
          }
          function cname($format="S"){
            return $this->getVar("cname", $format);
          }
          function titre($format="S"){
            return $this->getVar("titre", $format);
          }
          function img($format="S"){
            return $this->getVar("img", $format);
          }
          function coment($format="S"){
            return $this->getVar("coment", $format);
          }
          function text($format="S"){
            return $this->getVar("text", $format);
          }
          function clic(){
            return $this->getVar("clic");
          }
          function rating(){
            return $this->getVar("rating");
          }
          function vote(){
            return $this->getVar("vote");
          }
          function free(){
            return $this->getVar("free");
          }
          function copy(){
            return $this->getVar("copy");
          }
          function new_img(){
            return $this->getVar("new_img");
          }
          function date(){
            return $this->getVar("date");
          }
            function byte(){
            return $this->getVar("byte");
          }
          function size($format="S"){
            return $this->getVar("size", $format);
          }
            function thumbCorr(){
            return $this->getVar("thumbCorr");
          }
// ALT tag
          function alt($format="S"){
            return $this->getVar("alt", $format);
          }

        }
    }
?>