<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
}

include_once(RCX_ROOT_PATH."/modules/system/admin/userrank/userrank.php");

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

if (in_array($op, array("RankForumAdd", "RankForumSave"))) {
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=userrank', 3, $rcx_token->getErrors(true));
        exit();
    }
}

switch($op) {
  case "RankForumAdmin":
    RankForumAdmin();
    break;

  case "RankForumEdit":
    RankForumEdit((int)$rank_id);
    break;

  case "RankForumDel":
    RankForumDel((int)$rank_id, $ok);
    break;

  case "RankForumAdd":
    RankForumAdd($rank_title, $rank_min, $rank_max, $rank_image, $rank_special);
    break;

  case "RankForumSave":
    RankForumSave((int)$rank_id, $rank_title, $rank_min, $rank_max, $rank_image, $rank_special);
    break;

  default:
    RankForumAdmin();
}
?>
