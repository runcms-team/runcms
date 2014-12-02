<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  class GallTree{
    var $table;   
    var $id; 
    var $pid;    
    var $order;   
    var $title;   
    var $db;
  
    function GallTree($table_name, $id_name, $pid_name){
      global $db;
      $this->db = $db;
      $this->table = $table_name;
      $this->id = $id_name;
      $this->pid = $pid_name;
    }
  
  
    function getFirstChild($sel_id, $order=""){
      $arr =array();
      $sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result = $this->db->query($sql);
      $count = $this->db->num_rows($result);
      if ( $count==0 ) {
        return $arr;
      }
      while ( $myrow=$this->db->fetch_array($result) ) {
        array_push($arr, $myrow);
      }
      return $arr;
    }
  
    function getFirstChildId($sel_id){
      $idarray =array();
      $result = $this->db->query("SELECT ".$this->id." FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."");
      $count = $this->db->num_rows($result);
      if ( $count == 0 ) {
        return $idarray;
      }
      while ( list($id) = $this->db->fetch_row($result) ) {
        array_push($idarray, $id);
      }
      return $idarray;
    }
  
    function getAllChildId($sel_id, $order="", $idarray = array()){
      $sql = "SELECT ".$this->id." FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result=$this->db->query($sql);
      $count = $this->db->num_rows($result);
      if ( $count==0 ) {
        return $idarray;
      }
      while ( list($r_id) = $this->db->fetch_row($result) ) {
        array_push($idarray, $r_id);
        $idarray = $this->getAllChildId($r_id,$order,$idarray);
      }
      return $idarray;
    }
  
    function getAllParentId($sel_id, $order="", $idarray = array()){
      $sql = "SELECT ".$this->pid." FROM ".$this->table." WHERE ".$this->id."=".$sel_id."";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result=$this->db->query($sql);
      list($r_id) = $this->db->fetch_row($result);
      if ( $r_id == 0 ) {
        return $idarray;
      }
      array_push($idarray, $r_id);
      $idarray = $this->getAllParentId($r_id,$order,$idarray);
      return $idarray;
    }
  
    function getPathFromId($sel_id, $title, $path=""){
      $result = $this->db->query("SELECT ".$this->pid.", ".$title." FROM ".$this->table." WHERE ".$this->id."=$sel_id");
      if ( $this->db->num_rows($result) == 0 ) {
        return $path;
      }
      list($parentid,$name) = $this->db->fetch_row($result);
      $myts =& MyTextSanitizer::getInstance();
      $name = $myts->makeTboxData4Show($name);
      $path = "/".$name.$path."";
      if ( $parentid == 0 ) {
        return $path;
      }
      $path = $this->getPathFromId($parentid, $title, $path);
      return $path;
    }
  
    function makeMySelBox($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange=""){
      if ( $sel_name == "" ) {
        $sel_name = $this->id;
      }
      $myts =& GallTextSanitizer::getInstance();
      echo "<select class='select' name='".$sel_name."'";
      if ( $onchange != "" ) {
        echo " onchange='".$onchange."'";
      }
      echo ">\n";
      $sql = "SELECT ".$this->id.", ".$title." FROM ".$this->table." WHERE ".$this->pid."=0";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result = $this->db->query($sql);
      if ( $none ) {
        echo "<option value='0'>----</option>\n";
      }
      while ( list($catid, $name) = $this->db->fetch_row($result) ) {
        $sel = "";
        if ( $catid == $preset_id ) {
          $sel = " selected='selected'";
        }
        echo "<option value='$catid'$sel>$name</option>\n";
        $sel = "";
        $arr = $this->getChildTreeArray($catid);
        foreach ( $arr as $option ) {
          $option['prefix'] = str_replace(".","--",$option['prefix']);
          $catpath = $option['prefix']."&nbsp;".$myts->makeTboxData4Show($option[$title]);
          if ( $option[$this->id] == $preset_id ) {
            $sel = " selected='selected'";
          }
          echo "<option value='".$option[$this->id]."'$sel>$catpath</option>\n";
          $sel = "";
        }
      }
      echo "</select>\n";
    }
  
    function getNicePathFromId($sel_id, $title, $funcURL, $path=""){
      $sql = "SELECT ".$this->pid.", ".$title." FROM ".$this->table." WHERE ".$this->id."=$sel_id";
      $result = $this->db->query($sql);
      if ( $this->db->num_rows($result) == 0 ) {
        return $path;
      }
      list($parentid,$name) = $this->db->fetch_row($result);
      $myts =& GallTextSanitizer::getInstance();
      $name = $myts->makeTboxData4Show($name);
      $path = "<a href='".$funcURL."&".$this->id."=".$sel_id."'>".$name."</a>&nbsp;:&nbsp;".$path."";
      if ( $parentid == 0 ) {
        return $path;
      }
      $path = $this->getNicePathFromId($parentid, $title, $funcURL, $path);
      return $path;
    }
  
    function getIdPathFromId($sel_id, $path=""){
      $result = $this->db->query("SELECT ".$this->pid." FROM ".$this->table." WHERE ".$this->id."=$sel_id");
      if ( $this->db->num_rows($result) == 0 ) {
        return $path;
      }
      list($parentid) = $this->db->fetch_row($result);
      $path = "/".$sel_id.$path."";
      if ( $parentid == 0 ) {
        return $path;
      }
      $path = $this->getIdPathFromId($parentid, $path);
      return $path;
    }
  
    function getAllChild($sel_id=0,$order="",$parray = array()){
      $sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result = $this->db->query($sql);
      $count = $this->db->num_rows($result);
      if ( $count == 0 ) {
        return $parray;
      }
      while ( $row = $this->db->fetch_array($result) ) {
        array_push($parray, $row);
        $parray=$this->getAllChild($row[$this->id],$order,$parray);
      }
      return $parray;
    }
  
    function getChildTreeArray($sel_id=0,$order="",$parray = array(),$r_prefix=""){
      $sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."";
      if ( $order != "" ) {
        $sql .= " ORDER BY $order";
      }
      $result = $this->db->query($sql);
      $count = $this->db->num_rows($result);
      if ( $count == 0 ) {
        return $parray;
      }
      while ( $row = $this->db->fetch_array($result) ) {
        $row['prefix'] = $r_prefix.".";
        array_push($parray, $row);
        $parray = $this->getChildTreeArray($row[$this->id],$order,$parray,$row['prefix']);
      }
      return $parray;
    }
  }
?>
