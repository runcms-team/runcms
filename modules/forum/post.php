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
include_once(RCX_ROOT_PATH.'/class/fileupload.php');
include_once("class/class.permissions.php");

$upload = new fileupload();

if ( empty($_POST['forum']) )
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
else if ( empty($_POST['message']) )
{
	redirect_header("javascript:history.go(-1)", 2, _MD_ERRORMESSAGE);
	exit();
}
else {
   $forum = intval($_POST['forum']);
    $sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id = ".$forum."";

//		$sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id = ".$_POST['forum']."";
		if (!$result = $db->query($sql)) {
			redirect_header("index.php", 2, _MD_CANTGETFORUM);
			exit();
		}
	$forumdata = $db->fetch_array($result);

	$permissions = new Permissions($forumdata['forum_id']);
	if ( $permissions->can_view == 0 || ($permissions->can_post == 0 && $permissions->can_reply == 0))
	{
		redirect_header("viewforum.php?order=".$_POST['order']."&viewmode=".$_POST['viewmode']."&amp;forum=".intval($_POST['forum'])."",2,_MD_NORIGHTTOPOST);
		exit();
	}
	if ( !empty($_POST['contents_preview']) ) {
		include_once(RCX_ROOT_PATH."/header.php");
		OpenTable();
		$p_subject = $myts->makeTboxData4Preview($_POST['subject']);
		if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
			$myts->setType('admin');
			} else {
				$myts->setType('user');
			}
		$p_message = $myts->makeTareaData4Preview($_POST['message'], intval($_POST['allow_html']), intval($_POST['allow_smileys']), intval($_POST['allow_bbcode']));
		themecenterposts($p_subject, $p_message);
		echo "<br />";
		$subject  = $myts->makeTboxData4PreviewInForm($_POST['subject']);
		$message  = $myts->makeTboxData4PreviewInForm($_POST['message']);
		$hidden   = $myts->makeTboxData4PreviewInForm($_POST['hidden']);
		$viewmode = $myts->makeTboxData4PreviewInForm($_POST['viewmode']);
		include_once("include/forumform.inc.php");
		CloseTable();
	} else {
		include_once("class/class.forumposts.php");
		if ( !empty($_POST['post_id']) ) {
			$editerror = 0;
			$forumpost = new ForumPosts($_POST['post_id']);
			if ( $rcxUser ) {
				if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
					if ( $forumpost->uid() != $rcxUser->getVar("uid") && !is_moderator($_POST['forum'], $rcxUser->getVar("uid")) ) {
						$editerror = 1;
					}
				}
			} else {
				$editerror = 1;
			}
			if ( $editerror == 1 ) {
				redirect_header("viewtopic.php?topic_id=".$_POST['topic_id']."&post_id=".$_POST['post_id']."&order=".$_POST['order']."&viewmode=".$_POST['viewmode']."&pid=".$_POST['pid']."&amp;forum=".$_POST['forum']."",2,_MD_EDITNOTALLOWED);
				exit();
			}
		} else {
			$isreply = 0;
			if ( $rcxUser && empty($_POST['noname']) )
			{
				$uid = $rcxUser->getVar("uid");
			}
			else
			{
				$uid = 0;
			}
			$forumpost = new ForumPosts();
			$forumpost->setForum(intval($_POST['forum']));
			if (isset($_POST['pid']) && $_POST['pid'] != "") {
				$forumpost->setParent(intval($_POST['pid']));
			}
			if (!empty($_POST['topic_id'])) {
				$forumpost->setTopicId(intval($_POST['topic_id']));
				$isreply = 1;
			}
			$forumpost->setIp(_REMOTE_ADDR);
			$forumpost->setUid($uid);
		}
	
		//ADD by xtremdj in order to add [sondage] to post with polls
		if(($_POST["poll_question"]!="")&&($option[0]!="")&&($option[1]!="")) $rajsubject="[Sondage] ";
		else $rajsubject="";
		//EnD
		
		$forumpost->setSubject($rajsubject.$_POST['subject']); //ADD $rajsubject by xtremdj
	
		$forumpost->setSubject($_POST['subject']);

		$message = $_POST['message'];
		if ( $rcxUser && !empty($_POST['editpost']) && !empty($_POST['add_edited'])) {
			$editor   = $rcxUser->getVar("uname");
			$on_date  = _MD_ON." ".formatTimestamp(time(), _MEDIUMDATESTRING);
			$message .= "\n\n[ "._EDITEDBY." ".$editor." ".$on_date." ]";
		}
		$forumpost->setText($message);

		$forumpost->setHtml($_POST['allow_html']);
		$forumpost->setSmileys($_POST['allow_smileys']);
		$forumpost->setBBcode($_POST['allow_bbcode']);
		$forumpost->setIcon($_POST['icon']);
		$forumpost->setAttachsig($_POST['attachsig']);
		// alphalogic's attachment hack <---

		for ($i=0;$i<5;$i++)
		{
			if (!empty($_POST["attachment_$i"]))
			{
				$forumpost->setAttachment($_POST["attachment_$i"]);
			}
		}

		// --->

		if (!$rcxUser && !empty($_POST['anon_uname'])) {
			$forumpost->setAnonUname($_POST['anon_uname']);
		}

		if (!empty($_POST['notify'])) {
			$forumpost->setNotify($_POST['notify']);
		}
		if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
			$forumpost->setType('admin');
			} else {
				$forumpost->setType('user');
			}
		$postid = $forumpost->store();

		if ($isreply == 1) {
			$sql = "SELECT t.topic_notify, u.email, u.uname, u.uid FROM ".$bbTable['topics']." t, ".$db->prefix("users")." u WHERE t.topic_id = ".$_POST['topic_id']." AND t.topic_poster = u.uid";
			if (!$result = $db->query($sql)) {
				echo _MD_COULDNOTQUERY;
			}
			$m = $db->fetch_array($result);
			$myuid = 0;
			if ( $rcxUser ) {
				$myuid = $rcxUser->uid();
			}
			if ($m['topic_notify'] == 1 && $m['uid'] != $myuid && $m['uid'] != 0) {
				$subject = _MD_REPLYPOSTED;
				$message = sprintf(_MD_HELLO,$m['uname']);
				$message .= "\n\n";
				$message .= sprintf(_MD_URRECEIVING, $meta['title']);
				$message .= "\n\n"._MD_CLICKBELOW;
				$message .= "\n\n";
				$message .= $bbPath['url']."viewtopic.php?forum=".$_POST['forum']."&topic_id=".$_POST['topic_id']."\n\n------------\n".$meta['title']."\n".RCX_URL."";
				$rcxMailer =& getMailer();
				$rcxMailer->useMail();
				$rcxMailer->setToEmails($m['email']);
				$rcxMailer->setFromEmail($rcxConfig['adminmail']);
				$rcxMailer->setFromName($meta['title']);
				$rcxMailer->setSubject($subject);
				$rcxMailer->setBody($message);
				$rcxMailer->send();
			}
		}
	//Add by xtremdj to insert polls into db
	//insert polls
		
