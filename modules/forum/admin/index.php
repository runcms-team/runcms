<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$pagetype = "admin";

include_once("admin_header.php");
include_once("../functions.php");
include_once("../config.php");

if ( !empty($_POST['mode']) ) {
	$mode = $_POST['mode'];

	} elseif ( !empty($_GET['mode']) ) {
			$mode = $_GET['mode'];
	}

if ( !isset($mode) ) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
<tr>
<td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _MD_A_FORUM_INDEX;?></div>
<br /><br />
<table id="table1"><tr><td><div class="kpicon">
<a href="<?php echo $bbPath['admin'];?>/forum_config.php"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_A_LINK2_FORUM_CONFIG;?>"/>
<br /><?php echo _MD_A_LINK2_FORUM_CONFIG;?></a>
<a href="<?php echo $bbPath['admin'];?>/forum_manager.php"><img src="<?php echo RCX_URL;?>/images/system/katgoriopret.png" alt="<?php echo _MD_A_LINK2_FORUM_MANAGER;?>"/>
<br /><?php echo _MD_A_FORUM_MANAGER;?></a>	
<a href="<?php echo $bbPath['admin'];?>/sync.php"><img src="<?php echo RCX_URL;?>/images/system/synkron.png" alt="<?php echo _MD_A_LINK2SYNC;?>"/>
<?php echo _MD_A_SYNCFORUM;?></a>
<a href="<?php echo $bbPath['admin'];?>/prune.php"><img src="<?php echo RCX_URL;?>/images/system/reducer.png" alt="<?php echo _MD_A_LINK2PRUNEFORUM;?>"/>
<br /><?php echo _MD_A_PRUNEFORUM;?></a></div>
</td></tr></table>
</td>
    </tr>
</table>
<?php
}

CloseTable();
rcx_cp_footer();
?>