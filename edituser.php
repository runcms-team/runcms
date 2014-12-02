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

include_once('./mainfile.php');
include_once(RCX_ROOT_PATH.'/class/rcxformloader.php');

// If not a user, redirect
if ( !$rcxUser ) {
  redirect_header('index.php', 3, _NOPERM);
  exit();
}

// initialize $op variable
$op = 'editprofile';

// if GET/POST is set, change $op
if ( isset($_POST['op']) ) {
  $op =  $_POST['op'];
  } elseif ( isset($_GET['op']) ) {
    $op =  $_GET['op'];
  }

if ( $op == 'editprofile' ) {
  include_once('header.php');
  OpenTable();
  echo "<a href='userinfo.php?uid=".$rcxUser->getVar("uid")."'>". _US_PROFILE ."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;". _US_EDITPROFILE ."<br /><br />";
  $form        = new RcxThemeForm(_US_EDITPROFILE, "userinfo", "edituser.php", "post", true);
  $uname_label = new RcxFormLabel(_US_NICKNAME, $rcxUser->getVar("uname"));
  $form->addElement($uname_label);
  $name_text = new RcxFormText(_US_REALNAME, "name", 30, 60, $rcxUser->getVar("name", "E"));
  $form->addElement($name_text);
        $address_text = new RcxFormText(_US_ADDRESS,"address", 30, 50, $rcxUser->getVar("address"));
        $form->addElement($address_text);
        $zipcode_text = new RcxFormText(_US_ZIP_CODE, "zip_code", 7, 7, $rcxUser->getVar("zip_code"));
        $form->addElement($zipcode_text);
        $city_text = new RcxFormText(_US_TOWN, "town", 20, 30, $rcxUser->getVar("town"));
        $form->addElement($city_text);
	$location_text   = new RcxFormText(_US_LOCATION, "user_from", 30, 100, $rcxUser->getVar("user_from", "E"));
	$form->addElement($location_text);
        $telephone_text = new RcxFormText(_US_TELEPHONE, "phone", 14, 14, $rcxUser->getVar("phone"));
	$form->addElement($telephone_text);
        $baa = $rcxUser->getVar("birthday");
	$bday = substr($baa,0,2);
	$bmonth = substr($baa,2,2);
	$birthday_tray = new RcxFormElementTray(_US_BIRTHDAY .'<br />');
	$birthday_text = new RcxFormText(_US_DAY, "birthday", 2, 2, $bday, "E");
	$birthday1_text = new RcxFormText(_US_MONTH, "birthmonth", 2, 2, $bmonth, "E");
	$birthday2_text = new RcxFormText(_US_YEAR, "birthyear", 4, 4, $rcxUser->getVar("birthyear", "E"));
	$birthday_tray->addElement($birthday_text);
	$birthday_tray->addElement($birthday1_text);
	$birthday_tray->addElement($birthday2_text);
	$form->addElement($birthday_tray);

  $email_tray = new RcxFormElementTray(_US_EMAIL, '<br />');
  $email_text = new RcxFormText('', 'email', 30, 60, $rcxUser->getVar('email', 'E'));
  $email_tray->addElement($email_text);
  $email_cbox_value = $rcxUser->user_viewemail() ? 1 : 0;
  $email_cbox       = new RcxFormCheckBox('', 'user_viewemail', $email_cbox_value);
  $email_cbox->addOption(1, _US_ALLOWVIEWEMAIL);
  $email_tray->addElement($email_cbox);
  $form->addElement($email_tray);
  $url_text = new RcxFormText(_US_WEBSITE, 'url', 30, 100, $rcxUser->getVar('url', 'E'));
  $form->addElement($url_text);
  $avatar_array  =& RcxLists::getImgListAsArray(RCX_ROOT_PATH.'/images/avatar/');
  $avatar_select = new RcxFormSelect('', 'user_avatar', $rcxUser->getVar('user_avatar'));
  $avatar_select->addOptionArray($avatar_array);
  $a_dirlist      =& RcxLists::getDirListAsArray(RCX_ROOT_PATH.'/images/avatar/');
  $a_dir_labels   = array();
  $a_count        = 0;
  $a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;start=".$a_count."','avatars',600,400);\">AVATAR</a>";
  $a_count        = $a_count + count($avatar_array);
  $a_dir_labels[] = new RcxFormLabel('', $a_dir_link);

  foreach ($a_dirlist as $a_dir) {
    if ( $a_dir == 'users' ) {
      continue;
    }
    $avatars_array =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/".$a_dir."/", $a_dir."/");
    $avatar_select->addOptionArray($avatars_array);
    $a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;subdir=".$a_dir."&amp;start=".$a_count."','avatars',600,400);\">".$a_dir."</a>";
    $a_dir_labels[] = new RcxFormLabel("", $a_dir_link);
    $a_count        = $a_count + count($avatars_array);
  }

  if ( $rcxConfig['avatar_allow_upload'] == 1 ) {
    $myavatar = avatarExists($rcxUser->getVar("uid"));
    if ( $myavatar != false ) {
      $avatar_select->addOption($myavatar, _US_MYAVATAR);
    }
  }

  $avatar_select->setExtra("onchange='showImgSelected(\"avatar\", \"user_avatar\", \"images/avatar\")'");
  $avatar_label = new RcxFormLabel("", "<img src='images/avatar/".$rcxUser->getVar("user_avatar", "E")."' name='avatar' id='avatar' alt='' />");
  $avatar_tray  = new RcxFormElementTray(_US_AVATAR, "&nbsp;");
  $avatar_tray->addElement($avatar_select);
  $avatar_tray->addElement($avatar_label);
  foreach ($a_dir_labels as $a_dir_label) {
    $avatar_tray->addElement($a_dir_label);
  }
  $form->addElement($avatar_tray);

  if ( $rcxConfig['allow_theme'] == 1 ) {
    $temp         = $rcxUser->getVar("theme");
    $usertheme    = empty($temp) ? $rcxConfig['default_theme'] : $temp;
    $theme_select = new RcxFormSelectTheme(_US_THEME, "theme", $usertheme);
    $form->addElement($theme_select);
  }

  $timezone_select = new RcxFormSelectTimezone(_US_TIMEZONE, "timezone_offset", $rcxUser->getVar("timezone_offset"));

  $lang_select     = new RcxFormSelectLang(_US_LNG, "language", $rcxUser->getVar("language"));
  $icq_text        = new RcxFormText(_US_ICQ, "user_icq", 30, 100, $rcxUser->getVar("user_icq", "E"));
   $msnm_text       = new RcxFormText(_US_MSNM, "user_msnm", 30, 100, $rcxUser->getVar("user_msnm", "E"));
   $aim_text        = new RcxFormText(_US_AIM, "user_aim", 30, 100, $rcxUser->getVar("user_aim", "E"));
  $yim_text        = new RcxFormText(_US_YIM, "user_yim", 30, 100, $rcxUser->getVar("user_yim", "E"));
  $occupation_text = new RcxFormText(_US_OCCUPATION, "user_occ", 30, 100, $rcxUser->getVar("user_occ", "E"));
  $interest_text   = new RcxFormText(_US_INTEREST, "user_intrest", 30, 100, $rcxUser->getVar("user_intrest", "E"));
  $sig_tray        = new RcxFormElementTray(_US_SIGNATURE, "<br />");
  $sig_tarea       = new RcxFormDhtmlTextArea('', 'user_sig', $rcxUser->getVar('user_sig', 'E'));
  $sig_tray->addElement($sig_tarea);
  $sig_cbox_value = $rcxUser->getVar("attachsig") ? 1 : 0;
  $sig_cbox       = new RcxFormCheckBox("", "attachsig", $sig_cbox_value);
  $sig_cbox->addOption(1, _US_SHOWSIG);
  $sig_tray->addElement($sig_cbox);
  $umode_select = new RcxFormSelect(_US_CDISPLAYMODE, "umode", $rcxUser->getVar("umode"));
  $umode_select->addOptionArray(array("0"=>_NOCOMMENTS, "flat"=>_FLAT, "thread"=>_THREADED));
  $uorder_select = new RcxFormSelect(_US_CSORTORDER, "uorder", $rcxUser->getVar("uorder"));
  $uorder_select->addOptionArray(array("0"=>_OLDESTFIRST, "1"=>_NEWESTFIRST));
  $bio_tarea          = new RcxFormTextArea(_US_EXTRAINFO, "bio", $rcxUser->getVar("bio", "E"));
  $cookie_radio_value = empty($_COOKIE[$rcxConfig['cookie_name']]) ? 0 : 1;
  $cookie_radio       = new RcxFormRadioYN(_US_USECOOKIE, "usecookie", $cookie_radio_value, _YES, _NO);
  $oldpass           = new RcxFormPassword(_US_OLDPASSWORD, "oldpass", 10, 20);
  $pwd_text           = new RcxFormPassword(_US_NEWPASSWORD, "upass", 10, 20);
  $pwd_text2          = new RcxFormPassword(_US_VERIFYPASS, "vpass", 10, 20);
  $pwd_tray           = new RcxFormElementTray(_US_PASSWORD."<br />"._US_TYPEPASSTWICE, '<br /><br />');
  $pwd_tray->addElement($oldpass);
  $pwd_tray->addElement($pwd_text);
  $pwd_tray->addElement($pwd_text2);
  $mailok_radio  = new RcxFormRadioYN(_US_MAILOK, 'user_mailok', $rcxUser->getVar('user_mailok'));
  $uid_hidden    = new RcxFormHidden("uid", $rcxUser->getVar("uid"));
  $op_hidden     = new RcxFormHidden("op", "saveuser");
  $submit_button = new RcxFormButton("", "submit", _SAVE, "submit");

  $form->addElement($timezone_select);
  $form->addElement($lang_select);
  $form->addElement($icq_text);
  $form->addElement($aim_text);
  $form->addElement($yim_text);
 $form->addElement($msnm_text);
  $form->addElement($occupation_text);
  $form->addElement($interest_text);
  $form->addElement($sig_tray);
  $form->addElement($umode_select);
  $form->addElement($uorder_select);
  $form->addElement($bio_tarea);
  $form->addElement($pwd_tray);
  $form->addElement($cookie_radio);
  $form->addElement($mailok_radio);
  $form->addElement($uid_hidden);
  $form->addElement($op_hidden);
  $form->addElement($submit_button);
  $form->setRequired('email');
  $form->display();
  CloseTable();
  include_once('footer.php');
}

