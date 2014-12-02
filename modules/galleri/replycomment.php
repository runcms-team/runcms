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
    include_once(RCX_ROOT_PATH."/class/rcxcomments.php");
    include_once(RCX_ROOT_PATH."/header.php");    
    if ( !empty($_GET['comment_id']) ) {
      $artcomment = new RcxComments($db->prefix("galli_comments"), intval($_GET['comment_id']));
  } else {
    $artcomment = new RcxComments($db->prefix("galli_comments"));
  }    
    $r_name     = RcxUser::getUnameFromId($artcomment->getVar("user_id"));
    $r_content  = _NW_POSTERC."&nbsp;".$r_name."&nbsp;"._NW_DATEC."&nbsp;".formatTimestamp($artcomment->getVar("date"))."<br /><br />";
    $r_content .= $artcomment->getVar("comment");;
    $r_subject  = $artcomment->getVar("subject");
    $subject    = $artcomment->getVar("subject", "E");
    $message    = "";
    themecenterposts($r_subject, $r_content);
    $pid     = intval($_GET['comment_id']);
    $item_id = $artcomment->getVar("item_id");
    unset($comment_id);    
    OpenTable();
    include_once(INCL_PATH."/commentform.inc.php");
    CloseTable();   
    include_once(RCX_ROOT_PATH."/footer.php");
?>
