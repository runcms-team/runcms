/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @ Subpackage: ScarPoX ESeditor
* @ ESeditor is based on FCKeditor by Frederico Caldeira Knabben
* @ original authers website http://www.fckeditor.net
*
*/

function afficher(txt)
{
	document.getElementById( 'uni_area' ).value = txt ;
}

function rechercher()
{
	return document.getElementById( 'uni_area' ).value ;
}