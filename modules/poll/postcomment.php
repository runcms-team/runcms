<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("header.php");
include_once(RCX_ROOT_PATH."/class/rcxcomments.php");

if (isset($_REQUEST['op']))
{
  switch($_REQUEST['op'])
  {
    case "preview":
      include_once(RCX_ROOT_PATH."/header.php");
      (empty($rcxConfig['allow_html']) || empty($_REQUEST['allow_html'])) ? $html = 0 : $html = intval($_REQUEST['allow_html']);
      $p_subject = $myts->makeTboxData4Preview($_REQUEST['subject']);
      if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
      {
        $myts->setType('admin');
      }
      else
      {
        $myts->setType('user');
      }
      $p_comment = $myts->makeTareaData4Preview($_REQUEST['message'], $html, intval($_REQUEST['allow_smileys']), intval($_REQUEST['allow_bbcode']));
      themecenterposts($p_subject, $p_comment);

      $icon          = $_REQUEST['icon'];
      $noname        = $_REQUEST['noname'];
      $allow_html    = intval($_REQUEST['allow_html']);
      $allow_smileys = intval($_REQUEST['allow_smileys']);
      $allow_bbcode  = intval($_REQUEST['allow_bbcode']);
      $pid           = intval($_REQUEST['pid']);
      $item_id       = intval($_REQUEST['item_id']);
      $comment_id    = intval($_REQUEST['comment_id']);
      $order         = intval($_REQUEST['order']);
      $subject       = $myts->makeTboxData4PreviewInForm($_REQUEST['subject']);
      $message       = $myts->makeTboxData4PreviewInForm($_REQUEST['message']);
      
      OpenTable();
      include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
      CloseTable();
      break;

    case "post":
      // CAPTCHA hack by SVL
      // begin captcha
      if ((int)$rcxOption['use_captcha'] == 1 && !$rcxUser)
      {
        session_start();
        if(count($_REQUEST)>0)
        {
          if(!isset($_SESSION['captcha_keystring']) || $_SESSION['captcha_keystring'] !== md5($_REQUEST['keystring']))
          {
            redirect_header(_HTTP_REFERER, 3, _WRONGCAPKEY);
            exit;
          }
        }
        unset($_SESSION['captcha_keystring']);
      }
      // end captcha

      if (!empty($_REQUEST['comment_id']))
      {
        $pollcomment = new RcxComments($db->prefix("pollcomments"), intval($_REQUEST['comment_id']));
        $accesserror = 0;
        if ($rcxUser)
        {
          if (!$rcxUser->isAdmin($rcxModule->mid()))
          {
            if ($pollcomment->getVar("user_id") != $rcxUser->getVar("uid"))
            {
              $accesserror = 1;
            }
          }
        }
        else
        {
          $accesserror = 1;
        }
        if ($accesserror == 1)
        {
          redirect_header("pollresults.php?poll_id=".intval($_REQUEST['item_id'])."&amp;comment_id=".intval($_REQUEST['comment_id'])."&amp;order=".intval($_REQUEST['order']), 1, _PL_EDITNOTALLOWED);
          exit;
        }
      }
      else
      {
        $pollcomment = new RcxComments($db->prefix(pollcomments));
        $pollcomment->setVar("pid", intval($_REQUEST['pid']));
        $pollcomment->setVar("item_id", intval($_REQUEST['item_id']));
        $pollcomment->setVar("ip", _REMOTE_ADDR);
        if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
        {
          $pollcomment->setVar('type', 'admin');
        }
        else
        {
          $pollcomment->setVar('type', 'user');
        }
        if ($rcxUser)
        {
          $uid = $rcxUser->getVar("uid");
        }
        else
        {
          if ($rcxConfig['anonpost'] == 1)
          {
            $uid = 0;
          }
          else
          {
            redirect_header("pollresults.php?poll_id=".intval($_REQUEST['item_id'])."&amp;comment_id=".intval($_REQUEST['comment_id'])."&amp;order=".intval($_REQUEST['order'])."&amp;pid=".intval($_REQUEST['pid'])."", 1, _PL_ANONNOTALLOWED);
            exit();
          }
        }
        $pollcomment->setVar("user_id", $uid);
      }
      
      $pollcomment->setVar("subject", $_REQUEST['subject']);
      $pollcomment->setVar("comment", $_REQUEST['message']);
      $pollcomment->setVar("allow_html", intval($_REQUEST['allow_html']));
      $pollcomment->setVar("allow_smileys", intval($_REQUEST['allow_smileys']));
      $pollcomment->setVar("allow_bbcode", intval($_REQUEST['allow_bbcode']));
      $pollcomment->setVar("icon", $_REQUEST['icon']);
      $new_comment_id = $pollcomment->store();
      redirect_header("pollresults.php?poll_id=".intval($_REQUEST['item_id'])."&amp;comment_id=".$new_comment_id."&amp;order=".intval($_REQUEST['order'])."",2,_PL_THANKSFORPOST);
      exit;
      break;
  }
}
else
{
  redirect_header("index.php", 2);
  exit();
}
include_once(RCX_ROOT_PATH."/footer.php");
?>