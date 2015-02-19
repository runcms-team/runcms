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

/*********************************************************/
/* Users Functions                                       */
/*********************************************************/
include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/class/rcxformloader.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function displayUsers() {
global $db, $rcxConfig, $rcxModule, $_GET;

$userstart = isset($_GET['userstart']) ? intval($_GET['userstart']) : 0;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">';


OpenTable();

$usercount   = RcxUser::countAllUsers();
$nav         = new RcxPageNav($usercount, 500, $userstart, "userstart", "fct=users");
$editform    = new RcxThemeForm('', "edituser", "admin.php");
$user_select = new RcxFormSelect('', "uid");
$user_select->addOptionArray(RcxUser::getAllUsersList(array(), 'uname ASC', 500, $userstart));
$user_select_tray = new RcxFormElementTray(_AM_NICKNAME, "<br />");
$user_select_tray->addElement($user_select);
$user_select_nav = new RcxFormLabel('', $nav->renderNav(4));
$user_select_tray->addElement($user_select_nav);
$op_select = new RcxFormSelect("", "op");
$op_select->addOptionArray(array("modifyUser"=>_AM_MODIFYUSER, "delUser"=>_AM_DELUSER));
$submit_button = new RcxFormButton("", "submit", _GO, "submit");
$fct_hidden    = new RcxFormHidden("fct", "users");
$editform->addElement($user_select_tray);
$editform->addElement($op_select);
$editform->addElement($submit_button);
$editform->addElement($fct_hidden);
echo '<div class="KPstor" >'._AM_EDEUSER.'</div><br /><br />';
$editform->display();

echo "<br />";

$uid_value        = "";
$uname_value      = "";
$name_value       = "";
$address_value    = "";
$city_value       = "";
$zip_code_value    = "";
$location_value   = "";
$phone_value      = "";
$email_value      = "";
$email_cbox_value = 0;
$url_value        = "";
$avatar_value     = "blank.gif";
$theme_value      = $rcxConfig['default_theme'];
$timezone_value   = $rcxConfig['default_TZ'];
$lang_value		  = $rcxConfig['language'];;
$icq_value        = "";
$aim_value        = "";
$yim_value        = "";
$msnm_value       = "";
$location_value   = "";
$occ_value        = "";
$interest_value   = "";
$sig_value        = "";
$sig_cbox_value   = 0;
$umode_value      = $rcxConfig['com_mode'];
$uorder_value     = $rcxConfig['com_order'];
$bio_value        = "";
$rank_value       = 0;
$op_value         = "addUser";
$form_title       = _AM_ADDUSER;

include_once(RCX_ROOT_PATH."/modules/system/admin/users/userform.php");
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
function modifyUser($user) {
global $db, $rcxConfig, $rcxModule;

$user = new RcxUser($user);

if ( !$user->isActive() ) {
    
  rcx_cp_header();
  OpenTable();

  echo "<h4 style='text-align:left;'>"._AM_NOTACTIVE."</h4>";
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=users&amp;op=reactivate&amp;uid=".$user->getVar("uid"), _YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?fct=users", _NO);
  echo "</td></tr></table>";
  CloseTable();
  rcx_cp_footer();
  exit();
}

  rcx_cp_header();

if ($user) {
  $uid_value        = $user->getVar("uid");
  $uname_value      = $user->getVar("uname", "E");
  $name_value       = $user->getVar("name", "E");
  $address_value    = $user->getVar("address", "E");
  $town_value       = $user->getVar("town", "E");
  $zip_code_value   = $user->getVar("zip_code", "E");
  $user_from_value  = $user->getVar("user_from", "E");
  $phone_value      = $user->getVar("phone", "E");
  $email_value      = $user->getVar("email", "E");
  $email_cbox_value = $user->getVar("user_viewemail") ? 1 : 0;
  $url_value        = $user->getVar("url", "E");
  $avatar_value     = $user->getVar("user_avatar");
  $temp             = $user->getVar("theme");
  $theme_value      = empty($temp) ? $rcxConfig['default_theme'] : $temp;
  $timezone_value   = $user->getVar("timezone_offset");
  $lang_value       = $user->getVar("language", "E");
  $icq_value        = $user->getVar("user_icq", "E");
  $aim_value        = $user->getVar("user_aim", "E");
  $yim_value        = $user->getVar("user_yim", "E");
  $msnm_value       = $user->getVar("user_msnm", "E");
  $location_value   = $user->getVar("user_from", "E");

  $occ_value        = $user->getVar("user_occ", "E");
  $interest_value   = $user->getVar("user_intrest", "E");
  $sig_value        = $user->getVar("user_sig", "E");
  $sig_cbox_value   = ($user->getVar("attachsig") == 1) ? 1 : 0;
  $umode_value      = $user->getVar("umode");
  $uorder_value     = $user->getVar("uorder");
  $bio_value        = $user->getVar("bio", "E");
  $rank_value       = $user->rank(false);
  $op_value         = "updateUser";
  $form_title       = _AM_UPDATEUSER.": ".$user->getVar("uname");
  
  $rcx_token = & RcxToken::getInstance();
  
  

  
 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">'; 
  
  
  OpenTable();

  include_once(RCX_ROOT_PATH."/modules/system/admin/users/userform.php");
  
  
 echo '<br /><div class="KPstor" >'._AM_USERPOST.'</div>
            <br />
            <br />';
 
  echo "

  <table border='0'>
  <tr><td>"._AM_COMMENTS."</td><td>".$user->getVar("posts")."</td></tr>
  </table>
  <br />"._AM_PTBBTSDIYT."<br />
  <form action='admin.php' method='post'>
  <input type='hidden' name='id' value='".$user->getVar("uid")."'>
  <input type='hidden' name='type' value='user'>
  <input type='hidden' name='fct' value='users'>
  <input type='hidden' name='op' value='synchronize'>
  " . $rcx_token->getTokenHTML() . "
  <br /><br /><input type='submit' class='button' value='"._AM_SYNCHRONIZE."'>
  </form>";
  CloseTable();
  } else {
    OpenTable();  
    echo "<h4 style='text-align:left;'>";
    echo _AM_USERDONEXIT;
    echo "</h4>";
    CloseTable();
  }
  
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
function updateUser($uid, $uname, $name, $address, $town, $zip_code, $phone, $url, $email, $user_icq, $user_aim, $user_yim, $user_msnm, $user_from, $user_occ, $user_intrest, $user_viewemail, $user_avatar, $user_sig, $attachsig, $theme, $pass, $pass2, $rank, $bio, $uorder, $umode, $timezone_offset, $language) {
global $rcxConfig, $db, $rcxModule, $rcxBadEmails;

if ( !empty($rcxBadEmails) && hasMatch($rcxBadEmails, $email) ) {
  rcx_cp_header();
  OpenTable();
  echo _US_EMAILRESERVED;
  CloseTable();
  rcx_cp_footer();
  exit();
}


$edituser = new RcxUser($uid);
$edituser->setVar("name", $name);
$edituser->setVar("uname", $uname);
$edituser->setVar("address", $address);
$edituser->setVar("town", $town);
$edituser->setVar("zip_code", $zip_code);
$edituser->setVar("user_from", $user_from);
$edituser->setVar("phone", $phone);
$edituser->setVar("email", $email);
$edituser->setVar("url", formatURL($url));
$edituser->setVar("user_avatar", $user_avatar);
$edituser->setVar("user_icq", $user_icq);
$edituser->setVar("user_aim", $user_aim);
$edituser->setVar("user_yim", $user_yim);
$edituser->setVar("user_sig", $user_sig);
$edituser->setVar("user_viewemail", $user_viewemail);
$edituser->setVar("user_msnm", $user_msnm);
$edituser->setVar("attachsig", $attachsig);
$edituser->setVar("timezone_offset", $timezone_offset);
$edituser->setVar("language", $language);
$edituser->setVar("theme", $theme);
$edituser->setVar("uorder", $uorder);
$edituser->setVar("umode", $umode);
$edituser->setVar("bio", $bio);
$edituser->setVar("rank", $rank);
$edituser->setVar("user_occ", $user_occ);
$edituser->setVar("user_intrest", $user_intrest);

if ($pass2 != "") {
  if ($pass != $pass2) {
    rcx_cp_header();
    OpenTable();
    echo "<center>"._AM_STNPDNM."</center>";
    CloseTable();
    rcx_cp_footer();
    exit();
  }
  $salt = substr(md5(rand()), 0, 4);
  $edituser->setVar('pwdsalt', $salt);
  $suname = strtolower($uname);
  $shapwd = rc_shatool($suname.$pass);
  $edituser->setVar("pass", $shapwd);
}

  if (!$edituser->store())
  {
    rcx_cp_header();
    OpenTable();
    echo $editusers->getErrors();
    CloseTable();
    rcx_cp_footer();
  } else
  {
/*  $session = new RcxUserSession();
    $session->setUid($uid);
    $session->setUname($uname);
    $session->setPass($edituser->getVar('pass'));
    $session->setSalt($edituser->getVar('pwdsalt'));
    if (!$session->store())
   


{
    redirect_header("admin.php?fct=users",1,_UPDATED);

      exit();
    }
      redirect_header("../../index.php", 1, _NOTUPDATED);
  }
*/


/*} else {*/
		redirect_header("admin.php?fct=users",1,_UPDATED);
	}



exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function synchronize($id, $type) {
global $db;

switch($type) {
  case 'user':
    $tables = array("comments","rcxpollcomments");
    $total_posts = 0;
    $sql = "SELECT COUNT(*) AS total FROM ".$db->prefix("bb_posts")." WHERE uid=$id";
    if ($result = $db->query($sql)) {
      if($row = $db->fetch_array($result)) {
          $total_posts = $total_posts + $row['total'];
        }
      }
    foreach ($tables as $table) {
      $sql = "SELECT COUNT(*) AS total FROM ".$db->prefix($table)." WHERE user_id=$id";
      if ( $result = $db->query($sql) ) {
        if ($row = $db->fetch_array($result)) {
          $total_posts = $total_posts + $row['total'];
        }
      }
    }
    $sql = "UPDATE ".$db->prefix("users")." SET posts=$total_posts WHERE uid=$id";
    if (!$result = $db->query($sql)) {
      die(sprintf(_AM_CNUUSER %s ,$id));
    }
    break;

  case 'all users':
    $sql = "SELECT uid FROM ".$db->prefix("users")."";
    if (!$result = $db->query($sql)) {
      die(_AM_CNGUSERID);
    }
    while ($row = $db->fetch_array($result)) {
      $id = $row['uid'];
      synchronize($id, "user");
    }
    break;
}

redirect_header("admin.php?fct=users&op=modifyUser&uid=".$id."", 1, _UPDATED);
exit();
}
  } else {
    echo "Access Denied";
  }
?>
