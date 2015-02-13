<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

defined('RCX_ROOT_PATH') or die('Restricted access');

include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
// initialize form vars
$uname           = isset($_POST['uname'])           ? $myts->makeTboxData4PreviewInForm($_POST['uname']) : "";
$name            = isset($_POST['name'])            ? $myts->makeTboxData4PreviewInForm($_POST['name']) : "";
$address         = isset($_POST['address'])         ? $myts->makeTboxData4PreviewInForm($_POST['address']) : "";
$zip_code        = isset($_POST['zip_code'])        ? $myts->makeTboxData4PreviewInForm($_POST['zip_code']) : "";
$town            = isset($_POST['town'])            ? $myts->makeTboxData4PreviewInForm($_POST['town']) : "";
$user_from       = isset($_POST['user_from'])       ? $myts->makeTboxData4PreviewInForm($_POST['user_from']) : "";
$phone           = isset($_POST['phone'])           ? $myts->makeTboxData4PreviewInForm($_POST['phone']) : "";
$email           = isset($_POST['email'])           ? $myts->makeTboxData4PreviewInForm($_POST['email']) : "";
$user_viewemail  = isset($_POST['user_viewemail'])  ? $_POST['user_viewemail']                           : "";
$url             = isset($_POST['url'])             ? $myts->makeTboxData4PreviewInForm($_POST['url'])   : "";
$timezone_offset = isset($_POST['timezone_offset']) ? $_POST['timezone_offset']                          : "";
$user_avatar     = isset($_POST['user_avatar'])     ? $_POST['user_avatar']                              : "blank.gif";
$nickname_text = new RcxFormText(_US_NICKNAME, "uname", 26, 25, $uname);
$name_text = new RcxFormText(_US_REALNAME, "name", 30, 60, $name);
$address_text = new RcxFormText(_US_ADDRESS, "address", 30, 50, $address);
$zipcode_text = new RcxFormText(_US_ZIP_CODE, "zip_code", 7, 7, $zip_code);
$city_text = new RcxFormText(_US_TOWN, "town", 20, 30, $town);
$location_text = new RcxFormText(_US_LOCATION, "user_from", 30, 100, $user_from);
$telephone_text = new RcxFormText(_US_TELEPHONE, "phone", 8, 12, $phone);
$email_tray   = new RcxFormElementTray(_US_EMAIL, "<br />");
$email_text   = new RcxFormText("", "email", 25, 60, $email);
$email_option = new RcxFormCheckBox("", "user_viewemail", $user_viewemail);
$email_option->addOption(1, _US_ALLOWVIEWEMAIL);
$email_tray->addElement($email_text);
$email_tray->addElement($email_option);
$url_text = new RcxFormText(_US_WEBSITE, "url", 26, 255, $url);
$selected = ($timezone_offset != "") ? $timezone_offset : $rcxConfig['default_TZ'];
$timezone_select = new RcxFormSelectTimezone(_US_TIMEZONE, "timezone_offset", $selected);
$lang_select     = new RcxFormSelectLang(_US_LNG, "language", $rcxConfig['language']);
$avatar_select   = new RcxFormSelect("", "user_avatar", $user_avatar);
$avatar_array    =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/");
$avatar_select->addOptionArray($avatar_array);
$a_dirlist      =& RcxLists::getDirListAsArray(RCX_ROOT_PATH."/images/avatar/");
$a_dir_labels   = array();
$a_count        = 0;
$a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;start=".$a_count."','avatars',600,400);\">USER</a>";
$a_count        = $a_count + count($avatar_array);
$a_dir_labels[] = new RcxFormLabel("", $a_dir_link);
foreach ($a_dirlist as $a_dir)
{
  if ($a_dir == "users")
    continue;
  $avatars_array =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/".$a_dir."/", $a_dir."/");
  $avatar_select->addOptionArray($avatars_array);
  $a_dir_link     = "<a href=\"javascript:openWithSelfMain('".RCX_URL."/misc.php?action=showpopups&amp;type=avatars&amp;subdir=".$a_dir."&amp;start=".$a_count."','avatars',600,400);\">".$a_dir."</a>";
  $a_dir_labels[] = new RcxFormLabel("", $a_dir_link);
  $a_count        = $a_count + count($avatars_array);
}
$avatar_select->setExtra("onchange='showImgSelected(\"avatar\", \"user_avatar\", \"images/avatar\")'");
$avatar_label = new RcxFormLabel("", "<img src='images/avatar/blank.gif' name='avatar' id='avatar' alt='' />");
$avatar_tray  = new RcxFormElementTray(_US_AVATAR, "&nbsp;");
$avatar_tray->addElement($avatar_select);
$avatar_tray->addElement($avatar_label);
foreach ($a_dir_labels as $a_dir_label) {
  $avatar_tray->addElement($a_dir_label);
}
$pwd_text      = new RcxFormPassword(_US_PASSWORD  , "passw" , 26, 20);
$pwd_text2     = new RcxFormPassword(_US_VERIFYPASS, "vpassw", 26, 20);
$mailok_radio  = new RcxFormRadioYN(_US_MAILOK, 'user_mailok', 1);
$img_verify    = 0;
/* added  
*/
$zonetexta2 = join('', file(RCX_ROOT_PATH."/modules/system/cache/disclaimer.php"));
//$zonetexta2 = _DS_DISC2;
/* slut */
$op_hidden     = new RcxFormHidden("op", "newuser");
/* added */
$zonetext = new RcxFormTextArea(_US_USERDISC,"zonetext","$zonetexta2",30,80);
/* slut */
$submit_button = new RcxFormButton(_US_AGREE, "submit", _SUBMIT, "submit");
$reg_form      = new RcxThemeForm(_US_USERREG, "userinfo", "register.php", "POST", true);
$reg_form->addElement($nickname_text);
$reg_form->addElement($name_text);
$reg_form->addElement($address_text);
$reg_form->addElement($zipcode_text);
$reg_form->addElement($city_text);
$reg_form->addElement($location_text);
$reg_form->addElement($telephone_text);
$reg_form->addElement($email_tray);
$reg_form->addElement($url_text);
//$reg_form->addElement($timezone_select);
$reg_form->addElement($lang_select);
$reg_form->addElement($avatar_tray);
$reg_form->addElement($pwd_text);
$reg_form->addElement($pwd_text2);
/* added */
$reg_form->addElement($zonetext);
/* slut */
$reg_form->addElement($mailok_radio);
  // begin CAPTCHA hack by SVL
