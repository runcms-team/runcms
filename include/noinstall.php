<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include("../mainfile.php");
include(RCX_ROOT_PATH."/header.php");
$rcxOption['show_rblock'] =1;
OpenTable();
?>
<div align="center">
<strong><font color="#FF0000" size="7">WARNING !!!!</font></strong><br/>
<br/><img src="<?php echo RCX_URL;?>/images/hacking.gif" width="100" height="118" alt=""/><br/><br/>
<font color="#FF0000"><strong><h4>_install must be deletet before you can access siteadministration!!</h4></strong><br/>
</font></div>
<?php
CloseTable();		
include(RCX_ROOT_PATH."/footer.php");
?>