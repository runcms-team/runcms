<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if (!defined("GALL_ADMINHEADER_INCLUDED")) {define("GALL_ADMINHEADER_INCLUDED", 1);}
    include("../../../mainfile.php");
    
    echo "<style type='text/css'>
      .galladr1 a:link {color: #0000; text-decoration: none; font: bold 110% Verdana, Tahoma, sans-serif;}
      .galladr1 a:visited {color: #666666; text-decoration: none; font: bold 110% Verdana, Tahoma, sans-serif;}
      .galladr1 a:hover {color: #999999; text-decoration: none; font: bold 110% Verdana, Tahoma, sans-serif;}
      .galladr2 a:link {color: #666666; text-decoration: none; font: bold 90% Verdana, Tahoma, sans-serif;}
      .galladr2 a:visited {color: #666666; text-decoration: none; font: bold 90% Verdana, Tahoma, sans-serif;}
      .galladr2 a:hover {color: #999999; text-decoration: none; font: bold 90% Verdana, Tahoma, sans-serif;}
    .premium {border-top: 1px solid #000006; border-bottom: 1px solid #000006; border-left: 1px solid #000006; border-right: 1px solid #000006;}
    .standard {border-top: 1px solid #ECECEC; border-bottom: 1px solid #ECECEC; border-left: 1px solid #ECECEC; border-right: 1px solid #ECECEC;}
    .tb_bg1{background-color:#efefef}
    .tb_bg2{background-color:#abba2c}
    .tb_bg3{background-color:#b8b8b8}
    .tb_bg4{background-color:#abba2c}
    .tb_titel{color:#000;font-style:normal;font-weight:bolder; font-size:70%;font-family:Verdana,Arial,Helvetica,Geneva; text-decoration:none;background-color:#FFFFFF;margin:0pt;padding:2pt;border:solid 1pt #FFFFFF;}
    .tb_footer{color:#000;font-style:normal;font-weight:bolder; font-size:70%;font-family:Verdana,Arial,Helvetica,Geneva; text-decoration:none;background-color:#bdce31;text-align:right;margin:0pt;padding:2pt;border:solid 1pt #000;width:auto}
    .tb_line {background-color: #CCDDFF;background-image: url(../images/pixel.gif);}
    .textarea, .text, .button, .file {background: #ECECEC top; border: 1px solid #C0C0C0; font-family: Verdana, Tahoma, Arial; font-size: xx-small;}
    .tb_nymenu{color:#000;font-style:normal;font-weight:bolder; font-size:70%;font-family:Verdana,Arial,Helvetica,Geneva; text-decoration:none;background-color:#FFFFFF;margin:0pt;padding:2pt;border:solid 0pt #000;}

		  
		  </style>";

    define("GALLI_ACCESS", 1);
    include(RCX_ROOT_PATH."/modules/galleri/include/config.php");
    function gall_function($func, $parm_arr=array()){
        include_once(FUNC_INCL_PATH."/func_".$func.".php");
        $ret = call_user_func_array($func, $parm_arr);
        return $ret;
    }
if (@file_exists('../language/'.RC_ULANG.'/admin.php'))
  include_once('../language/'.RC_ULANG.'/admin.php');
else
  include_once('../language/english/admin.php');

    include_once(RCX_ROOT_PATH."/class/rcxmodule.php");
    if ( $rcxUser ) {
            $rcxModule = RcxModule::getByDirname("galleri");
            if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
                    define("GALL_ADMIN", 1);
            if (!defined('GALL_PAGE')) {define("GALL_PAGE", "index.php");}
            include(INCL_PATH."/cp_functions.php");
        }elseif(gall_function("coadmin_bere", array($op_coad))){
            define("GALL_CO_ADMIN", 1);
            if (!defined('GALL_PAGE')) {define("GALL_PAGE", "coadmin.php");}
            include(INCL_PATH."/coadmin_cp_functions.php");
        }else{
            redirect_header(RCX_URL."/",3,_NOPERM);
                    exit();
            }
        if ( !defined('GALL_ADMIN_HEADER_INCLUDED') ) {define("GALL_ADMIN_HEADER_INCLUDED", 1);}
        define("_STD_FONT", "<font face='Verdana,Arial,Helvetica' size='2'>");
        define("_STD_FONT_BOLD", "<font face='Verdana,Arial,Helvetica' size='2' weight='bolder'>");
        define("_ERROR_FONT", "<font face='Verdana,Arial,Helvetica' size='2' color='red'>");
    } else {
            redirect_header(RCX_URL."/",3,_NOPERM);
            exit();
    }
    include_once(INCL_PATH."/admin.errorhandler.php");
    $eh = new ErrorHandler;
    include_once(INCL_PATH."/img_popup_js.php");
?>