<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("RCX_RCXMODULE_INCLUDED")) {
  define("RCX_RCXMODULE_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxModule {

  var $mid;
  var $name;
  var $dirname;
  var $weight;
  var $isactive;
  var $config;
  var $hasadmin;
  var $hasmain;
  var $hassearch;
  var $haswaiting;
  var $modinfo   = array();
  var $modvars   = array();
  var $errors    = array();
  var $adminmenu = array();
  // added by SVL for choose sidebar view with module
  var $sidebar = 3; //0 - no sidebar, 1 - left only, 2 - right only, 3 - both
  // these table cannot be installed nor uninstalled
  // this is a very dirty workaround...may need to find a better method
  var $reservedTables = array(
          'groups',
          'groups_users_link',
          'groups_modules_link',
          'groups_blocks_link',
          'priv_msgs',
          'ranks',
          'session',
          'smiles',
          'users',
          'newblocks',
          'modules');


  function RcxModule($mid = -1, $load=true)
  {
    if ($mid != -1)
    {
      if (is_array($mid))
      {
        $this->makeModule($mid);
      }
      else
      {
        $this->getModule(intval($mid));
      }
      if ($load)
      {
        $this->loadModInfo($this->dirname);
        $this->loadModVars($this->dirname);
      }
    }
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadModInfo($dirname) {
  global $rcxConfig;

  if (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/language/".RC_ULANG."/modinfo.php"))
  {
    include_once(RCX_ROOT_PATH."/modules/".$dirname."/language/".RC_ULANG."/modinfo.php");
  }
  elseif (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/language/english/modinfo.php"))
  {  
    include_once(RCX_ROOT_PATH."/modules/".$dirname."/language/english/modinfo.php");
  }
  
  if (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/include/rcxv.php"))
  {
    include(RCX_ROOT_PATH."/modules/".$dirname."/include/rcxv.php");
  }
  else
  {
    echo "Module File for $dirname Not Found!";
    return;
  }

  $this->modinfo =& $modversion;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadConfig($dirname) {

  if (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/include/init.php"))
  {
    $moduleConfig = new stdClass();
    include(RCX_ROOT_PATH."/modules/".$dirname."/include/init.php");
    return $moduleConfig;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadModVars($dirname) {

  if (isset($this->modinfo['varfile']) && $this->modinfo['varfile'] != "")
  {
    if (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/".$this->modinfo['varfile'].""))
    {
      include(RCX_ROOT_PATH."/modules/".$dirname."/".$this->modinfo['varfile']."");
      $this->modvars =& $modvars;
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getModVar($key) {
  return $this->modvars[$key];
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getModule($mid) {
  global $db;

  $sql    = "SELECT * FROM ".RC_MODULES_TBL." WHERE mid = ".$mid."";
  $result = $db->query($sql);
  $array  = $db->fetch_array($result);
  $this->makeModule($array);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getAllModulesList($criteria=array(), $sort="name", $order="ASC") {
  global $db;

  $ret = array();
  $where_query = "";

  if (is_array($criteria) && count($criteria) > 0)
  {
    $where_query = " WHERE";
    
    foreach ($criteria as $c)
    {
      $where_query .= " $c AND";
    }
  
    $where_query = substr($where_query, 0, -4);
  }

  $sql    = "SELECT mid, name FROM ".RC_MODULES_TBL."$where_query ORDER BY $sort $order";
  $result = $db->query($sql);

  while ($myrow = $db->fetch_array($result))
  {
    $ret[$myrow['mid']] = $myrow['name'];
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function makeModule($array) {
  global $myts;

  foreach($array as $key => $value)
  {
    $this->$key = $value;
  }

  if (!empty($this->config))
  {
    $this->config =& unserialize($myts->oopsStripSlashesRT($this->config));
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getByDirname($dirname) {
  global $db, $myts;

  $ret = false;
  $sql = "SELECT * FROM ".RC_MODULES_TBL." WHERE dirname = '".trim($myts->oopsAddSlashesGPC(strip_tags($dirname)))."'"; // Fix by HDMan (http://MoscowVolvoClub.ru)

  if ($result = $db->query($sql))
  {
    $count = $db->num_rows($result);
    if ($count == 1)
    {
      $arr = $db->fetch_array($result);
      $ret = new RcxModule($arr);
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function activate() {
  global $db;

  if (!isset($this->weight) || !is_numeric($this->weight))
  {
    $this->weight = 0;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET last_update=".time().", weight=".$this->weight.", isactive=1 WHERE mid=".$this->mid."";

  if (!$result = $db->query($sql))
  {
    array_push($this->errors,"Could not update modules table");
    return false;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET isactive=1 WHERE mid=".$this->mid."";

  if (!$result = $db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function deactivate() {
  global $db;

  if (!isset($this->weight) || !is_numeric($this->weight))
  {
    $this->weight = 0;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET last_update=".time().", weight=".$this->weight.", isactive=0 WHERE mid=".$this->mid."";

  if (!$result = $db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET isactive=0 WHERE mid=".$this->mid."";

  if (!$result = $db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

return true;
}

/**
* Install a module
* If the module has blocks, insert blocks info in blocks table
*/
function install($create_tbl=true) {
  global $rcxConfig, $db, $myts;

  $error = false;
  if ($create_tbl != false)
  {

    if (!empty($this->modinfo['sqlfile']) && is_array($this->modinfo['sqlfile']))
    {
      $sql_file_path = RCX_ROOT_PATH."/modules/".$this->dirname()."/".$this->modinfo['sqlfile'][$rcxConfig['database']]."";

      if (@!file_exists($sql_file_path))
      {
        array_push($this->errors,"SQL file not found at $sql_file_path!");
        $error = true;
      }
      else
      {
        include_once(RCX_ROOT_PATH ."/include/sql_parse.php");
        $sql_content    = join('', file($sql_file_path));
        $sql_content    = remove_remarks($sql_content);
        $sql_content    = split_sql_file($sql_content, ';');
        $created_tables = array();

        foreach ($sql_content as $sql_query)
        {
          // [0] contains the prefixed query
          // [4] contains unprefixed table name
          // check if the table name is reserved
          if (!$prefixed_query = prefixQuery($sql_query, $db->prefix()))
          {
            array_push($this->errors, "$piece is not a valid SQL!");
            $error = true;
            break;
          }
          // check if the table name is reserved
          if (!in_array($prefixed_query[4], $this->reservedTables))
          {
            // not reserved, so try to create one
            if (!$db->query($prefixed_query[0]))
            {
              array_push($this->errors, $prefixed_query[0] . $db->error());
              $error = true;
              break;
            }
            else
            {
              if (!in_array($prefixed_query[4], $created_tables))
              {
                $created_tables[] = $prefixed_query[4];
              }
            }
          }
          else
          {
            // the table name is reserved, so halt the installation
            array_push($this->errors, $prefixed_query[4]." is a reserved table!");
            $error = true;
            break;
          }
        }
      
        // if there was an error, delete the tables created so far, so the next installation will not fail
        if ($error == true)
        {
          foreach ($created_tables as $ct)
          {
            $db->query("DROP TABLE ".$db->prefix($ct)."");
          }
        }
      }
    }
  }

  // if no error, save the module info and blocks info associated with it
  if (!$error)
  {
    $newmid = $db->genId(RC_MODULES_TBL."_mid_seq");

    if (!isset($this->modinfo['hasAdmin']) || $this->modinfo['hasAdmin'] != 1)
    {
      $this->modinfo['hasAdmin'] = 0;
    }

    if (!isset($this->modinfo['hasMain']) || $this->modinfo['hasMain'] != 1)
    {
      $this->modinfo['hasMain'] = 0;
    }

    if (!isset($this->modinfo['hasSearch']) || $this->modinfo['hasSearch'] != 1)
    {
      $this->modinfo['hasSearch'] = 0;
    }

    if (!isset($this->weight) || !is_numeric($this->weight))
    {
      $this->weight = 0;
    }

    $sql = "
      INSERT INTO ".RC_MODULES_TBL." SET
      mid=$newmid,
      name='".addslashes($this->modinfo['name'])."',
      dirname='".addslashes($this->modinfo['dirname'])."',
      version='".$myts->makeTboxData4Save($this->modinfo['version'])."',
      last_update=".time().",
      weight=".intval($this->weight).",
      isactive=1,
      config='".$settings."',
      hasmain=".intval($this->modinfo['hasMain']).",
      hasadmin=".intval($this->modinfo['hasAdmin']).",
      haswaiting=".intval($this->modinfo['hasWaiting']).",
      hassearch=".intval($this->modinfo['hasSearch']).",
      sidebar=".intval($this->sidebar)."";

    if (!$db->query($sql))
    {
      array_push($this->errors, $sql);
      foreach ($created_tables as $ct)
      {
        $db->query("DROP TABLE ".$db->prefix($ct)."");
      }
      
      return false;
    }
    else
    {
      if (empty($newmid))
      {
        $newmid = $db->insert_id();
      }
      
      if (isset($this->modinfo['blocks']))
      {
        $i = 1;
        foreach ($this->modinfo['blocks'] as $block)
        {
          // break the loop if missing block config
          if (!isset($block[$i]['file']) || !isset($block[$i]['show_func']))
          {
            break;
          }
          $options = "";
          if (isset($block['options']) && $block['options']!= "")
          {
            $options = $block['options'];
          }
          
          $newbid = $db->genId($db->prefix("blocks")."_bid_seq");
          $sql = "
            INSERT INTO ".RC_MODULES_TBL." SET
            bid=$newbid,
            mid=$newmid,
            func_num=$i,
            options='$options',
            name='".addslashes($block['name'])."',
            position=0,
            title='',
            content='',
            side=0,
            weight=0,
            visible=0,
            type='M',
            isactive=1,
            dirname='.addslashes($this->modinfo['dirname']).',
            func_file='.addslashes($this->modinfo['blocks'][$i]['file']).',
            show_func='.addslashes($this->modinfo['blocks'][$i]['show_func']).',
            edit_func='.addslashes($this->modinfo['blocks'][$i]['edit_func']).'";

          if (!$db->query($sql))
          {
            array_push($this->errors, $db->error());
          }
          
          $i++;
        } // END foreach ( $this->modinfo['blocks'] as $block )
      } // END isset($this->modinfo['blocks'])
    } // END IF SQL QUERY

    return $newmid;
  }
  else
  {
    return false;
  }
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function uninstall() {
  global $db;

  $sql = "DELETE FROM ".RC_MODULES_TBL." WHERE mid=".$this->mid."";

  if (!$db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

  $sql = "DELETE FROM ".RC_GRP_MOD_LINK_TBL." WHERE mid=".$this->mid."";

  if (!$db->query($sql))
  {
    array_push($this->errors, $db->error());
  }

  $block_arr = RcxBlock::getByModule($this->mid);

  foreach ($block_arr as $block)
  {
    if (!$block->delete())
    {
      array_push($this->errors, "Could not delete block. Block name: ".$block->name()." Block ID: ".$block->bid());
    }
  }

  if (!empty($this->modinfo['tables']) && is_array($this->modinfo['tables']))
  {
    foreach ($this->modinfo['tables'] as $table)
    {
      // prevent deletion of reserved core tables!
      if (!in_array($table, $this->reservedTables))
      {
        $sql = "DROP TABLE ".$db->prefix($table)."";

        if (!$db->query($sql))
        {
          array_push($this->errors, "Could not delete table ".$db->prefix($table)."");
        }
      }
      else
      {
        array_push($this->errors, "Not allowed to delete table ".$db->prefix($table)."!");
      }
    }
  }

  if (count($this->errors) > 0)
  {
    return false;
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function saveConfig() {
  global $db;

  $db->query("UPDATE ".RC_MODULES_TBL." SET config='".serialize($this->config)."' WHERE mid=".intval($this->mid())."");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isActivated() {

  if (!empty($this->isactive) && $this->isactive == 1)
  {
    return true;
  }

return false;
}

/**
* Updates module info in module table and blocks info in blocks table.
* It is generally used when blocks are added or modified.
* Or to change the block title in blocks admin menu.
* This does not change the actual block contents in DB
*/
function update() {
  global $db, $myts;

  if (!isset($this->modinfo['hasAdmin']) || $this->modinfo['hasAdmin'] != 1)
  {
    $this->modinfo['hasAdmin'] = 0;
  }
  if (!isset($this->modinfo['hasMain']) || $this->modinfo['hasMain'] != 1)
  {
    $this->modinfo['hasMain'] = 0;
  }
  if (!isset($this->modinfo['hasSearch']) || $this->modinfo['hasSearch'] != 1)
  {
    $this->modinfo['hasSearch'] = 0;
  }
  if (!isset($this->modinfo['hasWaiting']) || $this->modinfo['hasWaiting'] != 1)
  {
    $this->modinfo['hasWaiting'] = 0;
  }
  if (!isset($this->weight) || !is_numeric($this->weight))
  {
    $this->weight = 0;
  }
  if (!isset($this->sidebar) || !is_numeric($this->sidebar))
  {
    $this->sidebar = 3;
  }
  if ($settings = $this->loadConfig($this->modinfo['dirname']))
  {
    $settings = $myts->makeTboxData4Save(serialize($settings));
  }

  $sql = "
    UPDATE ".RC_MODULES_TBL." SET
    name='".addslashes($this->modinfo['name'])."',
    dirname='".addslashes($this->modinfo['dirname'])."',
    version='".$myts->makeTboxData4Save($this->modinfo['version'])."',
    last_update=".time().",
    weight=".intval($this->weight).",
    config='$settings',
    hasmain=".intval($this->modinfo['hasMain']).",
    hasadmin=".intval($this->modinfo['hasAdmin']).",
    hassearch=".intval($this->modinfo['hasSearch']).",
    hasWaiting=".intval($this->modinfo['hasWaiting']).",
    sidebar=".intval($this->sidebar)." 
    WHERE mid=".intval($this->mid)."";

  if (!$result = $db->query($sql))
  {
    array_push($this->errors, $db->error());
  }

  if (isset($this->modinfo['blocks']))
  {
    $count = count($this->modinfo['blocks']);
    for ($i = 1; $i <= $count; $i++)
    {
      // break the loop if missing block config
      if (!isset($this->modinfo['blocks'][$i]['file']) || !isset($this->modinfo['blocks'][$i]['show_func']))
      {
        break;
      }
      $options = "";

      if (isset($this->modinfo['blocks'][$i]['options']) && $this->modinfo['blocks'][$i]['options']!= "")
      {
        $options = $this->modinfo['blocks'][$i]['options'];
      }

      $sql = 'SELECT COUNT(*) FROM '.RC_NEWBLOCKS_TBL.' WHERE mid='.$this->mid.' AND func_num='.$i;
      list($fcount) = $db->fetch_row($db->query($sql));

      if ($fcount > 0)
      {
        $sql = "
          UPDATE ".RC_NEWBLOCKS_TBL." SET
          options='".$options."',
          name='".addslashes($this->modinfo['blocks'][$i]['name'])."',
          dirname='".addslashes($this->modinfo['dirname'])."',
          func_file='".addslashes($this->modinfo['blocks'][$i]['file'])."',
          show_func='".addslashes($this->modinfo['blocks'][$i]['show_func'])."',
          edit_func='".addslashes($this->modinfo['blocks'][$i]['edit_func'])."'
          WHERE mid=".$this->mid." AND func_num=".$i."";

      }
      else
      {
        $newbid = $db->genId($db->prefix("blocks")."_bid_seq");
        $sql = "
          INSERT INTO ".RC_NEWBLOCKS_TBL." SET
          bid=".$newbid.",
          mid=".$this->mid.",
          func_num=".$i.",
          options='".$options."',
          name='".addslashes($this->modinfo['blocks'][$i]['name'])."',
          position=0,
          title='',
          content='',
          side=0,
          weight=0,
          visible=0,
          type='M',
          isactive=1,
          dirname='".addslashes($this->modinfo['dirname'])."',
          func_file='".addslashes($this->modinfo['blocks'][$i]['file'])."',
          show_func='".addslashes($this->modinfo['blocks'][$i]['show_func'])."',
          edit_func='".addslashes($this->modinfo['blocks'][$i]['edit_func'])."'";
      }

      if (!$result = $db->query($sql))
      {
        array_push($this->errors,"Could not update ".$this->modinfo['blocks'][$i]['name']."");
      }
    } // END FOR

    $sql = "SELECT COUNT(*) FROM ".RC_NEWBLOCKS_TBL." WHERE mid=".$this->mid."";
    list($total) = $db->fetch_row($db->query($sql));

    if ($total > $count)
    {
      for ($j = $count + 1; $j <= $total; $j++)
      {
        $sql = 'DELETE FROM '.RC_NEWBLOCKS_TBL.' WHERE mid='.$this->mid.' AND func_num='.$j;
        $db->query($sql);
      }
    }
  } // END isset($this->modinfo['blocks'])

  if (count($this->errors) > 0)
  {
    return false;
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function changeOrder($order) {
  global $db;

  if (empty($order) || !is_numeric($order))
  {
    $order = 0;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET weight=".$order." WHERE mid=".$this->mid."";

  if (!$db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function changeSidebar($sidebar) {
  global $db;

  if (($sidebar < 0) || ($sidebar >3) || !is_numeric($sidebar))
  {
    $sidebar = 3;
  }

  $sql = "UPDATE ".RC_MODULES_TBL." SET sidebar=".$sidebar." WHERE mid=".$this->mid."";

  if (!$db->query($sql))
  {
    array_push($this->errors, $db->error());
    return false;
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function moduleExists($dirname) {
  global $db;

  $sql    = "SELECT COUNT(*) FROM ".RC_MODULES_TBL." WHERE dirname='$dirname'";
  $result = $db->query($sql);

  list($count) = $db->fetch_row($result);
  if ($count == 1)
  {
    return true;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function currentVersion() {

  if (isset($this->version))
  {
    return $this->version;
  }
  elseif($this->version())
  {
    return $this->version();
  }
  else
  {
    return '1.0.0';
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function last_update() {
  return $this->last_update;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isactive() {
  return $this->isactive;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setWeight($value) {
  $this->weight = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function weight() {
  return $this->weight;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sidebar() {
  return $this->sidebar;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function mid() {

  if (isset($this->mid))
  {
    return $this->mid;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function hasAdmin() {

  if ($this->modinfo['hasAdmin'])
  {
    return true;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function hasMain() {

  if ($this->modinfo['hasMain'])
  {
    return true;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function name($fromdb=false) {

  if($fromdb)
  {
    return $this->name;
  }
  elseif (isset($this->modinfo['name']))
  {
    return $this->modinfo['name'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function dirname() {

  if (isset($this->modinfo['dirname']))
  {
    return $this->modinfo['dirname'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function date() {

  if (isset($this->modinfo['date']))
  {
    return $this->modinfo['date'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function version() {

  if (isset($this->modinfo['version']))
  {
    return $this->modinfo['version'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function description() {

  if (isset($this->modinfo['description']))
  {
    return $this->modinfo['description'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function author() {

  if (isset($this->modinfo['author']))
  {
    return $this->modinfo['author'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function credits() {

  if (isset($this->modinfo['credits']))
  {
    return $this->modinfo['credits'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function help() {

  if (isset($this->modinfo['help']))
  {
    return $this->modinfo['help'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function license() {

  if (isset($this->modinfo['license']))
  {
    return $this->modinfo['license'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function official() {

  if (isset($this->modinfo['official']))
  {
    return $this->modinfo['official'];
  }
  else
  {
    return 1;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function image() {

  if (isset($this->modinfo['image']))
  {
    return $this->modinfo['image'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function adminindex() {

  if (isset($this->modinfo['adminindex']))
  {
    return $this->modinfo['adminindex'];
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &mainLink() {

  if ($this->hasMain())
  {
    $ret = "<a href='".RCX_URL."/modules/".$this->dirname()."/'>".$this->name(1)."</a>";
    return $ret;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &subLink() {

  $ret = array();

  if (isset($this->modinfo['sub']) && is_array($this->modinfo['sub']))
  {
    foreach ($this->modinfo['sub'] as $submenu)
    {
      $ret[] .= "<a href='".RCX_URL."/modules/".$this->dirname()."/".$submenu['url']."'>".$submenu['name']."</a>";
    }
    return $ret;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &mainLink2() {

  if ($this->hasMain())
  {
    $ret['link'] = RCX_URL."/modules/".$this->dirname()."/";
    $ret['name'] = $this->name(1);
    return $ret;
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &subLink2() {

  $ret = array();
  if (isset($this->modinfo['sub']) && is_array($this->modinfo['sub']))
  {
    $i=0;
    foreach ($this->modinfo['sub'] as $submenu)
    {
      $ret[$i]['name'] = $submenu['name'];
      $ret[$i]['link'] = RCX_URL."/modules/".$this->dirname()."/".$submenu['url'];
      $i++;
    }
    return $ret;
  }
return false;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function &search($term="", $andor="AND", $limit=0, $offset=0, $userid=0){
  global $rcxConfig;

  if (!isset($this->modinfo['hasSearch']) || !$this->modinfo['hasSearch'] || !isset($this->modinfo['search']['func']) || !isset($this->modinfo['search']['file']) || $this->modinfo['search']['func'] == "" || $this->modinfo['search']['file'] == "")
  {
    return false;
  }

  if (@file_exists(RCX_ROOT_PATH."/modules/".$this->dirname()."/".$this->modinfo['search']['file']))
  {
    include_once(RCX_ROOT_PATH."/modules/".$this->dirname()."/".$this->modinfo['search']['file']);
  }
  else
  {
    return false;
  }

  //$ret = array();
  if (function_exists($this->modinfo['search']['func']))
  {
    $func = $this->modinfo['search']['func'];
    $ret  = $func($term, $andor, $limit, $offset, $userid);
    return $ret;
  }
  else
  {
    return false;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadAdminMenu() {
  global $rcxConfig;

  if (isset($this->modinfo['adminmenu']) && $this->modinfo['adminmenu'] != "" && @file_exists(RCX_ROOT_PATH."/modules/".$this->dirname()."/".$this->modinfo['adminmenu']))
  {
    include_once(RCX_ROOT_PATH."/modules/".$this->dirname()."/".$this->modinfo['adminmenu']);
    $this->adminmenu = $adminmenu;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getAdminMenu() {
  $this->loadAdminMenu();
  return $this->adminmenu;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function errors() {
  return $this->errors;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getHasMainModulesList($dirname=false) {
  global $db;

  $ret    = array();
  $result = $db->query("SELECT mid, name, dirname from ".RC_MODULES_TBL." WHERE isactive=1 AND hasmain=1 ORDER BY name ASC");

  while ($myrow=$db->fetch_array($result))
  {
    if ($dirname == true)
    {
      $ret[$myrow['dirname']] = $myrow['name'];
    }
    else
    {
      $ret[$myrow['mid']] = $myrow['name'];
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getHasSearchModulesList($aslist = true) {
  global $db;

  $ret    = array();
  $result = $db->query("SELECT mid,name from ".RC_MODULES_TBL." WHERE isactive=1 AND hassearch=1 ORDER BY name ASC");

  while ($myrow=$db->fetch_array($result))
  {
    if ($aslist)
    {
      $ret[$myrow['mid']] = $myrow['name'];
    }
    else
    {
      $ret[] = $myrow['mid'];
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getHasAdminModulesList($aslist = true) {
  global $db;

  $ret    = array();
  $result = $db->query("SELECT mid, name FROM ".RC_MODULES_TBL." WHERE isactive=1 AND hasadmin=1 ORDER BY mid ASC");

  while ($myrow=$db->fetch_array($result))
  {
    if ($aslist)
    {
      $ret[$myrow['mid']] = $myrow['name'];
    }
    else
    {
      $ret[] = $myrow['mid'];
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getSystemModulesList($aslist = true) {
  global $db;

  $ret    = array();
  $result = $db->query("SELECT mid, name FROM ".RC_MODULES_TBL." WHERE isactive=1 AND hasadmin=1 AND dirname='system' ORDER BY mid ASC");

  while ($myrow=$db->fetch_array($result))
  {
    if ($aslist)
    {
      $ret[$myrow['mid']] = $myrow['name'];
    }
    else
    {
      $ret[] = $myrow['mid'];
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*  static
*  Get all modules as a list
*  set $aslist to true for ease of use with class RcxLists
*  $exclude is an array of module ids that you dont want to get
*/
function &getInstalledModules($asobject=true) {
  global $db;

  $ret = array();
  $sql = "SELECT * FROM ".RC_MODULES_TBL." ORDER BY weight, hasmain";
  $result = $db->query($sql);

  while ($myrow = $db->fetch_array($result))
  {
    if ($asobject == true)
    {
      $ret[] = new RcxModule($myrow);
    }
    else
    {
      $ret[] = $myrow['mid'];
    }
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getByRight($groupid, $right="R") {
  global $db;

  $sql = "SELECT DISTINCT mid FROM ".RC_GRP_MOD_LINK_TBL." WHERE type='".$right."'";

  if (is_array($groupid))
  {
    $sql .= " AND (groupid=".$groupid[0]."";
    $size = count($groupid);
    if ($size > 1)
    {
      for ($i = 1; $i < $size; $i++)
      {
        $sql .= " OR groupid=".$groupid[$i]."";
      }
    }
    $sql .= ")";
  }
  else
  {
    $sql .= " AND groupid=".$groupid."";
  }

  $sql   .= " ORDER BY mid ASC";
  $result = $db->query($sql);
  $mids   = array();

  while ($myrow = $db->fetch_array($result))
  {
    $mids[] = $myrow['mid'];
  }

return $mids;
}
} // END RCXMODULE

}
?>
