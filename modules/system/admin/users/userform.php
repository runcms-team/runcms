<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

global $_SERVER;
if ( preg_match("/userform\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}

$uid_label  = new RcxFormLabel(_AM_USERID, $uid_value);
$uname_text = new RcxFormText(_AM_NICKNAME, "uname", 30, 60, $uname_value);
$name_text  = new RcxFormText(_AM_NAME, "name", 30, 60, $name_value);
$address_text = new RcxFormText(_US_ADDRESS, "address", 30, 50, $address_value);

$zipcode_text = new RcxFormText(_US_ZIP_CODE, "zip_code", 7, 7, $zip_code_value);
$city_text = new RcxFormText(_US_TOWN, "town", 20, 30, $town_value);

$location_text = new RcxFormText(_US_LOCATION, "user_from", 30, 100, $user_from_value);
$telephone_text = new RcxFormText(_US_TELEPHONE, "phone", 8, 12, $phone_value);


$email_tray = new RcxFormElementTray(_AM_EMAIL, "<br />");
$email_text = new RcxFormText("", "email", 30, 60, $email_value);
$email_tray->addElement($email_text);
$email_cbox = new RcxFormCheckBox("", "user_viewemail", $email_cbox_value);
$email_cbox->addOption(1, _AM_AOUTVTEAD);
$email_tray->addElement($email_cbox);
$url_text      = new RcxFormText(_AM_URL, "url", 30, 100, $url_value);
$avatar_select = new RcxFormSelect("", "user_avatar", $avatar_value);
$avatar_array  = RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/");
$avatar_select->addOptionArray($avatar_array);
$a_dirlist      = RcxLists::getDirListAsArray(RCX_ROOT_PATH."/images/avatar/");
$a_dir_labels   = array();
$a_count        = 0;
$a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;start=".$a_count."','avatars',600,400);\">BRUGER</a>";
$a_count        = $a_count + count($avatar_array);
$a_dir_labels[] = new RcxFormLabel("", $a_dir_link);

foreach ($a_dirlist as $a_dir) {
	if ( $a_dir == "users" ) {
		continue;
	}
	$avatars_array = RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/".$a_dir."/", $a_dir."/");
		$avatar_select->addOptionArray($avatars_array);
		$a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;subdir=".$a_dir."&amp;start=".$a_count."','avatars',600,400);\">".$a_dir."</a>";
		$a_dir_labels[] = new RcxFormLabel("", $a_dir_link);
		$a_count        = $a_count + count($avatars_array);
	}

if ( $rcxConfig['avatar_allow_upload'] == 1 && $uid_value != "" ) {
	$myavatar = avatarExists($uid_value);
	if ( $myavatar != false ) {
		$avatar_select->addOption($myavatar, _US_MYAVATAR);
	}
}

$avatar_select->setExtra("onchange='showImgSelected(\"avatar\", \"user_avatar\", \"images/avatar\")'");
$avatar_label = new RcxFormLabel("", "<img src='".RCX_URL."/images/avatar/".$avatar_value."' name='avatar' id='avatar' alt='' />");
$avatar_tray  = new RcxFormElementTray(_AM_AVATAR, "&nbsp;");
$avatar_tray->addElement($avatar_select);
$avatar_tray->addElement($avatar_label);

foreach ($a_dir_labels as $a_dir_label) {
	$avatar_tray->addElement($a_dir_label);
}

$theme_select    = new RcxFormSelectTheme(_AM_THEME, "theme", $theme_value);
$lang_select     = new RcxFormSelectLang(_US_LNG, "language", $lang_value);
$timezone_select = new RcxFormSelectTimezone(_US_TIMEZONE, "timezone_offset", $timezone_value);
$icq_text        = new RcxFormText(_AM_ICQ, "user_icq", 20, 20, $icq_value);
$aim_text        = new RcxFormText(_AM_AIM, "user_aim", 20, 20, $aim_value);
$yim_text        = new RcxFormText(_AM_YIM, "user_yim", 20, 20, $yim_value);

$msnm_text       = new RcxFormText(_AM_MSNM, "user_msnm", 20, 20, $msnm_value);
$occupation_text = new RcxFormText(_AM_OCCUPATION, "user_occ", 30, 100, $occ_value);
$interest_text   = new RcxFormText(_AM_INTEREST, "user_intrest", 30, 255, $interest_value);
$sig_tray        = new RcxFormElementTray(_AM_SIGNATURE, "<br />");
$sig_tarea       = new RcxFormTextArea("", "user_sig", $sig_value);
$sig_tray->addElement($sig_tarea);
$sig_cbox = new RcxFormCheckBox("", "attachsig", $sig_cbox_value);
$sig_cbox->addOption(1, _US_SHOWSIG);
$sig_tray->addElement($sig_cbox);
$umode_select = new RcxFormSelect(_US_CDISPLAYMODE, "umode", $umode_value);
$umode_select->addOptionArray(array("0"=>_NOCOMMENTS, "flat"=>_FLAT, "thread"=>_THREADED));
$uorder_select = new RcxFormSelect(_US_CSORTORDER, "uorder", $uorder_value);
$uorder_select->addOptionArray(array("0"=>_OLDESTFIRST, "1"=>_NEWESTFIRST));
$bio_tarea   = new RcxFormTextArea(_US_EXTRAINFO, "bio", $bio_value);
$rank_select = new RcxFormSelect(_AM_RANK, "rank", $rank_value);
$ranklist    = RcxLists::getUserRankList();

if ( count($ranklist) > 0 ) {
	$rank_select->addOption(0, _AM_NSRA);
	$rank_select->addOption(0, "--------------");
	$rank_select->addOptionArray($ranklist);
	} else {
		$rank_select->addOption(0, _AM_NSRID);
	}

$pwd_text      = new RcxFormPassword(_AM_PASSWORD, "pass", 10, 20);
$pwd_text2     = new RcxFormPassword(_AM_RETYPEPD, "pass2", 10, 20);
$fct_hidden    = new RcxFormHidden("fct", "users");
$op_hidden     = new RcxFormHidden("op", $op_value);
$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");

$form = new RcxThemeForm('', "userinfo", "admin.php", "post", true);
$form->addElement($uname_text);
$form->addElement($name_text);
$form->addElement($address_text);
$form->addElement($zipcode_text);
$form->addElement($city_text);
$form->addElement($location_text);
$form->addElement($telephone_text);
$form->addElement($email_tray);
$form->addElement($url_text);
$form->addElement($avatar_tray);
$form->addElement($theme_select);
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
$form->addElement($rank_select);
$form->addElement($pwd_text);
$form->addElement($pwd_text2);
$form->addElement($fct_hidden);
$form->addElement($op_hidden);
$form->addElement($submit_button);

if ( !empty($uid_value) ) {
	$uid_hidden = new RcxFormHidden("uid", $uid_value);
	$form->addElement($uid_hidden);
	$form->setRequired(array("uname", "email"));
	} else {
		$form->setRequired(array("uname", "email", "pass", "pass2"));
	}
echo '<div class="KPstor" >'.$form_title.'</div><br /><br />';
$form->display();
//echo '</div><br><br>';
?>
