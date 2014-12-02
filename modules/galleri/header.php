<?php
// $Id: header.php,v 1.1 2007/12/11 07:49:07 farsus Exp $
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    include("../../mainfile.php");
	include(RCX_ROOT_PATH."/header.php");
   echo "<style type='text/css'>
        .textarea, .text, .button, .file {background: #ECECEC top; border: 1px solid #C0C0C0; font-family: Verdana, Tahoma, Arial; font-size: xx-small;}
		</style>";
    define("GALLI_ACCESS", 1);
	include_once(RCX_ROOT_PATH."/modules/galleri/include/config.php");

if (@file_exists('./language/'.RC_ULANG.'/main.php'))
{
  include_once('./language/'.RC_ULANG.'/main.php');
  include_once('./language/'.RC_ULANG.'/admin.php');
}

else
{
  include_once('./language/english/admin.php');
  include_once('./language/english/main.php');
}


	$gallgalerie_perpage = $galerieConfig['perpage_width'] * $galerieConfig['perpage_height'];
	include_once(GALLI_PATH."/class/module.textsanitizer.php");
	$gallts =& GallTextSanitizer::getInstance(); 
    function gall_function($func, $parm_arr=array()){
        include_once(FUNC_INCL_PATH."/func_".$func.".php");
        $ret = call_user_func_array($func, $parm_arr);
        return $ret;
    }
    define("_STD_FONT", "<font face='Verdana,Arial,Helvetica' size='2'>");
    define("_STD_FONT_BOLD", "<font face='Verdana,Arial,Helvetica' size='2' weight='bolder'>");
    define("_ERROR_FONT", "<font face='Verdana,Arial,Helvetica' size='2' color='red'>");
	include_once(INCL_PATH."/img_popup_js.php");
	$rcxOption['show_rblock'] = $galerieConfig['show_rblock'];
	$rcxOption['page_style'] = $galerieConfig['page_style'];
?>