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
include_once("class/class.toolbar.php");
include_once("class/class.mypagenav.php");

$forum    = intval($forum);
$topic_id = intval($topic_id);

if (isset($goto))
{
        if( !gotoTopic($forum, $topic_id, $goto) )
        {
                redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id",2,_MD_TOPICNOEXIST);
                die();
        }
}

if ( empty($forum) ) {
        redirect_header('index.php', 2, _MD_ERRORFORUM);
        exit();
        } elseif ( empty($topic_id) ) {
                redirect_header('viewforum.php?forum='.$forum.'', 2, _MD_ERRORTOPIC);
                exit();
        }

$adminview = 0;
if ($rcxUser) {
        if ( $rcxUser->isAdmin($rcxModule->mid()) || is_moderator($forum, $rcxUser->uid())) {
                $adminview = 1;
        }
}

// Check if topic is approved
if (!$adminview)
{
    $sql = "select is_approved, uid from ".$bbTable['posts']." WHERE topic_id=$topic_id AND pid=0";
    $result = $db->query($sql);
    $post_data = $db->fetch_array($result);
    $is_own_post = ($rcxUser && ($rcxUser->getVar('uid') == $post_data['uid']));
    if ($post_data['is_approved'] == 0 && !$is_own_post)
    {
       redirect_header('viewforum.php?forum='.$forum.'', 2, _MD_ERROR_UNAPPROVED);
       exit();
    }
}



//Début modif notification par mail
if ( $rcxUser ) {
   $user_id = $rcxUser->uid();
   $result = $db->query("SELECT email_notify FROM ".$bbTable['topics_mail']." WHERE topic_id = $topic_id AND usernotif_id = $user_id");
   $topicnotif = $db->fetch_array($result);
   if ( $flag_mail == 1 ) {
          $notif_table = $bbTable['topics_mail'];
          $sql    = "INSERT INTO ".$notif_table." ";
          $sql    .= "(email_notify,topic_id,usernotif_id) ";
          $sql    .= "VALUES ('1','$topic_id','$user_id')";
          $db->query($sql);
          $flag_reload = 1;
  }
   if ( $flag_mail == 2 ) {
           $db->query("DELETE FROM ".$bbTable['topics_mail']." WHERE topic_id='$topic_id' AND usernotif_id='$user_id'");
          $flag_reload = 1;
  }
   unset ($flag_mail);

   if ( $flag_reload ) {
      $flag_reload = 0;
      redirect_header("viewtopic.php?topic_id=$topic_id&amp;forum=$forum",1,_MD_EMAILDEMAND);
      exit();
   }
}
//Fin modif notification par mail

include_once($bbPath['path']."class/class.forumposts.php");

$sql = "
        SELECT
        t.topic_title,
        t.topic_status,
        t.topic_sticky,
        f.forum_name,
        f.allow_html,
        f.allow_sig,
        f.posts_per_page,
        f.hot_threshold,
        f.topics_per_page,
        f.allow_attachments,
        f.attach_maxkb,
        f.attach_ext,
        f.allow_polls,
        f.parent_forum
        FROM
        ".$bbTable['topics']." t
        LEFT JOIN ".$bbTable['forums']." f ON f.forum_id = t.forum_id
        WHERE
        t.topic_id = $topic_id
        AND
        t.forum_id = $forum";

if ( !$result = $db->query($sql) ) {
        $error = "<h4>"._MD_ERROROCCURED."</h4><hr />"._MD_COULDNOTQUERY;
        redirect_header("index.php", 2, $error);
        exit();
}

if ( !$forumdata = $db->fetch_array($result) ) {
        redirect_header("index.php", 2, _MD_FORUMNOEXIST);
        exit();
}

$permissions = new Permissions($forum);
if ($permissions->can_view == 0)
{
        redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
        exit();
}

$total = get_total_posts($topic_id, "topic");
if ( $total > $forumdata['posts_per_page'] ) {
        $times = 0;
        for ($x=0; $x<$total; $x+=$forumdata['posts_per_page']) {
                $times++;
        }
        $pages = $times;
}

$forumdata['topic_title'] = $myts->makeTboxData4Show($forumdata['topic_title']);


// MARK READ //

