<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (isset($_POST['fct'])) {
        $fct = trim($_POST['fct']);
}
if (isset($_GET['fct'])) {
        $fct = trim($_GET['fct']);
}
if (isset($fct) && $fct == "users") {
        $rcxOption['pagetype'] = "user";
}

$system_fct_list = array (
'blocksadmin', 
'captcha', 
'disclaimer', 
'editor', 
'filter', 
'findusers', 
'groups', 
'mailusers', 
'maintenance', 
'meta-generator', 
'modulesadmin', 
'preferences', 
'rens_cache', 
'smilies', 
'sysinfo', 
'tpleditor', 
'userrank', 
'users', 
'version');

include_once("../../mainfile.php");
include_once(RCX_ROOT_PATH."/include/cp_functions.php");
if (@file_exists(RCX_ROOT_PATH."/modules/system/language/".RC_ULANG."/admin.php"))
  include(RCX_ROOT_PATH."/modules/system/language/".RC_ULANG."/admin.php");
else
  include(RCX_ROOT_PATH."/modules/system/language/english/admin.php");

// Admin Authentication                                  
$admintest = 0;
if ($rcxUser) {
  $rcxModule = RcxModule::getByDirname("system");
  if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
    redirect_header(RCX_URL."/", 3, _NOPERM);
    exit();
  }
  $admintest = 1;
  } else {
    redirect_header(RCX_URL."/", 3, _NOPERM);
    exit();
  }
if ($admintest == 1) {
  if ( !empty($fct) ) {
      
     $fct = preg_replace("/[^a-z0-9_\-]/i", "", $fct);

     if (!in_array($fct, $system_fct_list)) {
         redirect_header(RCX_URL."/", 3, _NOPERM);
         exit();
     }
      
     if ( @file_exists(RCX_ROOT_PATH."/modules/system/admin/".$fct."/main.php") ) {
      if ( @file_exists(RCX_ROOT_PATH."/modules/system/admin/".$fct."/language/".RC_ULANG."/".$fct.".php") ) {
        include(RCX_ROOT_PATH."/modules/system/admin/".$fct."/language/".RC_ULANG."/".$fct.".php");
      } elseif ( @file_exists(RCX_ROOT_PATH."/modules/system/admin/".$fct."/language/english/".$fct.".php") ) {
        include(RCX_ROOT_PATH."/modules/system/admin/".$fct."/language/english/".$fct.".php");
      }
      include(RCX_ROOT_PATH."/modules/system/admin/".$fct."/main.php");
   } else {
      rcx_cp_header();
      system_menu();
      rcx_cp_footer();
    }
    } else {
      rcx_cp_header();
      system_menu();
      rcx_cp_footer();
    }
}

