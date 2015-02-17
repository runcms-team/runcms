<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once('header.php');

if (!empty($_GET['storytopic'])) {
    $sql = "SELECT COUNT(*) FROM " . $db->prefix("topics") . " WHERE topic_id=" . intval($_GET['storytopic']);

    $result = $db->query($sql);

    list($count) = $db->fetch_row($result);

    if ( !$count ) {
        rcx_404_error();
    }
}

  if ($rcxConfig['startpage'] == "news")
  {
    $rcxOption['show_rblock'] = 1;
    include_once(RCX_ROOT_PATH.'/header.php');
    $start = isset($_GET['start']) ? intval($_GET['start']) : '';
    if (empty($start))
    {
      make_cblock();
    }
  }
  else
  {
    $rcxOption['show_rblock'] = 0;
    include_once(RCX_ROOT_PATH.'/header.php');
  }
include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
include_once(RCX_ROOT_PATH.'/modules/news/cache/config.php');
include_once('class/class.newsstory.php');
if ( isset($_GET['storytopic']) && is_numeric($_GET['storytopic']) ) {
  $rcxOption['storytopic'] = intval($_GET['storytopic']);
  } else {
    $rcxOption['storytopic'] = 0;
  }
if ( isset($_GET['storynum']) && is_numeric($_GET['storynum']) ) {
  $rcxOption['storynum'] = intval($_GET['storynum']);
  } else {
    $rcxOption['storynum'] = $newsConfig['storyhome'];
  }
if ( $newsConfig['displaynav'] == 1 ) {
  echo "<br /><form name='form1' action='./index.php' method='get'>";
  $xt = new RcxTopic($db->prefix("topics"));
  $xt->makeTopicSelBox(1, $rcxOption['storytopic'], "storytopic");
  echo "<select class='select' name='storynum'>";
  for ($i=5; $i<=30; $i=$i+5) {
    $sel = "";
    if ( $i == $rcxOption['storynum'] ) {
      $sel = " selected='selected'";
    }
    echo "<option value='$i'$sel>$i</option>";
  }
  echo "</select><input type='submit' class='button' value='"._GO."' /></form>";
}
$sarray     = NewsStory::getAllPublished($rcxOption['storynum'], $start, $rcxOption['storytopic']);
$storycount = NewsStory::countByTopic($rcxOption['storytopic']);
$pagenav    = new RcxPageNav($storycount, $rcxOption['storynum'], $start, "storytopic=".$rcxOption['storytopic']."&amp;storynum=".$rcxOption['storynum']."&amp;start", "");

