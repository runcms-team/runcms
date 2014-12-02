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

include_once(RCX_ROOT_PATH."/modules/system/admin/users/users.php");

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
	
/**
* Description
*
* @param type $var description
* @return type description
*/
function filterSave($name,$type) {
global $myts, $_POST;

$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/bad'.$name.'.php');
		if ( !empty($badentries) ) {
			$value = '';
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
			if ($name == "unames"){
				$i = "#i";
			}else{
				$i = "#";
			}
			$value .= trim("#".preg_quote($type).$i);
			$value = trim($value);
		}
		
if (!@is_writable(RCX_ROOT_PATH."/modules/system/cache/bad".$name.".php")) {
	$errors[] = sprintf(_MUSTWABLE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
	return false;
}

$errors   = array();
$filter   = array();
$filtered = $myts->oopsNl2Br(trim($value));
$filter   = explode("<br />", $filtered);

if (!$file = @fopen(RCX_ROOT_PATH."/modules/system/cache/bad$name.php", "w")) {
	$errors[] = sprintf(_MUSTWABLE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
	} else {
		$output = "";
		foreach ($filter as $entry) {
			$output .= $entry."\n";
		}
		if (fwrite($file, $output) == -1) {
			$errors[] = sprintf(_NGWRITE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
		}
		fclose($file);
	}

if (count($errors) > 0) {
	rcx_cp_header();
	OpenTable();
	echo '<a href="admin.php?fct=filter"><h4>'._AM_FILTERSETTINGS.'</h4></a><br />';
	foreach ($errors as $er) {
		echo $er."<br />";
	}
}
	

}

$rcx_token = & RcxToken::getInstance();

if (in_array($op, array("reactivate", "synchronize", "delete_many_ok", "ban_many_ok", "updateUser", "delUserConf", "banUserConf", "addUser"))) {
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=users', 3, $rcx_token->getErrors(true));
        exit();
    }
}

switch($op) {

case "mod_users":
  include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
  displayUsers();
  break;

case "modifyUser":
  modifyUser($uid);
  break;

case "updateUser":
  updateUser($uid, $uname, $name, $address, $town, $zip_code, $phone, $url, $email, $user_icq, $user_aim, $user_yim, $user_msnm, $user_from, $user_occ, $user_intrest, $user_viewemail, $user_avatar, $user_sig, $attachsig, $theme, $pass, $pass2, $rank, $bio, $uorder, $umode, $timezone_offset, $language);
  break;

case "delUser":
  rcx_cp_header();
  OpenTable();
  $userdata = new RcxUser($uid);
  echo"<h3>".sprintf(_AM_HANDLES)."</h3><br />";
  echo "<h4>".sprintf(_AM_AYSYWTDU, $userdata->getVar("uname"))."</h4>";
  echo _AM_BYTHIS."<br /><br />";
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=users&op=delUserConf&del_uid=".$userdata->getVar("uid"),_YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?op=adminMain", _NO);
 echo "</td></tr></table>";
  echo "<h4>".sprintf(_AM_BANNED, $userdata->getVar("uname"))."</h4>";
  echo _AM_BANUSER."<br /><br />";
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=users&op=banUserConf&del_uid=".$userdata->getVar("uid"),_YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?op=adminMain", _NO);
  echo "</td></tr></table>";

  CloseTable();
  rcx_cp_footer();
  break;

case "delete_many":
  rcx_cp_header();
  OpenTable();
  $count = count($_POST['memberslist_id']);
  if ( $count > 0 ) {
    $list = "<a href='".RCX_URL."/userinfo.php?uid=".$_POST['memberslist_id'][0]."' target='_blank'>".$_POST['memberslist_uname'][$_POST['memberslist_id'][0]]."</a>";
    $hidden = "<input type='hidden' name='memberslist_id[]' value='".$_POST['memberslist_id'][0]."' />\n";
    for ( $i = 1; $i < $count; $i++ ) {
      $list .= ", <a href='".RCX_URL."/userinfo.php?uid=".$_POST['memberslist_id'][$i]."' target='_blank'>".$_POST['memberslist_uname'][$_POST['memberslist_id'][$i]]."</a>";
      $hidden .= "<input type='hidden' name='memberslist_id[]' value='".$_POST['memberslist_id'][$i]."' />\n";
    }
	echo "<h3>".sprintf(_AM_HANDLES)."</h3><br />";
    echo "<h4>".sprintf(_AM_AYSYWTDU," ".$list." ")."</h4>";
    echo _AM_BYTHIS."<br /><br />
    <form action='admin.php' method='post'>
    <input type='hidden' name='fct' value='users' />
    <input type='hidden' name='op' value='delete_many_ok' />
    " . $rcx_token->getTokenHTML() . "
    <input type='submit' class='button' value='"._YES."' />
    <input type='button' class='button' value='"._NO."' onclick='javascript:location.href=\"admin.php?op=adminMain\"' />";
    echo $hidden;
    echo "</form>";
    echo "<h4>".sprintf(_AM_BANNED," ".$list." ")."</h4>";
    echo _AM_BANUSER."<br /><br />
    <form action='admin.php' method='post'>
    <input type='hidden' name='fct' value='users' />
    <input type='hidden' name='op' value='ban_many_ok' />
    " . $rcx_token->getTokenHTML() . "
    <input type='submit' class='button' value='"._YES."' />
    <input type='button' class='button' value='"._NO."' onclick='javascript:location.href=\"admin.php?op=adminMain\"' />";
    echo $hidden;
    echo "</form>";

    } else {
      echo _AM_NOUSERS;
    }
  CloseTable();
  rcx_cp_footer();
  break;

case "delete_many_ok":
  $count = count($_POST['memberslist_id']);
  $output = "";
  for ($i=0; $i<$count; $i++) {
    $deluser = new RcxUser($_POST['memberslist_id'][$i]);
    if ( !$deluser->delete() ) {
      $output .= "Could not delete ".$deluser->getVar("uname")."<br />";
      } else {

        $output .= $deluser->getVar("uname")." deleted<br />";
      }
  }
  rcx_cp_header();
  OpenTable();
  echo $output;
  CloseTable();
  rcx_cp_footer();
  break;

case "banUser":
  rcx_cp_header();
  OpenTable();
  $userdata = new RcxUser($uid);
  echo "<h4>".sprintf(_AM_AYSYWTDU, $userdata->getVar("uname"))."</h4>";
  echo _AM_BYTHIS."<br /><br />";
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=users&op=banUserConf&del_uid=".$userdata->getVar("uid"),_YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?op=adminMain", _NO);
  echo "</td></tr></table>";
  CloseTable();
  rcx_cp_footer();
  break;

