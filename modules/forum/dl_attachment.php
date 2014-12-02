<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    include_once("../../mainfile.php");
    include_once(RCX_ROOT_PATH.'/modules/forum/config.php');
    include_once(RCX_ROOT_PATH.'/modules/forum/class/class.attachment.php');


        $attach_id = intval($attach_id);
        $attach = Attachment::getByID($attach_id);
        if (!$attach) die(_MD_NO_SUCH_FILE);
        $attach->download();
?>
