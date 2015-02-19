<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {


/**
* Description
*
* @param type $var description
* @return type description
*/
function module_list() {
global $rcxConfig, $rcxUser, $db, $rcxModule;
rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_AM_MODADMIN.'</div>
            <br />
            <br />';

OpenTable();

//echo "<h4 style='text-align:left'>"._MD_AM_MODADMIN."</h4>";
echo "<form action='admin.php' method='post' name='moduleadmin' id='moduleadmin'>
<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'><tr>
<td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3' align='center'>
<td><b>"._MD_AM_MODULE."</b></td>
<td><b>"._MD_AM_YOUR_NAME."</b></td>
<td><b>"._MD_AM_VERSION."</b></td>
<td><b>"._MD_AM_LASTUP."</b></td>
<td><b>"._MD_AM_ACTION."</b></td>
<td><b>"._MD_AM_SIDEBAR."</b></td>
<td><b>"._MD_AM_ORDER."</b><br /><small>"._MD_AM_ORDER0."</small></td>
<td><b>"._INFO."</b></td></tr>";

$installed_mods =& RcxModule::getInstalledModules();
$listed_mods    = array();

// List installed modules
foreach ( $installed_mods as $module ) {
  echo "<tr align='center' valign='middle' class='sysbg1'><td valign='bottom'>";

if ( $module->hasAdmin() && $module->isActivated() ) {
  echo "<a href='".RCX_URL."/modules/".$module->dirname()."/".$module->adminindex()."'><img src='".RCX_URL."/modules/".$module->dirname()."/".$module->image()."' alt='".htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)."' border='0'><br /><b>" .trim($module->name())."</b></a>";
  } else {
    echo "<img src='".RCX_URL."/modules/".$module->dirname()."/".$module->image()."' alt='".htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)."' border='0'><br /><b>" .trim($module->name())."</b>";
  }

echo "
<input type='hidden' name='name[]' value='" .htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)."' />
<input type='hidden' name='oldstatus[]' value='1' /></td>
<td align='center'>".$module->name(1)."</td>
<td align='center'>".$module->currentVersion()."</td>
<td align='center'>".formatTimestamp($module->last_update(),"m")."<br />";

if ( $module->dirname() != "system" && $module->isActivated() ) {
  echo "
  <span style='color:#ff0000;'>"._ACTIVE."</span></td>
  <td><select class='select' name='newstatus[]'>
  <option value='nochange' selected='selected'>"._MD_AM_NOCHANGE."</option>
  <option value='update'>"._UPDATE."</option>
  <option value='deactivate'>"._DEACTIVATE."</option>
  <option value='uninstall'>"._UNINSTALL."</option>";

  } elseif ( $module->dirname() != "system" ) {
    echo "
    "._INACTIVE."</td>
    <td><select class='select' name='newstatus[]'>
    <option value='nochange' selected='selected'>"._MD_AM_NOCHANGE."</option>
    <option value='activate'>"._ACTIVATE."</option>
    <option value='update'>"._UPDATE."</option>
    <option value='uninstall'>"._UNINSTALL."</option>";

    } else {
      echo "
      <span style='color:#ff0000;'>"._ACTIVE."</span></td>
      <td><select class='select' name='newstatus[]'>
      <option value='nochange' selected='selected'>"._MD_AM_NOCHANGE."</option>
      <option value='update'>"._UPDATE."</option>";
    }

echo "</select></td>";

// added by SVL for sidebar choose
if ( $module->dirname() != "system" && $module->hasMain() ) {
echo "
  <td><input type='hidden' name='oldsidebar[]' value='".$module->sidebar()."' />
  <select class='select' name='sidebar[]'>
  <option value='0'";
  if ( $module->sidebar() == 0) echo " selected='selected'";
  echo ">"._MD_AM_NOBAR."</option>
  <option value='1'";
  if ( $module->sidebar() == 1) echo " selected='selected'";  
  echo ">"._MD_AM_LONLYBAR."</option>
  <option value='2'";
  if ( $module->sidebar() == 2) echo " selected='selected'";  
  echo ">"._MD_AM_RONLYBAR."</option>
  <option value='3'";
  if ( $module->sidebar() == 3) echo " selected='selected'";  
  echo ">"._MD_AM_BOTHBAR."</option>";
  } else {
    echo "<td><input type='hidden' name='oldsidebar[]' value='3' />
    <input type='hidden' name='sidebar[]' value='3' />";
  }
  echo "</select></td>";

if ( $module->hasMain() ) {
  echo "<td>
  <input type='hidden' name='oldweight[]' value='".$module->weight()."' />
  <input type='text' class='text' name='weight[]' size='3' maxlength='5' value='".$module->weight()."' />";
  } else {
    echo "<td>
    <input type='hidden' name='oldweight[]' value='0' />
    <input type='hidden' name='weight[]' value='0' />";
  }

echo "
</td>
<td>
<a href='admin.php?fct=modulesadmin&op=edit&mid=".$module->mid()."'><img src='".RCX_URL."/images/editor/edit.gif' border='0' alt='"._EDIT."' /></a>
<a href='javascript:openWithSelfMain(\"".RCX_URL."/modules/system/admin.php?fct=version&amp;mid=".$module->mid()."\",\"Info\",300,230);'><img src='".RCX_URL."/images/editor/info.gif' border='0' alt='"._INFO."' /></a>
<input type='hidden' name='module[]' value='".$module->dirname()."' />
</td>
</tr>";
$listed_mods[] = trim($module->dirname());
}

