<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_RCXTREE_INCLUDED')) {
  define('RCX_RCXTREE_INCLUDED', 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxTree {

  var $table; //table with parent-child structure
  var $cid;    //name of unique id for records in table $table
  var $pid;   // name of parent id used in table $table
  var $order; //specifies the order of query results
  var $title; // name of a field in table $table which will be used when  selection box and paths are generated

  var $pidcid = array();
  var $cidpid = array();

  //constructor of class RcxTree
  //sets the names of table, unique id, and parend id
  function RcxTree($table, $cid, $pid)
  {
    $this->table = $table;
    $this->cid   = $cid;
    $this->pid   = $pid;
  }

/**
* returns an array of first child objects for a given id($sel_id)
*
* @param type $var description
* @return type description
*/
function getFirstChild($pid, $order='') {
  global $db;

  $arr = array();
  $sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->pid.'='.$pid.'';

  if ($order != '')
  {
    $sql .= ' ORDER BY '.$order.'';
  }

  $result = $db->query($sql);
  $count  = $db->num_rows($result);

  if ($count == 0)
  {
    return $arr;
  }

  while ($myrow = $db->fetch_array($result))
  {
    array_push($arr, $myrow);
  }

return $arr;
}

/**
* returns an array of all FIRST child ids of a given id($sel_id)
*
* @param type $var description
* @return type description
*/
function getFirstChildId($pid) {
  global $db;

  $arr = array();
  $sql = 'SELECT '.$this->cid.' FROM '.$this->table.' WHERE '.$this->pid.'='.$pid.'';

  $result = $db->query($sql);
  $count  = $db->num_rows($result);

  if ($count == 0)
  {
    return $arr;
  }

  while (list($id) = $db->fetch_row($result))
  {
    array_push($arr, $id);
  }

return $arr;
}

/**
* returns an array of ALL child ids for a given id($sel_id)
*
* @param type $var description
* @return type description
*/
function getAllChildId($pid, $idarray = array()) {

  if (empty($this->pidcid))
  {
    $this->loadtree();
  }

  $ele = $this->pidcid[$pid];

  if (!empty($ele))
  {
    foreach ($ele as $key => $value)
    {
      array_push($idarray, $key);
      $idarray = $this->getAllChildId($key, $idarray);
    }
  }

return $idarray;
}
/**
* returns an array of ALL parent ids for a given id($sel_id)
*
* @param type $var description
* @return type description
*/
function getAllParentId($cid, $order='', $idarray = array()) {
  global $db;

  $sql = 'SELECT '.$this->pid.' FROM '.$this->table.' WHERE '.$this->cid.'='.$cid.'';

  if ($order != '')
  {
    $sql .= ' ORDER BY '.$order.'';
  }

  $result = $db->query($sql);
  list($r_id) = $db->fetch_row($result);

  if ($r_id == 0)
  {
    return $idarray;
  }

  array_push($idarray, $r_id);
  $idarray = $this->getAllParentId($r_id, $order, $idarray);

return $idarray;
}

/**
* generates path from the root id to a given id($sel_id)
* the path is delimetered with "/"
*
* @param type $var description
* @return type description
*/
function getPathFromId($cid, $title, $path='') {
  global $db, $myts;

  $result = $db->query('SELECT '.$this->pid.', '.$title.' FROM '.$this->table.' WHERE '.$this->cid.'='.$cid.'');

  if ($db->num_rows($result) == 0)
  {
    return $path;
  }

  list($parentid, $name) = $db->fetch_row($result);
  $name = $myts->makeTboxData4Show($name);
  $path = '/'.$name.$path;

  if ($parentid == 0)
  {
    return $path;
  }

  $path = $this->getPathFromId($parentid, $title, $path);

return $path;
}

/**
* makes a nicely ordered selection box
* $preset_id is used to specify a preselected item
* set $none to 1 to add a option with value 0
*
* @param type $var description
* @return type description
*/
function makeMySelBox($title, $order='', $preset_id=0, $none=0, $sel_name='', $onchange='') {
  global $db, $myts;

  if ($sel_name == '')
  {
    $sel_name = $this->cid;
  }

  echo '<select class="select" name="'.$sel_name.'"';
  if ($onchange != '')
  {
    echo ' onchange="'.$onchange.'"';
  }
  echo ">";

  $sql = 'SELECT '.$this->cid.', '.$title.' FROM '.$this->table.' WHERE '.$this->pid.'=0';

  if ($order != '')
  {
    $sql .= ' ORDER BY '.$order.'';
  }

  $result = $db->query($sql);

  if ($none)
  {
    echo '<option value="0">----</option>';
  }

  while (list($catid, $name) = $db->fetch_row($result))
  {
    if ($catid == $preset_id)
    {
      $sel = ' selected="selected"';
    }
    echo '<option value="'.$catid.'"'.$sel.'>'.$name.'</option>';
    $sel = '';
    $arr = $this->getChildTreeArray($catid, $title);
    
    foreach ($arr as $option)
    {
      $option['prefix'] = str_replace('.', '--', $option['prefix']);
      $catpath = $option['prefix'].' '.$myts->makeTboxData4Show($option[$title]);
      if ($option[$this->cid] == $preset_id)
      {
        $sel = ' selected="selected"';
      }
    
      echo '<option value="'.$option[$this->cid].'"'.$sel.'>'.$catpath.'</option>';
      $sel = '';
    }
  }
  
  echo '</select>';
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getNicePathFromId($id, $title, $funcURL, $path='') {

  if (empty($this->cidpid))
  {
    $this->loadtree($title);
  }

  $curr     = $this->cidpid[$id];
  $out      = @each($curr);
  $name     = $out['value'];
  $parentid = $out['key'];

  $path = '<a href="'.$funcURL.$this->cid.'='.$id.'">'.$name.'</a> : '.$path;

  if ($parentid == 0 || $parentid == '')
  {
    return $path;
  }

  $path = $this->getNicePathFromId($parentid, $title, $funcURL, $path);

return $path;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadtree($title='title') {
  global $db, $myts;

  $sql    = 'SELECT '.$this->pid.', '.$this->cid.', '.$title.' FROM '.$this->table.'';
  $result = $db->query($sql);

  while (list($pid, $cid, $name) = $db->fetch_array($result))
  {
    $this->pidcid[$pid][$cid] = $myts->makeTboxData4Show($name);
    $this->cidpid[$cid][$pid] = $myts->makeTboxData4Show($name);
  }
}

/**
* generates id path from the root id to a given id
* the path is delimetered with "/"
*
* @param type $var description
* @return type description
*/
function getIdPathFromId($cid, $path='') {
  global $db;

  $result = $db->query('SELECT '.$this->pid.' FROM '.$this->table.' WHERE '.$this->cid.'='.$cid.'');

  if ($db->num_rows($result) == 0)
  {
    return $path;
  }

  list($parentid) = $db->fetch_row($result);
  $path = '/'.$cid.$path;

  if ($parentid == 0)
  {
    return $path;
  }

  $path = $this->getIdPathFromId($parentid, $path);

return $path;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getAllChild($pid=0, $order='', $parray = array()) {
  global $db;

  $sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->pid.'='.$pid.'';

  if ($order != '')
  {
    $sql .= ' ORDER BY '.$order.'';
  }

  $result = $db->query($sql);
  $count  = $db->num_rows($result);

  if ($count == 0)
  {
    return $parray;
  }

  while ($row = $db->fetch_array($result))
  {
    array_push($parray, $row);
    $parray=$this->getAllChild($row[$this->cid], $order, $parray);
  }

return $parray;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getChildTreeArray($pid=0, $order='', $parray = array(), $r_prefix='') {
  global $db;

  $sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->pid.'='.$pid.'';

  if ($order != '')
  {
    $sql .= ' ORDER BY '.$order.'';
  }

  $result = $db->query($sql);
  $count  = $db->num_rows($result);

  if ($count == 0)
  {
    return $parray;
  }

  while ($row = $db->fetch_array($result))
  {
    $row['prefix'] = $r_prefix.'.';
    array_push($parray, $row);
    $parray = $this->getChildTreeArray($row[$this->cid], $order, $parray, $row['prefix']);
  }

return $parray;
}

} // END CLASS TREE

}
?>
