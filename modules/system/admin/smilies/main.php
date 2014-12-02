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

include_once(RCX_ROOT_PATH."/modules/system/admin/smilies/smilies.php");

if (in_array($op, array("SmilesAdd", "SmilesSave"))) {
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=smilies', 3, $rcx_token->getErrors(true));
        exit();
    }
}

switch($op) {

  case "SmilesAdmin":
    SmilesAdmin();
    break;

  case "SmilesAdd":
    SmilesAdd($code,$smile_url,$emotion);
    break;

  case "SmilesEdit":
    SmilesEdit((int)$id);
    break;

  case "SmilesSave":
    SmilesSave((int)$id,$code,$smile_url,$emotion);
    break;

  case "SmilesDel":
    SmilesDel((int)$id, $ok);
    break;

  default:
    SmilesAdmin();
    break;
}

?>