if ( $op == 'saveuser' ) {
    
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header('userinfo.php?uid=' . $uid, 3, $rcx_token->getErrors(true));
      exit();
  }    
    
$uid = $_POST['uid'];
$url = $_POST['url'];
$user_avatar = $_POST['user_avatar'];
$oldpass = $_POST['oldpass'];
$upass = $_POST['upass'];
$vpass = $_POST['vpass'];
$name = $_POST['name'];
$adress = $_POST['adress'];
$zip_code = $_POST['zip_code'];
$town = $_POST['town'];
$phone = $_POST['phone'];
$user_icq = $_POST['user_icq'];
$user_from = $_POST['user_from'];
$user_sig = $_POST['user_sig'];
$user_viewemail = $_POST['user_viewemail'];
$user_aim = $_POST['user_aim'];
$user_yim = $_POST['user_yim'];
$user_msnm = $_POST['user_msnm'];
$attachsig = $_POST['attachsig'];
$timezone_offset = $_POST['timezone_offset'];
$theme = $_POST['theme'];
$uorder = $_POST['uorder'];
$umode = $_POST['umode'];
$bio = $_POST['bio'];
$user_occ = $_POST['user_occ'];
$user_intrest = $_POST['user_intrest'];
$user_mailok = $_POST['user_mailok'];
$language = $_POST['language'];
$usecookie = $_POST['usecookie'];

  if ( $rcxUser->getVar('uid') != $uid ) {
    redirect_header('index.php', 3, _NOACTION);
    exit();
  }

  $email = $myts->oopsStripSlashesGPC(trim($_POST['email']));
  if ( (!$email) || ($email=='') || (!checkEmail($email)) ) {
    include_once('header.php');
    OpenTable();
    echo _US_INVALIDMAIL.'<br />';
    CloseTable();
    include_once('footer.php');
    exit();
  }

  if ( !empty($rcxBadEmails) && hasMatch($rcxBadEmails, $email) ) {
    include_once('header.php');
    OpenTable();
    echo _US_EMAILRESERVED;
    CloseTable();
    include_once('footer.php');
    exit();

  }

  if ( $user_avatar != '' ) {
    if (substr($user_avatar, 0, 6) == 'users/') {
      if ( $myts->oopsStripSlashesGPC(trim($user_avatar)) != avatarExists($rcxUser->getVar("uid")) ) {
        $user_avatar = '';
      }
    }
  }

  if (isset($upass)) {
    $upass = trim($upass);
  }

  if (isset($vpass)) {
    $vpass = trim($vpass);
  }
  
  if (isset($oldpass)) {
    $oldpass = trim($oldpass);
  }

  if ((isset($upass)) && ($upass != $vpass)) {
    include_once('header.php');
    OpenTable();
    echo _US_PASSNOTSAME;
    CloseTable();
    include_once('footer.php');
    } elseif ( ($upass != '') && (strlen($upass) < $rcxConfig['minpass']) ) {
      include_once('header.php');
      OpenTable();
      printf(_US_PWDTOOSHORT, $rcxConfig['minpass']);
      CloseTable();
      include_once('footer.php');
      } else {
        $edituser = new RcxUser($uid);
        $edituser->setVar('name', $name);
				// new stuff
				if (strlen($birthday) == 1 ){
				$birthday = '0'.$birthday;}
				if (strlen($birthmonth) == 1 ){
				$birthmonth = '0'.$birthmonth;}
				$birthday = $birthday.$birthmonth;
				$edituser->setVar('birthday', $birthday);
				$edituser->setVar('birthyear', $birthyear);
				$edituser->setVar('address',$address);
                $edituser->setVar('zip_code',$zip_code);
                $edituser->setVar('town',$town);
				$edituser->setVar("phone",$phone);
			

        $edituser->setVar('email', $email);
        $edituser->setVar('url', formatURL($url));
        $edituser->setVar('user_avatar', $user_avatar);
        $edituser->setVar('user_icq', $user_icq);
        $edituser->setVar('user_from', $user_from);
        $edituser->setVar('user_sig', $user_sig);
        $edituser->setVar('user_viewemail', $user_viewemail);
        $edituser->setVar('user_aim', $user_aim);
        $edituser->setVar('user_yim', $user_yim);
        $edituser->setVar('user_msnm', $user_msnm);

        if (isset($upass) && $upass != '')
        {
            $sname = strtolower($edituser->getVar('uname'));
            
            if (rc_shatool($sname.$oldpass) != $edituser->getVar('pass')) {
            	    include_once('header.php');
            	    OpenTable();
            	    echo _US_WRONGPASSWORD;
            	    CloseTable();
            	    include_once('footer.php');
            	    exit();
            }
          
          $salt = substr(md5(rand()), 0, 4);
          $edituser->setVar('pwdsalt', $salt);
          
          $shapwd = rc_shatool($sname.$upass);
          $edituser->setVar('pass', $shapwd);
        }

        $edituser->setVar('attachsig', $attachsig);
        $edituser->setVar('timezone_offset', $timezone_offset);

        if (!empty($theme) && $rcxConfig['allow_theme'] == 1) {
          $edituser->setVar('theme', $theme);
        }

        $edituser->setVar('uorder', $uorder);
        $edituser->setVar('umode', $umode);
        $edituser->setVar('bio', $bio);
        $edituser->setVar('user_occ', $user_occ);
        $edituser->setVar('user_intrest', $user_intrest);
        $edituser->setVar('user_mailok', $user_mailok);
        $edituser->setVar('language', $language);

        if ($usecookie)
          cookie($rcxConfig['cookie_name'], $edituser->getVar('uname'), 31536000);
        else
          cookie($rcxConfig['cookie_name']);

        if (!$edituser->store())
        {
          include_once('header.php');
          echo $edituser->getErrors();
          include_once('footer.php');
        }
        else
        {
          $session = new RcxUserSession();
          $session->setUid($uid);
          $session->setUname($edituser->getVar('uname'));
          $session->setPass($edituser->getVar('pass'));
          $session->setSalt($edituser->getVar('pwdsalt'));
          if (!$session->store())
          {
            redirect_header("index.php", 1, _NOTUPDATED);
            exit();
          }
          redirect_header("userinfo.php?uid=".$uid."",1,_US_PROFUPDATED);
        }

        exit();
      }
}

