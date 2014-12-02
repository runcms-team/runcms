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
include_once('class.mypagenav.php');

/* NOTE: REQUIRES ALL TOPIC FIELDS + POST->ICON
*
*        Example:
*
*        $sql = "SELECT t.*, p.icon, p.anon_uname FROM ".$bbTable['topics']." t
*                        LEFT JOIN ".$bbTable['posts']." p
*                        ON p.post_id=t.topic_last_post_id";
*        $result = $db->query($sql, 5);
*        $topic_table = new TopicTable();
*        while($row = $db->fetch_object($result))
*        {
*                $topic_table->addTopic($row);
*        }
*        $topic_table->render();
*/

class TopicTable
{
        /* Variables */
        var $row_content = '';
        var $bSortable;
        var $sort_by;
        var $sort_order;
        var $hot_threshold;
		var $posts_per_page;

        /* Public Functions */
        function TopicTable($hot_threshold = 10, $posts_per_page = 10, $bSortable = true, $sort_by = 'post_time', $sort_order = 'DESC')
        {
                $this->hot_threshold  = $hot_threshold;
                $this->posts_per_page = $posts_per_page;
                $this->bSortable      = $bSortable;
                $this->sort_by        = $sort_by;
                $this->sort_order     = $sort_order;
        }

        function addTopic($topic_row)
        {
			global $bbImage, $db, $bbTable, $rcxUser, $rcxModule;


				$topic_bg = 'class= "bg3"';
				$adminview = 0;
				if ($rcxUser)
				{
					if ( $rcxUser->isAdmin($rcxModule->mid()) || is_moderator($topic_row->forum_id, $rcxUser->uid()))
					{
						$adminview = 1;
					}
				}
				if ($adminview)
				{
					$bUnaprovedPosts = false;
					$bUnaprovedAttach = false;

					$sql = "SELECT COUNT(*) FROM ".$bbTable['posts']." WHERE is_approved=0 AND topic_id=".$topic_row->topic_id;
					$result = $db->query($sql);
					$row = $db->fetch_array($result);
					if ($row[0] > 0) $bUnaprovedPosts = true;

					$sql = "SELECT COUNT(*) FROM ".$bbTable['posts']." p, ".$bbTable['attachments']." a WHERE p.post_id=a.post_id AND a.is_approved=0 AND p.topic_id=".$topic_row->topic_id;
					$result = $db->query($sql);
					$row = $db->fetch_array($result);
					if ($row[0] > 0) $bUnaprovedAttach = true;

					if ($bUnaprovedPosts && $bUnaprovedAttach)
					{
						$topic_bg = 'style="BACKGROUND-COLOR: #6495ED"';
					}
					else if ($bUnaprovedPosts)
					{
						$topic_bg = 'style="BACKGROUND-COLOR: #daaaaa"';
					}
					else if ($bUnaprovedAttach)
					{
						$topic_bg = 'style="BACKGROUND-COLOR: #aadaaa"';
					}

				}

				if (intval($topic_row->poll_id) > 0)
				{
					$poll = "<img src='".$bbImage['poll_mini']."' alt='[ Poll ]' />";
				}

				$pager = '';
				if (intval($topic_row->topic_replies + 1) > $this->posts_per_page)
				{
					$pager = '<br />[&nbsp;<img src="images/posticon.gif" alt="#" />&nbsp;'._MD_GOTOPAGE.'&nbsp;';
					$num_pages = ceil(($topic_row->topic_replies + 1)/$this->posts_per_page);
					if ($num_pages > 4)
					{
							$pager .= "<a href='viewtopic.php?topic_id=".$topic_row->topic_id."&amp;forum=".$topic_row->forum_id."&amp;start=0'>1</a>&nbsp;";
							$pager .= "...&nbsp;";
							for ($p = $num_pages-2; $p<=$num_pages; $p++)
							{
								$pager .= "<a href='viewtopic.php?topic_id=".$topic_row->topic_id."&amp;forum=".$topic_row->forum_id."&amp;start=".(($p-1)*$this->posts_per_page)."'>$p</a>,&nbsp;";
							}
					}
					else
					{
						for ($p = 1; $p<=$num_pages; $p++)
						{
							$pager .= "<a href='viewtopic.php?topic_id=".$topic_row->topic_id."&amp;forum=".$topic_row->forum_id."&amp;start=".(($p-1)*$this->posts_per_page)."'>$p</a>,&nbsp;";
						}
					}
					$pager = substr($pager,0,-7);
					$pager .= "&nbsp;]";
				}

                $last_post  = formatTimestamp($topic_row->post_time, "m") . "<br />";
                $last_post .= "<a href='".$bbPath['url']."viewtopic.php?post_id=".$topic_row->post_id."&amp;topic_id=".$topic_row->topic_id."&amp;forum=".$topic_row->forum_id."#".$topic_row->post_id."'>";
                if ($r->icon)
                {
					$last_post .= "<img src='".RCX_URL."/images/subject/".$topic_row->icon."' border='0' alt='#' />";
                }
                else
                {
                    $last_post .= "<img src='".RCX_URL."/images/subject/icon1.gif' border='0' alt='#' />";
                }
                $last_post .= "</a><br />"._MD_BY."&nbsp;";
				$last_post .= Linker::user_link($topic_row->uid, $topic_row->anon_uname);


                $this->row_content .= '<tr '.$topic_bg.'>';
                $this->row_content .= '<td align=center width=20><img src="'.$this->getFolderIcon($topic_row).'" alt="#" /></td>';
                $this->row_content .= '<td class="bg1" align=center width=20>'.$this->getSubjectIcon($topic_row->icon).'</td>';
                $this->row_content .= '<td>'.$poll.' '.Linker::topic_link($topic_row->topic_id, $topic_row->forum_id, $topic_row->topic_title).$pager.'</td>';
                $this->row_content .= '<td align="center" class="bg1" width=50>'.$topic_row->topic_replies.'</td>';
                $this->row_content .= '<td align="center" width=90>'.Linker::user_link($topic_row->topic_poster, $topic_row->anon_uname).'</td>';
                $this->row_content .= '<td align="center" class="bg1" width=20>'.$topic_row->topic_views.'</td>';
                $this->row_content .= '<td align="center" width=90>'.$last_post.'</td>';
                $this->row_content .= '</tr>';
        }

