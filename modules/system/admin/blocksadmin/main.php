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

include (RCX_ROOT_PATH."/modules/system/admin/blocksadmin/blocksadmin.php");
$op = "list";

if ( isset($_POST) ) {
  foreach ( $_POST as $k => $v ) {
    $$k = $v;
  }
}

if ( isset($_GET['op']) ) {
  if ( $_GET['op'] == "edit" || $_GET['op'] == "copy" || $_GET['op'] == "list" || $_GET['op'] == "delete" || $_GET['op'] == "delete_ok" ) {
    $op  = $_GET['op'];
    $bid = $_GET['bid'];
  }
}

  
if (in_array($op, array("order", "save", "update", "preview"))) {
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=blocksadmin', 3, $rcx_token->getErrors(true));
        exit();
    }
}

if ( $op == "list" ) {
  rcx_cp_header();
  list_blocks($_POST['bcmodule']);
  rcx_cp_footer();
  exit();
}

if ( $op == "order" ) {
  $size = count($bid);
  for ( $i = 0; $i < $size; $i++ ) {
    if ( $oldweight[$i] != $weight[$i] || $oldvisible[$i] != $visible[$i] || $oldside[$i] != $side[$i] || $bshow_template[$i] != $oldb_template[$i])
    order_block($bid[$i], $weight[$i], $visible[$i], $side[$i],$bshow_template[$i]);
  }
  redirect_header("admin.php?fct=blocksadmin", 1, _UPDATED);
  exit();
}

if ( $op == "save" ) {
  save_block($bside, $bweight, $bvisible, $btitle, $bcontent, $bctype, $bcmodule, $bshow_template);
  exit();
}

if ( $op == "copy" ) {
  copy_block($bid);
  exit();
}

if ( $op == "update" ) {
  update_block($bid, $bside, $bweight, $bposition, $bvisible, $btitle, $bcontent, $bctype, $options, $bcmodule, $read_access, $bshow_template);
  exit();
}

if ( $op == "delete" ) {
  delete_block($bid);
  exit();
}

if ( $op == "edit" ) {
  rcx_cp_header();
  edit_block($bid);
  rcx_cp_footer();
  exit();
}


if ( $op == "preview" ) {
    
  rcx_cp_header();
  preview_cblock($bid, $btitle, $bcontent, $bctype, $bposition, $options, $bshow_template, $bside);
  edit_block($bid, $op);
  rcx_cp_footer();
  exit();
}
?>
