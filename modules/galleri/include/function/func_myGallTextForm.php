<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function myGallTextForm($url , $value, $option="") {
      return "<form action='$url' method='post'><input type='submit' value='$value' />".$option."</form>\n";
    }
?>