if ((int)$rcxConfig['img_verify'] == 1 && !$rcxUser)
{
  session_start();
  $capexplain = new RcxFormLabel('', _INTERCAPKEY);
  $capexplain->setColspan();
  $captcha = new RcxFormLabel('<img src="'.RCX_URL.'/class/kcaptcha/kcaptcha.php?'.session_name().'='.session_id().'" />', '<input type="text" name="keystring" />');
  $reg_form->addElement($capexplain);
  $reg_form->addElement($captcha);
}
// end hack

// start tcaptcha hack by LARK (http://www.runcms.ru)

if ($tcaptcha['use_tc'] == 1 && !$rcxUser) {

    $qq = preg_split('/[\n\r]+/', trim(stripslashes($tcaptcha['tc_qq'])));
    $q_id = array_rand($qq);
    $question = array_shift(explode('|', $qq[$q_id]));
    
    $tcaptcha_tray  = new RcxFormElementTray(_US_ANSWERTHEQUESTION, "<br /><br />");
    $tcaptcha_tray->addElement(new RcxFormLabel($question));
    $tcaptcha_tray->addElement(new RcxFormText('', 'tc_ans', 30, 60, ''));

    $reg_form->addElement($tcaptcha_tray);
    $reg_form->addElement(new RcxFormHidden("q_id", $q_id));

}

// end tcaptcha hack

$required = array("uname", "email", "passw", "vpassw");
$reg_form->addElement($op_hidden);
$reg_form->addElement($submit_button);
$reg_form->setRequired($required);
?>