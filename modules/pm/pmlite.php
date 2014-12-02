<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('header.php');
include_once('class/pm.class.php');
include_once(RCX_ROOT_PATH."/class/fileupload.php");
include_once(RCX_ROOT_PATH.'/class/rcxmailer.php');
include_once('cache/config.php');

Global $rcxUser;

if ($_POST['msg_replay'] == 1) {
        $pm = new PM(intval($_POST['msg_id1']));
      $pm->setReplay();
      //$msg_id = 0;
    }

if ($_POST['submit']) {
    $op = "submit";
}
if ($_POST['preview']) {
    $op = "preview";
}

$to_userid = !empty($_POST['to_userid']) ? $_POST['to_userid'] : $_GET['to_userid'];
$to_userid = intval($to_userid);// patch by Hamid Ebadi (hamid Network Security Team)
$send = $_POST['send'];

$pm = new PM();
$pm_arr =& PM::getAllPM(array("to_userid='".$to_userid."'"), true);
$total_pm = count($pm_arr);

if ( !empty($pmConfig['max_pms']) && ($total_pm >= intval($pmConfig['max_pms'])) ) {
  redirect_header('index.php', 2, _PM_FULL);
  exit();
}
$pm = new PM();
$pm_arr1 =& PM::getAllPM(array("to_userid='".$rcxUser->getVar("uid")."'"), true);
$total_pm1 = count($pm_arr1);

if ( !empty($pmConfig['max_pms']) && ($total_pm1 >= intval($pmConfig['max_pms'])) ) {
  redirect_header('index.php', 2, _PM_FULL1);
  exit();
}

$upload = new fileupload();
// ------------------------------------------------------------------------- //

$reply     = !empty($_GET['reply'])     ? 1 : 0;
$msg_id    = !empty($_GET['msg_id'])    ? intval($_GET['msg_id']) : 0;
if ($send == "") {
    $send      = !empty($_GET['send'])      ? 1 : 0;
}

if ($to_userid == "") {
  $to_userid = !empty($_GET['to_userid']) ? intval($_GET['to_userid']) : 0;
}
// ------------------------------------------------------------------------- //

