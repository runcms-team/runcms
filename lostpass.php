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

include_once("mainfile.php");

if (!isset($email) || $email == "") {
  redirect_header("user.php", 2, _US_SORRYNOTFOUND);
  exit();
  }

$getuser = RcxUser::getAllUsers(array("email='".$myts->oopsAddSlashesGPC($email)."'"), true);

if ( empty($getuser) ) {
  redirect_header("user.php", 2, _US_SORRYNOTFOUND);
  exit();
  } else {
    $areyou = substr($getuser[0]->getVar("pass"), 0, 5);
    if ( isset($code) && $areyou == $code ) {
      $newpass     = makepass();
      $rcxMailer =& getMailer();
      $rcxMailer->useMail();
      $rcxMailer->setTemplate("lostpass2.tpl");
      $rcxMailer->assign("SITENAME", $meta['title']);
      $rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
      $rcxMailer->assign("SITEURL", RCX_URL."/");
      $rcxMailer->assign("IP", _REMOTE_ADDR);
      $rcxMailer->assign("NEWPWD", $newpass);
      $rcxMailer->setToUsers($getuser[0]->getVar("uid"));
      $rcxMailer->setFromEmail($rcxConfig['adminmail']);
      $rcxMailer->setFromName($meta['title']);
      $rcxMailer->setSubject(sprintf(_US_NEWPWDREQ, RCX_URL));
      if ( !$rcxMailer->send() ) {
        echo $rcxMailer->getErrors();
      }
// Next step: add the new password to the database
$uname = strtolower($getuser[0]->getVar("uname"));
$cryptpass = rc_shatool($uname.$newpass);
$salt = substr(md5(rand()), 0, 4);
$query     = "UPDATE ".RC_USERS_TBL." SET pass='$cryptpass', pwdsalt='$salt' WHERE uid=".$getuser[0]->getVar("uid")."";

if ( !$db->query($query) ) {
  include_once("header.php");
  echo _US_MAILPWDNG;
  include_once("footer.php");
  exit();
}

redirect_header("user.php", 3, sprintf(_US_PWDMAILED, $getuser[0]->getVar("uname")));
exit();

// If no Code, send it
} else {
  $rcxMailer =& getMailer();
  $rcxMailer->useMail();
  if (!empty($_POST['actkey'])) {
    $rcxMailer->setTemplate("actkey.tpl");
    $rcxMailer->setSubject(sprintf(_US_USERKEYFOR, $uname));
    } else {
      $rcxMailer->setTemplate("lostpass1.tpl");
      $rcxMailer->assign("NEWPWD_LINK", RCX_URL."/lostpass.php?email=".$email."&code=".$areyou);
      $rcxMailer->setSubject(sprintf(_US_NEWPWDREQ, $meta['title']));
    }
  $rcxMailer->assign("SITENAME", $meta['title']);
  $rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
  $rcxMailer->assign("SITEURL", RCX_URL."/");
  $rcxMailer->assign("IP", _REMOTE_ADDR);
  $rcxMailer->setToUsers($getuser[0]->getVar("uid"));
  $rcxMailer->setFromEmail($rcxConfig['adminmail']);
  $rcxMailer->setFromName($meta['title']);
  include_once("header.php");
  if ( !$rcxMailer->send() ) {
    echo $rcxMailer->getErrors();
    }
  echo "<h4>";
  printf(_US_CONFMAIL, $getuser[0]->getVar("uname"));
  echo "</h4>";
  include_once("footer.php");
  }

}
?>
