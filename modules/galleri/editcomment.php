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
      $artcomment = new RcxComments($db->prefix("galli_comments"), $_GET['comment_id']);
  } else {
    $artcomment = new RcxComments($db->prefix("galli_comments"));
  }   
    $allow_html    = $artcomment->getVar("allow_html");
    $allow_smileys = $artcomment->getVar("allow_smileys");
    $icon          = $artcomment->getVar("icon");
    $item_id       = $artcomment->getVar("item_id");
    $subject       = $artcomment->getVar("subject", "E");
    $message       = $artcomment->getVar("comment", "E");    
    OpenTable();
    include_once(INCL_PATH."/commentform.inc.php");
    CloseTable();    
    include_once(RCX_ROOT_PATH."/footer.php");
?>
