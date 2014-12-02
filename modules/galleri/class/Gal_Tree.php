<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    class GalTree{
    
      var $table;    
      var $id;   
      var $pid;   
      var $order;   
      var $title;    
      var $db;
    
      function GalTree($table_name, $id_name, $pid_name){
        global $db;
        $this->db = $db;
        $this->table = $table_name;
        $this->id = $id_name;
        $this->pid = $pid_name;
      } 
      
      function getPfadName($title,$preset_id=0){
        $ret = array();
        $sql = "SELECT ".$this->id.", ".$title.", ".$this->pid." FROM ".$this->table." WHERE ".$this->id."=".$preset_id."";
        $result = $this->db->query($sql);
        list($this->id, $title, $this->pid) = $this->db->fetch_row($result);
        $ret[id]=$this->id;
        $ret[title]=$title;
        $ret[pid]=$this->pid;
        return $ret;
      }
    
      function makeVerzeichnis($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="", $catorimg){
            include_once(GALLI_PATH."/class/module.textsanitizer.php");
          $gallts =& GallTextSanitizer::getInstance();
        if ( $sel_name == "" ) {
          $sel_name = $this->id;
        }
        $gallts =& GallTextSanitizer::getInstance();
        if ( $catorimg == "userUpload" ){
          echo "".IMG_VZAUF." <a href='".GAL_ADMIN_URL."/index.php?op="._AD_MA_USER."&amp;cid=0'>galerie</a><br>";
        }else{
          echo "".IMG_VZAUF." <b>galerie</b><br>";
        }
        $sql = "SELECT ".$this->id.", ".$title.", coment FROM ".$this->table." WHERE ".$this->pid."='0'";
        if ( $order != "" ) {
          $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        while ( list($catid, $name, $coment) = $this->db->fetch_row($result) ) {
          if ( $catorimg == "modImg" ){
            list($numrows)=$this->db->fetch_row($this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("galli_img")." WHERE cid=$catid and new_img=1"));
            if ($numrows >= 1){$new_img = "<img src='".IMG_URL."/new.gif' width='25' border='0'>";}else{$new_img = "";}
                    echo "".IMG_LEER."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/index.php?op=img_conf&amp;cid=".$catid."'>".$name."</a> (".$coment.")&nbsp;".$new_img."<br>";
          }else{
            echo "".IMG_LEER."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/index.php?op=$catorimg&amp;cid=$catid'>$name</a> ($coment)<br>";
          }
          $arr = $this->getChildTreeArray2($catid);
          foreach ( $arr as $option ) {
            $option['prefix'] = str_replace(".","".IMG_LEER."",$option['prefix']);
            $temp_id = $option[$this->id];
            if ( $catorimg == "modImg" ){
              list($numrows)=$this->db->fetch_row($this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("galli_img")." WHERE cid=$temp_id and new_img=1"));
              if ($numrows >= 1){$new_img = "<img src='".IMG_URL."/new.gif' width='25' border='0'>";}else{$new_img = "";}
                       $catpath = "".$option['prefix']."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/index.php?op=img_conf&amp;cid=".$option['cid']."'>".$gallts->makeTboxData4Show($option[$title])."</a>";
            }elseif ( $catorimg == "CoAdmin" ){
              $catpath = "".$option['prefix']."".IMG_VZAUF."&nbsp;&nbsp;".$gallts->makeTboxData4Show($option[$title]);
            }else{
              $catpath = "".$option['prefix']."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/index.php?op=$catorimg&amp;cid=$temp_id'>".$gallts->makeTboxData4Show($option[$title])."</a>";
            }
            echo "".IMG_LEER."$catpath";
            echo "&nbsp;(".$option["coment"].")&nbsp;$new_img<br>";
          }
        }
        echo "\n";
      }
    
      function getChildTreeArray2($sel_id=0,$order="",$parray = array(),$r_prefix=""){
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
          $parray = $this->getChildTreeArray2($row[$this->id],$order,$parray,$row['prefix']);
        }
        return $parray;
      }
    
      function makeVerzeichnisCoAdmin($title, $order="", $preset_id=0, $none=0, $sel_name="", $onchange="", $catorimg){
        global $op_coad, $myts;
        if ( $sel_name == "" ) {
          $sel_name = $this->id;
        }
        $sql = "SELECT ".$title.", coment FROM ".$this->table." WHERE ".$this->id."='$preset_id'";
        $result = $this->db->query($sql);
        list($name, $coment) = $this->db->fetch_row($result);
        if ( $catorimg == "modImg" ){
          echo "".IMG_VZAUF." <a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&amp;cid=".$preset_id."&amp;op_coad=".$op_coad."'>$name</a> ($coment)<br>";
        }else{
          echo "".IMG_VZAUF." <a href='".GAL_ADMIN_URL."/coadmin.php?op=".$catorimg."&amp;cid=".$preset_id."&amp;op_coad=".$op_coad."'>$name</a> ($coment)<br>";
        }
        $sql = "SELECT ".$this->id.", ".$title.", coment FROM ".$this->table." WHERE ".$this->pid."='$preset_id'";
        if ( $order != "" ) {
          $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        while ( list($catid, $name, $coment) = $this->db->fetch_row($result) ) {
          if ( $catorimg == "modImg" ){
            echo "".IMG_LEER."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&amp;cid=".$catid."&amp;op_coad=".$op_coad."'>$name</a> ($coment)<br>";
          }else{
            echo "".IMG_LEER."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/coadmin.php?op=$catorimg&amp;cid=$catid&amp;op_coad=".$op_coad."'>$name</a> ($coment)<br>";
          }
          $arr = $this->getChildTreeArray2($catid);
          foreach ( $arr as $option ) {
            $option['prefix'] = str_replace(".","".IMG_LEER."",$option['prefix']);
            $temp_id = $option[$this->id];
            if ( $catorimg == "modImg" ){
              $catpath = "".$option['prefix']."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&amp;cid=".$temp_id."&amp;op_coad=".$op_coad."'>".$myts->makeTboxData4Show($option[$title])."</a>";
            }else{
              $catpath = "".$option['prefix']."".IMG_VZAUF."&nbsp;&nbsp;<a href='".GAL_ADMIN_URL."/coadmin.php?op=$catorimg&amp;cid=$temp_id&amp;op_coad=".$op_coad."'>".$myts->makeTboxData4Show($option[$title])."</a>";
            }
            echo "".IMG_LEER."$catpath";
            echo "&nbsp;(".$option["coment"].")<br>";
          }
        }
        echo "\n";
      }
    
      function makeCatDir($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange=""){
        if ( $sel_name == "" ) {
          $sel_name = $this->id;
        }
        $gallts =& GallTextSanitizer::getInstance();
        $old_cid = 1;
        $new_cid = 0;
        $sql = "SELECT ".$this->id.", ".$title." FROM ".$this->table." WHERE ".$this->pid."='$preset_id'";
        if ( $order != "" ) {
          $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        while ( list($catid, $name) = $this->db->fetch_row($result) ) {
          if ( $catid == $none ){return false;} //"K1 falsch"
          $arr = $this->getChildTreeArrayCatDir($catid);
          foreach ( $arr as $option ) {
            if ( $option[$this->id] == $preset_id || ($old_cid > 0 && $option[$this->id] == $none) ){$old_cid++;}
            if ( $new_cid == 1 and $old_cid == 1 ){return true;}  //"U1 richtig"
            if ( $old_cid == 2 ){return false;} //"U1 falsch"
            $option['prefix'] = str_replace(".","/",$option['prefix']);
            $catpath = $option['prefix'];
            if ( $new_cid == 2 and $old_cid == 1 ){
              $catpfad = "/galerie/$name$catpath";
              return true;  //"U2 richtig"
            }
            if ( $option[$this->id] == $none || $new_cid > 0 ){$new_cid++;}
          }
          $old_cid = 0;
          $new_cid = 0;
        }
        return true;
      }
    
      function getChildTreeArrayCatDir($sel_id=0,$order="",$parray = array(),$r_prefix=""){
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
          $row['prefix'] = $r_prefix.".".$row['cname'];
          array_push($parray, $row);
          $parray = $this->getChildTreeArrayCatDir($row[$this->id],$order,$parray,$row['prefix']);
        }
        return $parray;
      }
      
      function makeCatCoAdmin($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="", $catorimg){
      
        global $op_coad;
        if ( $sel_name == "" ) {
          $sel_name = $this->id;
        }
        $co_admin_catid = array();
        $i = 0;
        $sql = "SELECT ".$title.", coment FROM ".$this->table." WHERE ".$this->id."='$preset_id'";
        $result = $this->db->query($sql);
        list($name, $coment) = $this->db->fetch_row($result);
          
          $co_admin_catid[$i] = $preset_id;
          $i++;
            $sql = "SELECT ".$this->id.", ".$title.", coment FROM ".$this->table." WHERE ".$this->pid."='$preset_id'";
        if ( $order != "" ) {
          $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        while ( list($catid, $name, $coment) = $this->db->fetch_row($result) ) {
          $co_admin_catid[$i] = $catid;
          $i++;
          $arr = $this->getChildTreeArray2($catid);
          foreach ( $arr as $option ) {
            $co_admin_catid[$i] = $option[$this->id];
            $i++;
          }
        }
        return $co_admin_catid;
      }
    
      function makeGallSelBox($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="", $op_coad=0){
        if ( $sel_name == "" ) {
          $sel_name = $this->id;
        }
        $gallts =& GallTextSanitizer::getInstance();
        echo "<select name='".$sel_name."'";
        if ( $onchange != "" ) {
          echo " onchange='".$onchange."'";
        }
        echo ">\n";
        $sql = "SELECT ".$this->id.", ".$title." FROM ".$this->table." WHERE ".$this->id."=".$op_coad."";
        if ( $order != "" ) {
          $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        if ( $none ) {
          echo "<option value='0'>----</option>\n";
        }
        while ( list($catid, $name) = $this->db->fetch_row($result) ) {
          if ( $catid == $preset_id ) {
            $sel = " selected='selected'";
          }
          echo "<option value='$catid'$sel>$name</option>\n";
          $sel = "";
          $arr = $this->getGallChildTreeArray($catid);
          foreach ( $arr as $option ) {
            $option['prefix'] = str_replace(".","--",$option['prefix']);
            $catpath = $option['prefix']."&nbsp;".$gallts->makeTboxData4Show($option[$title]);
            if ( $option[$this->id] == $preset_id ) {
              $sel = " selected='selected'";
            }
            echo "<option value='".$option[$this->id]."'$sel>$catpath</option>\n";
            $sel = "";
          }
        }
        echo "</select>\n";
      }
      
      function getGallChildTreeArray($sel_id=0,$order="",$parray = array(),$r_prefix=""){
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
          $parray = $this->getGallChildTreeArray($row[$this->id],$order,$parray,$row['prefix']);
        }
        return $parray;
      }
      
    }

?>