        function getHTML()
        {
                $content  = ($this->bSortable) ? $this->getTableHeaderSortable() : $this->getTableHeader();
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
                $content .= '<tr class="bg3">';
                $content .= '<td align="center" width=20></td>';
                $content .= '<td align="center" width=20></td>';
                $content .= '<td><b>'._MD_TOPIC.'</b></td>';
                $content .= '<td align="center"  width=20><b>'._MD_REPLIES.'</b></td>';
                $content .= '<td align="center"  width=90><b>'._MD_POSTER.'</b></td>';
                $content .= '<td align="center"  width=20><b>'._MD_VIEWS.'</b></td>';
                $content .= '<td align="center"  width=90><b>'._MD_LASTPOST.'</b></td>';
                $content .= '</tr>';

                return $content;
        }

        function getTableHeaderSortable()
        {
			global $forum;

                $content  = '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="100%"><tr><td class="bg2">';
                $content .= '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
                $content .= '<tr class="bg3">';
                $content .= '<td align="center" width=20></td>';
                $content .= '<td align="center" width=20></td>';
				
				$order = ($this->sort_by=='t.topic_title' && $this->sort_order=='DESC') ? 'ASC' : 'DESC';
                $content .= '<td><a href="viewforum.php?forum='.$forum.'&amp;sort_by=t.topic_title&amp;sort_order='.$order.'"><b>'._MD_TOPIC.'</b></a></td>';

				$order = ($this->sort_by=='t.topic_replies' && $this->sort_order=='DESC') ? 'ASC' : 'DESC';
                $content .= '<td align="center" width=20><a href="viewforum.php?forum='.$forum.'&amp;sort_by=t.topic_replies&amp;sort_order='.$order.'"><b>'._MD_REPLIES.'</b></a></td>';

				$order = ($this->sort_by=='u.uname' && $this->sort_order=='DESC') ? 'ASC' : 'DESC';
                $content .= '<td align="center" width=50><a href="viewforum.php?forum='.$forum.'&amp;sort_by=u.uname&amp;sort_order='.$order.'"><b>'._MD_POSTER.'</b></a></td>';

				$order = ($this->sort_by=='t.topic_views' && $this->sort_order=='DESC') ? 'ASC' : 'DESC';
                $content .= '<td align="center" width=20><a href="viewforum.php?forum='.$forum.'&amp;sort_by=t.topic_views&amp;sort_order='.$order.'"><b>'._MD_VIEWS.'</b></a></td>';

				$order = ($this->sort_by=='p.post_time' && $this->sort_order=='DESC') ? 'ASC' : 'DESC';
                $content .= '<td align="center" width=90><a href="viewforum.php?forum='.$forum.'&amp;sort_by=p.post_time&amp;sort_order='.$order.'"><b>'._MD_LASTPOST.'</b></a></td>';
                $content .= '</tr>';

                return $content;
        }

