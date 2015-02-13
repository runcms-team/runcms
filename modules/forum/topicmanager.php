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
$accesserror = 0;

$topic_id = intval($_REQUEST['topic_id']);
$forum = intval($_REQUEST['forum']);
$post_id = intval($_REQUEST['post_id']);

$newforum = intval($_REQUEST['newforum']);


if ( $rcxUser ) {
	if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
		if ( !is_moderator($forum, $rcxUser->uid()) ) {
			$accesserror = 1;
		}
	}
	} else {
		$accesserror = 1;
	}

if ( $accesserror == 1 ) {
	redirect_header("viewtopic.php?topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum",3,_MD_YANTMOTFTYCPTF);
	exit();
}


include_once(RCX_ROOT_PATH."/header.php");
OpenTable();

if ($_POST['submit']) {

switch($mode) {
	case 'del':
		// Update the users's post count, this might be slow on big topics but it makes other parts of the
		// forum faster so we win out in the long run.
		$sql = "SELECT uid, post_id FROM ".$bbTable['posts']." WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die(_MD_COULDNOTQUERY);
		}
		while ($row = $db->fetch_array($r)) {
			if ($row[uid] != 0) {
				$sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".$row['uid']."";
				$db->query($sql);
			}
		}
		//Kill all attachments from the topic <---
		$sql = "SELECT * FROM ".$bbTable['posts']." WHERE topic_id=$topic_id";
		if (!$result = $db->query($sql)) {
			die(_MD_COULDNOTREMOVE);
		}
		while ($o_attach = $db->fetch_object($result)) {
			if ($o_attach->attachment) {
				$attachment_csv = explode("|",$o_attach->attachment);
				unlink($bbPath['path'].'cache/attachments/'.$attachment_csv[1]);
			}
		}
		//--->
		
		$sql = "DELETE FROM ".$bbTable['posts']." WHERE topic_id=$topic_id";
		if (!$result = $db->query($sql)) {
			die(_MD_COULDNOTREMOVE);
		}
	
		$sql = "DELETE FROM ".$bbTable['topics_mail']." WHERE topic_id=$topic_id";
		if ( !$result = $db->query($sql) ) {
			die(_MD_COULDNOTREMOVE);
		}
	
		$sql = "DELETE FROM ".$bbTable['topics']." WHERE topic_id=$topic_id";
		if (!$result = $db->query($sql)) {
			die(_MD_COULDNOTQUERY);
		}
		sync($forum, 'forum');
		echo _MD_TTHBRFTD."<p><a href='viewforum.php?forum=$forum'>"._MD_RETURNTOTHEFORUM."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;

	case 'move':
		$sql = "UPDATE ".$bbTable['topics']." SET forum_id=$newforum WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die(_MD_EPGBATA);
		}
		$sql = "UPDATE ".$bbTable['posts']." SET forum_id=$newforum WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die(_MD_EPGBATA);
		}
		sync($newforum, 'forum');
		sync($forum, 'forum');
		echo _MD_TTHBM."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$newforum'>"._MD_VTUT."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;

	case 'lock':
		$sql = "UPDATE ".$bbTable['topics']." SET topic_status=1 WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die(_MD_EPGBATA);
		}
		echo _MD_TTHBL."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;

	case 'unlock':
		$sql = "UPDATE ".$bbTable['topics']." SET topic_status=0 WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die("Error - Could not unlock the selected topic. Please go back and try again.");
		}
		echo _MD_TTHBU."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;

	case 'sticky':
		$sql = "UPDATE ".$bbTable['topics']." SET topic_sticky=1 WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die("Error - Could not sticky the selected topic. Please go back and try again.");
		}
		echo _MD_TTHBS."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;

	case 'unsticky':
		$sql = "UPDATE ".$bbTable['topics']." SET topic_sticky=0 WHERE topic_id=$topic_id";
		if (!$r = $db->query($sql)) {
			die("Error - Could not unsticky the selected topic. Please go back and try again.");
		}
		echo _MD_TTHBUS."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;
	case 'approve_post':
		$sql = "UPDATE ".$bbTable['posts']." SET is_approved=1 WHERE post_id=$post_id";
		if (!$r = $db->query($sql)) {
			die("Error - Could not approve the selected post. Please go back and try again.");
		}
		echo _MD_TTHBAPPR."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;
	case 'unapprove_post':
		$sql = "UPDATE ".$bbTable['posts']." SET is_approved=0 WHERE post_id=$post_id";
		if (!$r = $db->query($sql)) {
			die("Error - Could not unapprove the selected post. Please go back and try again.");
		}
		echo _MD_TTHBUNAPPR."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='index.php'>"._MD_RTTFI."</a></p>";
		break;
	}

} else {  // No submit
?>

<form action='<?php echo _PHP_SELF;?>' method='post'>
<table border='0' cellpadding='1' cellspacing='0' align='center' valign='top' width='95%'><tr><td class='bg2'>
<table border='0' cellpadding='1' cellspacing='1' width='100%'>
<tr class='bg3' align='left'>

<?php
switch ($mode) {
	case 'del':
		?>
		<td colspan='2'><?php echo _MD_OYPTDBATBOTFTTY;?></td>
		<?php
		break;

	case 'move':
		?>
		<td colspan='2'><?php echo _MD_OYPTMBATBOTFTTY;?></td>
		<?php
		break;

	case 'lock':
		?>
		<td colspan='2'><?php echo _MD_OYPTLBATBOTFTTY;?></td>
		<?php
		break;

	case 'unlock':
		?>
		<td colspan='2'><?php echo _MD_OYPTUBATBOTFTTY;?></td>
		<?php
		break;

	case 'sticky':
		?>
		<td colspan='2'><?php echo _MD_OYPTSBATBOTFTTY;?></td>
		<?php
		break;

	case 'unsticky':
		?>
		<td colspan='2'><?php echo _MD_OYPTTBATBOTFTTY;?></td>
		<?php
		break;

	case 'approve_post':
		?>
		<td colspan='2'><?php echo _MD_AYS_APPROVE;?></td>
		<?php
		break;

	case 'unapprove_post':
		?>
		<td colspan='2'><?php echo _MD_AYS_UNAPPROVE;?></td>
		<?php
		break;
}
?>

</tr>

<?php
if ($mode == 'move') {
?>

<tr>
<td class='bg3'><?php echo _MD_MOVETOPICTO;?></td>
<td class='bg1'><select class='select' name='newforum' size='0'>

<?php
$sql = "SELECT forum_id, forum_name FROM ".$bbTable['forums']." WHERE forum_id != $forum ORDER BY forum_id";
if ($result = $db->query($sql)) {
	if ($myrow = $db->fetch_array($result)) {
		do {
			echo "<option value='".$myrow['forum_id']."'>".$myrow['forum_name']."</option>\n";
		} while ($myrow = $db->fetch_array($result));
	} else {
		echo "<option value='-1'>"._MD_NOFORUMINDB."</option>\n";
	}
	} else {
		echo "<option value='-1'>"._MD_DATABASEERROR."</option>\n";
	}
?>
</select></td>
</tr>
<?php
}
?>

<tr class='bg3'>
<td colspan='2' align='center'>

<?php
switch($mode) {
	case 'del':
		?>
		<input type='hidden' name='mode' value='del' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_DELTOPIC;?>' />
		<?php
		break;

	case 'move':
		?>
		<input type='hidden' name='mode' value='move' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_MOVETOPIC;?>' />
		<?php
		break;

	case 'lock':
		?>
		<input type='hidden' name='mode' value='lock' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_LOCKTOPIC;?>' />
		<?php
		break;

	case 'unlock':
		?>
		<input type='hidden' name='mode' value='unlock' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_UNLOCKTOPIC;?>' />
		<?php
		break;

	case 'sticky':
		?>
		<input type='hidden' name='mode' value='sticky' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_STICKYTOPIC;?>' />
		<?php
		break;

	case 'unsticky':
		?>
		<input type='hidden' name='mode' value='unsticky' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_UNSTICKYTOPIC;?>' />
		<?php
		break;

	case 'approve_post':
		?>
		<input type='hidden' name='mode' value='approve_post' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='hidden' name='post_id' value='<?php echo $post_id?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_APPROVE;?>' />
		<?php
		break;
	case 'unapprove_post':
		?>
		<input type='hidden' name='mode' value='unapprove_post' />
		<input type='hidden' name='topic_id' value='<?php echo $topic_id?>' />
		<input type='hidden' name='forum' value='<?php echo $forum?>' />
		<input type='hidden' name='post_id' value='<?php echo $post_id?>' />
		<input type='submit' class='button' name='submit' value='<?php echo _MD_UNAPPROVE;?>' />
		<?php
		break;
}
?>

</td></tr>
</form>
</table></td></tr></table>

<?php
}

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");

?>