$topics_read = ( isset($_COOKIE['forum_read_t']) ) ? unserialize($_COOKIE['forum_read_t']) : array();
$forums_read = ( isset($_COOKIE['forum_read_f']) ) ? unserialize($_COOKIE['forum_read_f']) : array();
if ( !empty($topics_read[$topic_id]) && !empty($forums_read[$forum_id]) )
{
        $topic_last_read = ( $topics_read[$topic_id] > $forums_read[$forum_id] ) ? $topics_read[$topic_id] : $forums_read[$forum_id];
}
else if ( !empty($topics_read[$topic_id]) || !empty($forums_read[$forum_id]) )
{
        $topic_last_read = ( !empty($topics_read[$topic_id]) ) ? $topics_read[$topic_id] : $forums_read[$forum_id];
}
else
{
        $topic_last_read = $last_visit;
}
if ( count($topics_read) >= 150 && empty($topics_read[$topic_id]) )
{
        asort($topics_read);
        unset($topics_read[key($topics_read)]);
}
$topics_read[$topic_id] = time();
setcookie('forum_read_t', serialize($topics_read), $bbCookie['exp_year'], $bbCookie['path'], $bbCookie['domain'], $bbCookie['secure']);

// MARK READ //


forum_page_header();
include_once('class/class.toggleblock.php');
OpenTable();

echo "<table border='0' width='$bbWidth' cellpadding='5' align='center'>";
$total_forum = get_total_posts($forum, 'forum');
echo "<tr><td align='left'><img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."index.php'>";
echo _MD_FORUMINDEX.'</a>';
if($forumdata['parent_forum'] == 0)
{
echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='". $bbPath['url']."viewforum.php?forum=$forum'>".$myts->makeTboxData4Show($forumdata['forum_name'])."</a>";
echo "<br /><img src='".$bbImage['f_content']."' alt='/' />&nbsp;&nbsp;<b>";
echo $forumdata['topic_title']."</b>";
}
else
{
        $q = "select forum_name from ".$bbTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
        $row = $db->fetch_array($db->query($q));
        echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='".$bbPath['url']."viewforum.php?forum=".$forumdata['parent_forum']."'>".$myts->makeTboxData4Show($row['forum_name'])."</a>";
        echo "</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;&nbsp;<a href='". $bbPath['url']."viewforum.php?forum=$forum&amp;$total_forum'>".$myts->makeTboxData4Show($forumdata['forum_name'])."</a>";
        echo "<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_content']."' alt='/' />&nbsp;&nbsp;<b>";
        echo $forumdata['topic_title']."</b>";
}
echo "</td></tr>";
echo "</table>";

if ( isset($post_id) && $post_id != "" ) {
        $forumpost = new ForumPosts($post_id);
        } else {
                $forumpost = new ForumPosts();
        }

if ($rcxUser) {
        if ( !isset($order) ) {
                $order = $rcxUser->getVar("uorder");
        }
        if (!isset($viewmode) && $rcxUser->getVar("umode") != "0") {
                $viewmode = $rcxUser->getVar("umode");
        }
        } else {
                if ( !isset($order) ) {
                        $order = $rcxConfig['com_order'];
                }
                if ( !isset($viewmode) && ($rcxConfig['com_mode'] != "0") ) {
                        $viewmode = $rcxConfig['com_mode'];
                }
        }

if ($order == 1) {
        $qorder = "post_time DESC";
        } else {
                $qorder = "post_time ASC";
        }
$forumpost->setOrder($qorder);

if ( !isset($post_id) || $post_id == "" ) {
        $pid=0;
        $forumpost->setTopicId($topic_id);
        $forumpost->setParent($pid);
}
else
{
  $start = $forumpost->getPageOffset($forumdata['posts_per_page']);
}

if ($viewmode == "thread") {
        $postsArray = $forumpost->getTopPosts();
        } else {
                $viewmode = "flat";
                if ( isset($start) ) {
                        $postsArray = $forumpost->getAllPosts($forumdata['posts_per_page'], $start);
                        } else {
                                $postsArray = $forumpost->getAllPosts($forumdata['posts_per_page']);
                        }
        }

$pagenav = new MyPageNav($total, $forumdata['posts_per_page'], $start, "forum=$forum&amp;topic_id=$topic_id&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortdays=$sortdays&amp;viewmode=$viewmode&amp;order=$order&amp;start", "");

