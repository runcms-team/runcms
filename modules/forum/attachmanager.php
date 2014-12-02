<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once 'header.php';
include_once 'class/class.attachment.php';
include_once 'class/class.forumposts.php';
include_once(RCX_ROOT_PATH.'/class/fileupload.php');

$post_id = intval($post_id);

if ($post_id <= 0)
{
	redirect_header('index.php',2,_MD_ERRORPOST);
	die();
}

$fp = new ForumPosts($post_id);

$permissions =  new Permissions($fp->forum_id);
if (!$permissions->can_attach)
{
	redirect_header('index.php',2,_MD_NORIGHTTOATTACH);
	die();
}

$adminview = 0;
if ($rcxUser)
{
	if ( $rcxUser->isAdmin($rcxModule->mid()) || is_moderator($fp->forum_id, $rcxUser->uid()))
	{
		$adminview = 1;
	}
}

$op = $_POST['op'];
switch ($op)
{
	case _DOWNLOAD:
	{
		$attach = Attachment::getByID($_POST['attach_id']);
		$attach->download();
		break;
	}
	case _DELETE:
	{
		$attach = Attachment::getByID($_POST['attach_id']);
		$attach->delete();

		$all_attachments = Attachment::getAllByPost($post_id, 1);
		if (count($all_attachments) == 0)
		{
			$fp->has_attachment = 0;
			$fp->store();
		}
		break;
	}
	case _ADD:
	{
		$uid = ($rcxUser) ? $rcxUser->getVar('uid') : 0;
		$upload = new fileupload();
		$upload->set_upload_dir('cache/attachments', 'new_attach');
		$upload->set_basename($uid.'_'.time());
		$result = $upload->upload();
		if ($result)
		{
			$attach = new Attachment();
			$attach->post_id = $_POST['post_id'];
			$attach->file_name = $result['new_attach']['realname'];
			$attach->file_pseudoname = $result['new_attach']['basename'].$result['new_attach']['extension'];
			$attach->file_size=$result['new_attach']['size'];
			$attach->is_approved = $permissions->autoapprove_attach;
			$attach->store();
			
		}
 		$attach_errors = $upload->errors(0);
		if ($attach_errors != "" && !strpos($attach_errors, _ULC_FILE))
		{
			redirect_header("attachmanager.php?post_id=$post_id", 5, "<b>Error</b>: ".$attach_errors."<br />");
			exit();
		}

		if ($fp->has_attachment == 0)
		{
			$fp->has_attachment = 1;
			$fp->store();
		}

		break;
	}
	case _MD_APPROVE:
	{
		if ($adminview)
		{
			$attach = Attachment::getByID($_POST['attach_id']);
			$attach->is_approved = 1;
			$attach->store();
		}
		break;
	}
	case _MD_UNAPPROVE:
	{
		if ($adminview)
		{
			$attach = Attachment::getByID($_POST['attach_id']);
			$attach->is_approved = 0;
			$attach->store();
		}
		break;
	}
}

forum_page_header();
OpenTable();

// Attachment List
echo "<p><b>"._MD_ATTACHMENTS."</b></p>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' align='center' valign='top'>";
echo "<tr><td class='bg2'>";
echo "<table width='100%' border='0' cellpadding='4' cellspacing='1'>";
echo "<tr class='bg1'><td><b>"._MD_FILE_NAME."</b></td><td><b>"._MD_FILE_SIZEC."</b></td><td><b>"._MD_ISAPPROVED."</b></td><td><b>"._MD_ACTIONS."</b></td></tr>";
$attachments = Attachment::getAllByPost($post_id, 1);
foreach($attachments as $attach)
{
	echo "<form action='attachmanager.php' method='post'>";
	echo "<input type='hidden' name='post_id' value='$post_id'>";
	echo "<input type='hidden' name='attach_id' value='".$attach->attach_id."'>";
	echo "<tr class='bg3'>";
	echo "<td>".$attach->file_name."</td>";	
	echo "<td>".sprintf("%.2f kb",$attach->file_size/1024)."</td>";
	$approved_check = ($attach->is_approved) ? ' checked' : '';
	echo "<td><input type='checkbox' class='checkbox' 'is_approved' DISABLED $approved_check>";	
	echo "<td><input type='submit' class='button' name='op' value='"._DOWNLOAD."'>&nbsp;&nbsp;";	

	if ($adminview)
	{
		if ($attach->is_approved)
		{
			echo "<input type='submit' class='button' name='op' value='"._MD_UNAPPROVE."'>&nbsp;&nbsp;";
		}
		else
		{
			echo "<input type='submit' class='button' name='op' value='"._MD_APPROVE."'>&nbsp;&nbsp;";
		}
	}

	echo "<input type='submit' class='button' name='op' value='"._DELETE."'></td>";	
	echo "</tr>";
	echo "</form>";
}
echo "</table>";
echo "</td></tr>";
echo "</table>";

// Add Attachment
$sql = "SELECT allow_attachments, attach_maxkb, attach_ext FROM ".$bbTable['forums']." WHERE forum_id=".$fp->forum_id;
$result = $db->query($sql);
$forumdata = $db->fetch_array($result);


echo "<p><b>"._MD_ADD_ATTACHMENT."</b></p>";

echo "<form action='attachmanager.php' method='post' enctype='multipart/form-data'>";
echo "<input type='hidden' name='post_id' value='$post_id'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' align='center' valign='top'>";
echo "<tr><td class='bg2'>";
echo "<table width='100%' border='0' cellpadding='4' cellspacing='1'>";


echo "<tr class='bg3' align='left'><td valign='top' style='white-space: nowrap;'><b>"._MD_ATTACHMENT."</b></td><td>";
$upload = new fileupload();
$upload->set_max_file_size($forumdata['attach_maxkb'], 'k', 'new_attach');
$upload->set_accepted($forumdata['attach_ext'],'new_attach');
$upload->render(1, 'new_attach');
echo '<br><b>'._MD_ALLOWED_EXTENSIONS.':</b><br>';
echo '<i>'.str_replace('|',' ',$forumdata['attach_ext']).'</i>';
echo "</td></tr>";

echo "<tr class='bg3' align='left'><td valign='top' style='white-space: nowrap;'></td><td>";
echo "<input type='submit' class='button' name='op' value='"._ADD."'></td>";	
echo "</td></tr>";

echo "</table>";
echo "</td></tr>";
echo "</table>";
echo "</form>";

// Preview Post
echo "<b>"._PREVIEW.":</b><br />";
$fp->showPost('flat','',$permissions,0,0, $adminview);

// Back To Topic
echo "<br />";
echo "<div align='center'>";
echo "<input type='button' class='button' value='"._MD_BACK_TO_TOPIC."' onclick='document.location=\"viewtopic.php?topic_id=".$fp->topic_id."&amp;forum=".$fp->forum_id."\"'>";
echo "</div>";

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>