<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
	
	function entfern_sonder($nom){
      $nom=stripslashes($nom);
      $nom=str_replace("ä","ae",$nom);
      $nom=str_replace("ö","oe",$nom);
      $nom=str_replace("ü","ue",$nom);
        $nom=str_replace("'","",$nom);
        $nom=str_replace("\"","",$nom);
        $nom=str_replace("\"","",$nom);
        $nom=str_replace("&","",$nom);
        $nom=str_replace(",","",$nom);
        $nom=str_replace(";","",$nom);
        $nom=str_replace("/","",$nom);
        $nom=str_replace("\\","",$nom);
        $nom=str_replace("`","",$nom);
        $nom=str_replace("<","",$nom);
        $nom=str_replace(">","",$nom);
        $nom=str_replace(" ","_",$nom);
      $nom=str_replace("ß","ss",$nom);
        $nom=str_replace(":","",$nom);
        $nom=str_replace("*","",$nom);
        $nom=str_replace("|","",$nom);
        $nom=str_replace("?","",$nom);
        $nom=str_replace("é","",$nom);
        $nom=str_replace("è","",$nom);
        $nom=str_replace("ç","",$nom);
        $nom=str_replace("@","",$nom);
        $nom=str_replace("â","",$nom);
        $nom=str_replace("ê","",$nom);
        $nom=str_replace("î","",$nom);
        $nom=str_replace("ô","",$nom);
        $nom=str_replace("û","",$nom);
        $nom=str_replace("ù","",$nom);
        $nom=str_replace("à","",$nom);
        $nom=str_replace("!","",$nom);
        $nom=str_replace("§","",$nom);
        $nom=str_replace("+","",$nom);
        $nom=str_replace("^","",$nom);
        $nom=str_replace("(","",$nom);
        $nom=str_replace(")","",$nom);
        $nom=str_replace("#","",$nom);
        $nom=str_replace("=","",$nom);
        $nom=str_replace("$","",$nom);
        $nom=str_replace("%","",$nom);
        return $nom;
    }

?>
