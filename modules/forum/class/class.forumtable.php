<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined('RCX_ROOT_PATH')) {
	exit();
}
include_once('class.linker.php');

class ForumTable
{
    /* Variables */
    var $row_content = '';
	var $new_topic_data = array();


	function ForumTable()
	{
		$this->getNewTopics();
	}
	
	function addForum($forum_row)
    {
		global $db, $myts, $bbImage, $rcxUser, $rcxModule, $bbTable, $last_visit, $_COOKIE;
		
		// MARK READ //
		$topics_read = ( isset($_COOKIE['forum_read_t']) ) ? unserialize($_COOKIE['forum_read_t']) : array();
		$forums_read = ( isset($_COOKIE['forum_read_f']) ) ? unserialize($_COOKIE['forum_read_f']) : array();
		// MARK READ //

        // Sanitize the easy stuff!
        $forum_row->subject = $myts->makeTboxData4Show($forum_row->subject);
        $name         = $myts->makeTboxData4Show($forum_row->forum_name);
        $total_posts  = $forum_row->forum_posts;
        $total_topics = $forum_row->forum_topics;
		$myts->setType('admin');
        $desc         = $myts->makeTareaData4Show($forum_row->forum_desc, 1, 1, 1);
        $forum_link   = Linker::forum_link_href($forum_row->forum_id);

        if ($forum_row->post_time)
        {
                $last_post  = formatTimestamp($forum_row->post_time, "m")."<br />";
				$last_post .= "<a href='".Linker::post_link_href($forum_row->forum_last_post_id, $forum_row->topic_id, $forum_row->forum_id)."'>";
                if ($forum_row->icon)
                {
                        $last_post .= "<img src='".RCX_URL."/images/subject/".$forum_row->icon."' border='0' alt='#' />";
                }
                else
                {
                        $last_post .= "<img src='".RCX_URL."/images/subject/icon1.gif' border='0' alt='#' />";
                }
                $last_post .= "</a><br />"._MD_BY."&nbsp;";
				$last_post .= Linker::user_link($forum_row->uid);
        }

        $last_post_datetime = $forum_row->post_time;
        if (empty($last_post))
        {
                $last_post = _MD_NOPOSTS;
        }

		$unread_topics = false;
		if ( !empty($this->new_topic_data[$forum_row->forum_id]) )
		{
			$forum_last_post_time = 0;

			while( list($check_topic_id, $check_post_time) = @each($this->new_topic_data[$forum_row->forum_id]) )
			{
				if ( empty($topics_read[$check_topic_id]) )
				{
					$unread_topics = true;
					$forum_last_post_time = max($check_post_time, $forum_last_post_time);
				}
				else
				{
					if ( $topics_read[$check_topic_id] < $check_post_time )
					{
						$unread_topics = true;
						$forum_last_post_time = max($check_post_time, $forum_last_post_time);
					}
				}
			}
			if ( !empty($forums_read[$forum_row->forum_id]) )
			{
				if ( $forums_read[$forum_row->forum_id] > $forum_last_post_time )
				{
					$unread_topics = false;
				}
			}
			
			// Check Subforums
			if ($forum_row->subforum_count > 0)
			{
				$sql = "SELECT forum_id from ".$bbTable['forums']." WHERE parent_forum=".$forum_row->forum_id;
				$r = $db->query($sql);
				while ($sf_row = $db->fetch_array($r))
				{
					while( list($check_topic_id, $check_post_time) = @each($this->new_topic_data[$sf_row[0]]) )
					{
						if ( empty($topics_read[$check_topic_id]) )
						{
							$unread_topics = true;
							$forum_last_post_time = max($check_post_time, $forum_last_post_time);
						}
						else
						{
							if ( $topics_read[$check_topic_id] < $check_post_time )
							{
								$unread_topics = true;
								$forum_last_post_time = max($check_post_time, $forum_last_post_time);
							}
						}
						if ( !empty($forums_read[$sf_row[0]]) )
						{
							if ( $forums_read[$sf_row[0]] > $forum_last_post_time )
							{
								$unread_topics = false;
							}
						}
					}
				}
			}


			if ( isset($_COOKIE['forum_read_f_all']) )
			{
				if ( $_COOKIE['forum_read_f_all'] > $forum_last_post_time )
				{
					$unread_topics = false;
				}
			}
		}
		$image = ( $unread_topics ) ? '<img src="'.$bbImage['newposts'].'" title="" alt="#" />' : '<img src="'.$bbImage['folder'].'" title="" alt="#" />';

        $sf_links          = '';
        if($forum_row->subforum_count > 0)
        {
                $sf_query = "
                        SELECT f.*, u.uname, u.uid, p.topic_id, p.post_time, p.subject, p.icon
                        FROM ".$bbTable['forums']." f
                        LEFT JOIN ".$bbTable['posts']." p
                        ON p.post_id = f.forum_last_post_id
                        LEFT JOIN ".$db->prefix("users")." u
                        ON u.uid = p.uid WHERE parent_forum=".$forum_row->forum_id."
                        ORDER BY f.cat_id, f.forum_order";

                if ($res = $db->query($sf_query))
                {
                        $bSFAdded = false;
                        while ($r = $db->fetch_object($res))
                        {
                                $perm = new Permissions($r->forum_id);
                                if ($perm->can_view)
                                {
                                        if (!$bSFAdded)
                                        {
                                                $sf_links .= "<br><br>"._MD_SUBFORUMS."&nbsp;&nbsp;";
                                                $bSFAdded = true;
                                        }
                                        $sf_links .= "<a href='viewforum.php?forum=".$r->forum_id."' title='".$r->forum_desc."'>".$r->forum_name."</a>&nbsp;&nbsp;";
                                }

                                $total_posts  += $r->forum_posts;
                                $total_topics += $r->forum_topics;

                                if ($r->post_time > $last_post_datetime)
                                {
                                        $last_post_datetime = $r->post_time;
                                        $r->subject = $myts->makeTboxData4Show($r->subject);
                                        $last_post  = formatTimestamp($r->post_time, "m") . "<br />";
                                        $last_post .= "<a href='".$bbPath['url']."viewtopic.php?post_id=".$r->forum_last_post_id."&amp;topic_id=".$r->topic_id."&amp;forum=".$r->forum_id."#".$r->forum_last_post_id."'>";
                                        if ($r->icon)
                                        {
                                                $last_post .= "<img src='".RCX_URL."/images/subject/".$r->icon."' border='0' alt='#' />";
                                        }
                                        else
                                        {
                                                $last_post .= "<img src='".RCX_URL."/images/subject/icon1.gif' border='0' alt='#' />";
                                        }
                                        $last_post .= "</a><br />"._MD_BY."&nbsp;";
										$last_post .= Linker::user_link($r->uid);
								}
                        }
                }
        }

        if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
        {
                $admin_link = "<div align='left'><a href='admin/forum_manager.php?op=edit_forum&amp;forum_id=".$forum_row->forum_id."'><img src='".$bbImage['editicon']."' alt='"._EDIT."' border='0' /></a>";
        }

        $forum_display = "$admin_link <a href='$forum_link'><b>$name</b></a><br />$desc $sf_links</div>";

        $this->row_content .= '        <tr class="bg3" valign="top">';
        $this->row_content .= '                <td class="bg3" width="20">'.$image.'</td>';
        $this->row_content .= '                <td class="bg1" onmouseover="this.className=\'bg3\'; this.style.cursor=\'hand\';" onmouseout="this.className=\'bg1\';" onclick="window.location.href=\''.$forum_link.'\';">'.$forum_display.'</td>';
        $this->row_content .= '                <td class="bg3" width="5%"  align="center" valign="middle">'.$total_topics.'</td>';
        $this->row_content .= '                <td class="bg1" width="5%"  align="center" valign="middle">'.$total_posts.'</td>';
        $this->row_content .= '                <td class="bg3" width="15%" align="center" valign="middle">'.$last_post.'</td>';
        $this->row_content .= '                <td class="bg1" width="5%"  align="center" valign="middle">'.$this->get_moderators($forum_row->forum_id).'</td>';
        $this->row_content .= '        </tr>';
	}

