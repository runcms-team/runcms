<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$rcxOption['pagetype']   = 'user';
$rcxOption['page_style'] = 8;

include_once("./mainfile.php");

if ($rcxConfig['ban_profile_viewer'] && !$rcxUser) {
    redirect_header("whyregister.php", 2, _NOPERM);
    exit();
}

$uid = intval($_GET['uid']);
$module = RcxModule::getByDirname('pm');
if ( empty($uid) ) {
  redirect_header("index.php", 3, _US_SELECTNG);
  exit();
}

if ($rcxUser) {

if ( $uid == $rcxUser->getVar("uid") ) {
  include_once("header.php");
  OpenTable();
  echo "<h3>";
  printf(_US_WELCOME, $meta['title']);
  echo "</h3><br />";
  echo "<h4>"._US_THISISYOURPAGE."</h4><br />";
  echo "<form name='usernav' action='user.php' method='post'>
  <table align='center' border='0'><tr><td><input type='button' class='button' value='"._US_EDITPROFILE."' onclick=\"location='edituser.php'\" /></td>";
  if ( $rcxConfig['avatar_allow_upload'] == 1 ) {
    echo "<td><input type='button' class='button' value='"._US_UPLOADMYAVATAR."' onclick=\"location='edituser.php?op=avatarform'\" /></td>";
    }
  if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups()) )
  {
    echo "<td><input type='button' class='button' value='"._US_INBOX."' onclick=\"location='".RCX_URL."/modules/pm/index.php'\" /></td>";
  }
  if ( $rcxConfig['self_delete'] ) {
    echo "<td><input type='button' class='button' value='"._US_DELACCOUNT."' onclick=\"location='user.php?op=delete'\" /></td>";
  }

  echo "<td><input type='button' class='button' value='"._US_LOGOUT."' onclick=\"location='user.php?op=logout'\" /></td>
  <td></td></tr></table></form><br /><br />";
  $thisUser =& $rcxUser;

  } else {
    $thisUser= new RcxUser($uid);
    if ( !$thisUser->isActive() ) {
      redirect_header("index.php", 3, _US_SELECTNG);
      exit();
    }
    include_once("header.php");
    OpenTable();
    echo "<h4>";
    if ($rcxUser->isAdmin()) {
      echo "<a href='./modules/system/admin.php?fct=users&op=modifyUser&uid=$uid'><img src='./images/read.gif' border='0' alt='"._EDIT."' /></a>";
    }
    printf(_US_PROFILEFOR, $thisUser->getVar("uname"));
    echo "</h4>";
  }

  } else {
    $thisUser = new RcxUser($uid);
    if ( !$thisUser->isActive() ) {
      redirect_header("index.php", 3, _US_SELECTNG);
      exit();
    }
    include_once("header.php");
    OpenTable();
    echo "<h4>";
    printf(_US_PROFILEFOR, $thisUser->getVar("uname"));
    echo "</h4><br />";
  }