echo "<table width='$bbWidth'><tr>";
echo "<td align='left'>";
echo $pagenav->renderNav();
echo "</td>";
echo "<td align='right'>";
echo "<a href='print.php?forum=$forum&amp;topic_id=$topic_id' target='_blank'><img src='".$bbImage['topic_print']."' alt='"._MD_PRINT_TOPIC."' /></a>&nbsp;";

if ( $permissions->can_post == 1 )
{
        echo "<a href='newtopic.php?forum=$forum'><img src='".$bbImage['newthread']."' alt='#' /></a>&nbsp;";
}

if ($forumdata['topic_status']!=1 && $permissions->can_reply )
{
        echo "<a href='reply.php?forum=$forum&amp;post_id=".$postsArray[count($postsArray)-1]->postid()."&amp;topic_id=$topic_id&amp;viewmode=".$viewmode."&amp;order=".$order."'><img src='".$bbImage['reply']."' alt='"._MD_REPLY."' /></a>&nbsp;";
}
else if($forumdata['topic_status']==1)
{
        echo "<img src='".$bbImage['reply_locked']."' alt='#' />";
}
echo "</td>";
echo "</tr></table>";

$toolbar = new Toolbar($forum, $forumdata['forum_name'], $topic_id, $forumdata['topic_title']);
$toolbar->display();

// ADD By xtremdj to show the polls if there are one
$sql="SELECT * from ".$bbTable['poll_desc']." where topic_id=".$topic_id;

if(!$result = $db->query($sql)){
                error_die("Problem reuesting polls");
        }
        $polldata = $db->fetch_array($result);

if (($polldata["poll_id"]!="")&&($poll_id==""))
        {
        // show the polls
        echo "<table align='center' width='$bbWidth' border='0'><tr><td>";
        include_once($bbPath['path']."class/forumpoll.php");
        include_once($bbPath['path']."class/forumpolloption.php");
        include_once($bbPath['path']."class/forumpolllog.php");
        include_once($bbPath['path']."class/forumpollrenderer.php");
        $poll = new ForumPoll($polldata["poll_id"]);
        $renderer = new ForumPollRenderer($poll);

        if($rcxUser)
        {
                $voted_polls = ForumPollLog::hasVoted($polldata["poll_id"], $REMOTE_ADDR, $rcxUser->getVar("uid"));
        }
        else
        {
                $voted_polls = ForumPollLog::hasVoted($polldata["poll_id"], $REMOTE_ADDR);
        }
        if ( $voted_polls  || $permissions->can_vote==0 || $poll->hasExpired()) echo $renderer->renderResults();
        else echo $renderer->renderForm();
        echo "</td></tr></table>";

        }
        else
                if ($poll_id!="")
                {
                //Show result of the polls
                echo "<table align='center' width='$bbWidth' border='0'><tr><td>";
                include_once($bbPath['path']."class/forumpoll.php");
                include_once($bbPath['path']."class/forumpolloption.php");
                include_once($bbPath['path']."class/forumpolllog.php");
                include_once($bbPath['path']."class/forumpollrenderer.php");
    $poll = new ForumPoll($polldata["poll_id"]);
                $renderer = new ForumPollRenderer($poll);
                echo $renderer->renderResults();
                echo "</td></tr></table>";

          }
//END of Hack by xtremdj

if ($viewmode == "flat") {
        $count = 0;
        foreach ($postsArray as $obj) {
                if ( !($count % 2) ) {
                        $row_color = 1;
                        } else {
                                $row_color = 2;
                        }
                $forumpost->setType($obj->type);
                $obj->showPost($viewmode, $order, $permissions, $forumdata['topic_status'], $forumdata['allow_sig'], $adminview, $row_color, $forumdata['allow_attachments']);
                $count++;
        }
}

