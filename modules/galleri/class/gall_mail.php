<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    if (!defined("GALL_MAIL_INCLUDED")) {
      define("GALL_MAIL_INCLUDED", 1);
    
        include_once(RCX_ROOT_PATH."/class/rcxobject.php");
        
        Class GallMail extends RcxObject {
    
            function GallMail($id=NULL) {
                global $rcxConfig;
            
                $this->RcxObject();
                $this->initVar("id", "int", NULL, false);
                $this->initVar("uid", "int", NULL, false);
                $this->initVar("nom1", "textbox", NULL, false, 40, true);
                $this->initVar("nom2", "textbox", NULL, false, 40, true);
                $this->initVar("email1", "textbox", NULL, false, 40, true);
                $this->initVar("email2", "textbox", NULL, false, 40, true);
                $this->initVar("sujet", "textbox", NULL, false, 60, true);            
                $this->initVar("actkey", "textbox", NULL, false, 20, true);
                $this->initVar("message", "textarea", NULL, false, NULL, true);
                $this->initVar("image", "textbox", NULL, false, 250, true);
                $this->initVar("music", "textbox", NULL, false, 100, true);
                $this->initVar("body", "textbox", NULL, false, 6, true);
                $this->initVar("border", "textbox", NULL, false, 6, true);
                $this->initVar("color", "textbox", NULL, false, 6, true);
                $this->initVar("poli", "textbox", NULL, false, 20, true);
                $this->initVar("tail", "textbox", NULL, false, 20, true);
                $this->initVar("date", "int", NULL, false);
                $this->initVar("status", "int", NULL, false);
                $this->initVar("date_vers", "int", NULL, false);
                $this->initVar("visit", "int", NULL, false);
                $this->initVar("date_gelesen", "int", 0, false);
            if ( !empty($id) ) {
              if ( is_array($id) ) {
                $this->set($id);
            } else {
              $this->load(intval($id));
            }
            }
          }
        
        
        //---------------------------------------------------------------------------------------//
            function load($id) {
                global $db, $objCache;
    /*            
                if (!empty($objCache->GallMail['load'][$id])) {
                  $this->set($objCache->GallMail['load'][$id]);
                  return;
                }
    */            
                $sql = "SELECT * FROM ".$db->prefix("galli_mail")." WHERE id=".$id."";
                if ( !$result = $db->query($sql) ) {
                  die("ERROR");
                }
                
                $numrows = $db->num_rows($result);
                if ( $numrows == 1 ) {
                  $myrow = $db->fetch_array($result);
                  $this->set($myrow);
    //              $objCache->GallMail['load'][$id] = $myrow;
              } elseif ( $numrows == 0 ) {
   //             echo "Datensatz nicht vorhanden!<br>";
   //                 echo $sql;
                    exit();
            } else {
              die("Duplicate User Entries!");
            }
            }
            
    
            function store() {
                global $db, $rcxUser;
                
                if ( !$this->isCleaned() ) {
                  if ( !$this->cleanVars() ) {
                    return false;
                  }
                }
                
                foreach ( $this->cleanVars as $k=>$v ) {
                  $$k = $v;
                }
                
                if ( empty($id) ) {
//                  $id = $db->genId($db->prefix("galli_mail")."_id_seq");
                  $id = $db->genId($db->prefix("galli_mail"));
                  $sql = "
                    INSERT INTO ".$db->prefix("galli_mail")." SET 
                    id = ".intval($id).",
                        uid = ".intval($uid).",
                        nom1 = '$nom1',
                        nom2 = '$nom2',
                        email1 = '$email1',
                        email2 = '$email2',
                        sujet = '$sujet',
                        actkey = '$actkey',
                        message = '$message',
                        image = '$image',
                        music = '$music',
                        body = '$body',
                        border = '$border',
                        color = '$color',
                        poli = '$poli',
                        tail = '$tail',
                        date = '".$date."',
                        status = ".intval($status).",
                        date_vers = '".$date_vers."',
                        visit = '0',
                        date_gelesen = '".$date_gelesen."' ";
                        
                }  else {
                    $sql ="
                        UPDATE ".$db->prefix("galli_mail")." SET
                        uid = ".intval($uid).",
                        nom1 = '$nom1',
                        nom2 = '$nom2',
                        email1 = '$email1',
                        email2 = '$email2',
                        sujet = '$sujet',
                        actkey = '$actkey',
                        message = '$message',
                        image = '$image',
                        music = '$music',
                        body = '$body',
                        border = '$border',
                        color = '$color',
                        poli = '$poli',
                        tail = '$tail',
                        date = '".$date."',
                        status = ".intval($status).",
                        date_vers = '".$date_vers."',
                        visit = ".intval($visit).",
                        date_gelesen = '".$date_gelesen."' WHERE id=".$id." ";;
                }
    //echo $sql;
                if ( !$result = $db->query($sql) ) {
                  $this->setErrors("error in galli_mail database...");
                  return false;
                }
                
                if ( empty($id) ) {
                  $id = $db->insert_id();
                }
                
                return $id;
            }
            
    
            function delete() {
                global $db;
                
                if ( $this->getVar("id") > 0 ) {
                  $sql = "DELETE FROM ".$db->prefix("galli_mail")." WHERE id=".$this->getVar("id")."";
                  if ( !$result = $db->query($sql) ) {
                    return false;
                  }
                    return true;
                }else{
                    return false;
                }
            }
    
    
            function &getAllMail($criteria=array(), $asobject=false, $orderby="id ASC", $limit=0, $start=0){
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
                  $sql = "SELECT id FROM ".$db->prefix("galli_mail")."$where_query ORDER BY $orderby";
                  $result = $db->query($sql,$limit,$start);
                  while ( $myrow = $db->fetch_array($result) ) {
                    $ret[] = $myrow['id'];
                  }
              } else {
                $sql = "SELECT * FROM ".$db->prefix("galli_mail")."".$where_query." ORDER BY $orderby";
                $result = $db->query($sql,$limit,$start);
                while ( $myrow = $db->fetch_array($result) ) {
                  $ret[] = new GallMail($myrow);
                }
              }      
    //echo $sql."<br>";                  
                return $ret;
            }
            
            
            function &getAllMailList($criteria=array(), $orderby="id ASC", $limit=0, $start=0) {
                global $myts, $db;
                
                $ret = array();
                $where_query = "";
                
                if ( is_array($criteria) && count($criteria) > 0 ) {
                  $where_query = " WHERE";
                  foreach ( $criteria as $c ) {
                    $where_query .= " $c AND";
                  }
                  $where_query = substr($where_query, 0, -4);
                }
                
                $sql = "SELECT id, sujet FROM ".$db->prefix("galli_mail")."".$where_query." ORDER BY $orderby";
                $result = $db->query($sql,$limit,$start);
                
                while ( $myrow = $db->fetch_array($result) ) {
                  $ret[$myrow['id']] = $myts->makeTboxData4Show($myrow['sujet']);
                }
                
                return $ret;
            }
    
            
            function &countAllMail($criteria=array()) {
                global $db;
                
                $where_query = "";
                
                if ( is_array($criteria) && count($criteria) > 0 ) {
                  $where_query = " WHERE";
                  foreach ( $criteria as $c ) {
                    $where_query .= " $c AND";
                  }
                  $where_query = substr($where_query, 0, -4);
                }
                
                $sql       = "SELECT COUNT(*) FROM ".$db->prefix("galli_mail")."".$where_query."";
    //echo $sql;            
                $result    = $db->query($sql);
                list($ret) = $db->fetch_row($result);
                
                return $ret;
            }
    
            function id(){ return $this->getVar("id");}
            function uid(){ return $this->getVar("uid");}
            function nom1($format="S"){ return $this->getVar("nom1", $format);}
            function nom2($format="S"){ return $this->getVar("nom2", $format);}
            function email1($format="S"){ return $this->getVar("email1", $format);}
            function email2($format="S"){ return $this->getVar("email2", $format);}
            function sujet($format="S"){ return $this->getVar("sujet", $format);}
            function usid(){ return $this->getVar("usid", $format);}
            function actkey($format="S"){ return $this->getVar("actkey", $format);}
            function message($format="S"){ return $this->getVar("message", $format);}
            function image($format="S"){ return $this->getVar("image", $format);}
            function music($format="S"){ return $this->getVar("music", $format);}
            function body($format="S"){ return $this->getVar("body", $format);}
            function border($format="S"){ return $this->getVar("border", $format);}
            function color($format="S"){ return $this->getVar("color", $format);}
            function poli($format="S"){ return $this->getVar("poli", $format);}
            function tail($format="S"){ return $this->getVar("tail", $format);}
            function date(){ return $this->getVar("date");}
            function status(){ return $this->getVar("status");}
            function date_vers(){ return $this->getVar("date_vers");}
            function visit(){ return $this->getVar("visit");}
            function date_gelesen(){ return $this->getVar("date_gelesen");}
        } 
    }
?>
