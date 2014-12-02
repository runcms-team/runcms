<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
Class GalliConf extends RcxObject{

  var $inactive = false;

  function GalliConf($id=NULL){
  
    $this->RcxObject();
    $this->initVar("id", "int", NULL, false);
    $this->initVar("parm1", "int", NULL, false);
    $this->initVar("parm2", "int", NULL, false);
    $this->initVar("parm3", "int", NULL, false);
    $this->initVar("parm4", "int", NULL, false);
    $this->initVar("parm5", "int", NULL, false);
    $this->initVar("parm6", "int", NULL, false);
    $this->initVar("parm7", "int", NULL, false);
    $this->initVar("parm8", "int", NULL, false);
    $this->initVar("parm9", "textbox", NULL, false, 50, true);
    $this->initVar("parm10", "textbox", NULL, false, 40, true);
    $this->initVar("parm11", "textbox", NULL, false, 6, true);
    $this->initVar("parm12", "textbox", NULL, false, 6, true);
    $this->initVar("parm13", "textbox", NULL, false, 40, true);
    $this->initVar("parm14", "textbox", NULL, false, 20, true);
    $this->initVar("parm15", "textbox", NULL, false, 20, true);
        $this->initVar("parm16", "int", 0, false);
    $this->initVar("parm17", "int", 0, false);
        $this->initVar("parm18", "textbox", NULL, false, 255, true);
        $this->initVar("parm19", "double", NULL, false);
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
    $sql = "SELECT * FROM ".$db->prefix("galli_conf")." WHERE id=".$id."";
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
    if ( empty($id) ) {
      $id = $db->genId($db->prefix("galli_conf")."_id_seq");
      $sql = "INSERT INTO ".$db->prefix("galli_conf")." (id, parm1, parm2, parm3, parm4, parm5, parm6, parm7, parm8, parm9, parm10, parm11, parm12, parm13, parm14, parm15, parm16, parm17, parm18, parm19) VALUES (".$id.", '".$parm1."', '".$parm2."', '".$parm3."', '".$parm4."', '".$parm5."', '".$parm6."', '".$parm7."', '".$parm8."', '".$parm9."', '".$parm10."', '".$parm11."', '".$parm12."', '".$parm13."', '".$parm14."', '".$parm15."', '".$parm16."', '".$parm17."', '".$parm18."', '".$parm19."')";
    }  else {        
      $sql ="UPDATE ".$db->prefix("galli_conf")." SET id='".$id."', parm1='".$parm1."', parm2='".$parm2."', parm3='".$parm3."', parm4='".$parm4."', parm5='".$parm5."', parm6='".$parm6."', parm7='".$parm7."', parm8='".$parm8."', parm9='".$parm9."', parm10='".$parm10."', parm11='".$parm11."', parm12='".$parm12."', parm13='".$parm13."', parm14='".$parm14."', parm15='".$parm15."', parm16='".$parm16."', parm17='".$parm17."', parm18='".$parm18."', parm19='".$parm19."' WHERE id=".$id." ";
    }
//    echo $sql;
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
      $sql = "DELETE FROM ".$db->prefix("galli_conf")." WHERE id=".$this->getVar("id")."";
      if ( !$result = $db->query($sql) ) {
        return false;
      }
    }
    return true;
  }

  function id(){
    return $this->getVar("id");
  }
  function parm1(){
    return $this->getVar("parm1");
  }
  function parm2(){
    return $this->getVar("parm2");
  }
  function parm3(){
    return $this->getVar("parm3");
  }
  function parm4(){
    return $this->getVar("parm4");
  }
  function parm5(){
    return $this->getVar("parm5");
  }
  function parm6(){
    return $this->getVar("parm6");
  }
  function parm7(){
    return $this->getVar("parm7");
  }
  function parm8(){
    return $this->getVar("parm8");
  }
  function parm9($format="S"){
    return $this->getVar("parm9", $format);
  }
  function parm10($format="S"){
    return $this->getVar("parm10", $format);
  }
  function parm11($format="S"){
    return $this->getVar("parm11", $format);
  }
  function parm12($format="S"){
    return $this->getVar("parm12", $format);
  }
  function parm13($format="S"){
    return $this->getVar("parm13", $format);
  }
  function parm14($format="S"){
    return $this->getVar("parm14", $format);
  }
  function parm15($format="S"){
    return $this->getVar("parm15", $format);
  }
  function parm16(){
    return $this->getVar("parm16");
  }
  function parm17(){
    return $this->getVar("parm17");
  }
    function parm18($format="S"){
    return $this->getVar("parm18", $format);
  }
    function parm19($format="S"){
    return $this->getVar("parm19", $format);
  }
}
?>