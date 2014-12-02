<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
$rcxOption['pagetype'] = "admin";

include_once("mainfile.php");
include_once(RCX_ROOT_PATH."/include/cp_functions.php");

$admintest = 0;

if ($rcxUser) {
  if ( !$rcxUser->isAdmin() ) {
    redirect_header("index.php", 2, _NOPERM);
    exit();
  }
  $admintest = 1;
  } else {
    redirect_header("index.php", 2, _NOPERM);
    exit();
  }

$op = "list";

if ( !empty($_GET['op']) ) {
  $op = $_GET['op'];
}

if ( !empty($_POST['op']) ) {
  $op = $_POST['op'];
}

if ($admintest == 1) {

switch ($op) {

case "list":
  rcx_cp_header();
  OpenTable();
   if ( @is_dir(RCX_ROOT_PATH."/_install" ) ) {
      redirect_header(RCX_URL."/include/noinstall.php", 0);
  die;
  }
	
if ( @is_writable(RCX_ROOT_PATH."/mainfile.php" ) ) {
         redirect_header(RCX_URL."/include/nomain.php", 0);
  die;
  }
   ?>
  <table width="100%"><tr>
<td width="100%"> 	<div class="KPstor"></div>
  <table border="0" cellpadding="0" cellspacing="0" align="top" width="100%"><tr><td class="sysbg2"><div class="KPstor">RunCms2 Goals:</div>
        <table width="100%" border="0" cellpadding="4" cellspacing="1"><tr><td class="sysbg1">
<div class="ftop">
- Simple and easy to use -<br />
- Optimize Code and Cosmetic look -<br />
- Compatible with latest server software -<br /><br />
</div></td></tr><tr><td> 

<div class="sysinf1"><b><br />
RunCms2 is based on ScarPox. (ScarPox is Only Published in Danish.)<br />
Which in turn is based on RunCms (1.4 build 20062006).<br /><br />
There is no guarantee that I will deal with RunCms out in perpetuity.</b><br /><br /> </div>
<div class="KPmellem">
RunCms2 used at your own risk.! <br />
Without warranty of any kind. <br />
All code is released under GPL <br />
<br /><div style="color: black; font-style: italic;"><small> - Sincerely, <br />
    Farsus aka Jan Cordsen <br />
Farsus Design & Hosting <br />
www.farsus.dk</small><br/><br/></div></div>
  </td></tr></table>
  <?php
  CloseTable();
  rcx_cp_footer();
  break;

default:
  break;
}

}
?>