    function getHTML()
    {
        $content  = $this->getTableHeader();
        $content .= $this->row_content;
        $content .= $this->getTableFooter();

         return $content;
    }

    function render()
    {
        echo $this->getHTML();
    }

        /* Private Functions */
        function getTableHeader()
        {
                $content  = '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">';
                $content .= '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
    		    $content .= '        <tr class="bg3" align="center">';
    		    $content .= '                <td>&nbsp;</td>';
    		    $content .= '                <td nowrap="nowrap" align="left"><b>'._MD_FORUM.'</b></td>';
    		    $content .= '                <td nowrap="nowrap"><b>'._MD_TOPICS.'</b></td>';
    		    $content .= '                <td nowrap="nowrap"><b>'._MD_POSTS.'</b></td>';
    		    $content .= '                <td nowrap="nowrap"><b>'._MD_LASTPOST.'</b></td>';
    		    $content .= '                <td nowrap="nowrap"><b>'._MD_MODERATOR.'</b></td>';
		        $content .= '        </tr>';

                return $content;
        }

        function getTableFooter()
        {
                $content  = '</table>';
                $content .= '</td></tr></table>';

                return $content;
        }
		
		function get_moderators($forum_id=0)
		{
			global $db, $myts, $bbTable;
			$content = '';

			$sql = "SELECT u.uid, u.uname FROM ".$db->prefix("users")." u, ".$bbTable['forum_mods']." f
					WHERE f.forum_id=$forum_id AND f.user_id=u.uid";

			if ($result = $db->query($sql))
			{
				if ($db->num_rows($result) > 1)
				{
					$content .= "<select class='select' name='moderators' onchange='top.location.href=\"".RCX_URL."/userinfo.php?uid=\" + this.options[this.options.selectedIndex].value + \"\";'>
								<option value='1'>------</option>";

					while (list($uid, $uname) = $db->fetch_row($result))
					{
						$content .= "<option value='$uid'>".$myts->makeTboxData4Show($uname)."</option>";
					}
					$content .= "</select>";
			}
			else
			{
				list($uid, $uname) = $db->fetch_row($result);
				$content .= " <a href='".RCX_URL."/userinfo.php?uid=".$uid."'>".$myts->makeTboxData4Show($uname)."</a>";
			}
		}
		else
		{
			$content .= "???";
		}
		return $content;
	}

	function getNewTopics()
	{
		global $db, $last_visit, $bbTable;

		$sql = "SELECT t.forum_id, t.topic_id, p.post_time 
				FROM " . $bbTable['topics'] . " t, " . $bbTable['posts'] . " p 
				WHERE p.post_id = t.topic_last_post_id 
					AND p.post_time > " . intval($last_visit);
		if ( !($result = $db->query($sql)) )
		{
			echo $sql."<br>".$db->error();
			die();
		}

		while( $topic_data = $db->fetch_row($result) )
		{
			$fid = $topic_data[0];
			$tid = $topic_data[1];
			$this->new_topic_data[$fid][$tid] = $topic_data[2];
		}
	}
}
?>