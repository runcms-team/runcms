<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function pruef_cname($nom){
      $nom=stripslashes($nom);
      $nom=str_replace("ä","ae",$nom);
      $nom=str_replace("ö","oe",$nom);
      $nom=str_replace("ü","ue",$nom);
        return $nom;
    }

?>