if(($_POST["poll_question"]!="")&&($option[0]!="")&&($option[1]!=""))
	{
		$poll_question=$_POST["poll_question"];
		$poll_question =$myts->censorString($poll_question);
		$poll_question = $myts->makeTboxData4Save($poll_question);
		$start_time = time();
		$end_time = $start_time + (intval($_POST["poll_expire"]) * 86400);
	//insert poll description
	if ( $rcxUser ) $uiduser=$rcxUser->uid();
	else $uiduser=0;
	$requete="INSERT INTO ".$bbTable['poll_desc']." (poll_id, question, description, user_id, start_time, end_time, votes, voters, multiple, display, weight, mail_status,topic_id) VALUES (NULL, '".$poll_question."', 'j', ".$uiduser.", ".$start_time.", ".$end_time.", 0, 0, 0, 0, 0, 0,".$forumpost->topic().")";
	if (!$resultsql = $db->query($requete)) 
		{
		error_die("Error in the insertion of the polls ".$db->error());
		}
	//Select id of new poll
	$requete="SELECT MAX(poll_id) as idmaximum from ".$bbTable['poll_desc'];
	if (!$resultsql = $db->query($requete)) 
		{
		error_die("Error in the insertion of the polls ".$db->error());
		
		}
	$idrs = $db->fetch_array($resultsql);
	$idmaximum=$idrs["idmaximum"];

	//insert options

	for($i=0;$i<count($option);$i++)
		{
		if($option[$i]!="" && $bar_color[$i]!="")
			{
			$option[$i] =$myts->censorString($option[$i]);
			$option[$i] = $myts->makeTboxData4Save($option[$i]);
			
			$requete="INSERT INTO ".$bbTable['poll_option']." (option_id, poll_id, option_text, option_count, option_color) VALUES (NULL, ".$idmaximum.", '".$option[$i]."', 0, '".$bar_color[$i]."')";
			if (!$resultsql = $db->query($requete)) 
				{
				error_die("Error in the insertion of the polls ".$db->error());
				}
			}
		$cpt++;
		}
	}
		
