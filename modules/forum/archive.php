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
include_once("class/class.forumposts.php");

$forum = intval($forum);
$topic_id = intval($topic_id);
$permissions = new Permissions($forum);

if($forum == 0)
{
        display_archive();
}

if ($forum > 0 && $topic_id == 0)
{
        if ($permissions->can_view == 0)
        {
                redirect_header('archive.php',2,_MD_NORIGHTTOACCESS);
                die();
        }

        display_forum_topics($forum);
}

if ($forum > 0 && $topic_id > 0)
{
        if ($permissions->can_view == 0)
        {
                redirect_header('archive.php',2,_MD_NORIGHTTOACCESS);
                die();
        }
        display_topic($forum, $topic_id, $content_only);
}


////////////////////////////////////////////////////////////////////
function display_archive()
{
        global $db, $bbTable, $bbImage;

        include_once(RCX_ROOT_PATH."/header.php");
        OpenTable();

        echo "<table border='0' width='100%' cellpadding='5'>";
        echo "<tr><td align='left'><img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."archive.php'>";
        echo _MD_FORUM_ARCHIVE."</a>";
        echo "</td></tr></table><br>";

        echo "<table border='0' width='90%' cellpadding='5' align=center>";
        echo "<tr><td>";
        $sql = "SELECT * FROM ".$bbTable['categories'];
        $result = $db->query($sql);
        while ($row = $db->fetch_object($result))
        {
                echo "<h3>".$row->cat_title."</h3>";
                display_archive_forums($row->cat_id);
        }
        echo "</td></tr></table>";
        CloseTable();
        include_once(RCX_ROOT_PATH."/footer.php");
}

function display_archive_forums($cat_id, $parent_forum = 0, $level=0)
{
        global $db, $myts, $rcxUser, $rcxModule, $bbTable;

        $sql = "SELECT forum_id, forum_name FROM ".$bbTable['forums']." WHERE cat_id ='$cat_id' AND parent_forum=$parent_forum ORDER BY forum_id";
        if ($res = $db->query($sql))
        {
                while (list($forum_id, $forum_name) = $db->fetch_row($res))
                {
                        $permissions = new Permissions($forum_id);
                        if ($permissions->can_view == 0)
                        {
                                continue;
                        }
                        $name = $myts->makeTboxData4Show($forum_name);
                        for ($i = 0; $i<($level*4+4); $i++)
                                echo "&nbsp;";
                        echo "<a href='archive.php?forum=$forum_id'><b>$name</b></a><br>";
                        $newlevel = $level+1;
                        display_archive_forums($cat_id, $forum_id, $newlevel);
                }
        }

}
////////////////////////////////////////////////////////////////////
function display_forum_topics($forum)
{
        global $db, $myts, $rcxUser, $rcxModule, $bbTable, $bbImage;

        include_once(RCX_ROOT_PATH."/header.php");
        OpenTable();

        $q = "select * from ".$bbTable['forums']." WHERE forum_id=".$forum;
        $result = $db->query($q);
        if(!$result)
                echo $db->error();

        $forumdata = $db->fetch_array($result);
        echo "<table border='0' width='100%' cellpadding='5'>";
        echo "<tr><td align='left'><img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."archive.php'>";
        echo _MD_FORUM_ARCHIVE."</a>";
        if($forumdata['parent_forum'] == 0)
        {
                echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_close']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($forumdata['forum_name'])."</b><br />";
        }
        else
        {
                $q = "select forum_name from ".$bbTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
                $row = $db->fetch_array($db->query($q));
                echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".$myts->makeTboxData4Show($row['forum_name'])."</a>";
                echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_close']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($forumdata['forum_name'])."</b><br />";
        }
        echo "</td></tr></table><br>";

        echo "<table border='0' width='90%' cellpadding='5' align=center>";
        echo "<tr><td>";
        $sql = "select * from ".$bbTable['topics']." where forum_id=$forum order by topic_last_post_id DESC";
        $result = $db->query($sql);
        $counter = 1;
        while ($row = $db->fetch_object($result))
        {
                echo "$counter.&nbsp;";
                echo "<a href='archive.php?forum=$forum&amp;topic_id=".$row->topic_id."'>".$row->topic_title."</a>";
                echo "&nbsp;&nbsp;&nbsp;<a href='archive.php?forum=$forum&amp;topic_id=".$row->topic_id."&amp;content_only=1' target=_blank>"._MD_ARCHIVE_POPUP."</a>";
                echo "<br>";

                $counter++;
        }
        echo "</td></tr></table>";

        CloseTable();
        include_once(RCX_ROOT_PATH."/footer.php");
}
////////////////////////////////////////////////////////////////////
function display_topic($forum, $topic_id, $content_only = 1)
{
        global $db, $myts, $rcxUser, $rcxModule, $bbTable, $bbImage, $meta;

        if($content_only==0)
        {
                include_once(RCX_ROOT_PATH."/header.php");
                OpenTable();
        }

        $q = "select * from ".$bbTable['forums']." WHERE forum_id=".$forum;
        $result = $db->query($q);
        $forumdata = $db->fetch_array($result);

        $q = "select * from ".$bbTable['topics']." WHERE topic_id=".$topic_id;
        $result = $db->query($q);
        $topicdata = $db->fetch_array($result);

        echo "<table border='0' width='100%' cellpadding='5'>";
        echo "<tr><td align='left'><img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."archive.php'>";
        echo _MD_FORUM_ARCHIVE."</a>";
        if($forumdata['parent_forum'] == 0)
        {
                echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".$myts->makeTboxData4Show($forumdata['forum_name'])."</a>";
                echo "<br /><img src='".$bbImage['f_content']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($topicdata['topic_title'])."</b><br />";
        }
        else
        {
                $q = "select forum_name from ".$bbTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
                $row = $db->fetch_array($db->query($q));
                echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".$myts->makeTboxData4Show($row['forum_name'])."</a>";
                echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".$myts->makeTboxData4Show($forumdata['forum_name'])."</a>";
                echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_content']."' alt='/' />&nbsp;&nbsp;<b>".$myts->makeTboxData4Show($topicdata['topic_title'])."</b><br />";
        }

        echo "</td></tr></table><br>";

// =============== LINK HEADER ===============
echo "<table border='0' width='640' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF' align=center><tr><td>";
echo "<h3>"._MD_FORUM." : ".$forumdata['forum_name']."</h3>";
echo "<h3>"._MD_SUBJECT." : ".$topicdata['topic_title']."</h3>";
echo "<i><b>".$meta['copyright']."<br /><a href=".RCX_URL.">".RCX_URL."</a>
<br /><br />"._MD_PRINT_TOPIC_LINK."<br />
<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum</a>
</b></i><br /><br />";
// ============= END LINK HEADER =============

        $forumpost = new ForumPosts();
        $forumpost->setOrder("post_time ASC");
        $forumpost->setTopicId($topic_id);
        $forumpost->setParent(0);

        $postsArray = $forumpost->getAllPosts();
        $count = 0;
        echo "<table border='0' width='100%' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF'><tr><td>";
        foreach ($postsArray as $obj)
        {
                if ( !($count % 2) )
                {
                        $row_color = 1;
                }
                else
                {
                        $row_color = 2;
                }
                echo "<tr><td>";
                $forumpost->setType($obj->type);
                $obj->showPostForPrint($viewmode, $order, $can_post, 0, 1, 0, $row_color);
                $count++;
                echo "</td></tr>";
        }
        echo "</table>";
        echo "</td></tr></table>";

        if($content_only==0)
        {
                CloseTable();
                include_once(RCX_ROOT_PATH."/footer.php");
        }
}

?>