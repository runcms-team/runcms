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
include_once("class/class.permissions.php");

$forum = intval($forum);
if ($forum == 0)
{
        redirect_header("index.php", 2, _MD_ERRORFORUM);
        exit();
}

$forum_data = getForumData($forum);
$permissions = new Permissions($forum);
if ( $permissions->can_view == 0 )
{
        redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
        exit();
}

// MARK READ //
if ( isset($GET['mark']) || isset($_POST['mark']) )
{
        $mark_read = (isset($_POST['mark'])) ? $_POST['mark'] : $_GET['mark'];
}
else
{
        $mark_read = '';
}

//
// Handle marking posts
//
if ( $mark_read == 'topics' )
{
                $sql = "SELECT MAX(post_time)
                        FROM " . $bbTable['posts'] . "
                        WHERE forum_id = $forum";
                if ( !($result = $db->query($sql)) )
                {
                        echo $sql.'<br>'.$db->error();
                        die();
                }

                if ( $row = $db->fetch_row($result) )
                {
                        $topics_read = ( isset($_COOKIE['forum_read_t']) ) ? unserialize($_COOKIE['forum_read_t']) : array();
                        $forums_read = ( isset($_COOKIE['forum_read_f']) ) ? unserialize($_COOKIE['forum_read_f']) : array();

                        if ( ( count($forums_read) + count($topics_read) ) >= 150 && empty($forums_read[$forum]) )
                        {
                                asort($forums_read);
                                unset($forums_read[key($forums_read)]);
                        }

                        if ( $row[0] > $last_visit )
                        {
                                $forums_read[$forum] = time();

                                setcookie('forum_read_f', serialize($forums_read), $bbCookie['exp_year'], $bbCookie['path'], $bbCookie['domain'], $bbCookie['secure']);
                        }
                }

        redirect_header("viewforum.php?forum=$forum", 2, _MD_MSG_MARK_READ_TOPICS);
        die();
}
//
// End handle marking posts
//

$topics_read = ( isset($_COOKIE['forum_read_t']) ) ? unserialize($_COOKIE['forum_read_t']) : array();
$forums_read = ( isset($_COOKIE['forum_read_f']) ) ? unserialize($_COOKIE['forum_read_f']) : array();


// MARK READ //



forum_page_header();
include_once("class/class.toolbar.php");
include_once('class/class.toggleblock.php');
include_once('class/class.forumtable.php');
include_once('class/class.topictable.php');
include_once("class/class.mypagenav.php");
OpenTable();
// Render Nav Bar
echo "<table border='0' width='$bbWidth' cellpadding='5' align='center'>";
echo "<tr><td align='left'><img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."index.php'>";
echo _MD_FORUMINDEX."</a>";
if($forum_data->parent_forum == 0)
{
        echo "</a><br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_close']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($forum_data->forum_name)."</b>";
}
else
{
        $q = "select forum_name from ".$bbTable['forums']." WHERE forum_id=".$forum_data->parent_forum;
        $row = $db->fetch_array($db->query($q));
        echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."viewforum.php?forum=".$forum_data->parent_forum."'>".$myts->makeTboxData4Show($row['forum_name'])."</a>";
        echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_close']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($forum_data->forum_name)."</b>";
}
echo "</td></tr></table>";

// Render Subforums
renderSubforums($forum);

$topic_count = getForumTopicCount($forum);
$pager = new MyPageNav($topic_count, $forum_data->topics_per_page, $start, "forum=$forum&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortdays=$sortdays&amp;start", "");

$pager_buttons .= "<table width='100%'>";
$pager_buttons .= "<tr>";
$pager_buttons .= "<td align=left>";
$pager_buttons .= $pager->renderNav();
$pager_buttons .= "</td>";
$pager_buttons .= "<td align=right>";
if ( $permissions->can_post)
{
        if ($forum_data->allow_polls == 1 && $permissions->can_addpoll)
        {
                $pager_buttons .= "<a href='newtopic.php?forum=$forum&amp;addpoll=1'><img src='".$bbImage['newpoll']."' alt='#' /></a>&nbsp;";
        }
        $pager_buttons .= "<a href='newtopic.php?forum=$forum'><img src='".$bbImage['newthread']."' alt=#' /></a>";
}
$pager_buttons .= "</td>";
$pager_buttons .= "</tr>";
$pager_buttons .= "</table>";
echo $pager_buttons;


$toolbar = new Toolbar($forum, $forum_data->forum_name);
$toolbar->display();

// Render Topics
$sort_by    = (isset($sort_by))    ? $sort_by    : 'p.post_time';
$sort_order = (isset($sort_order)) ? $sort_order : 'DESC';
$start                = intval($start);

renderTopics();


// Pager / Buttons
echo $pager_buttons;