//if the mode is thread, show thread
if ($viewmode == "thread") {
        foreach ($postsArray as $obj) {
                $forumpost->setType($obj->type);
                $obj->showPost($viewmode, $order, $permissions, $forumdata['topic_status'], $forumdata['allow_sig'], $adminview);

                //if not in the top page, show links
                if ( $forumpost->parent() ) {
                        echo "<div style='text-align:left'>";
                        echo "&nbsp;<a href='./viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;viewmode=$viewmode&amp;order=$order'>"._MD_TOP."</a>&nbsp;|&nbsp;<a href='"._PHP_SELF."?forum=$forum&amp;topic_id=$topic_id&amp;post_id=".$forumpost->parent()."&amp;viewmode=".$viewmode."&amp;order=".$order."#".$forumpost->parent()."'>"._MD_PARENT."</a>";
                        echo "</div>";
                }
                echo "<br />";
                $treeArray = $forumpost->getPostTree($obj->postid());
                if ( count($treeArray) > 0 ) {
                        $obj->showTreeHead();
                        $count = 0;
                        foreach ($treeArray as $treeItem) {
                                if ( !($count % 2) ) {
                                        $color_num = 1;
                                        } else {
                                                $color_num = 2;
                                        }
                                $treeItem->showTreeItem($viewmode, $order, $color_num);
                                $count++;
                        }
                        $obj->showTreeFoot();
                }
                echo "<br />";
        }
}

if ( !isset($refresh) && $viewmode != "thread" ) {
        $sql = "UPDATE ".$bbTable['topics']." SET topic_views=topic_views+1 WHERE topic_id=$topic_id";
        $db->query($sql);
}

//if ( !$forumpost->parent() )
{
echo "<table width='$bbWidth'><tr>";
echo "<td align='left'>";
echo $pagenav->renderNav();
echo "</td>";
echo "<td align='right'>";

echo "<a href='print.php?forum=$forum&amp;topic_id=$topic_id' target='_blank'><img src='".$bbImage['topic_print']."' alt='"._MD_PRINT_TOPIC."' /></a>&nbsp;";

if ( $permissions->can_post == 1 )
{
        echo "<a href='newtopic.php?forum=$forum'><img src='".$bbImage['newthread']."' alt='#' /></a>&nbsp;";
}

if ($forumdata['topic_status']!=1 && $permissions->can_reply )
{
        echo "<a href='reply.php?forum=$forum&amp;post_id=".$postsArray[count($postsArray)-1]->postid()."&amp;topic_id=$topic_id&amp;viewmode=".$viewmode."&amp;order=".$order."'><img src='".$bbImage['reply']."' alt='"._MD_REPLY."' /></a>&nbsp;";
}
else if($forumdata['topic_status']==1)
{
        echo "<img src='".$bbImage['reply_locked']."' alt='#' />";
}

echo "</td>";
echo "</tr></table>";
}

// Prev/Next Topic
$topic_link = "viewtopic.php?topic_id=$topic_id&amp;forum=$forum";
echo "<div align='center'><b>&laquo;&nbsp;&nbsp;<a href='$topic_link&amp;goto=prev'>"._MD_PREV_TOPIC."</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='$topic_link&amp;goto=next'>"._MD_NEXT_TOPIC."</a>&nbsp;&nbsp;&raquo;</b></div><br />";

// Similar Threads
if($forumConfig['similar_threads'])
{
  include_once("class/class.similarthreads.php");
  $arrKeywords = split(" ", $forumdata['topic_title']);
  $st = new SimilarThreads($topic_id, $arrKeywords);
  $st->display();
}

// QuickReply
if ($forumdata['topic_status']!=1 && $permissions->can_reply )
{
        include_once(RCX_ROOT_PATH.'/class/form/themeform.php');
        include_once(RCX_ROOT_PATH.'/class/form/formhidden.php');
        include_once(RCX_ROOT_PATH.'/class/form/formtext.php');
        include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
        include_once(RCX_ROOT_PATH.'/class/form/formbutton.php');

        $num_posts = count($postsArray);
        $new_subject = $postsArray[$num_posts-1]->subject;
        if(substr($new_subject,0,3)!='Re:') $new_subject = 'Re: '.$new_subject;

        $qrform = new RcxThemeForm('', 'quick_reply', 'post.php');
        $qrform->addElement(new RcxFormHidden('forum', intval($forum)));
        $qrform->addElement(new RcxFormHidden('topic_id', intval($topic_id)));
        $qrform->addElement(new RcxFormHidden('pid', $postsArray[$num_posts-1]->post_id));
        $qrform->addElement(new RcxFormHidden('is_reply', 1));
        $qrform->addElement(new RcxFormHidden('allow_smileys', 1));
        $qrform->addElement(new RcxFormHidden('allow_bbcode', 1));
        $qrform->addElement(new RcxFormHidden('viewmode', $viewmode));
        $qrform->addElement(new RcxFormText(_MD_SUBJECT, 'subject', 60, 60, $new_subject));
        //$qrform->addElement(new RcxFormDHTMLTextArea(_MD_MESSAGEC, 'message', $message, 4, 88));
        $qrform->addElement(new RcxFormDHTMLTextArea(_MD_MESSAGEC, 'message', $message));
        $qrform->addElement(new RcxFormButton('', 'contents_submit', _REPLY, "submit"));
        ToggleBlockRenderer::render('quick_reply', _MD_QUICK_REPLY, '', $qrform->render());
}
// Quick Reply

