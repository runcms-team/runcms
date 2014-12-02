<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function format_filegroesse($groesse){
        if ($groesse >= 1073741824){
            $groesse = round($groesse / 1073741824 * 100) / 100 . " Gb";
        }elseif($groesse >= 1048576){
            $groesse = round($groesse / 1048576 * 100) / 100 . " Mb";
        }elseif($groesse >= 1024){
            $groesse = round($groesse / 1024 * 100) / 100 . " Kb";
        }else{
            $groesse = $groesse . " Byte";
        }
        if($groesse==0) {$groesse="-";}
        return $groesse;
    }
?>
