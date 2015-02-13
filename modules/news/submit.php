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
include_once(RCX_ROOT_PATH."/class/rcxtree.php");
include_once("class/class.newsstory.php");
include_once("cache/config.php");
if ($rcxUser) {
	$uid = $rcxUser->uid();
	} elseif ($newsConfig['anonsubmit'] == 1) {
		$uid = 0;
		} else {
			redirect_header("index.php", 3, _NW_ANONNOTALLOWED);
			exit();
		}
switch($_POST['op']) {
case "preview":
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('index.php', 3, $rcx_token->getErrors(true));
        exit();
    }
    
	$xt = new RcxTopic($db->prefix("topics"), $_POST['topic_id']);
	include_once(RCX_ROOT_PATH."/header.php");
	OpenTable();
	$p_subject = $myts->makeTboxData4Preview($xt->topic_title("P").": ".$_POST['subject']);
	$hometext  = $_POST['hometext'];
	$moretext  = $_POST['moretext'];

	( empty($rcxConfig['allow_html']) && empty($_POST['allow_html']) ) ? $html = 0 : $html = intval($_POST['allow_html']);
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
		$myts->setType('admin');
		} else {
			$myts->setType('user');
		}
	$p_message  = $myts->makeTareaData4Preview($hometext, $html, intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
	if ( !empty($moretext) ) {
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
		$myts->setType('admin');
		} else {
			$myts->setType('user');
		}
		$p_message .= "<br /><br />".$myts->makeTareaData4Preview($moretext, $html, intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
	}
	$subject       = $myts->makeTboxData4PreviewInForm($_POST['subject']);
		//editor integration
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
		$myts->setType('admin');
		} else {
			$myts->setType('user');
		}
	$hometext_ed  = $myts->makeTareaData4Preview($hometext, $html, intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
		$myts->setType('admin');
		} else {
			$myts->setType('user');
		}
	$moretext_ed  = $myts->makeTareaData4Preview($moretext, $html, intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
	if ($editorConfig["displayeditor"] == 1 && $editorConfig['displayforuser'] == 1 && $rcxUser)
	{
		$hometext   = $runESeditor->Value = $hometext_ed;
		$moretext   = $runESeditor->Value = $moretext_ed;
	}else{
		$hometext   = $myts->makeTboxData4PreviewInForm($_POST['hometext']);
		$moretext   = $myts->makeTboxData4PreviewInForm($_POST['moretext']);
		}
	// editor integration slut
	$noname        = intval($_POST['noname']);
	$allow_html    = intval($_POST['allow_html']);
	$allow_smileys = intval($_POST['allow_smileys']);
	$allow_bbcode  = intval($_POST['allow_bbcode']);
	$notifypub     = intval($_POST['notifypub']);
	echo "<b>"._NW_SUBMITNEWS."</b><br /><br />";
	OpenTable("85%");
	themecenterposts($p_subject, $p_message);
	CloseTable();
	include_once("include/storyform.inc.php");
	CloseTable();
	include_once(RCX_ROOT_PATH."/footer.php");
	break;
case "post":
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('index.php', 3, $rcx_token->getErrors(true));
        exit();
    }    
    
	$story = new NewsStory();
	$story->setTitle($_POST['subject']);
	$story->setHometext($_POST['hometext']);
	$story->setBodytext($_POST['moretext']);
	$story->setUid($uid);
	$story->setTopicId($_POST['topic_id']);
	$story->setHostname(_REMOTE_ADDR);
	$story->setHtml($_POST['allow_html']);
	$story->setSmileys($_POST['allow_smileys']);
	$story->setBBcode($_POST['allow_bbcode']);
	$story->setNotifyPub($_POST['notifypub']);
	if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
		$story->setType('admin');
		} else {
			$story->setType('user');
		}
	$result = $story->store();
	if ($result && $newsConfig['notifysubmit'] == 1) {
		$rcxMailer =& getMailer();
		$rcxMailer->useMail();
		$rcxMailer->setToEmails($rcxConfig['adminmail']);
		$rcxMailer->setFromEmail($rcxConfig['adminmail']);
		$rcxMailer->setFromName($meta['title']);
		$rcxMailer->setSubject(_NW_NOTIFYSBJCT);
		$rcxMailer->setBody(_NW_NOTIFYMSG);
		$rcxMailer->send();
		}
	redirect_header("index.php", 2, _NW_THANKS);
	break;
default:
	$xt = new RcxTopic($db->prefix("topics"));
	include_once(RCX_ROOT_PATH."/header.php");
	OpenTable();
	echo "<h3>"._NW_SUBMITNEWS."</h3>";
	$subject  = "";
	$message  = "";
	$moretext = "";
	include_once("include/storyform.inc.php");
	CloseTable();
	include_once(RCX_ROOT_PATH."/footer.php");
	break;
}

?>