echo "<br />";

// Tab Pane
include_once("class/class.tabpane.php");
$tabPane = new TabPane();

if ($forumConfig['wol_enabled'])
{
        include_once("class/tab.whosonline.php");
        $wolTab = new TabWhosOnline($forum);
        $tabPane->addTab($wolTab);
}

include_once("class/tab.search.php");
$search = new TabSearch();
$tabPane->addTab($search);
include_once("class/tab.permissions.php");
$perm = new TabPermissions($permissions);
$tabPane->addTab($perm);
$tabPane->render();
// Tab Pane

echo "<table width='$bbWidth'><tr>
<td>";
if ($rcxUser) {
        if ( $rcxUser->isAdmin($rcxModule->mid()) || is_moderator($forum, $rcxUser->uid()) ) {
                if ( $forumdata['topic_status'] != 1 ) {
                        echo "<a href='".$bbPath['url']."topicmanager.php?mode=lock&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['locktopic']."' alt='"._MD_LOCKTOPIC."' /></a> ";
                        } else {
                                echo "<a href='".$bbPath['url']."topicmanager.php?mode=unlock&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['unlocktopic']."' alt='"._MD_UNLOCKTOPIC."' /></a> ";
                        }
                echo "<a href='".$bbPath['url']."topicmanager.php?mode=move&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['movetopic']."' alt='"._MD_MOVETOPIC."' /></a> ";
                echo "<a href='".$bbPath['url']."topicmanager.php?mode=del&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['deltopic']."' alt='"._MD_DELETETOPIC."' /></a>";
                if ( $forumdata['topic_sticky'] == 0 ) {
                        echo "&nbsp;<a href='".$bbPath['url']."topicmanager.php?mode=sticky&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['stickytopic']."' alt='"._MD_STICKYTOPIC."' /></a>";
                        } else {
                                echo "&nbsp;<a href='".$bbPath['url']."topicmanager.php?mode=unsticky&amp;topic_id=$topic_id&amp;forum=$forum'><img src='".$bbImage['unstickytopic']."' alt='"._MD_UNSTICKYTOPIC."' /></a>";
                        }
        }
}
echo "</td>
<td align='right' valign='top'>";
make_jumpbox();
echo "</td></tr></table>";

if ($forumConfig['rss_enable'] == 1) {
        echo "<div align='right'><a href='./cache/forum.xml' target='_blank'><img src='./images/xml.gif' border='0' vspace='2' alt='XML' /></a></div>";
}
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>

<?php

function gotoTopic($forum, &$topic_id, $goto)
{
        global $db, $bbTable;

        $bFound = false;

        $sql = '';
        if($goto == "next")
        {
                $sql = "SELECT topic_id from ".$bbTable['topics']." WHERE forum_id=$forum AND topic_id>$topic_id ORDER BY topic_id ASC";
        }
        else if($goto == "prev")
        {
                $sql = "SELECT topic_id from ".$bbTable['topics']." WHERE forum_id=$forum AND topic_id<$topic_id ORDER BY topic_id DESC";
        }

        $result = $db->query($sql, 1);
        if (!$result)
        {
                echo "$sql<br>".$db->error();
                die();
        }

        if ($db->num_rows($result) == 1)
        {
                list($topic_id) = $db->fetch_row($result);
                $bFound = true;
        }

        return $bFound;
}

?>
