<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !defined('FORUM_FUNCTIONS_INCLUDED') ) {
        define('FORUM_FUNCTIONS_INCLUDED', 1);

/**
* Returns the total number of posts in the whole system, a forum, or a topic
* Also can return the number of users on the system.
*
* @param type $var description
* @return type description
*/
function get_total_posts($id, $type) {
global $db, $bbTable;

switch($type) {
case 'users':
        $sql = "SELECT COUNT(*) AS total FROM ".$db->prefix("users")." u WHERE (u.uid != 0) AND (level != -1)";
        break;

case 'all':
        $sql = "SELECT COUNT(*) AS total FROM ".$bbTable['posts']."";
        break;

case 'forum':
        $sql = "SELECT COUNT(*) AS total FROM ".$bbTable['posts']." WHERE forum_id = '$id'";
        break;

case 'topic':
        $sql = "SELECT COUNT(*) AS total FROM ".$bbTable['posts']." WHERE topic_id = '$id'";
        break;

// Old, we should never get this.
case 'user':
        die("Should be using the users.user_posts column for this.");
        break;
}

if (!$result = $db->query($sql)) {
        return("ERROR");
}

if (!$myrow = $db->fetch_array($result)) {
        return("0");
}

return($myrow['total']);
}

/**
* Returns the most recent post in a forum, or a topic
*
* @param type $var description
* @return type description
*/
function get_last_post($id, $type) {
global $db, $bbTable;

switch($type) {
case 'time_fix':
        $sql = "SELECT p.post_time FROM ".$bbTable['posts']." p WHERE p.topic_id = '$id' ORDER BY post_time DESC";
        break;

case 'forum':
        $sql = "SELECT p.post_time, p.uid, u.uname FROM ".$bbTable['posts']." p, ".$db->prefix("users")." u WHERE p.forum_id = '$id' AND p.uid = u.uid ORDER BY post_time DESC";
        break;

case 'topic':
        $sql = "SELECT p.post_time, u.uname FROM ".$bbTable['posts']." p, ".$db->prefix("users")." u WHERE p.topic_id = '$id' AND p.uid = u.uid ORDER BY post_time DESC";
        break;

case 'user':
        $sql = "SELECT p.post_time FROM ".$bbTable['posts']." p WHERE p.uid = '$id'";
        break;
}

if (!$result = $db->query($sql,1,0)) {
        return(_ERROR);
}

if (!$myrow = $db->fetch_array($result)) {
        return(_MD_NOPOSTS);
}

if (($type != 'user') && ($type != 'time_fix')) {
        $val = sprintf("%s <br /> %s %s", $myrow['post_time'], _MD_BY, $myrow['uname']);
        } else {
                $val = $myrow['post_time'];
        }

return($val);
}

/**
* Checks if a user (user_id) is a moderator of a perticular forum (forum_id)
* Retruns 1 if TRUE, 0 if FALSE or Error
*
* @param type $var description
* @return type description
*/
function is_moderator($forum_id, $user_id) {
global $db, $bbTable;

$sql = "SELECT user_id FROM ".$bbTable['forum_mods']." WHERE forum_id = " . intval($forum_id) . " AND user_id = " . intval($user_id);

if (!$result = $db->query($sql)) {
        return("0");
}

if (!$myrow = $db->fetch_array($result)) {
        return("0");
}

if ($myrow['user_id'] != '') {
        return("1");
        } else {
                return("0");
        }
}

/**
* Checks if a topic is locked
*
* @param type $var description
* @return type description
*/
function is_locked($topic) {
global $db, $bbTable;

$sql = "SELECT topic_status FROM ".$bbTable['topics']." WHERE topic_id = '$topic'";

if (!$r = $db->query($sql)) {
        return(FALSE);
}

if (!$m = $db->fetch_array($r)) {
        return(FALSE);
}

if ($m[topic_status] == 1) {
        return(TRUE);
        } else {
                return(FALSE);
        }
}

/**
* Displays an error message and exits the script. Used in the posting files.
*
* @param type $var description
* @return type description
*/
function error_die($msg) {
global $bbWidth;

?>
<br />
<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="<?php echo $bbWidth;?>"><tr>
<td class="bg2">
<table border="0" cellpadding="1" cellspacing="1" width="100%"><tr class="bg3" align="left">
<td><p><ul><?php echo $msg;?></ul></p></td>
</tr></table>
</td></tr></table>
<br />

<?php
CloseTable();
include_once(RCX_ROOT_PATH . "/footer.php");
exit();
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function sync($id, $type) {
global $db, $bbTable;

switch($type) {

case 'forum':
        $sql = "SELECT max(post_id) AS last_post FROM ".$bbTable['posts']." WHERE forum_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not get post ID");
        }

        if ($row = $db->fetch_array($result)) {
                $last_post = $row["last_post"];
        }

        $sql = "SELECT count(post_id) AS total FROM ".$bbTable['posts']." WHERE forum_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not get post count");
        }

        if ($row = $db->fetch_array($result)) {
                $total_posts = $row["total"];
        }

        $sql = "SELECT count(topic_id) AS total FROM ".$bbTable['topics']." WHERE forum_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not get topic count");
        }

        if ($row = $db->fetch_array($result)) {
                $total_topics = $row["total"];
        }

        $sql = "UPDATE ".$bbTable['forums']." SET forum_last_post_id = '$last_post', forum_posts = $total_posts, forum_topics = $total_topics WHERE forum_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not update forum $id");
        }
        break;