/*
case "ban_many":
  rcx_cp_header();
  OpenTable();
  $count = count($_POST['memberslist_id']);
  if ( $count > 0 ) {
    $list = "<a href='".RCX_URL."/userinfo.php?uid=".$_POST['memberslist_id'][0]."' target='_blank'>".$_POST['memberslist_uname'][$_POST['memberslist_id'][0]]."</a>";
    $hidden = "<input type='hidden' name='memberslist_id[]' value='".$_POST['memberslist_id'][0]."' />\n";
    for ( $i = 1; $i < $count; $i++ ) {
      $list .= ", <a href='".RCX_URL."/userinfo.php?uid=".$_POST['memberslist_id'][$i]."' target='_blank'>".$_POST['memberslist_uname'][$_POST['memberslist_id'][$i]]."</a>";
      $hidden .= "<input type='hidden' name='memberslist_id[]' value='".$_POST['memberslist_id'][$i]."' />\n";
    }
    echo "<h4>".sprintf(_AM_AYSYWTDU," ".$list." ")."</h4>";
    echo _AM_BYTHI."<br /><br />
    <form action='admin.php' method='post'>
    <input type='hidden' name='fct' value='users' />
    <input type='hidden' name='op' value='ban_many_ok' />
    <input type='submit' class='button' value='"._YES."' />
    <input type='button' class='button' value='"._NO."' onclick='javascript:location.href=\"admin.php?op=adminMain\"' />";
    echo $hidden;
    echo "</form>";
    } else {
      echo _AM_NOUSERS;
    }
  CloseTable();
  rcx_cp_footer();
  break;
*/
case "ban_many_ok":
  $count = count($_POST['memberslist_id']);
  $output = "";
  for ($i=0; $i<$count; $i++) {
    $deluser = new RcxUser($_POST['memberslist_id'][$i]);
    if ( !$deluser->delete() ) {
      $output .= "Could not ban ".$deluser->getVar("uname")."<br />";
      } else {
      	  $nom = $deluser ->getVar("uname");
  				$mail = $deluser ->getVar("email");
  				$ips = $deluser ->getVar("regip");
  				filterSave('unames', $nom);
  				filterSave('emails', $mail);
  				if($ips !== ""){
  				filterSave('ips', $ips);
						}
        $output .= $deluser->getVar("uname")." banned<br />";
      }
  }
  rcx_cp_header();
  OpenTable();
  echo $output;
  CloseTable();
  rcx_cp_footer();
  break;

