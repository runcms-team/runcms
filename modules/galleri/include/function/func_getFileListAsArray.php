<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  function &getFileListAsArray($dirname, $type) {
        $filelist = array();
        if ($handle = @opendir($dirname)) {
          while (false !== ($file = readdir($handle))) {
            if ( preg_match("/\.(".$type.")$/i", $file) ) {
              $filelist[$file] = $file;
            }
          }
          closedir($handle);
          asort($filelist);
          reset($filelist);
        }
        return $filelist;
    }
?>
