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
      $nom=str_replace("�","ae",$nom);
      $nom=str_replace("�","oe",$nom);
      $nom=str_replace("�","ue",$nom);
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
      $nom=str_replace("�","ss",$nom);
        $nom=str_replace(":","",$nom);
        $nom=str_replace("*","",$nom);
        $nom=str_replace("|","",$nom);
        $nom=str_replace("?","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("@","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("�","",$nom);
        $nom=str_replace("!","",$nom);
        $nom=str_replace("�","",$nom);
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