if ( $op == 'avatarform' && $rcxConfig['avatar_allow_upload'] == 1 ) {
  include_once('header.php');
  OpenTable();
  echo "<a href='userinfo.php?uid=".$rcxUser->getVar("uid")."'>". _US_PROFILE ."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;". _US_UPLOADMYAVATAR ."<br /><br />";
  if ( $oldavatar = avatarExists($rcxUser->getVar("uid")) ) {
    echo "<div style='text-align:center;'><h4 style='color:#ff0000; font-weight:bold;'>"._US_OLDDELETED."</h4>";
    echo "<img src='".RCX_URL."/images/avatar/".$oldavatar."' /></div>";
  }
  $pixels_label  = new RcxFormLabel(_US_MAXPIXEL, $rcxConfig['avatar_width']." x ".$rcxConfig['avatar_height']);
  $size_label    = new RcxFormLabel(_US_MAXIMGSZ, $rcxConfig['avatar_maxsize']);
  $file_form     = new RcxFormFile(_US_SELFILE, 'avatarfile', $rcxConfig['avatar_maxsize']);
  $op_hidden     = new RcxFormHidden('op', 'avatarupload');
  $submit_button = new RcxFormButton('', 'submit', _SUBMIT, 'submit');
  $form          = new RcxThemeForm(_US_UPLOADMYAVATAR, 'uploadavatar', 'edituser.php', "post", true);
  $form->setExtra("enctype='multipart/form-data'");
  $form->setRequired('avatarfile');
  $form->addElement($pixels_label);
  $form->addElement($size_label);
  $form->addElement($file_form);
  $form->addElement($op_hidden);
  $form->addElement($submit_button);
  $form->display();
  CloseTable();
  include_once('footer.php');
}