if ( $thisUser->isActive() ) {
  echo "
  <table width='100%' border='0'><tr valign='top'>
  <td width='50%'>
  <table border='0' cellpadding='0' cellspacing='0' align='center' valign='top' width='80%'><tr>
  <td class='bg2'>
  <table border='0' cellpadding='4' cellspacing='1' width='100%'><tr valign='top' class='bg1'>
  <td colspan='2' align='center'><b>".sprintf(_US_ALLABOUT, $thisUser->getVar("uname"))."</b></td>
  </tr>";

  if ($thisUser->getVar("user_avatar")) {
    echo "<tr valign='top' class='bg3'>";
    echo "<td><b>"._US_AVATAR.":</b></td><td align='center'><img src='images/avatar/".$thisUser->getVar("user_avatar")."' alt='' /></td>";
    echo "</tr>";
  }

  if ($rcxUser && ($thisUser->getVar("name") != '') ) {
    echo "<tr valign='top' class='bg1'><td><b>"._US_REALNAME.":</b></td><td align='center'>".$thisUser->getVar("name")."</td></tr>";
  }
  /* yderlige info m.m.
	/*if ($rcxUser && ($thisUser->getVar("address") != '')) { 
    echo "<tr valign='top' class='bg3'><td><b>"._US_ADDRESS.":</b></td><td align='center'>".$thisUser->getVar("address")."</td></tr>";
	}
	if ($rcxUser && ($thisUser->getVar("zip_code") != '')) {
	echo "<tr valign='top' class='bg1'><td><b>"._US_ZIP_CODE.":</b></td><td align='center'>".$thisUser->getVar("zip_code")."</td></tr>";
	}
	if ($rcxUser && ($thisUser->getVar("town") != '')) {
	echo "<tr valign='top' class='bg3'><td><b>"._US_TOWN.":</b></td><td align='center'>".$thisUser->getVar("town")."</td></tr>";
	}
	if ($rcxUser && ($thisUser->getVar("user_from") != '')) {
	echo "<tr valign='top' class='bg1'><td><b>"._US_LOCATION.":</b></td><td align='center'>";
		echo $thisUser->getVar("user_from");
		echo "</td></tr>";
	}
	if ($rcxUser && ($thisUser->getVar("phone") != '')) {
	echo "<tr valign='top' class='bg3'><td><b>"._US_TELEPHONE.":</b></td><td align='center'>".$thisUser->getVar("phone")."</td></tr>";
	}*/
	if ($rcxUser && ($thisUser->getVar("birthday") != '')) {
	echo "<tr valign='top' class='bg1'><td><b>"._US_BIRTHDAY.":</b></td><td align='center'>";
		$baa = $thisUser->getVar("birthday");
		$d = substr($baa,0,2);
		$m = substr($baa,2,2);
		echo $d.".".$m.".".$thisUser->getVar("birthyear");
		echo "</td></tr>";
	}

  if ($thisUser->getVar("url") != "") {
    echo "<tr valign='top' class='bg3'><td><b>"._US_WEBSITE.":</b></td><td>";
    
    if ($rcxConfig['hide_external_links']) {
        echo $myts->checkGoodUrl($thisUser->getVar("url"), "<img src='".RCX_URL."/images/icons/www.gif' alt='" . _US_WEBSITE . "' />", false) . "\n";
    } else {
    	echo "<a href='".$thisUser->getVar("url", "E")."' target='_blank'>".$thisUser->getVar("url")."</a>\n";
    }
    
    echo "</td></tr>";
  }

  if ($rcxUser) {
    if ($rcxUser->isAdmin() || ($rcxUser->getVar("uid") == $thisUser->getVar("uid")) || ($thisUser->getVar("user_viewemail") == 1)) {
      echo "<tr valign='top' class='bg1'><td><b>"._US_EMAIL.":</b></td><td>";
      echo "<a href='mailto:".$thisUser->getVar("email", "E")."'>".$thisUser->getVar("email")."</a>";
      echo "</td></tr>";
    }
  }

  if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups()) ){
    echo "<tr valign='top' class='bg3'><td><b>"._US_PM.":</b></td><td>";
    if ( !RcxGroup::checkRight('module', $module->mid(), $thisUser->groups()) ){
    echo _US_NOT_AUTORIZED_PM;  
    }else{
    echo "<a href='".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$thisUser->getVar("uid")."'><img src='".RCX_URL."/images/icons/pm.gif' alt='".sprintf(_SENDPMTO, $thisUser->getVar("uname"))."' />";
    }
    echo "</a></center>";
    echo "</td></tr>";
  }

  if ($rcxUser && ($thisUser->getVar("user_icq") != '') ) {
    echo "<tr valign='top' class='bg1'><td><b>"._US_ICQ.":</b></td><td>";
    echo $thisUser->getVar("user_icq");
    echo "</td></tr>";
  }

  if ($rcxUser && ($thisUser->getVar("user_msnm") != '') ) {
    echo "<tr valign='top' class='bg3'><td><b>"._US_MSNM.":</b></td><td>";
    echo $thisUser->getVar("user_msnm");
    echo "</td></tr>";
  }

  if ($thisUser->getVar("user_occ") != '') {
    echo "<tr valign='top' class='bg3'><td><b>"._US_OCCUPATION.":</b></td><td>";
    echo $thisUser->getVar("user_occ");
    echo "</td></tr>";
  }

  if ($thisUser->getVar("user_intrest") != '') {
    echo "<tr valign='top' class='bg1'><td><b>"._US_INTEREST.":</b></td><td>";
    echo $thisUser->getVar("user_intrest");
    echo "</td></tr>";
  }

  if ($thisUser->getVar("bio") != '') {
    echo "<tr valign='top' class='bg3'><td><b>"._US_EXTRAINFO.":</b></td><td>";
    echo $myts->makeTboxData4Show($thisUser->getVar("bio"));
    echo "</td></tr>";
  }

  echo "</table></td></tr></table></td>";
  echo "<td width='50%'>";

  echo "<table border='0' cellpadding='0' cellspacing='0' align='center' valign='top' width='80%'><tr><td class='bg2'><table border='0' cellpadding='4' cellspacing='1' width='100%'><tr valign='top' class='bg1'><td colspan='2' align='center'><b>"._US_STATISTICS."</b></td></tr><tr valign='top' class='bg3'><td><b>"._US_MEMBERSINCE.":</b></td><td align='center'>".formatTimestamp($thisUser->getVar("user_regdate"),"s")."</td></tr>\n";
  $userrank = $thisUser->rank();
  echo "<tr valign='top' class='bg1'><td><b>"._US_RANK.":</b></td><td align='center'>";
  if ( $userrank['image'] ) {
    echo "<img src='".RCX_URL."/images/ranks/".$userrank['image']."' alt='' /><br />";
  }
  echo $userrank['title']."</td></tr><tr valign='top' class='bg3'><td><b>"._US_POSTS.":</b></td><td align='center'>".$thisUser->getVar("posts")."</td></tr>\n";
  $date = $thisUser->getVar("last_login");
  if ( !empty($date) ) {
    echo "<tr valign='top' class='bg1'><td><b>"._US_LASTLOGIN.":</b></td><td align='center'>".formatTimestamp($date,"m")."</td></tr>\n";
    }
  echo "</table></td></tr></table>";

  if ( $thisUser->getVar("user_sig") ) {
    echo "
    <br />
    <table border='0' cellpadding='0' cellspacing='0' align='center' valign='top' width='80%'>
    <tr><td class='bg2'>
    <table border='0' cellpadding='4' cellspacing='1' width='100%'><tr valign='top' class='bg1'>
    <td colspan='2' align='center'><b>"._US_SIGNATURE."</b></td></tr><tr valign='top' class='bg3'><td>";
    if ($rcxConfig['no_bbcode_user_sig']) {
    	echo $myts->makeTboxData4Show($thisUser->getVar("user_sig", "N"));
    } else {
    	echo $myts->makeTareaData4Show($thisUser->getVar("user_sig", "N"), 0, 1, 1);
    }
    
    echo "</td></tr></table></td></tr></table>";
  }
  echo "</td></tr></table>";

  } else {
    printf(_US_INACTIVE, $uid);
  }

