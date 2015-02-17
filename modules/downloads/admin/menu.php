<?php
// $Id: menu.php,v 1.1 2006/05/21 21:20:13 farsus Exp $
//***********************************************************/
//*		            	RUNCMS                              */
//*              Simplicity & ease off use                  */
//*             < http://www.runcms.org >                   */
//***********************************************************/
$adminmenu[0]['title'] = _MI_DOWNLOADS_ADMENU1;
$adminmenu[0]['link'] = "admin/index.php?op=mydownloadsConfigAdmin";
$adminmenu[1]['title'] = _MI_DOWNLOADS_ADMENU2;
$adminmenu[1]['link'] = "admin/index.php?op=downloadsConfigMenu";
$adminmenu[2]['title'] = _MI_DOWNLOADS_ADMENU3;
$adminmenu[2]['link'] = "admin/index.php?op=listNewDownloads";
$adminmenu[3]['title'] = _MI_DOWNLOADS_ADMENU4;
$adminmenu[3]['link'] = "admin/index.php?op=listBrokenDownloads";
$adminmenu[4]['title'] = _MI_DOWNLOADS_ADMENU5;
$adminmenu[4]['link'] = "admin/index.php?op=listModReq";
?>