if ( ($op == 'avatarupload') && ($rcxConfig['avatar_allow_upload'] == 1) ) {
  
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header('edituser.php?op=avatarform', 3, $rcx_token->getErrors(true));
      exit();
  } 
     
  include_once(RCX_ROOT_PATH . '/class/fileupload.php');
  $upload = new fileupload();
  $upload->set_upload_dir(RCX_ROOT_PATH . '/images/avatar/users', 'avatarfile');
  $upload->set_basename($rcxUser->uid(), 'avatarfile');
  $upload->set_accepted('gif|jpg|png', 'avatarfile');
  $upload->set_overwrite(2, 'avatarfile');
  $upload->set_max_image_height($rcxConfig['avatar_height'], 'avatarfile');
  $upload->set_max_image_width($rcxConfig['avatar_width']  , 'avatarfile');

  $result = $upload->upload();
  if ($result['avatarfile']['filename']) {
    $db->query("UPDATE ".RC_USERS_TBL." SET user_avatar='".avatarExists($rcxUser->getVar('uid'))."' WHERE uid=".$rcxUser->getVar("uid")."");
    redirect_header('user.php', 0);
    } else {
      include_once('header.php');
      OpenTable();
      echo $upload->errors();
      CloseTable();
      include_once('footer.php');
      exit();
    }
}
?>
