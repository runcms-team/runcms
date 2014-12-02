<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./header.php");
include_once(RCX_ROOT_PATH . "/class/rcxcomments.php");
include_once("./class/class.newsstory.php");
include_once("./cache/config.php");

$item_id = (!empty($item_id)) ? intval($item_id) : 0;
$storyid = (!empty($storyid)) ? intval($storyid) : 0;

if (empty($storyid) && empty($item_id))
{
  redirect_header("index.php", 2, _NW_NOSTORY);
  exit();
}


// set comment mode if not set
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
if (($mode != "0") && ($mode != "thread") && ($mode != "flat"))
{
  if ($rcxUser)
  {
    $mode = $rcxUser->getVar("umode");
  }
  else
  {
    $mode = $rcxConfig['com_mode'];
  }
}

// set comment order if not set
$order = isset($_GET['order']) ? intval($_GET['order']) : '';
if (($order != "0") && ($order != "1"))
{
  if ($rcxUser)
  {
    $order = $rcxUser->getVar("uorder");
  }
  else
  {
    $order = $rcxConfig['com_order'];
  }
}

if (!empty($comment_id))
{
  $artcomment = new RcxComments($db->prefix("comments"), $comment_id);
}
else
{
  $artcomment = new RcxComments($db->prefix("comments"));
}

$item_id = (!empty($storyid)) ? $storyid : $item_id;
$artcomment->setVar("item_id", $item_id);

if ( $artcomment->getVar("pid") == 0 ) {
  $story = new NewsStory($item_id);
  if ( $story->published() == 0 || $story->published() > time() ) {
    redirect_header("index.php", 2, _NW_NOSTORY);
    exit();
  }
  include_once(RCX_ROOT_PATH."/header.php");
  $datetime  = formatTimestamp($story->published());
  $title     = $story->textlink()." : ".$story->title();
  $hometext  = $story->hometext();
  $bodytext  = trim($story->bodytext());
  $morelink  = '';
  if ( empty($bodytext) ) {
    $bodytext = $hometext;
    } else {
      $content     = explode("[pagebreak]", $bodytext);
      $story_pages = count($content);
      if ($story_pages > 1) {
        $storypage = intval($_GET['storypage']);
        if ($storypage > $story_pages) {
          $storypage = $story_pages;
        }
        include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
        $nav     = new RcxPageNav($story_pages, 1, $storypage, "storypage", "storyid=$item_id");
        $pagenav = $nav->renderNav();
        if ($storypage > 0) {
          $bodytext = trim($content[$storypage]);
          } else {
            $bodytext = $hometext.'<br /><br />'.trim($content[0]);
          }
        } else {
          $bodytext = $hometext.'<br /><br />'.trim($content[0]);
        }
    }
  $poster_name = $story->uname();
  if ( $poster_name ) {
    $poster = "<a href='".RCX_URL."/userinfo.php?uid=".$story->uid()."'>".$poster_name."</a>";
    } else {
      $poster = $rcxConfig['anonymous'];
    }
  echo "<table width='100%' border='0'><tr><td valign=top>";
  $adminlink = "&nbsp;";
  if ($rcxUser) {
    if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
      $adminlink = $story->adminlink();
    }
  }
  $imglink = "";
  if ( $story->topicdisplay() ) {
    $imglink = $story->imglink();
  }
  if ( (!$rcxUser || !$rcxUser->isAdmin()) && (!isset($storypage) && empty($_COOKIE["storyread"][$item_id])) ) {
    $story->updateCounter();
    cookie("storyread[$item_id]", 1, 31536000);
  }
  themenews($poster, $datetime, $title, $story->counter(), $bodytext, $imglink, $adminlink, $pagenav);
  echo "</td><td>&nbsp;</td><td valign='top' width='200'>";
  $boxtitle  = ""._NW_RELATEDLINKS."";
  $boxstuff  = "";
  $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href='index.php?storytopic=".$story->topicid()."'>";
  $boxstuff .= sprintf(_NW_MOREABOUT, $story->topic_title());
  $boxstuff .= "</a><br />";
  // if the poster is not anonymous, show link to other articles by this poster
  if ( $poster_name ) {
    $boxstuff .= "<strong><big>&middot;</big></strong> <a href='".RCX_URL."/userinfo.php?uid=".$story->uid()."'>";
    $boxstuff .= sprintf(_NW_NEWSBY, $poster_name);
    $boxstuff .= "</a>";
  }
  $boxstuff .= "<br /><br /><b>";
  $boxstuff .= sprintf(_NW_MOSTREAD, $story->topic_title());
  $boxstuff .= "</b><br />";
  $result2   = $db->query("SELECT storyid, title FROM ".$db->prefix("stories")." WHERE topicid=".$story->topicid()." AND published <= ".time()." ORDER BY counter DESC",1,0);
  list($topstory, $ttitle) = $db->fetch_row($result2);
  $ttitle    = $myts->makeTboxData4Show($ttitle);
  $boxstuff .= "<strong><big>&middot;</big></strong> <a href='./article.php?item_id=".$topstory."'>".$ttitle."</a><br /><br /><b>";
  $boxstuff .= sprintf(_NW_LASTNEWS, $story->topic_title());
  $boxstuff .= "</b><br />";
  $result2   = $db->query("SELECT storyid, title FROM ".$db->prefix("stories")." WHERE topicid=".$story->topicid()." AND published <= ".time()." ORDER BY published DESC",1,0);
  list($topstory, $ttitle) = $db->fetch_row($result2);
  $ttitle    = $myts->makeTboxData4Show($ttitle);
  $boxstuff .= "<strong><big>&middot;</big></strong> <a href='./article.php?item_id=".$topstory."'>".$ttitle."</a><br /><br />";
  $boxstuff .= "<a href='print.php?storyid=$item_id'><img src='images/print1.gif' border='0' alt='"._NW_PRINTERFRIENDLY."' width='32' height='32' /></a>&nbsp;&nbsp;";
  $boxstuff .= "<a target='_top' href='mailto:?subject=".rawurlencode(sprintf(_NW_INTARTICLE,$meta['title']))."&body=".rawurlencode(sprintf(_NW_INTARTFOUND, $meta['title']).":\r\n".RCX_URL."/modules/".$rcxModule->dirname()."/article.php?item_id=".$story->storyid())."'><img src='images/friend1.gif' border='0' alt='"._NW_SENDSTORY."' width='32' height='32' /></a>";
  themecenterposts($boxtitle, $boxstuff);
  echo "</td></tr></table>";
}

