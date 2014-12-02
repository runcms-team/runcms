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
    $rcxConfig['anonpost'] = $galerieConfig['coment_anon'];
    
    if ( isset($_POST['op']) ) {
    
        switch($_POST['op']) {
        
        case "preview":
          include_once(RCX_ROOT_PATH."/header.php");
          ( empty($rcxConfig['allow_html']) || empty($_POST['allow_html']) ) ? $html = 0 : $html = intval($_POST['allow_html']);
          $p_subject = $myts->makeTboxData4Preview($_POST['subject']);
          if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
            $myts->setType('admin');
            } else {
              $myts->setType('user');
            }
          $p_comment = $myts->makeTareaData4Preview($_POST['message'], $html, intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
          themecenterposts($p_subject, $p_comment);   
          $icon          = $_POST['icon'];
          $noname        = intval($_POST['noname']);
          $allow_html    = intval($_POST['allow_html']);
          $allow_smileys = intval($_POST['allow_smileys']);
          $allow_bbcode  = intval($_POST['allow_bbcode']);
          $pid           = intval($_POST['pid']);
          $item_id       = intval($_POST['item_id']);
          $comment_id    = intval($_POST['comment_id']);
          $order         = $_POST['order'];
          $subject       = $myts->makeTboxData4PreviewInForm($_POST['subject']);
          $message       = $myts->makeTboxData4PreviewInForm($_POST['message']);
          OpenTable();
          include_once(RCX_ROOT_PATH."/include/commentform.inc.php");
          CloseTable();
          break;
        
        case "post":
          if ( !empty($_POST['comment_id']) ) {
            $artcomment = new RcxComments($db->prefix("galli_comments"), $_POST['comment_id']);
            $accesserror = 0;
          if ( $rcxUser ) {
            if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
              if ( $artcomment->getVar("user_id") != $rcxUser->getVar("uid") ) {
                $accesserror = 1;
              }
            }
          } else {
            $accesserror = 1;
          }
        
          if ( $accesserror == 1 ) {
                redirect_header("viewcat.php?id=".intval($_POST['item_id']),1,_NW_EDITNOTALLOWED);
            exit();
          }
        
          } else {
            $artcomment = new RcxComments($db->prefix("galli_comments"));
            $artcomment->setVar("pid", $_POST['pid']);
            $artcomment->setVar("item_id", $_POST['item_id']);
            $artcomment->setVar("ip", _REMOTE_ADDR);
            if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
              $artcomment->setVar('type', 'admin');
              } else {
                $artcomment->setVar('type', 'user');
              }
            if ( $rcxUser ) {
              $uid = $rcxUser->getVar("uid");
              } else {
                if ( $rcxConfig['anonpost'] == 1 ) {
                  $uid = 0;
                  } else {
                      redirect_header("viewcat.php?id=".$_POST['itemid'],1,_NW_ANONNOTALLOWED);
                    exit();
                  }
            }
            $artcomment->setVar("user_id", $uid);
          }   
          $artcomment->setVar("subject", $myts->makeTboxData4Save($_POST['subject']));
          $artcomment->setVar("comment", $myts->makeTboxData4Save($_POST['message']));
          $artcomment->setVar("allow_html", intval($_POST['allow_html']));
          $artcomment->setVar("allow_smileys", intval($_POST['allow_smileys']));
          $artcomment->setVar("allow_bbcode", intval($_POST['allow_bbcode']));
          $artcomment->setVar("icon", $myts->makeTboxData4Save($_POST['icon']));
          $newtid = $artcomment->store();
            redirect_header("viewcat.php?id=".intval($_POST['item_id']),2,_NW_THANKSFORPOST);
          exit();
          break;
        }
    
  } else {
    redirect_header("index.php",2);
    exit();
  }
    
    include_once(RCX_ROOT_PATH."/footer.php");
?>
