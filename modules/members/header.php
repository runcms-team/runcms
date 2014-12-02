<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
 * @package     modules
 * @subpackage  sections
 */

include_once('../../mainfile.php');
include_once(RCX_ROOT_PATH.'/class/groupaccess.php');

if (@file_exists('./language/'.RC_ULANG.'/main.php'))
  include_once('./language/'.RC_ULANG.'/main.php');
else
  include_once('./language/english/main.php');
?>
