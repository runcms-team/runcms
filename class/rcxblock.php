<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

if (!defined("RCX_RCXBLOCK_INCLUDED")) {
  define("RCX_RCXBLOCK_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxobject.php");
include_once(RCX_ROOT_PATH."/class/rcxmodule.php");
include_once(RCX_ROOT_PATH."/class/rcxgroup.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxBlock extends RcxObject {

  function RcxBlock($id = NULL)
  {
    $this->RcxObject();
    $this->initVar("bid", "int", NULL, false);
    $this->initVar("mid", "int", 0, false);
    $this->initVar("func_num", "int", 0, false);
    $this->initVar("options", "textbox", NULL, false, 255, false);
    $this->initVar("name", "textbox", NULL, true, 150, false);
    $this->initVar("position", "int", 0, false);
    $this->initVar("title", "textbox", NULL, false, 150, false);
    $this->initVar("content", "textarea", NULL, false);
    $this->initVar("side", "int", 0, false);
    $this->initVar("weight", "int", 0, false);
    $this->initVar("visible", "int", 0, false);
    $this->initVar("type", "other", NULL, false);
    $this->initVar("c_type", "other", NULL, false);
    $this->initVar("isactive", "int", NULL, false);
    $this->initVar("iscopy", "int", 0, false);
    $this->initVar("dirname", "textbox", NULL, false, 50);
    $this->initVar("func_file", "textbox", NULL, false, 50);
    $this->initVar("show_func", "textbox", NULL, false, 50);
    $this->initVar("edit_func", "textbox", NULL, false, 50);
    $this->initVar("show_mid", "textbox", NULL, false, 255);
    //added by EsseBe for blocks templates
    $this->initVar("show_template", "textbox", NULL, false, 50);
    $this->initVar("page_style", "int", 0, false);

    if (!empty($id))
    {
      if (is_array($id))
      {
        $this->set($id);
      }
      else
      {
        $this->load(intval($id));
      }
    }
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
  global $db;

  $sql = "SELECT * FROM ".RC_NEWBLOCKS_TBL." WHERE bid = ".intval($id)."";
  //$arr = $db->fetch_array($db->query($sql));
  // Cached Querys
  $result = $db->query($sql, false, false, 'blocks_');
  // End Cached Querys
  //$arr = $db->fetch_array($result);
  $arr = $db->fetch_assoc($result);
  $this->set($arr);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function showBlock($sideblock, $title, $content, $force=false) {  
  global  $rcxModule;

  if ($this->getVar('show_mid') != '0' && $force == false)
  {
    if ($rcxModule)
    {  
      if (!in_array($rcxModule->mid(), explode('|', $this->getVar('show_mid'))))
      {
        return false;
      }
    }
    else
    {  
      if (!in_array('-1', explode('|', $this->getVar('show_mid'))))
      {
        return false;
      }
    }  
  }
  $canswitch = true;  
  $show_template = ($this->getVar('show_template') != '') ? $this->getVar('show_template') : 'standard';
  
  if ($show_template  == 'standard')
  {
    $canswitch = true;
  }
  else
  {
//    if (@file_exists(RCX_ROOT_PATH . '/themes/' . RCX_THEME . '/template/' .  $show_template))
    if (@file_exists(THEME_PATH . '/template/' .  $show_template))
    {
      themebox_template($title, $content, $show_template);
      $canswitch = false;
    }
    else
    {
      $canswitch = true;
    }
    clearstatcache();
  }

  if ($canswitch)
  {
    switch ($sideblock)
    {
      case RCX_SIDEBLOCK_LEFT:
        themesidebox_left($title, $content);
        break;
      case RCX_SIDEBLOCK_RIGHT:
        themesidebox_right($title, $content);
        break;
      case RCX_CENTERBLOCK_TOPLEFT:
      case RCX_CENTERBLOCK_BOTTOMLEFT:
        themecenterbox_left($title, $content);
        break;
      case RCX_CENTERBLOCK_TOPRIGHT:
      case RCX_CENTERBLOCK_BOTTOMRIGHT:
        themecenterbox_right($title, $content);
        break;
      case RCX_CENTERBLOCK_TOPCENTER:
      case RCX_CENTERBLOCK_BOTTOMCENTER:
        themecenterbox_center($title, $content);
        break;
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
  global $db, $myts;

  if (!$this->isCleaned())
  {
    if (!$this->cleanVars())
    {
      return false;
    }
  }

  foreach ($this->cleanVars as $k=>$v)
  {
    $$k = $v;
  }

  $show_template = (!$show_template) ? 'standard' : $show_template;
  
  if (empty($bid))
  {
    //  $bid = $db->genId($db->prefix("blocks")."_bid_seq");
    $sql = "
    INSERT INTO ".RC_NEWBLOCKS_TBL." SET
    bid='$bid',
    mid='$mid',
    func_num='$func_num',
    options='$options',
    name='".$name."',
    position='$position',
    title='".$title."',
    content='".$content."',
    side='".$side."',
    weight='".intval($weight)."',
    visible='".intval($visible)."',
    type='$type',
    c_type='".$c_type."',
    isactive=1,
    iscopy='".intval($iscopy)."',
    dirname='".$dirname."',
    func_file='".$func_file."',
    show_func='".$show_func."',
    show_mid='".$show_mid."',
    show_template='".$show_template."',
    page_style='".intval($page_style)."',
    edit_func='".$edit_func."'";

  }
  else
  {
    
    $sql = "UPDATE ".RC_NEWBLOCKS_TBL." SET options='".$options."'";
    // a custom block needs its own name
    if ($type == "C")
    {
      $sql .= ", name='".$name."'";
    }
    $sql .= ", position='".$position."', 
    title='".$title."', 
    content='".$content."', 
    side='".$side."', 
    weight='".intval($weight)."', 
    visible='".intval($visible)."', 
    c_type='".$c_type."', 
    show_mid='".$show_mid."', 
    show_template='".$show_template."', 
    page_style='".intval($page_style)."' 
    WHERE bid='".intval($bid)."'";
  }

//echo $sql;
  if (!$db->query($sql))
  {
    $this->setErrors("Could not save block data into database");
    return false;
  }

  if (empty($bid))
  {
    $bid = $db->insert_id();
  }
  // Clear Cache
  $db->clear_cache('blocks_');
  // end Clear Cache
return $bid;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
  global $db;

  $sql = "DELETE FROM ".RC_NEWBLOCKS_TBL." WHERE bid=".$this->getVar("bid")."";

  if (!$db->query($sql))
  {
    return false;
  }
  
  $sql = "DELETE FROM ".RC_GRP_BLOCK_LINK_TBL." WHERE block_id=".$this->getVar("bid")."";
  $db->query($sql);

  // Clear Cache
  $db->clear_cache('blocks_');
  // end Clear Cache

return true;
}

/**
* do stripslashes/htmlspecialchars according to the needed output
*
* @param $format      output use: S for Show and E for Edit
* @param $c_type    type of block content
* @returns string
*/
function getContent($format = "S", $c_type = "T") {
  global $myts;

  switch ($format)
  {
    case "S":
        // check the type of content
        // H : custom HTML block
        // P : custom PHP block
        // S : use text sanitizater (smilies enabled)
        // T : use text sanitizater (smilies disabled)
        if ($c_type == "H")
        {
          $content = $myts->oopsStripSlashesRT($this->getVar("content", "N"));
          $content = str_replace("{X_SITEURL}", RCX_URL."/", $content);
          return $content;
        }
        elseif ($c_type == "P")
        {
          ob_start();
          print eval($this->getVar("content", "N"));
          $content = ob_get_contents();
          ob_end_clean();
          $content = str_replace("{X_SITEURL}", RCX_URL."/", $content);
          return $content;
        }
        elseif ($c_type == "S")
        {
          $content = $myts->makeTareaData4Show($this->getVar("content", "N"), 1, 1);
          $content = str_replace("{X_SITEURL}", RCX_URL."/", $content);
          return $content;
        }
        else
        {
          $content = $myts->makeTareaData4Show($this->getVar("content", "N"));
          $content = str_replace("{X_SITEURL}", RCX_URL."/", $content);
          return $content;
        }

    case "E":
        $content = $this->getVar("content", "E");
  }

return $content;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &buildBlock() {
  global $rcxUser, $rcxConfig;

  $block = array();

  // M for module block, S for system block C for Custom
  if ($this->getVar("type") != "C")
  {
    // get block display function
    $show_func = $this->getVar('show_func');
    if (!$show_func)
    {
      return false;
    }

    $dir_name = $this->getVar('dirname');
    // must get lang files b4 execution of the function
    if (@file_exists(RCX_ROOT_PATH."/modules/".$dir_name."/blocks/".$this->getVar('func_file')))
    {
      if (@file_exists(RCX_ROOT_PATH."/modules/".$dir_name."/language/".RC_ULANG."/blocks.php"))
      {
        include_once(RCX_ROOT_PATH."/modules/".$dir_name."/language/".RC_ULANG."/blocks.php");
      }
      elseif (@file_exists(RCX_ROOT_PATH."/modules/".$dir_name."/language/english/blocks.php"))
      {
        include_once(RCX_ROOT_PATH."/modules/".$dir_name."/language/english/blocks.php");
      }
      clearstatcache();
      // get the file where the function is defined
      include_once(RCX_ROOT_PATH."/modules/".$dir_name."/blocks/".$this->getVar('func_file'));
      $options = explode("|", $this->getVar("options"));

      if (function_exists($show_func))
      {
        // execute the function
        $block = $show_func($options);
        if (!$block)
        {
          return false;
        }
      }
      else
      {
        return false;
      }
      // align content if there is additional content in db
      $block['content'] = $this->buildContent($this->getVar("position"), $block['content'], $this->getContent("S", $this->getVar("c_type")));
      // replace title if there is additional title in db
      $block['title'] = $this->buildTitle($block['title'], $this->getVar("title"));
    }
    else
    {
      return false;
    }
  }
  else
  {
    // it is a custom block, so just return the contents
    // and title in db
    $block['title']   = $this->getVar("title");
    $block['content'] = $this->getContent("S", $this->getVar("c_type"));
  }

return $block;
}

/**
* Aligns the content of a block
* If position is 0, content in DB is positioned
* before the original content
* If position is 1, content in DB is positioned
* after the original content
*/
function buildContent($position, $content="", $contentdb="") {

  if ($position == 0)
  {
    $ret = $contentdb.$content;
  }
  elseif($position == 1)
  {
    $ret = $content.$contentdb;
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function buildTitle($originaltitle, $newtitle="") {

  if ($newtitle != "")
  {
    $ret = $newtitle;
  }
  else
  {
    $ret = $originaltitle;
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isCustom() {

  if ($this->getVar("type") == "C")
  {
    return true;
  }

return false;
}

/**
* gets html form for editting block options
*
* @param type $var description
* @return type description
*/
function getOptions() {
  global $rcxUser, $rcxConfig;

  if ($this->getVar("type") != "C")
  {
    $edit_func = $this->getVar('edit_func');
    
    if (!$edit_func)
    {
      return false;
    }
    $d_name = $this->getVar('dirname');
    if (@file_exists(RCX_ROOT_PATH."/modules/".$d_name."/blocks/".$this->getVar('func_file')))
    {
      if (@file_exists(RCX_ROOT_PATH."/modules/".$d_name."/language/".RC_ULANG."/blocks.php"))
      {
        include_once(RCX_ROOT_PATH."/modules/".$d_name."/language/".RC_ULANG."/blocks.php");
      }
      elseif (@file_exists(RCX_ROOT_PATH."/modules/".$d_name."/language/english/blocks.php"))
      {
        include_once(RCX_ROOT_PATH."/modules/".$d_name."/language/english/blocks.php");
      }
      clearstatcache();
      include_once(RCX_ROOT_PATH.'/modules/'.$d_name.'/blocks/'.$this->getVar('func_file'));
      $options = explode("|", $this->getVar("options"));
      $edit_form = $edit_func($options);
    
      if (!$edit_form)
      {
        return false;
      }
      return $edit_form;
    }
    else
    {
      return false;
    }
  }
  else
  {
    return false;
  }
}

/**
* get all the blocks that match the supplied parameters
* @param $side
*    0: sideblock - left
*    1: sideblock - right
*    2: sideblock - left and right
*    3: centerblock - left
*    4: centerblock - right
*    5: centerblock - center
*    6: centerblock - left, right, center
* @param $groupid   groupid (can be an array)
* @param $visible   0: not visible 1: visible
* @param $orderby   order of the blocks
* @returns array of block objects
*/
function &getAllBlocksByGroup(
        $groupid, $asobject=true, $side=NULL, $visible=NULL,
        $orderby="b.weight, b.bid", $isactive=1, $show_mid=0, $page_style=0) {

  global $db, $rcxModule;

  $mid = ($rcxModule)? $rcxModule-> mid ():0; 

  // stop
  $ret = array();

  if (!$asobject)
  {
    $sql = "SELECT DISTINCT b.bid ";
  }
  else
  {
    $sql = "SELECT DISTINCT b.* ";
  }
  $sql .= "FROM ".RC_NEWBLOCKS_TBL." b LEFT JOIN ".RC_GRP_BLOCK_LINK_TBL." l ON l.block_id=b.bid";

  if (is_array($groupid))
  {
    $sql .= " WHERE (l.groupid=".$groupid[0]."";
    $size = count($groupid);
    if ($size  > 1)
    {
      for ($i=1; $i<$size; $i++)
      {
        $sql .= " OR l.groupid=".$groupid[$i]."";
      }
    }
    $sql .= ")";
  }
  else
  {
    $sql .= " WHERE l.groupid=".$groupid."";
  }
  $sql .= " AND b.isactive=$isactive";

  if (isset($side))
  {
    if ($side == RCX_SIDEBLOCK_BOTH)
    {
      $sql .= " AND (side=".RCX_SIDEBLOCK_LEFT." OR side=".RCX_SIDEBLOCK_RIGHT.")";
    }
    elseif ($side == RCX_CENTERBLOCK_TOPALL)
    {
      $sql .= " AND (side=".RCX_CENTERBLOCK_TOPLEFT." OR side=".RCX_CENTERBLOCK_TOPRIGHT." OR side=".RCX_CENTERBLOCK_TOPCENTER.")";
    }
    elseif ($side == RCX_CENTERBLOCK_BOTTOMALL)
    {
      $sql .= " AND (side=".RCX_CENTERBLOCK_BOTTOMLEFT." OR side=".RCX_CENTERBLOCK_BOTTOMRIGHT." OR side=".RCX_CENTERBLOCK_BOTTOMCENTER.")";
    }
    else
    {
      $sql .= " AND side=$side";
    }
  }

  if (isset($visible))
  {
    $sql .= " AND b.visible=$visible";
  }
  //désactivé pour test
  //if ( !empty($show_mid) ) {
  //    
  //  $sql .= " AND (b.show_mid=$show_mid OR b.show_mid=0)";
  //}

  if (!empty($page_style))
  {
    $sql .= " AND ($page_style & b.page_style)";
  }
  $sql   .= " ORDER BY $orderby";

  //$result = $db->query($sql);
  // Cached Querys
  $result = $db->query($sql, false, false, 'blocks_');
  // End Cached Querys

  $added  = array();
  $myrow  = array();
  //  while ($myrow = @$db->fetch_array($result))
  while ($myrow = @$db->fetch_assoc($result))
  {
    if ($myrow['show_mid'] != '0' && $mid != 1)
    {
      if (!empty($show_mid))
      {
        if (!in_array($show_mid, explode('|', $myrow['show_mid'])))
        {
          continue;
        }
      }
      else
      {
        if (!in_array('-1', explode('|', $myrow['show_mid'])))
        {
          continue;
        }
      }
    }

    if (!in_array($myrow['bid'], $added))
    {
      if (!$asobject)
      {
        $ret[] = $myrow['bid'];
      }
      else
      {
        $ret[] = new RcxBlock($myrow);
      }
      array_push($added, $myrow['bid']);
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
function &getAllBlocks($rettype="object", $side=NULL, $visible=NULL, $orderby="side, weight, bid", $isactive=1, $mid=NULL) {
  global $db;

  $ret = array();
  $where_query = " WHERE isactive=$isactive";

  if (isset($side))
  {
    if ($side == RCX_SIDEBLOCK_BOTH)
    {
      $side = "(side=".RCX_SIDEBLOCK_LEFT." OR side=".RCX_SIDEBLOCK_RIGHT.")";
    }
    elseif ($side == RCX_CENTERBLOCK_TOPALL)
    {
      $side = "(side=".RCX_CENTERBLOCK_TOPLEFT." OR side=".RCX_CENTERBLOCK_TOPRIGHT." OR side=".RCX_CENTERBLOCK_TOPCENTER.")";
    }
    elseif ($side == RCX_CENTERBLOCK_BOTTOMALL)
    {
      $side = "(side=".RCX_CENTERBLOCK_BOTTOMLEFT." OR side=".RCX_CENTERBLOCK_BOTTOMRIGHT." OR side=".RCX_CENTERBLOCK_BOTTOMCENTER.")";
    }
    else
    {
      $side = "side=$side";
    }
    $where_query .= " AND $side";
  }

  if (isset($visible))
  {
    $where_query .= " AND visible=$visible";
  }
  if (isset($mid))
  {
    $where_query .= " AND (show_mid=$mid OR show_mid=0)";
  }
  $where_query .= " ORDER BY $orderby";

  switch($rettype)
  {
    case "object":
      $sql = "SELECT * FROM ".RC_NEWBLOCKS_TBL."".$where_query;
      $result = $db->query($sql);
//      while ($myrow = $db->fetch_array($result))
      while ($myrow = @$db->fetch_assoc($result))
      {
        $ret[] = new RcxBlock($myrow);
      }
      break;

    case "list":
      $sql = "SELECT * FROM ".RC_NEWBLOCKS_TBL."".$where_query;
      $result = $db->query($sql);
//      while ($myrow = $db->fetch_array($result))
      while ($myrow = @$db->fetch_assoc($result))
      {
        $block = new RcxBlock($myrow);
        $name  = $block->getVar("title") ? $block->getVar("title") : $block->getVar("name");
        $ret[$block->getVar("bid")] = $name;
      }
      break;

    case "id":
      $sql = "SELECT bid FROM ".RC_NEWBLOCKS_TBL."".$where_query;
      $result = $db->query($sql);
//      while ($myrow = $db->fetch_array($result))
      while ($myrow = @$db->fetch_assoc($result))
      {
        $ret[] = $myrow['bid'];
      }
      break;
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getByModule($moduleid, $asobject=true){
global $db;

  if ($asobject == true)
  {
    $sql = $sql = "SELECT * FROM ".RC_NEWBLOCKS_TBL." WHERE mid=".$moduleid."";
  }
  else
  {
    $sql = "SELECT bid FROM ".RC_NEWBLOCKS_TBL." WHERE mid=".$moduleid."";
  }
  //$result = $db->query($sql);
  // Cached Querys
  $result = $db->query($sql, false, false, 'blocks_');
  // end Cached Querys
  $ret    = array();

//  while ($myrow = $db->fetch_array($result))
  while ($myrow = $db->fetch_assoc($result))
  {
    if ($asobject)
    {
      $ret[] = new RcxBlock($myrow);
    }
    else
    {
      $ret[] = $myrow['bid'];
    }
  }

return $ret;
}

} // END RCXBLOCK

}
?>