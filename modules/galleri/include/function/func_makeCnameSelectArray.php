<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeCnameSelectArray($table, $title, $order="", $t_id="", $s_id="", $c_id=0, $ex_child=0) {
        global $db, $myts;       
        $sql = "SELECT ".$t_id.", ".$title." FROM ".$db->prefix($table)." WHERE ";
        if ($c_id > 0){
            $sql .= "cid = ".$c_id." and ";
        }
         $sql .= $s_id."=0";
         if ($order != "") {
          $sql .= " ORDER BY ".$order;
        }
        $result = $db->query($sql);
        $ret = array();
        while ( list($catid, $name) = $db->fetch_row($result) ) {
            if ($ex_child == 0){
                $ret[$catid] = $myts->makeTboxData4Show($name);
            }
          $arr = getChildBArray($table, $t_id, $s_id, $catid, $title);
          foreach ($arr as $option) {
            $option['prefix'] = str_replace(".", "--", $option['prefix']);
            $catpath = $option['prefix']." ".$myts->makeTboxData4Show($option[$title]);
                $ret[$option[$t_id]] = $myts->makeTboxData4Show($catpath);
          }
        }
        return $ret;
    }    
    
    function getChildBArray($table, $t_id, $s_id, $sel_id=0, $order="", $parray = array(), $r_prefix="") {
        global $db;        
        $sql = "SELECT * FROM ".$db->prefix($table)." WHERE ".$s_id."=".$sel_id."";
        if ($order != "") {
          $sql .= " ORDER BY ".$order." ";
        }        
        $result = $db->query($sql);
        $count  = $db->num_rows($result);        
        if ($count == 0) {
          return $parray;
        }
        while ( $row = $db->fetch_array($result) ) {
          $row['prefix'] = $r_prefix.".";
          array_push($parray, $row);
          $parray = getChildBArray($table, $t_id, $s_id, $row[$t_id], $order, $parray, $row['prefix']);
        }        
        return $parray;
    }
?>
