<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  function &getTemplateFileListAsArray($dirname, $format="php") {
        global $myts;
        $filelist = array();
        if ($handle = @opendir($dirname)) {
          while (false !== ($file = readdir($handle))) {
            if ( preg_match("/\.(".$format.")$/i", $file) ) {
              $name = substr($file, 0, -4);
                    $name = str_replace("_", " ", $myts->makeTboxData4Show($name));
                    $filelist[$file] = $name;
            }
          }
          closedir($handle);
          asort($filelist);
          reset($filelist);
        }
        return $filelist;
    }
?>
