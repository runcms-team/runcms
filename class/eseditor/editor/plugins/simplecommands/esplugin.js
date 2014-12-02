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

ESToolbarItems.RegisterItem( 'SourceSimple'	, new ESToolbarButton( 'Source', ESLang.Source, null, ES_TOOLBARITEM_ONLYICON, true, true ) ) ;
ESToolbarItems.RegisterItem( 'StyleSimple'		, new ESToolbarStyleCombo( null, ES_TOOLBARITEM_ONLYTEXT ) ) ;
ESToolbarItems.RegisterItem( 'FontNameSimple'	, new ESToolbarFontsCombo( null, ES_TOOLBARITEM_ONLYTEXT ) ) ;
ESToolbarItems.RegisterItem( 'FontSizeSimple'	, new ESToolbarFontSizeCombo( null, ES_TOOLBARITEM_ONLYTEXT ) ) ;
ESToolbarItems.RegisterItem( 'FontFormatSimple', new ESToolbarFontFormatCombo( null, ES_TOOLBARITEM_ONLYTEXT ) ) ;