case 'topic':
        $sql = "SELECT max(post_id) AS last_post FROM ".$bbTable['posts']." WHERE topic_id = $id";
        if (!$result = $db->query($sql)) {
                die("Could not get post ID");
        }

        if ($row = $db->fetch_array($result)) {
                $last_post = $row["last_post"];
        }

        if ( $last_post > 0 ) {
                $sql = "SELECT count(post_id) AS total FROM ".$bbTable['posts']." WHERE topic_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not get post count");
        }

        if ($row = $db->fetch_array($result)) {
                $total_posts = $row["total"];
        }

        $total_posts -= 1;
        $sql = "UPDATE ".$bbTable['topics']." SET topic_replies = $total_posts, topic_last_post_id = $last_post WHERE topic_id = $id";

        if (!$result = $db->query($sql)) {
                die("Could not update topic $id");
        }
        }
        break;

case 'all forums':
        $sql = "SELECT forum_id FROM ".$bbTable['forums']."";
        if (!$result = $db->query($sql)) {
                die("Could not get forum IDs");
        }

        while ($row = $db->fetch_array($result)) {
                $id = $row["forum_id"];
                sync($id, "forum");
        }
        break;

case 'all topics':
        $sql = "SELECT topic_id FROM ".$bbTable['topics']."";
        if (!$result = $db->query($sql)) {
                die("Could not get topic ID's");
        }

        while ($row = $db->fetch_array($result)) {
                $id = $row["topic_id"];
                sync($id, "topic");
        }
        break;
}

return(TRUE);
}

function build_rss()
{
	global $db, $bbTable, $forumConfig, $bbPath, $myts;

	if ($forumConfig['rss_enable'] == 1)
	{
		include (RCX_ROOT_PATH.'/class/xml-rss.php');
		$sql= "SELECT t.* FROM ".$bbTable['topics']." AS t, ".$bbTable['forum_group_access']." AS g WHERE t.forum_id=g.forum_id AND g.group_id=3 ORDER BY t.topic_last_post_id DESC";
		$query = $db->query($sql, $forumConfig['rss_maxitems']);
		if ($query)
		{
			$rss = new xml_rss($bbPath['path'] . 'cache/forum.xml');
			$rss->channel_title .= " :: "._MI_FORUM_NAME;
			$rss->image_title   .= " :: "._MI_FORUM_NAME;
			$rss->max_items            = $forumConfig['rss_maxitems'];
			$rss->max_item_description = $forumConfig['rss_maxdescription'];

			while ( $row = $db->fetch_object($query) )
			{
				$link = $bbPath['url'] . 'viewtopic.php?topic_id=' . $row->topic_id . '&amp;forum=' . $row->forum_id;
				$title = $myts->makeTareaData4Show($row->topic_title);
				$description = '';

				$sql = "SELECT * FROM ".$bbTable['posts']." WHERE topic_id=".$row->topic_id." ORDER BY post_id";
				if($res = $db->query($sql))
				{
					if($post_row = $db->fetch_object($res))
					{
						$description .= "\"".$post_row->post_text."\"";
						$description .= " <BR> "._MD_POSTED_BY." ";
						$description .= RcxUser::getUnameFromID($post_row->uid);
						$description .= " (".formatTimestamp($post_row->post_time).")";
					}
				}
				$rss->build($title, $link, $description);
			}
			$rss->save();
		}
	}
}

} // End FORUM_FUNCTIONS_INCLUDED
?>