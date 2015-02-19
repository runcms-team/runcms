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
include_once("../../../mainfile.php");
include_once(RCX_ROOT_PATH."/include/cp_functions.php");
/*********************************************************/
/* Admin Authentication                                  */
/*********************************************************/
$admintest = 0;
if ($rcxUser) {
  if ( !$rcxUser->isAdmin() ) {
    redirect_header(RCX_URL."/", 2, _NOPERM);
    exit();
  }
  $admintest = 1;
  } else {
    redirect_header(RCX_URL."/", 2, _NOPERM);
    exit();
  }
  rcx_cp_header();
  
  
  echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AD_LASTTENUSERS.'</div>
            <br />
            <br />';
  
  OpenTable();

echo"<table><tr>";

  $sql = "SELECT * FROM ".$db->prefix("users")." WHERE level>0 ORDER BY uid DESC";
  $result = $db->query($sql, 10, 0);
  echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

  <tr class='bg3' align='center'>


<td><b>"._AD_NICKNAME."</b></td><td><b>"._AD_EMAIL."</b></td><td><b>"._AD_AVATAR."</b></td><td><b>"._AD_REGISTERED."</b></td><td><b>"._AD_ACTION."</b></td></tr>";
  while ( $myrow = $db->fetch_array($result) ) {
    $myuser     = new RcxUser($myrow);
   $user_image = $myuser->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$myuser->getVar("user_avatar")."' alt='' />" : '&nbsp;';
    echo "
    <tr class='bg1'>
    <td><a href='".RCX_URL."/userinfo.php?uid=".$myuser->getVar("uid")."' target='_blank'>".$myuser->getVar("uname")."</a></td>
    <td><a href='mailto:".$myuser->getVar("email")."'>".$myuser->getVar("email")."</a></td>
   <td align='center'>".$user_image."</td>
    <td align='center'>".formatTimestamp($myuser->getVar("user_regdate"))."</td>
    <td align='right'><a href='".RCX_URL."/modules/system/admin.php?fct=users&amp;op=modifyUser&amp;uid=".$myuser->getVar("uid")."'>"._EDIT."</a>&nbsp;<a href='".RCX_URL."/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=".$myuser->getVar("uid")."'>"._DELETE."</a></td>
    </tr>";
  }
  echo "</table></td></tr></table><br />";

  CloseTable();
  
  
echo "                        
        </td>
    </tr>
</table>";

  rcx_cp_footer();
 // break;
  ?>
