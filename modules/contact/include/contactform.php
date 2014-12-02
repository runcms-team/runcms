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

include_once(RCX_ROOT_PATH.'/class/rcxformloader.php');

$mail_firma     = new RcxFormText(_CT_COMPANY, 'bill_firma', 25, 60, $bill_firma);
$mail_adresse    = new RcxFormText(_CT_LOCATION.'*', 'bill_adresse', 30, 60, $bill_adresse); // olsen
$mail_postnr     = new RcxFormText(_CT_POSTNR.'*', 'bill_postnr', 4, 5, $bill_postnr); // olsen
$mail_by     = new RcxFormText(_CT_BY.'*', 'bill_by', 30, 60, $bill_by); // olsen

$mail_nummer      = new rcxFormText(_CT_TLF.'*', 'tlf_nummer', 8, 12, $tlf_nummer);
$mail_url         = new RcxFormText(_CT_URL, 'user_url', 30, 255, $user_url);

$mail_im  = new RcxFormElementTray(_CT_IM, '&nbsp;');
$mail_im1 = new RcxFormSelect('', 'user_im', $user_im);
$mail_im1->addOptionArray(array('MSN'=> _CT_MSN,'ICQ'=> _CT_ICQ, 'Other'=> _CT_OTHER));
$mail_im2 = new RcxFormText('', 'user_im_details', 30, 60, $user_im_details);
$mail_im->addElement($mail_im1);
$mail_im->addElement($mail_im2);

$mail_name        = new RcxFormText(_CT_NAME.'*', 'user_name', 30, 60, $user_name);
$mail_email       = new RcxFormText(_CT_EMAIL.'*', 'user_email', 30, 60, $user_email);

$reasonArray = explode('|', $contact_reason);
if (count($reasonArray) > 1) {
  $mail_reason  = new RcxFormSelect(_CT_REASON.'*', 'contact_reason');

  foreach ($reasonArray as $key) {
    $contact_array[$key] = $key;
  }
  $mail_reason->addOptionArray($contact_array);
  } else {
    $mail_reason = new RcxFormText(_CT_REASON.'*', 'contact_reason', 50, 60, $contact_reason);
  }


$mail_comments   = new RcxFormTextArea(_CT_COMMENTS.'*', 'user_comments', $user_comments,10,70);

$mail_options  = new RcxFormElementTray(_CT_OPTIONS, '&nbsp;');
$mail_reciept  = new RcxFormCheckBox(_CT_RECIEPT, 'mail_reciept', 1);
$mail_reciept->addOption(1, '&nbsp;');
$mail_priority = new RcxFormSelect(_CT_PRIORITY, 'mail_priority', 3);
$mail_priority->addOptionArray(array(1 => _CT_MAILP1, 2 => _CT_MAILP2, 3 => _CT_MAILP3, 4 => _CT_MAILP4, 5 => _CT_MAILP5));
$mail_options->addElement($mail_reciept);
$mail_options->addElement($mail_priority);

$mail_attachment  = new RcxFormElementTray(_CT_ATTACH, '&nbsp;');
$mail_file1 = new RcxFormFile('', 'mail_attachment', intval($contactConfig['max_file_size']));
$mail_file2 = new RcxFormLabel('<br />'.$contactConfig['max_file_size']." "._BYTES." "._MAX." (".$contactConfig['allowed_extensions'].")", '');
$mail_attachment->addElement($mail_file1);
$mail_attachment->addElement($mail_file2);

$mail_op     = new RcxFormHidden('op', 'contact');
$mail_submit = new RcxFormButton('', 'submit', _SUBMIT, 'submit');

// ------------------------ //

$contact_form = new RcxThemeForm(_CT_CONTACT, 'contact', 'index.php');
$contact_form->setExtra("enctype='multipart/form-data'");

/*
$contact_form->addElement($mail_im);
*/

$contact_form->addElement($mail_name);
$contact_form->addElement($mail_firma);
$contact_form->addElement($mail_adresse); // olsen
$contact_form->addElement($mail_postnr); // olsen
$contact_form->addElement($mail_by); // olsen
$contact_form->addElement($mail_nummer);
$contact_form->addElement($mail_email);
$contact_form->addElement($mail_url);

$contact_form->addElement($mail_reason);
$contact_form->addElement($mail_comments);


$contact_form->addElement($mail_options);

if ($contactConfig['allow_attachment']) {
  if ($rcxUser || $contactConfig['annon_attachment']) {
    $contact_form->addElement($mail_attachment);
  }
}

// begin CAPTCHA hack by SVL
if ((int)$contactConfig['use_captcha'] == 1 && !$rcxUser)
{
  session_start();
  $capexplain = new RcxFormLabel('', _INTERCAPKEY);
  $capexplain->setColspan();
  $captcha = new RcxFormLabel('<img src="'.RCX_URL.'/class/kcaptcha/kcaptcha.php?'.session_name().'='.session_id().'">', '<input type="text" name="keystring">');

  $contact_form->addElement($capexplain);
  $contact_form->addElement($captcha);
}
// end hack
$contact_form->addElement($mail_op);
$contact_form->addElement($mail_submit);

$contact_form->setRequired(array('user_name', 'user_email', 'contact_reason', 'user_comments'));
///'bill_by', 'bill_postnr', 'bill_adresse','tlf_nummer', 
$contact_form->display();
?>