if ($newsConfig['rss_enable'] == 1) {
  echo "<div align='right'><a href='./cache/news.xml' target='_blank'><img src='./images/xml.gif' alt='' border='0' vspace=2></a></div>";
}
if ($newsConfig['displaytwo']==0){ // 2 kolonner
foreach ($sarray as $story) {
  $poster = $story->uname();
  if ( $poster != false ) {
    $poster = "<a href='".RCX_URL."/userinfo.php?uid=".$story->uid()."'>".$poster."</a>";
    } else {
      $poster = $rcxConfig['anonymous'];
    }
  $created    = formatTimestamp($story->published());
  $hometext   = $story->hometext();
  $introcount = strlen($hometext);
  $fullcount  = strlen($story->bodytext());
  $totalcount = ($introcount + $fullcount);
  $morelink   = "";
  if ( $fullcount > 1 ) {
    $morelink .= "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
    $morelink .= "'><b>"._NW_READMORE."</b></a> | ";
    $morelink .= sprintf(_NW_BYTESMORE, $totalcount);
    $morelink .= " | ";

  }
  // fix tæller 3-1-10
$count     = $story->getCommentsCount();
//$count     = $story->comments;
//
$morelink .= "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
$morelink2 = "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
if ($count == 0 ) {
 $morelink .= "'>"._NW_COMMENTS."?</a>";
  } else {
    if ($fullcount < 1) {
      if ($count == 1) {
        $morelink .= "'><b>"._NW_READMORE."</b></a> | $morelink2'>"._NW_ONECOMMENT."</a>";
        } else {
          $morelink .= "'><b>"._NW_READMORE."</b></a> | $morelink2'>";
          $morelink .= sprintf(_NW_NUMCOMMENTS, $count);
          $morelink .= "</a>";
        } 
      } else {
        if ($count == 1) {
          $morelink .= "'>"._NW_ONECOMMENT.'</a>';
          } else {
            $morelink .= "'>";
            $morelink .= sprintf(_NW_NUMCOMMENTS, $count);
            $morelink .= '</a>';
          }
      }
  }
  $thetext    = $hometext;
  $storytopic = $story->topic();
  $adminlink  = '&nbsp;';
  if ($rcxUser) {
    if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
      $adminlink = $story->adminlink();
    }
  }
  $imglink = '';
  if ( $story->topicdisplay() ) {
    $imglink = $story->imglink();
  }
  $title = $story->textlink().' : '.$story->title();
// formatteret historie slutter her
// nu vises historien
  themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
}
}// 2 kolonner
else{
$z=1;
$e=1;
foreach ($sarray as $story) {
	$poster = $story->uname();
	if ( $poster != false ) {
		$poster = "<a href='".RCX_URL."/userinfo.php?uid=".$story->uid()."'>".$poster."</a>";
		} else {
			$poster = $rcxConfig['anonymous'];
		}
	$created    = formatTimestamp($story->published());
	$hometext   = $story->hometext();
	$introcount = strlen($hometext);
	$fullcount  = strlen($story->bodytext());
	$totalcount = ($introcount + $fullcount);
	$morelink   = "";
	if ( $fullcount > 1 ) {
		$morelink .= "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
		$morelink .= "'><b>"._NW_READMORE."</b></a> | ";
		$morelink .= sprintf(_NW_BYTESMORE, $totalcount);
    $morelink .= " | ";

	}
  // fix tæller 3-1-10
$count     = $story->getCommentsCount();
//$count     = $story->comments;
//
$morelink .= "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
$morelink2 = "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";

if ($count == 0) {
 $morelink .= "'>"._NW_COMMENTS."?</a>";
  } else {
    if ($fullcount < 1) {
      if ($count == 1) {
        $morelink .= "'><b>"._NW_READMORE."</b></a> | $morelink2'>"._NW_ONECOMMENT."</a>";
        } else {
          $morelink .= "'><b>"._NW_READMORE."</b></a> | $morelink2'>";
          $morelink .= sprintf(_NW_NUMCOMMENTS, $count);
          $morelink .= "</a>";
        }
      } else {
        if ($count == 1) {
          $morelink .= "'>"._NW_ONECOMMENT.'</a>';
          } else {
            $morelink .= "'>";
            $morelink .= sprintf(_NW_NUMCOMMENTS, $count);
            $morelink .= '</a>';
          }
      }
  }
	$thetext    = $hometext;
	$storytopic = $story->topic();
	$adminlink  = '&nbsp;';

	if ($rcxUser) {
		if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
			$adminlink = $story->adminlink();
		}
	}
	$imglink = '';
	if ( $story->topicdisplay() ) {
		$imglink = $story->imglink();
	}
	$title = $story->textlink().' : '.$story->title();
        if ($newsConfig['displayfirst']==1){  
        	if($e==1){
                        echo"<table width='100%'><tr><td valign='top' width='100%'>";
                        themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
                        echo"</td></tr></table><table width='100%'><tr><td valign='top' width='50%'>";
                        $first=1;
                }
                else{$first=0;}
        }
        elseif($e==1){
                echo"<table width='100%'><tr><td valign='top' width='50%'>";
        }

        if ($newsConfig['displayfirst']==1){
                if($z%2 == 0 AND $first!=1){
                        themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
                }
        }
        else{
                if($z%2 != 0){
                        themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
                }
        }
        $z++;
        $e++;
}
echo"</td><td valign='top' width='50%'>";
$z=1;
foreach ( $sarray as $story ) {
        if ( $story->uname() != false ) {
                $poster = "<a href='".RCX_URL."/userinfo.php?uid=".$story->uid()."'>".$story->uname()."</a>";
        } else {
                $poster = $rcxConfig['anonymous'];
        }
        $created = formatTimestamp($story->created());
        $hometext = $story->hometext();
        $introcount = strlen($hometext);
        $fullcount = strlen($story->bodytext());
        $totalcount = $introcount + $fullcount;
        $morelink = "";
        if ( $fullcount > 1 ) {
                    $morelink .= "<a href='".RCX_URL."/modules/news/article.php?storyid=".$story->storyid()."";
                    $morelink .= "'><b>"._NW_READMORE."</b></a> | ";
                $morelink .= sprintf(_NW_BYTESMORE,$totalcount);
        }
if ($count == 0) {
	} else {
		if ($fullcount < 1) {
			if ($count == 1) {
				$morelink .= "'><b>"._NW_READMORE."</b></a>";
				} else {
					$morelink .= "'><b>"._NW_READMORE."</b></a>";
				}
			} 
	}
	$thetext = $hometext."\n";
        $storytopic = $story->topic();
        $adminlink = "&nbsp;";
        if ( $rcxUser ) {
                if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
                	$adminlink = $story->adminlink();
                }
        }
        $imglink = "";
        if ( $story->topicdisplay() ) {
                $imglink = $story->imglink();
        }
        $title = $story->textlink()."&nbsp;:&nbsp;".$story->title();
// formatteret historie slutter her
// nu vises historien
        if ($newsConfig['displayfirst']==1){
                if($z%2 != 0 AND $z !=1){
                        themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
                }
        }
        else{
                if($z%2 == 0){
                        themenews($poster, $created, $title, $story->counter(), $thetext, $imglink, $adminlink, $morelink);
                }
        }
        $z++;
}
echo"</td></tr></table>";
}
// vis navigation bar
echo '<div align="center">'.$pagenav->renderNav(3, 3).'</div>';
include_once(RCX_ROOT_PATH.'/footer.php');
?>