CloseTable();

$mids   =& RcxModule::getHasSearchModulesList(false);
$output = '';
foreach ($mids as $mid) {
  $module  = new RcxModule($mid);
  $results = array();
  $results = $module->search("", "", 5, 0, $thisUser->getVar("uid"));
  $count   = count($results);

  if ( is_array($results) && $count) {
      $output .= "<h4>".$module->name()."</h4>";
      for ($i=0; $i<$count; $i++) {
        if ( isset($results[$i]['image']) && $results[$i]['image'] != "" ) {
          $output .= "<img src='modules/".$module->dirname()."/".$results[$i]['image']."' alt='".$module->name()."' />&nbsp;";
          } else {
            $output .= "<img src='images/icons/posticon.gif' alt='".$module->name()."' />&nbsp;";
          }
        $output .= "<b><a href='modules/".$module->dirname()."/".$results[$i]['link']."'>".$myts->makeTboxData4Show($results[$i]['title'])."</a></b><br />";
        $output .= "<small>";
        $output .= $results[$i]['time'] ? " (". formatTimestamp($results[$i]['time']).")" : "";
        $output .= "</small><br />";
      }

      if ( $count == 5 ) {
        $output .= "
          <form action='search.php' method='post' id='showall".$mid."' name='showall".$mid."'>
          <input type='hidden' name='mid' value='".$mid."' />
          <input type='hidden' name='action' value='showall' />
          <input type='hidden' name='andor' value='".$andor."' />
          <input type='hidden' name='uid' value='".$uid."' />
          <img src='".RCX_URL."/images/pixel.gif' />
          <a href='#$mid' onclick='rcxGetElementById(\"showall".$mid."\").submit();'>"._US_SHOWALL."</a>
          </form>";
      }
    }
}

if ($output != '') {
  echo "";
  OpenTable();
  echo $output;
  CloseTable();
}

include_once("footer.php");
?>
