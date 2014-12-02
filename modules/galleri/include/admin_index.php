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
    include ("rcxv.php");
  
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
  <tr>
    <td width="724px" class="KPindex">
<div class="KPstor" ><?php echo _AD_MA_GALLI_HOVEDADMIN;?></div><br />
	
	<br />
	<div class="kpicon"><table><tr><td>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=cat_conf">
		<img src="<?php echo RCX_URL;?>/images/system/katgoriopret.png" alt="<?php echo _MI_GALLI_ADMENU2;?>" />
<br />
<?php echo _MI_GALLI_ADMENU2;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=img_conf">
		<img src="<?php echo RCX_URL;?>/images/system/oploadgal.png" alt="<?php echo _MI_GALLI_ADMENU3;?>" />	
<br />
<?php echo _MI_GALLI_ADMENU3;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=ftp_upload">
		<img src="<?php echo RCX_URL;?>/images/system/oploadftp.png" alt="<?php echo _MI_GALLI_ADMENU4;?>" />
<br />
<?php echo _MI_GALLI_ADMENU4;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=img_copyr">
		<img src="<?php echo RCX_URL;?>/images/system/copyrightedit.png" alt="<?php echo _MI_GALLI_ADMENU5;?>" />
<br />
<?php echo _MI_GALLI_ADMENU5;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=menue_copyr">
		<img src="<?php echo RCX_URL;?>/images/system/copyrightinfo.png" alt="<?php echo _MI_GALLI_ADMENU6;?>" /><br /><?php echo _MI_GALLI_ADMENU6;?></a><br /><td></tr>
		<tr><td>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=allg_einst">
		<img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MI_GALLI_ADMENU7;?>" />
		<br />
<?php echo _MI_GALLI_ADMENU7;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=haupts_einst">
		<img src="<?php echo RCX_URL;?>/images/system/forsidesetop.png" alt="<?php echo _MI_GALLI_ADMENU8;?>" />
		<br />
<?php echo _MI_GALLI_ADMENU8;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=cat_einst">
		<img src="<?php echo RCX_URL;?>/images/system/katgorisetop.png" alt="<?php echo _MI_GALLI_ADMENU9;?>" />
		<br />
<?php echo _MI_GALLI_ADMENU9;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=design_block">
		<img src="<?php echo RCX_URL;?>/images/system/blokke.png" alt="<?php echo _MI_GALLI_ADMENU10;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU10;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=rahmen_einst">
		<img src="<?php echo RCX_URL;?>/images/system/rammesetop.png" alt="<?php echo _MI_GALLI_ADMENU11;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU11;?>
</a><br />
		</td></tr><tr><td>
        <a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=upload_einst">
		<img src="<?php echo RCX_URL;?>/images/system/oploadsetop.png" alt="<?php echo _MI_GALLI_ADMENU12;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU12;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=admin_design">
		<img src="<?php echo RCX_URL;?>/images/system/adminsetop.png" alt="<?php echo _MI_GALLI_ADMENU13;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU13;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=extra_einst">
		<img src="<?php echo RCX_URL;?>/images/system/ekstrasetop.png" alt="<?php echo _MI_GALLI_ADMENU14;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU14;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=CoAdmin_config">
		<img src="<?php echo RCX_URL;?>/images/system/coadminsetop.png" alt="<?php echo _MI_GALLI_ADMENU15;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU15;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=User_config">
		<img src="<?php echo RCX_URL;?>/images/system/oploadsret.png" alt="<?php echo _MI_GALLI_ADMENU16;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU16;?>
</a><br />
		</td></tr><tr><td>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=system_test">
		<img src="<?php echo RCX_URL;?>/images/system/systemtest.png" alt="<?php echo _MI_GALLI_ADMENU18;?>"/>
		<br />
<?php echo _MI_GALLI_ADMENU18;?>
</a>
        <a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php?op=gd_info">
		<img src="<?php echo RCX_URL;?>/images/system/gdinfo.png" alt="<?php echo _MI_GALLI_ADMENU19;?>"/>
<br />
<?php echo _MI_GALLI_ADMENU19;?>
</a>
	    <a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php">
		<img src="<?php echo RCX_URL;?>/images/system/blank.png" alt="<?php echo _MD_AM_FRI;?>"/>
		<br />
<?php echo _MD_AM_FRI;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php">
		<img src="<?php echo RCX_URL;?>/images/system/blank.png" alt="<?php echo _MD_AM_FRI;?>"/>
		<br />
<?php echo _MD_AM_FRI;?>
</a>
		<a href="<?php echo RCX_URL;?>/modules/galleri/admin/index.php">
		<img src="<?php echo RCX_URL;?>/images/system/blank.png" alt="<?php echo _MD_AM_FRI;?>"/>
		<br />
<?php echo _MD_AM_FRI;?>
</a><br />
		</td></tr></table>
	</td>

<?php

echo "</tr></table>";



 


?>