<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include("mainfile.php");
include(RCX_ROOT_PATH."/header.php");
$rcxOption['show_rblock'] =1;
OpenTable();
?>
<div align="center">
<strong><font color="#FF0000" size="7"><?php echo _ABUSE1;?></font></strong><br/>
<br/><img src="images/hacking.gif" width="100" height="118" alt=""/><br/><br/>
<font color="#FF0000"><strong><?php echo _ABUSE2;?></strong><br/>
</font><?php echo _ABUSE3;?></div>
<?php
CloseTable();		
include(RCX_ROOT_PATH."/footer.php");
?>