echo "
</table></td>
</tr></table><br />

<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'><tr>
<td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3' align='center'>
<td><b>"._MD_AM_MODULE."</b></td>
<td><b>"._MD_AM_VERSION."</b></td>
<td><b>"._MD_AM_LASTUP."</b></td>
<td><b>"._MD_AM_ACTION."</b></td>
<!-- <td><b>"._MD_AM_SIDEBAR."</b></td> -->
<td><b>"._MD_AM_ORDER."</b><br /><small>"._MD_AM_ORDER0."</small></td>
<td><b>"._INFO."</b></td></tr>";

// List inactive modules
$modules_dir = RCX_ROOT_PATH."/modules";
$handle      = opendir($modules_dir);

while (false !== ($file = readdir($handle))) {
  if ( @is_dir($modules_dir."/".$file) && @file_exists($modules_dir."/".$file."/include/rcxv.php") ) {
    if ( !in_array(trim($file), $listed_mods) ) {
      $module = new RcxModule();
      $module->loadModInfo($file);

echo "
<tr align='center' valign='middle' class='sysbg1'>

<td align='center' valign='bottom'>
<img src='".RCX_URL."/modules/".$module->dirname()."/".$module->image()."' alt='".htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)."' border='0'>
<br /><b>" .trim($module->name())."</b>
<input type='hidden' name='name[]' value='" .htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)."' />
</td>

<td align='center'>".$module->currentVersion()."</td>
<td align='center'>"._MD_AM_NOTINSTALLED."</td>

<td>
<input type='hidden' name='oldstatus[]' value='0' />
<select class='select' name='newstatus[]'>
<option value='nochange' selected='selected'>"._MD_AM_NOCHANGE."</option>
<option value='install'>"._INSTALL."</option>
</select>
</td>";

echo "<td>";
if ( $module->hasMain() ) {
  echo "
  <input type='hidden' name='oldweight[]' value='0' />
  <input type='text' class='text' name='weight[]' size='3' maxlength='5' value='1'/>";
  } else {
    echo "
    <input type='hidden' name='oldweight[]' value='0' />
    <input type='hidden' name='weight[]' value='0' />";
  }

echo "
</td><td>
<a href='javascript:openWithSelfMain(\"".RCX_URL."/modules/system/admin.php?fct=version&amp;mid=".$module->dirname()."\",\"Info\",300,230);'><img src='".RCX_URL."/images/editor/info.gif' border='0' alt='"._INFO."' /></a>
<input type='hidden' name='module[]' value='".$module->dirname()."' />
</td></tr>";

unset($module);
} // END in_array()
} // END ereg
} // END while

