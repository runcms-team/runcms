<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
	include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
	$op = "form";

	if (!empty($_POST['op']) && $_POST['op'] == "send") {
		$op =  $_POST['op'];
	}

	if ( $op == "form" ) {
		rcx_cp_header();
		OpenTable();
		$display_criteria = 1;
		include_once(RCX_ROOT_PATH."/modules/system/admin/mailusers/mailform.php");
		$form->display();
		CloseTable();
		rcx_cp_footer();
		exit();
	}

	if ( $op == "send" && !empty($_POST['mail_send_to']) ) {
	    
	   $rcx_token = & RcxToken::getInstance();
	   if ( !$rcx_token->check() ) {
	       redirect_header('admin.php?fct=mailusers', 3, $rcx_token->getErrors(true));
	       exit();
	   }
	    
		$to_groups   = array();
		$to_users    = array();
		$send_users  = array();
		$criteria    = array();
		$rcxMailer =& getMailer();

		if ( !empty($_POST['mail_inactive']) ) {
			$criteria[] = "level = 0";
		} else {
			if ( !empty($_POST['mail_to_group']) ) {
				foreach ($_POST['mail_to_group'] as $groupid) {
					if ($groupid != 0) {
						$mailgroup = new RcxGroup($groupid);
						$members   = $mailgroup->getMembers();
						foreach ($members as $member) {
							$to_groups[] = $member;
						}
					}
				}
			}
			if ( !empty($_POST['mail_lastlog_min']) ) {
				$f_mail_lastlog_min = trim($_POST['mail_lastlog_min']);
				$time = mktime(0,0,0,substr($f_mail_lastlog_min,5,2),substr($f_mail_lastlog_min,8,2),substr($f_mail_lastlog_min,0,4));
				if ( $time > 0 ) {
					$criteria[] = "last_login > $time";
				}
			}
			if ( !empty($_POST['mail_lastlog_max']) ) {
				$f_mail_lastlog_max = trim($_POST['mail_lastlog_max']);
				$time = mktime(0,0,0,substr($f_mail_lastlog_max,5,2),substr($f_mail_lastlog_max,8,2),substr($f_mail_lastlog_max,0,4));
				if ( $time > 0 ) {
					$criteria[] = "last_login < $time";
				}
			}
			if ( !empty($_POST['mail_idle_more']) && is_numeric($_POST['mail_idle_more']) ) {
				$f_mail_idle_more = intval(trim($_POST['mail_idle_more']));
				$time = (86400 * $f_mail_idle_more);
				$time = (time() - $time);
				if ( $time > 0 ) {
					$criteria[] = "last_login < $time";
				}
			}
			if ( !empty($_POST['mail_idle_less']) && is_numeric($_POST['mail_idle_less']) ) {
				$f_mail_idle_less = intval(trim($_POST['mail_idle_less']));
				$time = (86400 * $f_mail_idle_less);
				$time = (time() - $time);
				if ( $time > 0 ) {
					$criteria[] = "last_login > $time";
				}
			}
			if ( !empty($_POST['mail_ok']) ) {
				$criteria[] = "user_mailok = 1";
			}
		}

		if ( !empty($_POST['mail_regd_min']) ) {
			$f_mail_regd_min = trim($_POST['mail_regd_min']);
			$time = mktime(0,0,0,substr($f_mail_regd_min,5,2),substr($f_mail_regd_min,8,2),substr($f_mail_regd_min,0,4));
			if ( $time > 0 ) {
				$criteria[] = "user_regdate > $time";
			}
		}
		if ( !empty($_POST['mail_regd_max']) ) {
			$f_mail_regd_max = trim($_POST['mail_regd_max']);
			$time = mktime(0,0,0,substr($f_mail_regd_max,5,2),substr($f_mail_regd_max,8,2),substr($f_mail_regd_max,0,4));
			if ( $time > 0 ) {
				$criteria[] = "user_regdate < $time";
			}
		}

		if ( !empty($criteria) ) {
			if ( empty($_POST['mail_inactive']) ) {
				$criteria[] = "level > 0";
			}
			$getusers =& RcxUser::getAllUsers($criteria);
			foreach ($getusers as $getuser) {
				$to_users[] = $getuser;
			}
		}
	}

		if ( !empty($_POST['mail_to_user']) ) {
			foreach ($_POST['mail_to_user'] as $getuser) {
				$to_users[] = $getuser;
			}
		}

		if ( !empty($_POST['mail_to_emails']) ) {
			$to_emails = explode(",", $_POST['mail_to_emails']);
			foreach($to_emails as $email) {
				$rcxMailer->setToEmails(trim($email));
			}
		}

		if ( !empty($to_users) && !empty($to_groups) ) {
			$send_users = array_intersect($to_users, $to_groups);
			} elseif (!empty($to_users)) {
				$send_users = $to_users;
				} elseif (!empty($to_groups)) {
					$send_users = $to_groups;
				}

		$send_users = array_unique($send_users);
		$rcxMailer->setToUsers($send_users);

		rcx_cp_header();
		OpenTable();
		if ( count(($send_users + $rcxMailer->toEmails)) > 0 ) {
			$rcxMailer->setFromName($_POST['mail_fromname']);
			$rcxMailer->setFromEmail($_POST['mail_fromemail']);
			$rcxMailer->setSubject($_POST['mail_subject']);
			$rcxMailer->setBody($_POST['mail_body']);
			if ( $_POST['mail_send_to'] == "mail" ) {
				$rcxMailer->useMail();
			}
			if ( $_POST['mail_send_to'] == "pm") {
				$rcxMailer->usePM();
			}
			if ( !empty($_POST['mail_reciept']) ) {
				$rcxMailer->setReciept($_POST['mail_fromemail']);
			}

			$rcxMailer->setType($_POST['mail_type']);
			$rcxMailer->setPriority($_POST['mail_priority']);

			if ( !empty($_FILES['attachment']['name']) ) {
				include_once(RCX_ROOT_PATH."/class/fileupload.php");
				$upload = new fileupload();
				$upload->set_upload_dir(RCX_ROOT_PATH . "/cache/", 'attachment');
				$upload->set_overwrite(1, 'attachment');
				$result = $upload->upload();
				if ($result['attachment']['filename']) {
					$attach_type = $_POST['inline'] ? 'inline' : 'attachment';
					$rcxMailer->attachFile(RCX_ROOT_PATH."/cache/".$result['attachment']['filename'], $result['attachment']['type'], $attach_type);
					@unlink(RCX_ROOT_PATH."/cache/".$result['attachment']['filename']);
					} else {
						$upload->errors(1);
					}
			}

			$rcxMailer->useToggle(1);
			$rcxMailer->send();
			echo $rcxMailer->getSuccess();
			echo $rcxMailer->getErrors();
			} else {
				echo "<h4>"._AM_NOUSERMATCH."</h4>";
			}

	CloseTable();
	rcx_cp_footer();
	exit();
	} else {
		echo "Access Denied";
	}
?>