        function getTableFooter()
        {
                $content  = '</table>';
                $content .= '</td></tr></table>';

                return $content;
        }

        function getSubjectIcon($icon)
        {
                if (!empty($icon))
                {
                        return "<img src=\"".RCX_URL."/images/subject/".$icon."\" alt=\"#\" />";
                }
                else
                {
                        return "&nbsp;";
                }
        }

        function getFolderIcon($topic_row)
        {
                global $last_visit, $bbImage, $_COOKIE;

                $is_sticky = (intval($topic_row->topic_sticky) == 1) ? true : false;
                if($is_sticky) return $bbImage['sticky'];

                $is_locked = (intval($topic_row->topic_status) == 1) ? true : false;
                if($is_locked) return $bbImage['locked'];

                $is_hot		= (intval($topic_row->topic_replies) > $this->hot_threshold) ? true : false;			

				// MARK READ //
				$topics_read = ( isset($_COOKIE['forum_read_t']) ) ? unserialize($_COOKIE['forum_read_t']) : array();
				$forums_read = ( isset($_COOKIE['forum_read_f']) ) ? unserialize($_COOKIE['forum_read_f']) : array();
				// MARK READ //

				if( $topic_row->topic_time > $last_visit ) 
				{
					if( !empty($topics_read) || !empty($forums_read) || isset($_COOKIE['forum_read_f_all']) )
					{
						$unread_topics = true;

						if( !empty($topics_read[$topic_row->topic_id]) )
						{
							if( $topics_read[$topic_row->topic_id] >= $topic_row->topic_time )
							{
								$unread_topics = false;
							}
						}

						if( !empty($forums_read[$topic_row->forum_id]) )
						{
							if( $forums_read[$topic_row->forum_id] >= $topic_row->topic_time )
							{
								$unread_topics = false;
							}
						}

						if( isset($_COOKIE['forum_read_f_all']) )
						{
							if( $_COOKIE['forum_read_f_all'] >= $topic_row->topic_time )
							{
								$unread_topics = false;
							}
						}

						if( $unread_topics )
						{
							$img = ($is_hot) ? $bbImage['hot_newposts'] : $bbImage['newposts'];
							return $img;
						}
						else
						{
							$img = ($is_hot) ? $bbImage['hot_folder'] : $bbImage['folder'];
							return $img;
						}
					}
					else
					{
						$img = ($is_hot) ? $bbImage['hot_newposts'] : $bbImage['newposts'];
						return $img;
					}
				}
				else 
				{
					$img = ($is_hot) ? $bbImage['hot_folder'] : $bbImage['folder'];
					return $img;
				}

        }
}
?>