echo "
</table></td></tr>
<tr align='center'><td><br />
<input type='hidden' name='fct' value='modulesadmin' />
<input type='hidden' name='op' value='confirm' />
<input type='submit' class='button' name='submit' value='"._SUBMIT."' />
</td></tr></table>
</form><br /><br />";

CloseTable();

echo "                        
        </td>
    </tr>
</table>";

rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_install($module) {
global $rcxConfig, $rcxUser, $db;

if ( !RcxModule::moduleExists($module) ) {
  $mymodule = new RcxModule();
  $mymodule->loadModInfo($module);
  $newmid   = $mymodule->install();
  //update the main menu cache

  if (!$newmid) {
    $ret  = "<div align='center'>".sprintf(_MD_AM_FAILINS, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
    $errs = $mymodule->errors();

    foreach ($errs as $err) {
      $ret .= " - ".$err."<br />";
    }

    $ret .= "</div>";
    return $ret;
    } else {
      $mymodule = new RcxModule($newmid);
      $result   = $mymodule->update();
      $groups   = $rcxUser->groups();

      // retrieve all block ids for this module
      $blocks =& RcxBlock::getByModule($newmid, false);
      foreach ($groups as $mygroup) {
        if ( RcxGroup::checkRight("module", 0, $mygroup, "A") ) {

          $sql = "INSERT INTO ".$db->prefix("groups_modules_link")." SET groupid=$mygroup, mid=$newmid, type='A'";
          $db->query($sql);
          $sql = "INSERT INTO ".$db->prefix("groups_modules_link")." SET groupid=$mygroup, mid=$newmid, type='R'";
          $db->query($sql);

          foreach ($blocks as $blc) {
            $sql = "INSERT INTO ".$db->prefix("groups_blocks_link")." SET groupid=$mygroup, block_id=$blc, type='R'";
            $db->query($sql);
          }
        }
      }

    return "<div align='center'>".sprintf(_MD_AM_OKINS, "<b>".$mymodule->name()."</b>")."</div>";
    }
}

return "<div align='center'>".sprintf(_MD_AM_FAILINS, "<b>".$module."</b>")."&nbsp;"._ERROR.":<br /> - ".sprintf(_MD_AM_ALEXISTS, $module)."</div>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_uninstall($module) {
global $rcxConfig, $_GET;

$mymodule =& RcxModule::getByDirname($module);

if ($mymodule->dirname() == "system") {
  $msg = "<div align='center'>".
  sprintf(_MD_AM_FAILUNINS, "<b>".$mymodule->name()."</b>").
  "&nbsp;"._ERROR.":<br /> - "._MD_AM_SYSNO."</div>";
  return $msg;

  } elseif ($mymodule->dirname() == $rcxConfig['startpage']) {
    $msg =  "<div align='center'>".
    sprintf(_MD_AM_FAILUNINS, "<b>".$mymodule->name()."</b>").
    "&nbsp;"._ERROR.":<br /> - "._MD_AM_STRTNO."</div>";
    return $msg;
    } else {
      if ( !$mymodule->uninstall() ) {
        $ret = "<div align='center'>".sprintf(_MD_AM_FAILUNINS, "<b>".$mymodule->name()."</b>").
        "&nbsp;"._ERROR.":<br />";
        $errs = $mymodule->errors();
        foreach($errs as $err) {
          $ret .= " - ".$err."<br />";
        }

      return $ret."</div>";
      }

  return "<div align='center'>".sprintf(_MD_AM_OKUNINS, "<b>".$mymodule->name()."</b>")."</div>";
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_update($module) {
  global $rcxConfig;
  $mymodule =& RcxModule::getByDirname($module);
  if ( !$mymodule->update() ) {
    $ret = "<div align='center'>".sprintf(_MD_AM_FAILUPD, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
    $errs = $mymodule->errors();
    foreach ( $errs as $err ) {
      $ret .= " - ".$err."<br />";
    }
    return $ret."</div>";
  }
  return "<div align='center'>".sprintf(_MD_AM_OKUPD, "<b>".$mymodule->name()."</b>")."</div>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_activate($module) {
  global $rcxConfig;
  $mymodule =& RcxModule::getByDirname($module);
  if ( !$mymodule->activate() ) {
    $ret = "<div align='center'>".sprintf(_MD_AM_FAILACT, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
    $errs = $mymodule->errors();
    foreach ( $errs as $err ) {
      echo " - ".$err."<br />";
    }
    return $ret."</div>";
  }
  return "<div align='center'>".sprintf(_MD_AM_OKACT, "<b>".$mymodule->name()."</b>")."</div>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_deactivate($module) {
global $rcxConfig;

$mymodule =& RcxModule::getByDirname($module);

if ($mymodule->dirname() == "system") {
  return "<div align='center'>".sprintf(_MD_AM_FAILDEACT, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br /> - "._MD_AM_SYSNO."</div>";
  } elseif ($mymodule->dirname() == $rcxConfig['startpage']) {
    return "<div align='center'>".sprintf(_MD_AM_FAILDEACT, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br /> - "._MD_AM_STRTNO."</div>";
    } else {
      if ( !$mymodule->deactivate() ) {
        $ret = "<div align='center'>".sprintf(_MD_AM_FAILDEACT, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
        $errs = $mymodule->errors();
        foreach ( $errs as $err ) {
          $ret .= " - ".$err."<br />";
        }

      return $ret."</div>";
      }

    return "<div align='center'>".sprintf(_MD_AM_OKDEACT, "<b>".$mymodule->name()."</b>")."</div>";
    }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_order($module, $order) {
global $rcxConfig;

$mymodule =& RcxModule::getByDirname($module);

if ( !$mymodule->changeOrder($order) ) {
  $ret = "<div align='center'>".sprintf(_MD_AM_FAILORDER, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
  $errs = $mymodule->errors();
  foreach ( $errs as $err ) {
    $ret .= " - ".$err."<br />";
  }

return $ret."</div>";
}

return "<div align='center'>".sprintf(_MD_AM_OKORDER, "<b>".$mymodule->name()."</b>")."</div>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
/*function ct_update($module, $ct) {
global $rcxConfig;

$mymodule =& RcxModule::getByDirname($module);

if ( !$mymodule->changeCache($ct) ) {
        $ret = "<p>".sprintf(_MD_AM_FAILCACHE, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
        $errs = $mymodule->errors();
        foreach ( $errs as $err ) {
                $ret .= " - ".$err."<br />";
        }

return $ret."</p>";
}

return "<p>".sprintf(_MD_AM_OKCACHE, "<b>".$mymodule->name()."</b>")."</p>";
}
*/

/**
* Description
*
* @param type $var description
* @return type description
*/
function module_sidebar($module, $sidebar) {
global $rcxConfig;

$mymodule =& RcxModule::getByDirname($module);

if ( !$mymodule->changeSidebar($sidebar) ) {
  $ret = "<div align='center'>".sprintf(_MD_AM_FAILBARUPD, "<b>".$mymodule->name()."</b>")."&nbsp;"._ERROR.":<br />";
  $errs = $mymodule->errors();
  foreach ( $errs as $err ) {
    $ret .= " - ".$err."<br />";
  }

return $ret."</div>";
}

return "<div align='center'>".sprintf(_MD_AM_OKBARUPD, "<b>".$mymodule->name()."</b>")."</div>";
}
/**
* Description
*
* @param type $var description
* @return type description
*/
// Modified: LARK < balnov@kaluga.net >
function module_edit($mid) {
global $db;

$module =& new RcxModule($mid);

include_once(RCX_ROOT_PATH . "/class/rcxformloader.php");
$form = new RcxThemeForm("", "moduleedit", "admin.php", "post", true);
$form->addElement(new FormHeadingRow("<b><a href=\"javascript:openWithSelfMain('".RCX_URL."/modules/system/admin.php?fct=version&mid=".$mid."', 'Info', 300, 230);\">"._MD_AM_INFO."</a></b>"));
$form->addElement(new RcxFormLabel(_MD_AM_VERSION, $module->currentVersion()));

if ($module->isActivated()) {
  $status = "<span style='color:#ff0000;'>"._ACTIVE."</span>";
  } else {
    $status = _INACTIVE;
  }
$form->addElement(new RcxFormLabel(_MD_AM_STATUS, $status));
$form->addElement(new RcxFormLabel(_MD_AM_LASTUP, formatTimestamp($module->last_update(), "m")));
$form->addElement(new RcxFormLabel(_MD_AM_INSTALLDIR, "<b>/modules/".$module->dirname()."</b>"));

$form->addElement(new FormHeadingRow(_MD_AM_SETTINGS));
$form->addElement(new RcxFormText(_NAME, "modname", 34, 34, $module->name));

// added by SVL for sidebar choose
if ( $module->dirname() != "system" && $module->hasMain() ) {
$sidebar = new RcxFormSelect(_MD_AM_SIDEBAR, "sidebar[]", $module->sidebar());
$sidebar->addOptionArray(array(0 => _MD_AM_NOBAR, 1 => _MD_AM_LONLYBAR, 2 => _MD_AM_RONLYBAR, 3 => _MD_AM_BOTHBAR));
$form->addElement($sidebar);
$form->addElement(new RcxFormHidden("oldsidebar[]", $module->sidebar()));
} else {
$form->addElement(new RcxFormLabel(_MD_AM_SIDEBAR, "N/A"));
$form->addElement(new RcxFormHidden("sidebar[]", "3"));
$form->addElement(new RcxFormHidden("oldsidebar[]", "3"));
}
if ( $module->hasMain() ) {

$weight_tray = new RcxFormElementTray(_MD_AM_ORDER, "&nbsp;");
$weight_tray->addElement(new RcxFormText("", "weight[]", 10, 34, $module->weight()));
$weight_tray->addElement(new RcxFormLabel("", _MD_AM_ORDER0));
$form->addElement($weight_tray);

$form->addElement(new RcxFormHidden("oldweight[]", $module->weight()));
 } else {
$form->addElement(new RcxFormLabel(_MD_AM_ORDER, "N/A"));
$form->addElement(new RcxFormHidden("weight[]", "3"));
$form->addElement(new RcxFormHidden("oldweight[]", "3"));
 }


$form->addElement(new FormHeadingRow(_MD_AM_ACCESSRIGHTS));

$sql    = 'SELECT groupid, type FROM '.$db->prefix('groups_modules_link').' WHERE mid='.$mid.'';
$result = $db->query($sql);
while (list($groupid, $type) = $db->fetch_row($result)) {
  if ($type == 'A') {
    $groups_admin[] = $groupid;
    } elseif ($type == 'R') {
      $groups_read[] = $groupid;
    }
}
  
$form->addElement(new RcxFormSelectGroup(_MD_AM_ADMINACCESS, 'admin_access', true, $groups_admin, 5, true));
$form->addElement(new RcxFormSelectGroup(_MD_AM_READACCESS, 'read_access', true, $groups_read, 5, true));    

$form->addElement(new FormHeadingRow(""));

$form_buttons = new RcxFormElementTray(_ACTION, "&nbsp;");

$newstatus = new RcxFormSelect("", "newstatus[]");
$nst_array = array('nochange' => _MD_AM_NOCHANGE, 'update' => _UPDATE);
if ( $module->dirname() != "system" && $module->isActivated() ) {
$nst_array['deactivate']=_DEACTIVATE;
} elseif ( $module->dirname() != "system" && $module->isActivated() ) {
$nst_array['activate']=_ACTIVATE;
}   
$nst_array['uninstall']=_UNINSTALL;
$newstatus->addOptionArray($nst_array);
$form_buttons->addElement($newstatus);

$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
$cancel_button = new RcxFormButton("", "cancel", _CANCEL, "button");
$cancel_button->setExtra("onclick='javascript:history.go(-1)'");
$form_buttons->addElement($submit_button);
$form_buttons->addElement($cancel_button);
$form->addElement($form_buttons);

$form->addElement(new RcxFormHidden("name[]", htmlspecialchars($module->name(), RCX_ENT_FLAGS, RCX_ENT_ENCODING)));
$form->addElement(new RcxFormHidden("oldstatus[]", "1"));
$form->addElement(new RcxFormHidden("module[]", $module->dirname()));
$form->addElement(new RcxFormHidden("edit", "1"));
$form->addElement(new RcxFormHidden("fct", "modulesadmin"));
$form->addElement(new RcxFormHidden("op", "confirm"));

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'. _MD_AM_EDITMOD.' "'.$module->name().'"</div>
            <br />
            <br />';

$form->display();

echo "                        
        </td>
    </tr>
</table>";

}

/**
* Description
*
* @param type $var description
* @return type description
*/
function get_module_admin_menu() {
  /************************************************************
   * Based on:
   * - PHP Layers Menu 1.0.7(c)2001,2002 Marco Pratesi <pratesi@telug.it>
   * - TreeMenu 1.1 - Bjorge Dijkstra <bjorge@gmx.net>
   ************************************************************/

  $abscissa_step   = 90;  // step for the left boundaries of layers
  $abscissa_offset = 5; // to choose the horizontal coordinate start offset for the layers
  $rightarrow      = "";
  // the following is to support browsers not detecting the mouse position
  $ordinata_step = 15;  // estimated value of the number of pixels between links on a layer
  $ordinata[1]   = (150-$ordinata_step);// to choose the vertical coordinate start offset for the layers

  $moveLayers      = array();
  $shutdown        = array();
  $firstleveltable = array();

  /*********************************************/
  /* read file to $tree array                  */
  /* tree[x][0] -> tree level                  */
  /* tree[x][1] -> item text                   */
  /* tree[x][2] -> item link                   */
  /* tree[x][3] -> link target                 */
  /* tree[x][4] -> module id                   */
  /*********************************************/

  $js       = "";
  $maxlevel = 0;
  $cnt      = 1;
  $mids     =& RcxModule::getHasAdminModulesList(false);
  foreach ($mids as $mid) {
    $mod       = new RcxModule($mid);
    $adminmenu = $mod->getAdminMenu();
    if ( !empty($adminmenu) || $mod->adminindex() ) {
      $tree[$cnt][0] = 1;
      $tree[$cnt][5] = "<img src='\".RCX_URL.\"/modules/".$mod->dirname()."/".$mod->image()."' />";
      $tree[$cnt][1] .= $mod->name();
      $tree[$cnt][2] = "\".RCX_URL.\"/modules/".$mod->dirname()."/".$mod->adminindex();
      $tree[$cnt][3] = "";
      $tree[$cnt][4] = $mid;
      $tree[$cnt][6] = "<b>"._VERSION.":</b> ".$mod->currentVersion()."<br /><b>"._DESCRIPTION.":</b> ".$mod->description()."";
      if ($mod->dirname() == 'system') { 
        $tree[$cnt][7] = "<a href='".RCX_URL."/modules/".$mod->dirname()."/admin.php' /><img src='".RCX_URL."/modules/".$mod->dirname()."/".$mod->image()."' /></a>";
      } else {
        $tree[$cnt][7] = "<a href='".RCX_URL."/modules/".$mod->dirname()."/index.php' /><img src='".RCX_URL."/modules/".$mod->dirname()."/".$mod->image()."' /></a>";
      }
      $layer_label[$cnt] = "L" . $cnt;
      if ( $tree[$cnt][0] > $maxlevel ) {
        $maxlevel = $tree[$cnt][0];
      }
      $cnt++;
      if ( !empty($adminmenu) ) {
        foreach ( $adminmenu as $menuitem ) {
          $menuitem['link'] = trim($menuitem['link']);
          $menuitem['target'] = trim($menuitem['target']);
          $tree[$cnt][0] = 2;
          $tree[$cnt][1] = trim($menuitem['title']);
          $tree[$cnt][2] = (empty($menuitem['link'])) ? "#" : "\".RCX_URL.\"/modules/".$mod->dirname()."/".$menuitem['link'];
          $tree[$cnt][3] = (empty($menuitem['target'])) ? "" : $menuitem['target'];
          $tree[$cnt][4] = $mid;
          $layer_label[$cnt] = "L" . $cnt;
          if ($tree[$cnt][0] > $maxlevel) {
            $maxlevel = $tree[$cnt][0];
          }
          $cnt++;
        }
      }
    }
  }
  $tmpcount = count($tree);
  $tree[$tmpcount+1][0] = 0;
  for ( $i = 0; $i < $maxlevel; $i++) {
    $abscissa[$i] = $i * $abscissa_step + $abscissa_offset;
  }
  for ( $cnt = 1; $cnt <= $tmpcount; $cnt++) {  // this counter scans all nodes
    // assign the layers name to the current hierarchical level,
    // to keep trace of the route leading to the current node on the tree
    $layername[$tree[$cnt][0]] = $layer_label[$cnt];

    // assign the starting vertical coordinates for all sublevels
    for ( $i = $tree[$cnt][0] + 1; $i < $maxlevel; $i++) {
      $ordinata[$i] = $ordinata[$i-1] + 1.5*$ordinata_step;
    }
    // increment the starting vertical coordinate for the current sublevel
    if ($tree[$cnt][0] < $maxlevel) {
      $ordinata[$tree[$cnt][0]] += $ordinata_step;
    }
    if ($tree[$cnt+1][0]>$tree[$cnt][0] && $cnt<$tmpcount) {
      // the node is not a leaf, hence it has at least a child
      // initialize the corresponding layer content trought a void string
      $layer[$layer_label[$cnt]] = "";
      // prepare the popUp function related to the children
  $js .= "\nfunction popUp" . $layer_label[$cnt] . "() {\n" . "shutdown();\n";
  $js .= "setleft('" . $layer_label[$cnt] . "'," . $abscissa[$tree[$cnt][0]] . ");\n";

      for ($i=1; $i<=$tree[$cnt][0]; $i++) {
        $js .= "popUp(\\\"" . $layername[$i] . "\\\", true);\n";
      }
      $js .= "}";

      // geometrical parameters are assigned to the new layer, related to the above mentioned children
      // $moveLayers[$tree[$cnt][4]] .= "setleft('" . $layer_label[$cnt] . "'," . $abscissa[$tree[$cnt][0]] . ");\n";
      $moveLayers[$tree[$cnt][4]] .= "settop('" . $layer_label[$cnt] . "'," . $ordinata[$tree[$cnt][0]] . ");";
      //$moveLayers[$tree[$cnt][4]] .= "setwidth('" . $layer_label[$cnt] . "'," . $abscissa_step . ");\n";
      // the new layer is accounted for in the shutdown() function
      $shutdown[$tree[$cnt][4]] .= "popUp('" . $layer_label[$cnt] . "', false);";
    }
    if ($tree[$cnt+1][0]>$tree[$cnt][0] && $cnt<$tmpcount) {
      // not a leaf
      $currentarrow = $rightarrow;
    } else {
      // a leaf
      $currentarrow = "";
    }
    /* */
    $currentlink = $tree[$cnt][2];
    /* */
    /*
    if ( $tree[$cnt+1][0] > $tree[$cnt][0] && $cnt < $tmpcount) {
    // not a leaf
      $currentlink = "#";
    } else {
    // a leaf
      $currentlink = $tree[$cnt][2];
    }
    */
    if ($tree[$cnt][3] != "") {
      $currenttarget = " target='" . $tree[$cnt][3] . "'";
    } else {
      $currenttarget = "";
    }
    if ($tree[$cnt][0] > 1) {
      // the hierarchical level is > 1, hence the current node is not a child of the root node
      // handle accordingly the corresponding link, distinguishing if the current node is a leaf or not
      if ( $tree[$cnt+1][0] > $tree[$cnt][0] && $cnt < $tmpcount ) {  // not a leaf
        $onmouseover = " onMouseover='moveLayerY(\\\"" . $layer_label[$cnt] . "\\\", currentY) ; popUp" . $layer_label[$cnt] . "();";
      } else {  // a leaf
        $onmouseover = " onMouseover='popUp" . $layername[$tree[$cnt][0]-1] . "();";
      }
      $layer[$layername[$tree[$cnt][0]-1]] .= "<img src='\".RCX_URL.\"/images/menu/pointer.gif' />&nbsp;<a href='" . $currentlink . "'" . $onmouseover . "'" . $currenttarget . ">" .$tree[$cnt][1]. "</a>" . $currentarrow . "<br />\n";
    } elseif ($tree[$cnt][0] == 1) {
      // the hierarchical level is = 1, hence the current node is a child of the root node
      // handle accordingly the corresponding link, distinguishing if the current node is a leaf or not
      if ($tree[$cnt+1][0]>$tree[$cnt][0] && $cnt<$tmpcount) {
        // not a leaf
        $onmouseover = " onMouseover='moveLayerY(\\\"" . $layer_label[$cnt] . "\\\", currentY) ; popUp" . $layer_label[$cnt] . "();";
      } else {
        // a leaf
        $onmouseover = " onMouseover='shutdown();";
      }
      $firstleveltable[$tree[$cnt][4]] .= "<a href='" . $currentlink . "'" . $onmouseover . "'" . $currenttarget . ">" . $tree[$cnt][5] . "</a>" . $currentarrow . "<br />";
    }
  } // end of the "for" cycle scanning all nodes

  $cellpadding = 10;
  $width = $abscissa_step - $cellpadding;
  $menu_layers = "";
  for ( $cnt = 1; $cnt <= $tmpcount; $cnt++ ) {
    if (!($tree[$cnt+1][0]<=$tree[$cnt][0])) {
      $menu_layers .= "
        <div id='".$layer_label[$cnt]."' style='position: absolute; visibility: hidden; z-index:1000;'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='".$abscissa_step."'><tr>
        <td class='sysbg2'>
        <table width='100%' border='0' cellpadding='4' cellspacing='1'><tr>
        <td class='sysbg3' align='center' nowrap='nowrap'><b>".$tree[$cnt][1]."</b></td>
        </tr><tr>
        <td class='sysbg1' nowrap='nowrap'>".$layer[$layer_label[$cnt]]."<br /></td>
        </tr><tr>
        <td class='sysbg3'>".$tree[$cnt][7]."<br /><small>".$tree[$cnt][6]."</small></td>
        </tr></table></td>
        </tr></table></div>\n";
    }
  }
  $menu_layers .= "<script type='text/javascript'>\n<!--\nmoveLayers();\nloaded = 1;\n// -->\n</script>\n";
  $content = "<"."?php\n";
  $content .= "\$rcx_admin_menu_js = \"".$js."\";\n";
  foreach ( $moveLayers as $k => $v ){
    $content .= "\$rcx_admin_menu_ml[$k] = \"".$v."\";\n";
  }
  foreach ( $shutdown as $k => $v ){
    $content .= "\$rcx_admin_menu_sd[$k] = \"".$v."\";\n";
  }
  foreach ( $firstleveltable as $k => $v ){
    $content .= "\$rcx_admin_menu_ft[$k] = \"".$v."\";\n";
  }
  $content .= "\$rcx_admin_menu_dv = \"".$menu_layers."\";\n";
  $content .= "\n?".">";
  return $content;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function write_module_admin_menu($content) {

$filename = RCX_ROOT_PATH."/modules/system/cache/adminmenu.php";

if ( !$file = fopen($filename, "w") ) {
  echo "open fail fail";
  return false;
}

if ( fwrite($file, $content) == -1 ) {
  echo "write fail";
  return false;
}

fclose($file);
return true;
}
  } else {
    redirect_header(RCX_URL."/", 3, _NOPERM);
  }
?>
