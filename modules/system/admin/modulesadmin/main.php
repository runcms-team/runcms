<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }
include_once(RCX_ROOT_PATH."/modules/system/admin/modulesadmin/modulesadmin.php");
$op = "list";

if ( isset($_POST) ) {
  foreach ( $_POST as $k => $v ) {
    $$k = $v;
  }
}

if (!empty($_GET['op']) && ($_GET['op'] == 'edit')) {
  rcx_cp_header();
  OpenTable();
  module_edit($_GET['mid']);
  CloseTable();
  rcx_cp_footer();
  exit();
}

if ( $op == "list" ) {
  module_list();
}

if ( $op == "confirm" ) {
  rcx_cp_header();
  OpenTable();
  $error = array();
  if ( @!is_writable(RCX_ROOT_PATH."/modules/system/cache/adminmenu.php") ) {
    if ( @!chmod(RCX_ROOT_PATH."/modules/system/cache/adminmenu.php", 0666) ) {
      $error[] = sprintf(_MUSTWABLE, "<b>".RCX_ROOT_PATH."/modules/system/cache/adminmenu.php</b>");
    }
  }
  if ( count($error) > 0 ) {
    foreach ( $error as $er ) {
      echo $er."<br />";
    }
    echo "<p><a href='admin.php?fct=modulesadmin'>"._MD_AM_BTOMADMIN."</a></p>";
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  echo "<h4 style='text-align:center;'>"._MD_AM_PCMFM."</h4>
  <form action='admin.php' method='post'>
  <input type='hidden' name='fct' value='modulesadmin' />
  <input type='hidden' name='op' value='submit' />
  <table align='center' border='0' cellpadding='0' cellspacing='0' width='50%'><tr><td class='sysbg2'>
  <table width='100%' border='0' cellpadding='4' cellspacing='1'>
  <tr valign='middle' class='sysbg3' align='center'><td><b>"._MD_AM_MODULE."</b></td><td><b>"._MD_AM_ACTION."</b></td><td><b>"._MD_AM_ORDER."</b></td><td><b>"._MD_AM_SIDEBAR."</b></td></tr>";
  $size = count($module);
  for ( $i = 0 ; $i < $size; $i++ ) {
    echo "<tr class='sysbg1'><td>".$name[$i]."</td><td align='center'>";
    if ( $newstatus[$i] != "nochange" ) {
      switch ($newstatus[$i]) {
        case "deactivate":
          $statustext = _DEACTIVATE;
          break;
        case "activate":
          $statustext = _ACTIVATE;
          break;
        case "install":
          $statustext = _INSTALL;
          break;
        case "uninstall":
          $statustext = _UNINSTALL;
          break;
        case "update":
          $statustext = _UPDATE;
          break;
      }
      echo "<span style='color:#ff0000;font-weight:bold;'>".$statustext."</span>";
    } else {
      echo _MD_AM_NOCHANGE;
    }
    echo "</td><td align='center'>";
    if ( $oldweight[$i] != $weight[$i] ) {
      echo "<span style='color:#ff0000;font-weight:bold;'>".$weight[$i]."</span>";
    } else {
      echo $weight[$i];
    }
// sidebar added by SVL
    echo "</td><td align='center'>";
      switch ($sidebar[$i]) {
        case "0":
          $sidebartext = _MD_AM_NOBAR;
          break;
        case "1":
          $sidebartext = _MD_AM_LONLYBAR;
          break;
        case "2":
          $sidebartext = _MD_AM_RONLYBAR;
          break;
        case "3":
          $sidebartext = _MD_AM_BOTHBAR;
          break;
      }
    if ( $oldsidebar[$i] != $sidebar[$i] ) {
      echo "<span style='color:#ff0000;font-weight:bold;'>".$sidebartext."</span>";
    } else {
      echo $sidebartext;
    }
    echo "
    <input type='hidden' name='module[]' value='".$module[$i]."' />
    <input type='hidden' name='oldstatus[]' value='".$oldstatus[$i]."' />
    <input type='hidden' name='newstatus[]' value='".$newstatus[$i]."' />
    <input type='hidden' name='oldweight[]' value='".intval($oldweight[$i])."' />
    <input type='hidden' name='weight[]' value='".intval($weight[$i])."' />
    <input type='hidden' name='oldsidebar[]' value='".intval($oldsidebar[$i])."' />
    <input type='hidden' name='sidebar[]' value='".intval($sidebar[$i])."' />";

    if (($_GET['edit'] == 1) || ($_POST['edit'] == 1)) {
      echo "
      <input type='hidden' name='edit' value='1' />
      <input type='hidden' name='modname' value='".$myts->makeTboxData4Edit($modname)."' />";
      if ( !empty($_POST['admin_access']) ) {
        foreach($_POST['admin_access'] as $key => $admin) {
          echo "<input type='hidden' name='admin_access[]' value='".$admin."' />";
        }
      }
      if ( !empty($_POST['read_access']) ) {
        foreach($_POST['read_access'] as $key => $user) {
          echo "<input type='hidden' name='read_access[]' value='".$user."' />";
        }
      }
    }
    echo "</td></tr>";
  }
  
  $rcx_token = & RcxToken::getInstance();
  
  echo "
  <tr class='sysbg3' align='center'><td colspan='4'>" . $rcx_token->getTokenHTML() . "<input type='submit' class='button' value='"._SUBMIT."' />&nbsp;<input type='button' class='button' value='"._CANCEL."' onclick='location=\"admin.php?fct=modulesadmin\"' /></td></tr>
  </table>
  </td></tr></table>
  </form>";
  CloseTable();
  rcx_cp_footer();
}

if ( $op == "submit" ) {
  
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header("admin.php?fct=modulesadmin&op=edit&mid=". $mid, 3, $rcx_token->getErrors(true));
      exit();
  }  
    
  $size = count($newstatus);
  $ret = array();
  $write = false;
  for ( $i = 0 ; $i < $size; $i++ ) {
    $reorder = true;
    switch ($newstatus[$i]) {
      case "install":
        $ret[] = module_install($module[$i]);
        $write = true;
        break;
      case "activate":
        $ret[] = module_activate($module[$i]);
        $write = true;
        break;
      case "deactivate":
        $ret[] = module_deactivate($module[$i]);
        $write = true;
        break;
      case "update":
        $ret[] = module_update($module[$i]);
        $write = true;
        break;
      case "uninstall":
        $ret[]   = module_uninstall($module[$i]);
        $reorder = false;
        $write   = true;
        break;
      default:
        break;
    }
    if ( $oldstatus[$i] == 0 && $newstatus[$i] != "install" ) {
      $reorder = false;
    }
    if ( $reorder == true && $oldweight[$i] != $weight[$i] ) {
      $ret[] = module_order($module[$i], $weight[$i]);
      $write = true;
    }
// added by SVL for sidebar choose
    if ( $oldsidebar[$i] != $sidebar[$i] ) {
      $ret[] = module_sidebar($module[$i], $sidebar[$i]);
      $write = true;
    }
  }
  if ( $write ) {
    $contents = get_module_admin_menu();
    if (!write_module_admin_menu($contents)) {
      $ret[] = "<p>"._MD_AM_FAILWRITE."</p>";
    }
  }


  if ($_POST['edit'] == 1) {
    $mymodule =& RcxModule::getByDirname($module[0]);
    if ($mymodule) {
      $mid          = $mymodule->mid();
      $modname      = $myts->makeTboxData4Save($_POST['modname']);
      $read_access  = $_POST['read_access'];
      $admin_access = $_POST['admin_access'];

      if ( !empty($modname) ) {
        $sql    = 'UPDATE '.$db->prefix('modules').' SET name="'.$modname.'" WHERE mid='.$mid.'';
        $result = $db->query($sql);
        if (!$result) {
          $ret[]  = 'Could not update modules name.';
        }
        // echo $sql.'<br />';
      }

      if ( !empty($read_access) && @is_array($read_access) ) {
        $sql    = 'DELETE FROM '.$db->prefix('groups_modules_link').' WHERE (mid='.$mid.' AND type="R" AND groupid != 1)';
        $result = $db->query($sql);
        // echo $sql.'<br />';
        if (!$result) {
          $ret[]  = 'Could not delete old read access rights.';
          } else {
            foreach($read_access as $key => $read) {
              if ($read != 1) {
                $sql    = 'INSERT INTO '.$db->prefix('groups_modules_link').' SET mid='.$mid.', groupid='.$read.', type="R"';
                $result = $db->query($sql);
                // echo $sql.'<br />';
                if (!$result) {
                  $ret[]  = 'Could not update read access rights.';
                }
              }
            }
          }
      }

      if ( !empty($admin_access) && @is_array($admin_access) ) {
        $sql    = 'DELETE FROM '.$db->prefix('groups_modules_link').' WHERE (mid='.$mid.' AND type="A" AND groupid != 1)';
        $result = $db->query($sql);
        // echo $sql.'<br />';
        if (!$result) {
          $ret[]  = 'Could not delete old admin access rights.';
          } else {
            foreach($admin_access as $key => $admin) {
              if ($admin != 1) {
                $sql    = 'INSERT INTO '.$db->prefix('groups_modules_link').' SET mid='.$mid.', groupid='.$admin.', type="A"';
                $result = $db->query($sql);
                // echo $sql.'<br />';
                if (!$result) {
                  $ret[]  = 'Could not update admin access rights.';
                }
              }
            }
          }
      }
      } else {
        $ret[] = 'No module selected';
      }

    if ( count($ret) > 0 ) {
      foreach ($ret as $msg) {
        $message .= $msg;
      }
      } else {
        $message = _UPDATED;
      }
    redirect_header("admin.php?fct=modulesadmin&op=edit&mid=$mid", 3, $message);
    exit();
  }

  rcx_cp_header();
  OpenTable();
  if ( count($ret) > 0 ) {
    foreach ($ret as $msg) {
      echo $msg;
    }
  }

  echo "<div align='center'><br /><br /><li><a href='admin.php?fct=modulesadmin'>"._MD_AM_BTOMADMIN."</a></li>";
  echo "<br /><br />";
  echo "<li><a href='admin.php?fct=groups'>"._MD_AM_EDITACCESS."</a></li><br /><br /></div>";

  CloseTable();
  rcx_cp_footer();
}
?>