if ( $op == 'submit' || $op == 'preview' ) {
  $res = $db->query("SELECT COUNT(*) FROM ".$db->prefix("users")." WHERE uid=".intval($_POST['to_userid'])."");
  list($count) = @$db->fetch_row($res);

if ( $count != 1 ) {
  $message = _PM_USERNOEXIST.'<br />'._PM_PLZTRYAGAIN;
  redirect_header('javascript:history.go(-1)', 2, $message);
  exit();
  } else {
    $pm   = new PM();
    $type = $rcxUser->isAdmin() ? 1 : 0;
    $pm->setVar('type'          , $type);
    if ($_POST['msg_image'] == "") {
        $_POST['msg_image'] = 'icon1.gif';
    }
    //*******************
  $attachment_info='';
    if ($msg_attachment)
    { 
      $upload->set_upload_dir('cache/files', 'msg_attachment');
      $upload->set_basename($rcxUser->getVar('uid').'_'.time());
      $result = $upload->upload();
      $attach_errors = $upload->errors(0);
    if ($result)
    {
      $attachment_filename=$result['msg_attachment']['realname'];
      $attachment_pseudoname=$result['msg_attachment']['basename'].$result['msg_attachment']['extension'];
      $attachment_size=$result['msg_attachment']['size'];
      $attachment_info=$attachment_filename.'|'.$attachment_pseudoname.'|'.$attachment_size.'|0';
    }
    if ($attach_errors != "" && !strpos($attach_errors, _ULC_FILE))
    {
      redirect_header("javascript:history.go(-'2')", 5, "<b>Error</b>: ".$attach_errors."<br />");
      exit();
    }
  }
    //******************
    if ($_POST['subject'] == "") {
        $subject = "Post";
    } else {
    $subject = $_POST['subject'];
    }
    
    $pm->setVar('msg_image'     , $_POST['msg_image']);
    $pm->setVar('subject'       , $subject);
    $pm->setVar('msg_attachment', $attachment_info);
    $pm->setVar('msg_text'      , $_POST['message']);
    $pm->setVar('to_userid'     , $_POST['to_userid']);
    $pm->setVar('allow_html'    , $_POST['allow_html']);
    $pm->setVar('allow_smileys' , $_POST['allow_smileys']);
    $pm->setVar('allow_bbcode'  , $_POST['allow_bbcode']);
    $pm->setVar('from_userid'   , $rcxUser->getVar('uid'));
    $pm->setVar('msg_replay'    , 0);
    $pm_uname = RcxUser::getUnameFromId($pm->getVar('to_userid'));
    
    
  if ( $op == 'preview' ) {
    include_once('../../header.php');
    themecenterposts($pm->getVar('subject', 'P'), $pm->getVar('msg_text', 'P'));
    OpenTable();

    echo '<h4>'._MI_PMSUBLINK_SEND.'</h4>';
    $subject = $pm->getVar('subject', 'F');
    $message = $pm->getVar('msg_text', 'F');
    include_once('include/pmform.inc.php');

    CloseTable();
    include_once('../../footer.php');
    } else {
      if ( !$pm->store() ) {
        redirect_header('javascript:history.go(-1)', 2, $pm->getErrors());
        exit();
        } else {
        //***********************************
        $fromusername = RcxUser::getUnameFromId($pm->getVar('from_userid'));
        $username = RcxUser::getUnameFromId($pm->getVar('to_userid'));
        
        $to_user = $pm->getVar('to_userid');
        $sql = "SELECT msg_mail FROM ".$db->prefix("pm_msgs_config")." WHERE msg_uid=".$to_user."";
        $result = $db->query($sql);
        $mailsend = $db->fetch_row($result);
        if ($mailsend[0] == 1 and $pmConfig['sendmail'] == 1) {
          $sql = "SELECT email FROM ".$db->prefix("users")." WHERE uid=".$to_user."";
            $result = $db->query($sql);
          $usermail = $db->fetch_row($result);
          $mailbody = _PM_MAILBODY." ".RCX_URL;
          $rcxMailer =& getMailer();
          $rcxMailer->useMail();
          $rcxMailer->setTemplate("pm.tpl");
          $rcxMailer->setTemplateDir(RCX_ROOT_PATH."/modules/pm");
          $rcxMailer->assign("SITENAME", $meta['title']);
          $rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
          $rcxMailer->assign("SITEURL", RCX_URL."/");
          $rcxMailer->assign("FROMUSERNAME", $fromusername);
          $rcxMailer->assign("USERNAME", $username);
          $rcxMailer->setToEmails($usermail);
          $rcxMailer->setFromEmail($mail);
          $rcxMailer->setFromName($meta['title']);
          $rcxMailer->setSubject(_PM_MAILSUBJECT);
          $rcxMailer->send();
        }
        //**************************************
          redirect_header('index.php', 2, _PM_MESSAGEPOSTED);
          exit();
        }
    }
  }
  } elseif ( $reply == 1 || $send == 1 ) {
    $pm = new PM($msg_id);
    if ($reply == 1) {
      if ($pm->getVar('to_userid') != $rcxUser->getVar('uid')) {
        redirect_header('javascript:history.go(-1)', 1);
        exit();
      }
      $pm->setVar('to_userid', $pm->getVar('from_userid'));
      $pm_uname = RcxUser::getUnameFromId($pm->getVar('from_userid'));
      if (stristr($pm->getVar('subject', 'F'),'Re:')) {
          $subject  = $pm->getVar('subject', 'F');
      } else {
      $subject  = 'Re: '.$pm->getVar('subject', 'F');
      }
      $message  = "[quote]\n";
      $message .= sprintf(_PM_USERWROTE, $pm_uname);
      $message .= "\n\n".$pm->getVar('msg_text', 'F')."\n\n[/quote]\n\n";
      } elseif ($to_userid) {
        $pm->setVar('to_userid', $to_userid);
        $pm_uname = RcxUser::getUnameFromId($to_userid);
      }
    include_once('../../header.php');
    OpenTable();

    echo '<h4>'._MI_PMSUBLINK_SEND.'</h4>';
    include_once('include/pmform.inc.php');

    CloseTable();
    include_once('../../footer.php');
    } else {
      redirect_header(RCX_URL.'/', 1);
      exit();
    }
?>
