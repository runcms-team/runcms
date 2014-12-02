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
include_once(RCX_ROOT_PATH."/header.php");
include_once("class/class.newsstory.php");
$count     = 0;
$altbg     = 0;
$fromyear  = "0000";
$frommonth = "00";
$lastyear  = "0000";
$lastmonth = "00";
$op = isset($_GET['op']) ? trim($_GET['op']) : '';
//switch($op) {
switch($_GET['op']) {

case "get":
  $fromyear  = intval($year);
  $frommonth = intval($month);
  break;
}
$useroffset = "0";
if ($rcxUser) {
  $timezone = $rcxUser->timezone();
  if (isset($timezone)) {
    $useroffset = $rcxUser->timezone();
    } else {
      $useroffset = $rcxConfig['default_TZ'];
    }
}
OpenTable();
echo '<table border="0" width="100%"><tr><td>';
$result=$db->query("SELECT published FROM ".$db->prefix("stories")." WHERE published>0 AND published<=".time()." ORDER BY published DESC");
if (!$result) {
  echo $db->errno(). ": ".$db->error(). "<br />";
  CloseTable();
  include_once(RCX_ROOT_PATH."/footer.php");
  exit();
  } else {
  echo "<b>"._NW_NEWSARCHIVES."</b><br /><br />";
  while (list($time) = $db->fetch_row($result)) {
    $datetime[1]  = date("Y", $time);
    $datetime[2]  = date("m", $time);
    if (($lastyear != $datetime[1]) || ($lastmonth != $datetime[2])) {
      $lastyear  = $datetime[1];
      $lastmonth = $datetime[2];
      echo "<img src='images/size.gif' border='0' alt='' align='middle' />&nbsp;<a href='archive.php?op=get&amp;year=".$lastyear."&amp;month=".$lastmonth."'>";
      switch($lastmonth) {
        case "01":
          print _NW_JANUARY;
          break;
        case "02":
          print _NW_FEBRUARY;
          break;
        case "03":
          print _NW_MARCH;
          break;
        case "04":
          print _NW_APRIL;
          break;
        case "05":
          print _NW_MAY;
          break;
        case "06":
          print _NW_JUNE;
          break;
        case "07":
          print _NW_JULY;
          break;
        case "08":
          print _NW_AUGUST;
          break;
        case "09":
          print _NW_SEPTEMBER;
          break;
        case "10":
          print _NW_OCTOBER;
          break;
        case "11":
          print _NW_NOVEMBER;
          break;
        case "12":
          print _NW_DECEMBER;
          break;
      }
      echo ", $lastyear</a><br />";
    }
  }
}
print ("</td></tr></table>");
if ($fromyear != "0000") {
  print ("<br />");
  print ("<table border='0' width='100%'><tr><td>");
  echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='bg3'>";
  echo "<tr align='center' class='bg2'><td align='left'>&nbsp;<b>"._NW_ARTICLES." ( ";
  switch($frommonth) {
    case "01":
      print _NW_JANUARY;
      break;
    case "02":
      print _NW_FEBRUARY;
      break;
    case "03":
      print _NW_MARCH;
      break;
    case "04":
      print _NW_APRIL;
      break;
    case "05":
      print _NW_MAY;
      break;
    case "06":
      print _NW_JUNE;
      break;
    case "07":
      print _NW_JULY;
      break;
    case "08":
      print _NW_AUGUST;
      break;
    case "09":
      print _NW_SEPTEMBER;
      break;
    case "10":
      print _NW_OCTOBER;
      break;
    case "11":
      print _NW_NOVEMBER;
      break;
    case "12":
      print _NW_DECEMBER;
      break;
  }
  echo "
     $fromyear )</b></td>
    <td align='center'><b>"._NW_ACTIONS."</b></td>
    <td><b>"._NW_VIEWS."</b></td>
    <td><b>"._NW_COMMENTS."</b></td>
    <td><b>"._NW_DATE."</b></td>
    </tr>";
  // må justere den valgte tid til server tidstempling
  $timeoffset = $useroffset - $rcxConfig['server_TZ'];
  $monthstart = mktime(0-$timeoffset,0,0,$frommonth,1,$fromyear);
  $monthend   = mktime(23-$timeoffset,59,59,$frommonth+1,0,$fromyear);
  $monthend   = ($monthend > time()) ? time() : $monthend;
  $sql = "SELECT * FROM ".$db->prefix("stories")." WHERE published > $monthstart and published < $monthend ORDER by published DESC";
  //echo $sql;
  $result = $db->query($sql);
  while ($myrow = $db->fetch_array($result)) {
    $article    = new NewsStory($myrow);
    $printP     = "<a href='print.php?storyid=".$article->storyid()."'><img src='images/print.gif' border='0' alt='"._NW_PRINTERFRIENDLY."' width='15' height='11' /></a>&nbsp;";
    $sendF      = "<a target='_top' href='mailto:?subject=".rawurlencode(sprintf(_NW_INTARTICLE, $meta['title']))."&body=".rawurlencode(sprintf(_NW_INTARTFOUND, $meta['title']).":\r\n".RCX_URL."/modules/".$rcxModule->dirname()."/article.php?storyid=".$article->storyid())."'><img src='images/friend.gif' border='0' alt='"._NW_SENDSTORY."' width='15' height='11' /></a>";
    $storytitle = $article->title();
    $storytopic = $article->topic_title();
    $storytitle = "<a href='index.php?storytopic=".$article->topicid()."'>".$storytopic."</a>: <a href='article.php?storyid=".$article->storyid()."'>".$storytitle."</a>";
    if ($altbg==0) {
      echo "<tr align='right' class='bg1'>";
      $altbg = 1;
      } else {
        echo "<tr align='right'>";
        $altbg=0;
      }
    $sql = $db->query("SELECT COUNT(*) FROM ".$db->prefix("comments")." WHERE item_id='".$article->storyid()."'");
    $comments = $db->fetch_row($sql);
    echo "
      <td align='left'>&nbsp;<a href='article.php?storyid=".$article->storyid()."'>".$storytitle."</td>
      <td align='center'>$printP $sendF</td>
      <td align='center'><small>".$article->counter()."</small></td>
      <td align='center'><small>".intval($comments[0])."</small></td>

      <td align='left'><small>".formatTimestamp($article->published(), "s", $useroffset)."</small></td>
      </tr>";
    $count ++;
  }
echo "</table></td></tr></table><small>";
printf(_NW_THEREAREINTOTAL, $count);
echo "</small>";
}
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