case "delUserConf":
  $user = new RcxUser($del_uid);
  $user->delete();
  redirect_header("admin.php?fct=users", 1, _UPDATED);
  break;

case "banUserConf":

  $user = new RcxUser($del_uid);
  $nom  = $user ->getVar("uname");
  $mail = $user ->getVar("email");
  $ips  = $user ->getVar("regip");
  filterSave('unames', $nom);
  filterSave('emails', $mail);
  
  if($ips !== ""){
  filterSave('ips', $ips);
	}
  $user->delete();
  redirect_header("admin.php?fct=users", 1, _UPDATED);
  break;




case "addUser":
  if ( !($uname && $email && $pass) ) {
    rcx_cp_header();
    OpenTable();
    echo _AM_YMCACF;
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  $newuser = new RcxUser();
  if ( isset($user_viewemail) ) {
    $newuser->setVar("user_viewemail", $user_viewemail);
  }
  if ( isset($attachsig) ) {
    $newuser->setVar("attachsig", $attachsig);
  }
  $newuser->setVar("name", $name);
  $newuser->setVar("uname", $uname);
  $newuser->setVar("address", $address);
  $newuser->setVar("zip_code", $zip_code);
  $newuser->setVar("town", $town);
  $newuser->setVar("user_from", $user_from);
  $newuser->setVar("phone", $phone);
  $newuser->setVar("email", $email);
  $newuser->setVar("url", formatURL($url));
  $newuser->setVar("user_avatar", $user_avatar);
  $newuser->setVar("theme", $theme);
  $newuser->setVar("user_icq", $user_icq);
  $newuser->setVar("user_aim", $user_aim);
  $newuser->setVar("user_yim", $user_yim);
  $newuser->setVar("user_sig", $user_sig);
  $newuser->setVar("user_msnm", $user_msnm);
  $newuser->setVar("pass", md5($pass));
  $newuser->setVar("actkey", substr(md5(makepass()), 0, 8));
  $newuser->setVar("timezone_offset", $timezone_offset);
  $newuser->setVar("language", $language);
  $newuser->setVar("theme", $theme);
  $newuser->setVar("uorder", $uorder);
  $newuser->setVar("umode", $umode);
  $newuser->setVar("bio", $bio);
  $newuser->setVar("rank", $rank);
  $newuser->setVar("level", 1);
  $newuser->setVar("user_occ", $user_occ);
  $newuser->setVar("user_intrest", $user_intrest);

  if ( !$newuser->store() ) {
    rcx_cp_header();
    OpenTable();
    echo _AM_CNRNU;
    CloseTable();
    rcx_cp_footer();
    exit();
    } else {
      redirect_header("admin.php?fct=users", 1, _UPDATED);
    }
  break;

case "synchronize":
  synchronize($id, $type);
  break;

case "reactivate":
  $result = $db->query("UPDATE ".$db->prefix("users")." SET level=1 WHERE uid=$uid");
  if (!$result) {
    redirect_header("admin.php?fct=users&op=modifyUser&uid=".$uid."", 1, _NOTUPDATED);
  }
  redirect_header("admin.php?fct=users&op=modifyUser&uid=".$uid."", 1, _UPDATED);
  break;

default:
  include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
  displayUsers();
  break;
}

} else {
  echo "Access Denied";
}
?>