// Core Menu Functions
/**
* Description
*
* @param type $var description
* @return type description
*/
function system_menu_item($folder, $modversion) {
global $rcxConfig;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function system_menu() {
global $rcxConfig, $rcxUser, $rcxModule;
OpenTable();
echo "<table border='0' cellpadding='1' align='center'><tr>";
$admin_dir = RCX_ROOT_PATH."/modules/system/admin";
$handle    = @opendir($admin_dir);
$counter   = 0;
while (false !== ($file = readdir($handle))) {
  if ( $file != '.' && $file != '..' && @file_exists($admin_dir."/".$file."/rcxv.php") ) {
    include_once($admin_dir."/".$file."/rcxv.php");
    if ( $modversion['hasAdmin'] ) {
      echo "<td align='center' valign='bottom' width='19%'>";
      system_menu_item($file, $modversion);
      echo "</td>";
      $counter++;
    }
    if ( $counter > 4 ) {
      $counter = 0;
      echo "</tr><tr>";
    }
  }
unset($modversion);
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
<tr>
    <td width="724px" class="KPindex">
<div class="KPstor" ><?php echo _MI_SYSTEM_NAME;?></div><br />
		<br />
	<div class="kpicon"><table><tr><td>
				<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=blocksadmin"><img src="<?php echo RCX_URL;?>/images/system/blokke.png" alt="<?php echo _MD_AM_BKAD;?>"><br /><?php echo _MD_AM_BKAD;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=modulesadmin"><img src="<?php echo RCX_URL;?>/images/system/moduler.png" alt="<?php echo _MD_AM_MDAD;?>"/>	
<br />
<?php echo _MD_AM_MDAD;?>
</a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=preferences"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_AM_PREF;?>"/>
<br />
<?php echo _MD_AM_PREF;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=disclaimer"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _MD_AM_DISC;?>"/>
<br />
<?php echo _MD_AM_DISC;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=maintenance"><img src="<?php echo RCX_URL;?>/images/system/maintance.png" alt="<?php echo _MD_AM_MAINT;?>"/>
<br />
<?php echo _MD_AM_MAINT;?></a>
</td></tr><tr><td>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=userrank"><img src="<?php echo RCX_URL;?>/images/system/userrank.png" alt="<?php echo _MD_AM_RANK;?>"/>
<br />
<?php echo _MD_AM_RANK;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=users"><img src="<?php echo RCX_URL;?>/images/system/edituser.png" alt="<?php echo _MD_AM_USER;?>"/>
<br />
<?php echo _MD_AM_USER;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=findusers"><img src="<?php echo RCX_URL;?>/images/system/finduser.png" alt="<?php echo _MD_AM_FINDUSER;?>"/>
<br />
<?php echo _MD_AM_FINDUSER;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=groups"><img src="<?php echo RCX_URL;?>/images/system/grupper.png" alt="<?php echo _MD_AM_ADGS;?>"/>
<br />
<?php echo _MD_AM_ADGS;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/include/nyebruger.php"><img src="<?php echo RCX_URL;?>/images/system/nyebruger.png" alt="<?php echo _MD_AM_NYESTE;?>"/>
<br />
<?php echo _MD_AM_NYESTE;?>
</a>
</td></tr><tr><td>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=meta-generator"><img src="<?php echo RCX_URL;?>/images/system/metagen.png" alt="<?php echo _MD_AM_META;?>"/>
<br />
<?php echo _MD_AM_META;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=filter"><img src="<?php echo RCX_URL;?>/images/system/filter.png" alt="<?php echo _MD_AM_FLTR;?>"/>
<br />
<?php echo _MD_AM_FLTR;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=captcha"><img src="<?php echo RCX_URL;?>/images/system/captcha.png" alt="<?php echo _MD_AM_CAPTCHA;?>"/>
 <br />
<?php echo _MD_AM_CAPTCHA;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=editor"><img src="<?php echo RCX_URL;?>/images/system/editor.png" alt="<?php echo _MD_AM_EDITOR;?>"/>
<br />
<?php echo _MD_AM_EDITOR;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=mailusers"><img src="<?php echo RCX_URL;?>/images/system/mailuser.png" alt="<?php echo _MD_AM_MLUS;?>"/>
<br />
<?php echo _MD_AM_MLUS;?></a>
</td></tr><tr><td>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=smilies"><img src="<?php echo RCX_URL;?>/images/system/smilie.png" alt="<?php echo _MD_AM_SMLS;?>"/>
<br />
<?php echo _MD_AM_SMLS;?></a>
<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=tpleditor"><img src="<?php echo RCX_URL;?>/images/system/oploadsetop.png" alt="<?php echo _MD_AM_FRI;?>"/>
<br />
<?php echo _MD_AM_THEMEEDITOR;?></a>
<a href=""><img src="<?php echo RCX_URL;?>/images/system/blank.png" alt="<?php echo _MD_AM_FRI;?>"/>
<br />
<?php echo _MD_AM_FRI;?></a>	

<a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=rens_cache"><img src="<?php echo RCX_URL;?>/images/system/renscache.png" alt="<?php echo _MD_AM_RENSCACHE;?>"/>
<br />
<?php echo _MD_AM_RENSCACHE;?></a>
</a><a href="<?php echo RCX_URL;?>/modules/system/admin.php?fct=sysinfo"><img src="<?php echo RCX_URL;?>/images/system/sysinfo.png" alt="<?php echo _MD_AM_SYSINFO;?>"/>
<br />
<?php echo _MD_AM_SYSINFO;?></a>
</td></tr></table></div>
	</td></tr>
  </table>
<?php
CloseTable();
}
?>