// END HACK

//Debut modif notification par Mail
		if ($topic_id){
		    $sql = "SELECT usernotif_id FROM ".$bbTable['topics_mail']." WHERE topic_id = $topic_id";
		    $result = $db->query($sql);
		    if(!$result) {
				echo _MD_COULDNOTQUERY;
			}
			$sqltitle = "SELECT topic_title FROM ".$bbTable['topics']." WHERE topic_id = $topic_id";
			$resulttitle = $db->query($sqltitle);
			if(!$resulttitle) {
				echo _MD_COULDNOTQUERY;
			}
			$mtopic = $db->fetch_array($resulttitle);
		
			$sqlauteur = "SELECT uid FROM ".$bbTable['posts']." WHERE post_id = $postid";
			$resultauteur = $db->query($sqlauteur);
			if(!$resultauteur) {
				echo _MD_COULDNOTQUERY;
			}
			$mauteur = $db->fetch_array($resultauteur);
			$sqlpostauteur = "SELECT uname FROM ".$db->prefix("users")." WHERE uid = ".$mauteur[uid]."";
			$resultpostauteur = $db->query($sqlpostauteur);
			if(!$resultpostauteur) {
				echo _MD_COULDNOTQUERY;
			}
			$mpostauteur = $db->fetch_array($resultpostauteur);
		
			while ( $notifmail = @each ($db->fetch_array($result)) ) {
				$sqlbis = "SELECT email, uname FROM ".$db->prefix("users")." WHERE uid = ".$notifmail[1]."";
				$resultbis = $db->query($sqlbis);
				$mlist = $db->fetch_array($resultbis);
				$subject = _MD_REPLYPOSTED2;
				$message = sprintf(_MD_HELLO,$mlist['uname']);
				$message .= "\n\n";
				$message .= sprintf(_MD_URRECEIVING2,$meta['title']);
				$message .= "\n\n";
				$message .= sprintf(_MD_MAILTITRETOPIC,$mtopic['topic_title']);
				$message .= "\n\n";
				$message .= sprintf(_MD_POSTAUTEUR,$mpostauteur['uname']);
				$message .= "\n\n"._MD_CLICKBELOW;
				$message .= "\n\n";
				$message .= $bbPath['url']."viewtopic.php?forum=".$forum."&topic_id=".$topic_id."\n\n------------\n".$rcxConfig['sitename']."\n".RCX_URL."";
		    	$rcxMailer =& getMailer();
				$rcxMailer->useMail();
				$rcxMailer->setToEmails($mlist['email']);
				$rcxMailer->setFromEmail($rcxConfig['adminmail']);
				$rcxMailer->setFromName($meta['title']);
				$rcxMailer->setSubject($subject);
				$rcxMailer->setBody($message);
				$rcxMailer->send();
			}
		}		
// Fin modif notification par mail


			if ( $_POST['viewmode'] == "thread" )
			{
				$post_id = $forumpost->postid();
				redirect_header("viewtopic.php?topic_id=".$forumpost->topic()."&amp;post_id=".$postid."&amp;order=".$_POST['order']."&amp;viewmode=thread&amp;pid=".$_POST['pid']."&amp;forum=".$_POST['forum']."#".$postid."", 2, _MD_THANKSSUBMIT);
				exit();
			}
			else
			{
				redirect_header("viewtopic.php?topic_id=".$forumpost->topic()."&amp;post_id=".$postid."&amp;order=".$_POST['order']."&amp;viewmode=flat&amp;pid=".$_POST['pid']."&amp;forum=".$_POST['forum']."#".$postid."", 2, _MD_THANKSSUBMIT);
				exit();
			}

	}
include_once(RCX_ROOT_PATH."/footer.php");
}
?>