$orderby = ($order == 1) ? "date DESC" : "date ASC";

if ( $mode == "flat" ) {
  $criteria = array("item_id=".$item_id."");
  $commentsArray = $artcomment->getAllComments($criteria, true, $orderby);
  } elseif ( $mode=="thread" ) {
    $criteria = array("item_id=".$item_id."", "pid=".$artcomment->getVar("pid")."");
    $commentsArray = $artcomment->getAllComments($criteria, true, $orderby);
    } else {
      $commentsArray = "";
    }

include_once(RCX_ROOT_PATH."/header.php");
OpenTable();

// print navbar
$artcomment->printNavBar($item_id, $mode, $order);

// Now, show comments
if ( is_array($commentsArray) && count($commentsArray) ) {
  if ( $rcxUser && $rcxUser->isAdmin($rcxModule->mid()) ) {
    $adminview = 1;
    } else {
      $adminview = 0;
    }
  if ( $mode=="flat" ) {
    $count = 0;
    foreach($commentsArray as $ele) {
      if ( !($count % 2) ) {
        $color_num = 1;
        } else {
          $color_num = 2;
        }
      $ele->showThreadPost($order, $mode, $adminview, $color_num);
      $count++;
    }
  }
  if ( $mode=="thread" ) {
    foreach($commentsArray as $ele) {
      $ele->showThreadPost($order, $mode, $adminview);
      //show thread tree
      //if not in the top page, show links to parent and top comment
      if ( $ele->getVar("pid") != 0 ) {
        echo "<div style='text-align:left'>";
        echo "<a href='./article.php?item_id=".$ele->getVar("item_id")."&amp;mode=".$mode."&amp;order=".$order."'>"._TOP."</a> | ";
        echo "<a href='./article.php?item_id=".$ele->getVar("item_id")."&amp;comment_id=".$ele->getVar("pid")."&amp;mode=".$mode."&amp;order=".$order."#".$ele->getVar("pid")."'>"._PARENT."</a>";
        echo "</div>";
      }
      echo "<br />";
      $treeArray = $ele->getCommentTree();
      if ( count($treeArray) >0 ) {
        $ele->showTreeHead();
        $count = 0;
        foreach ($treeArray as $treeItem) {
          if ( !($count % 2) ) {
            $color_num = 1;
          } else {
            $color_num = 2;
          }
          $treeItem->showTreeItem($order, $mode, $color_num);
          $count++;
        }
        $ele->showTreeFoot();
      }
    }
    echo "<br />";
  }
}

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
