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
if ( preg_match("/mailform\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

$form = new RcxThemeForm(_AM_SENDMTOUSERS, "mailusers", "admin.php?fct=mailusers", "post", true);
$form->setExtra("enctype='multipart/form-data'");

//  from finduser section
if (!empty($_POST['memberslist_id'])) {
  $user_count = count($_POST['memberslist_id']);
  $display_names = "";
  for ( $i=0; $i<$user_count; $i++) {
    $uid_hidden = new RcxFormHidden("mail_to_user[]", $_POST['memberslist_id'][$i]);
    $form->addElement($uid_hidden);
    $display_names .= "<a href='".RCX_URL."/userinfo.php?uid=".$_POST['memberslist_id'][$i]."' target='_blank'>".$_POST['memberslist_uname'][$_POST['memberslist_id'][$i]]."</a>, ";
  }
  $users_label = new RcxFormLabel(_AM_SENDTOUSERS2, substr($display_names, 0, -2));
  $form->addElement($users_label);
  $display_criteria = 0;
}

if ( !empty($display_criteria) ) {
  $group_select    = new RcxFormSelectGroup(_AM_GROUPIS."<br />", "mail_to_group", false, '----', 5, true);
  $group_select->addOption(0, '----');
  $lastlog_min     = new RcxFormText(_AM_LASTLOGMIN."<br />"._AM_TIMEFORMAT."<br />", "mail_lastlog_min", 20, 10);
  $lastlog_max     = new RcxFormText(_AM_LASTLOGMAX."<br />"._AM_TIMEFORMAT."<br />", "mail_lastlog_max", 20, 10);
  $regd_min        = new RcxFormText(_AM_REGDMIN."<br />"._AM_TIMEFORMAT."<br />", "mail_regd_min", 20, 10);
  $regd_max        = new RcxFormText(_AM_REGDMAX."<br />"._AM_TIMEFORMAT."<br />", "mail_regd_max", 20, 10);
  $idle_more       = new RcxFormText(_AM_IDLEMORE."<br />", "mail_idle_more", 10, 5);
  $idle_less       = new RcxFormText(_AM_IDLELESS."<br />", "mail_idle_less", 10, 5);

  $umail_ok         = new RcxFormCheckBox('', "mail_ok", 0);
  $umail_ok->addOption(1, _AM_MAILOK);

  $inactive_cbox   = new RcxFormCheckBox(_AM_INACTIVE."<br />", "mail_inactive");
  $inactive_cbox->addOption(1, _AMIFCHECKD);
  $inactive_cbox->setExtra("onclick='disableElement(\"mail_lastlog_min\"); disableElement(\"mail_lastlog_max\"); disableElement(\"mail_idle_more\"); disableElement(\"mail_idle_less\"); disableElement(\"mail_to_group\");'");

  $criteria_tray = new RcxFormElementTray(_AM_SENDTOUSERS, "<br /><br />");
  $criteria_tray->addElement($group_select);
  $criteria_tray->addElement($lastlog_min);
  $criteria_tray->addElement($lastlog_max);
  $criteria_tray->addElement($idle_more);
  $criteria_tray->addElement($idle_less);

  $criteria_tray->addElement($umail_ok);

  $criteria_tray->addElement($inactive_cbox);
  $criteria_tray->addElement($regd_min);
  $criteria_tray->addElement($regd_max);
  $form->addElement($criteria_tray);
}

$fname_text      = new RcxFormText(_AM_MAILFNAME, "mail_fromname", 30, 255, $meta['title']);
$fromemail       = !empty($rcxConfig['adminmail']) ? $rcxConfig['adminmail'] : $rcxUser->getVar("email", "E");
$femail_text     = new RcxFormText(_AM_MAILFMAIL, "mail_fromemail", 30, 255, $rcxUser->getVar("email", "E"));
$subject_caption = _AM_MAILSUBJECT."<br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_MAILTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_MAILTAGS2."</span>";

$subject_text    = new RcxFormText($subject_caption, "mail_subject", 100, 255);

if ($editorConfig['displayformailusers'] == 1)
{
  include_once(RCX_ROOT_PATH.'/class/eseditor/eseditor.php');
  $runESeditor = new ESeditor('mail_body');

  if ($runESeditor->IsCompatible())
  {
    $runESeditor->Width = "100%";    
    $runESeditor->BasePath = RCX_URL."/class/eseditor/";

    ob_start(); 
    $runESeditor->Config['FullPage'] = true;
    $runESeditor->Create();
    $body_caption    = _AM_MAILBODY."<br /><span style='font-size:x-small;font-weight:bold;'>"._AM_MAILTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_MAILTAGS1."<br />"._AM_MAILTAGS2."<br />"._AM_MAILTAGS3."<br />"._AM_MAILTAGS4."</span>";
    $body_cap        = new RcxFormLabel('', $body_caption);
    $body_cap->setColspan();
    $body_text       = new RcxFormLabel($body_caption, ob_get_contents());
    $body_text->setColspan();
    ob_end_clean();
    
    $mail_type = new RcxFormRadio(_AM_TYPE, "mail_type", "text/html");
    $mail_type->addOption("text/html", "HTML");
  }
  else
  {
    $mail_type = new RcxFormRadio(_AM_TYPE, "mail_type", "text/plain");
    $mail_type->addOption("text/plain", "TEXT");
    $mail_type->addOption("text/html", "HTML");
    $body_caption    = _AM_MAILBODY."<br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_MAILTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_MAILTAGS1."<br />"._AM_MAILTAGS2."<br />"._AM_MAILTAGS3."<br />"._AM_MAILTAGS4."</span>";
    $body_text       = new RcxFormDhtmlTextArea($body_caption, "mail_body", "", 10);
    $body_cap        = new RcxFormLabel();
    $body_cap->setColspan();
  }
} else {
  $mail_type = new RcxFormRadio(_AM_TYPE, "mail_type", "text/plain");
  $mail_type->addOption("text/plain", "TEXT");
  $mail_type->addOption("text/html", "HTML");
  $body_caption    = _AM_MAILBODY."<br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_MAILTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_MAILTAGS1."<br />"._AM_MAILTAGS2."<br />"._AM_MAILTAGS3."<br />"._AM_MAILTAGS4."</span>";
  $body_text       = new RcxFormDhtmlTextArea($body_caption, "mail_body", "", 10);
  $body_cap        = new RcxFormLabel();
  $body_cap->setColspan();
} 

$to_checkbox     = new RcxFormRadio(_AM_SENDTO, "mail_send_to", "mail");
$to_checkbox->addOption("mail", _AM_EMAIL);
$to_checkbox->addOption("pm", _AM_PM);

$to_emails = new RcxFormText(_AM_TOEMAILS, "mail_to_emails", 100, 255);
$priority  = new RcxFormSelect(_AM_PRIORITY, "mail_priority", 3);
$priority->addOptionArray(array(1 => '1 (Highest)', 2 => '2 (High)', 3 => '3 (Normal)', 4 => '4 (Low)', 5 => '5 (Lowest)'));

$reciept = new RcxFormCheckBox(_AM_RECIEPT, "mail_reciept", 0);
$reciept->addOption(1, _YES);

$file_select = new RcxFormElementTray(_AM_ATTACH);
$file_browse = new RcxFormFile('', 'attachment', 512000);
$file_inline = new RcxFormCheckBox('', "inline", 0);
$file_inline->addOption(1, _AM_INLINE);
$file_select->addElement($file_browse);
$file_select->addElement($file_inline);

$op_hidden     = new RcxFormHidden("op", "send");
$submit_button = new RcxFormButton("", "mail_submit", _SEND, "submit");

$form->addElement($to_emails);
$form->addElement($priority);
$form->addElement($mail_type);
$form->addElement($reciept);
$form->addElement($fname_text);
$form->addElement($femail_text);
$form->addElement($subject_text);
$form->addElement($body_cap);
$form->addElement($body_text);
$form->addElement($file_select);
$form->addElement($to_checkbox);
$form->addElement($op_hidden);
$form->addElement($submit_button);

if ($editorConfig['displayformailusers'] == 1)
  $form->setRequired(array("mail_subject", "mail_send_to"));
else
  $form->setRequired(array("mail_subject", "mail_body", "mail_send_to"));
?>
