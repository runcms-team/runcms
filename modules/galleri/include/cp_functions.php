<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once(RCX_ROOT_PATH."/include/cp_functions.php");

if ( !defined("GALL_CPFUNCTIONS_INCLUDED") ) {
  define("GALL_CPFUNCTIONS_INCLUDED",1);
    
  function gall_cp_header(){
    global $rcxConfig, $rcxUser, $galerieConfig;
      rcx_cp_header();

        if ($galerieConfig['install'] == 1 && $galerieConfig['update'] >= 4){
  }
}
  function gall_cp_footer(){
        rcx_cp_footer();
  }
}
?>