include_once("class/class.tabpane.php");
$tabPane = new TabPane();

if ($forumConfig['wol_enabled'])
{
        include_once("class/tab.whosonline.php");
        $wolTab = new TabWhosOnline($forum);
        $tabPane->addTab($wolTab);
}

include_once("class/tab.legend.php");
$legend = new TabLegend(LEGEND_FORUM);
$tabPane->addTab($legend);
include_once("class/tab.search.php");
$search = new TabSearch();
$tabPane->addTab($search);
include_once("class/tab.permissions.php");
$perm = new TabPermissions($permissions);
$tabPane->addTab($perm);

$adminview = 0;
if ($rcxUser && $rcxModule)
{
        if ( $rcxUser->isAdmin($rcxModule->mid()) || is_moderator($forum, $rcxUser->uid()))
        {
                $adminview = 1;
        }
}
if ($adminview)
{
        include_once("class/tab.modlegend.php");
        $modlegend = new TabModLegend();
        $tabPane->addTab($modlegend);
}
$tabPane->render();

echo "<div align= right>";
make_jumpbox();
echo "</div>";

if ($forumConfig['rss_enable'] == 1) {
        echo "<div align='right'><a href='./cache/forum.xml' target='_blank'><img src='./images/xml.gif' border='0' vspace='2' alt='#' /></a></div>";
}
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>

<?php

function getForumData($forum)
{
        global $db, $bbTable;

        $sql = "SELECT * FROM ".$bbTable['forums']." WHERE forum_id=$forum";
        if (!$result = $db->query($sql))
        {
                redirect_header("index.php", 2, _MD_ERRORCONNECT);
                exit();
        }

        if (!$forum_data = $db->fetch_object($result))
        {
                redirect_header("index.php", 2, _MD_ERROREXIST);
                exit();
        }
        return $forum_data;
}

function getSubForumData($parent_forum)
{
        global $db, $bbTable;

        $retData = array();

        $sql = "
                SELECT f.*, u.uname, u.uid, p.topic_id, p.post_time, p.subject, p.icon
                FROM ".$bbTable['forums']." f
                LEFT JOIN ".$bbTable['posts']." p
                ON p.post_id = f.forum_last_post_id
                LEFT JOIN ".$db->prefix("users")." u
                ON u.uid = p.uid WHERE f.parent_forum = $parent_forum
                ORDER BY f.cat_id, f.forum_order";

        if (!$f_res = $db->query($sql)) {
                die("Error <br />$sql<br>$db->error()</br>");
        }

        while ($forum_data = $db->fetch_object($f_res)) {
                $retData[] = $forum_data;
        }

        return $retData;
}

function renderSubforums($parent_forum)
{
        $subforum_data = getSubForumData($parent_forum);

        $forum_count = 0;
        $forum_table = new ForumTable();
        for ($x=0; $x<count($subforum_data); $x++)
    {
            if ($forum_data[$x]->cat_id == $category['cat_id'])
        {
                        $permissions = new Permissions($subforum_data[$x]->forum_id);
            if ($permissions->can_view == 0)
            {
                    continue;
            }
                    $forum_table->addForum($subforum_data[$x]);
                        $forum_count++;
        }
    }

    // Display inside a collapsible block
        if($forum_count > 0)
        {
            $id = 'subforums';
            $title = _MD_SUBFORUMS;
            $link = '';
            ToggleBlockRenderer::render($id, $title, $link, $forum_table->getHTML());
        }
}

function getForumTopicCount($forum_id)
{
        global $db, $bbTable;
        $sql = "SELECT count(*) from ".$bbTable["topics"]." where forum_id=$forum_id";
        $res = $db->query($sql);
        $row = $db->fetch_array($res);
        return $row[0];
}

function renderTopics()
{
        global $db, $bbTable, $forum_data, $forum, $sort_by, $sort_order, $start;

        $sql = "SELECT t.*, p.*, poll.poll_id FROM ".$bbTable['topics']." t
                        LEFT JOIN ".$bbTable['posts']." p
                        ON p.post_id=t.topic_last_post_id
                        LEFT JOIN ".$bbTable['poll_desc']." poll
                        ON t.topic_id=poll.topic_id
                                                WHERE t.forum_id=$forum";
				$sql .= " ORDER BY topic_sticky DESC";
                if (!empty($sort_by) && !empty($sort_order))
                {
                        $sql .= " , $sort_by $sort_order";
                }

        $result = $db->query($sql, $forum_data->topics_per_page, $start);
        $topic_table = new TopicTable($forum_data->hot_threshold, $forum_data->posts_per_page, true, $sort_by, $sort_order);
        while($row = $db->fetch_object($result))
        {
                $topic_table->addTopic($row);
        }
        $topic_table->render();

}
?>