<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* converted to Runcms2 serie by Farsus Design www.farsus.dk
*
* Original Author: LARK (balnov@kaluga.net)
* Support of the module : http://www.runcms.ru
* License Type : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 Vladislav Balnov. All rights reserved
*
*/ 

define("_AM_TPLEDITOR_NAME","Theme editor ");
define("_AM_TPLEDITOR_DESC","The module is intended for editing HTML of templates, CSS files, language files, etc.");

define("_TE_MAIN_LINK","Main");
define("_TE_TPL_LINK","Template  %s");
define("_TE_NO_DATA_ON_TPL","There are no data on templates of the module: <font color='#339933'>%s</font>");

// tpl_list.php
define("_TE_LIST_TEMPLATES","Theme list");
define("_TE_TEMPLATES","Themes");
define("_TE_EDIT","Edit");
define("_TE_NOT_TEMPLATES","Theme no");
define("_TE_LOAD_TEMPLATE","Theme Upload");
define("_TE_LOAD_FILE","<b>Upload Theme</b><br />Theme Pack Format <font color='#339933'>.zip</font><br /><font color='#FF0000'>The structure of Theme should be observed! </font>");
define("_TE_LOAD","Upload");

// tpl_edit.php
define("_TE_NO_TPL_VERSION","theme_version.php does not exist!");
define("_TE_EDITOR_TEMPLATE","Now editing: <font color='#339933'>%s</font>");
define("_TE_GENERAL_DATA","Common data");
define("_TE_TPL_NAME","Full name of Theme");
define("_TE_TPL_AUTHOR","Author");
define("_TE_TPL_AUTHOR_SITE","Authors Site");
define("_TE_TPL_LICENSE","License");
define("_TE_TPL_DESCRIPTION","Description");
define("_TE_TPL_VERSION","Version");
define("_TE_TPL_PATTERNS","Theme Base");
define("_TE_TPL_CSS","Theme CSS");
define("_TE_TPL_JAVA_SCRIPT","Theme JavaScript");
define("_TE_CLASSES_MANAGER","Class Manager");
define("_TE_SHOW","Show");
define("_TE_NO_FILE","The file is absent");
define("_TE_LANGUAGE_FILES","Language files");
define("_TE_TPL_BLOCKS","Additional Block templates");
define("_TE_GRAPHIC_FILES","Graphic files");
define("_TE_HOW_MANY_FILES","<b>Total image files: <font color='#ff8100'>%s</font></b>");
define("_TE_IMAGES_MANAGER","Image Maneger");
define("_TE_HOW_MANY_TPL","(<b>template: <font color='#ff8100'>%s</font></b>)");
define("_TE_TPL_OF_MODULES","Modules Templates");

// file_edit.php
define("_TE_NO_FILE2","The file %s is not found");
define("_TE_TPL_BLOCK","Additional templates for blocks");
define("_TE_FILE_EDITOR","Edit file: <font color='#339933'>%s</font>");
define("_TE_FILE_NAME","File Name");
define("_TE_FILE_CHANGE","Last change");
define("_TE_DESCRIPTION","Description");
define("_TE_CONTENT","Contents");
define("_TE_BASE_TAGS","The list of available base tags");
define("_TE_LANGUAGE_TAGS","The list available language tags");
define("_TE_NO_FILE3","<font color='#FF0000'>ATTENTION! The file \"%s\" is absent</font>");
define("_TE_NO_LANGUAGE_FILES","<font color='#FF0000'>ATTENTION! Language files are not found!</font>");
define("_TE_REPLACED","It will be replaced on:  <b>%s</b>");
define("_TE_NO_CONFORMITY","Conformity is not found");
define("_TE_WRITTEN_FILE","Changes in a file <font color='#339933'>%s</font> are successfully saved");
define("_TE_NO_DESCRIPTION","The description is absent");

// color_popup.php
define("_TE_FILE","File: <b>%s</b>");
define("_TE_PRINT_PAGE","Print");
define("_TE_CLOSE_PAGE","Close a window");

// css_edit.php
define("_TE_CLASSES_MANAGER2","Classes Manager: <font color='#339933'>%s</font>");
define("_TE_IMPORT_CSS","Import CSS");

// formcolortray.php
define("_TE_COLORS_TABLE","Table of colors");

// lang_edit.php
define("_TE_LANGUAGE_EDITOR","Edit language constants: <font color='#339933'>%s</font>");
define("_TE_CONST_DEF","Constants / definitions");

// tpl_extract.php
define("_TE_NO_TPL_VERSION2","In archive there is no file template_version.php");
define("_TE_TPL_IS_LOADED","The theme is loaded and unpacked in a folder \"themes\"");

// tpl_info_save.php
define("_TE_TPL_INFO_SAVE","Theme <font color='#339933'>%s</font> are successfully saved");

// img_edit.php
define("_TE_IMAGES_MANAGER2","Image manager: <font color='#339933'>%s</font>");
define("_TE_PREVIEW_IMG","Preliminary viewing");
define("_TE_BYTE","byte");
define("_TE_FORMATS_FILE","Allowable image formats: <font color='#339933'>%s</font>");
define("_TE_LOAD_IMAGE","<b>Upload image </b>");
define("_TE_LOAD","<b>Load</b>");

// tpl_files_config.php
define("_TPL_WAITBOX","The file contains a code determining appearance of the small block with the message which appears during loading page");
define("_TPL_CENTERBOX_CENTER","The file contains code HTML which determines appearance of the average central block of a portal");
define("_TPL_CENTERBOX_LEFT","The file contains code HTML which determines appearance of the left central block of a portal");
define("_TPL_CENTERBOX_RIGHT","The file contains code HTML which determines appearance of the right central block of a portal");
define("_TPL_CENTERPOSTS","The file determines appearance, first, the block \" Related links \" located on page with the full version of article, second, this field for preliminary viewing at the publication of news, the comment, or the message at a forum, in the same field in the form of the answer is located the text of the message which you make comments or on which you respond. And, thirdly, it is tops/ratings of links and files (sections \"Popular\" è \"Rating\")");
define("_TPL_FOOTER","The file contains code HTML determining appearance of the bottom part of a site");
define("_TPL_HEADER","The file contains code HTML which determines appearance of the top part of a site. Should contain necessarily tag body");
define("_TPL_MAINTENANCE","The file determines appearance of page deduced at closing a site");
define("_TPL_SIDEBOX_LEFT","The file contains code HTML which determines appearance of the left blocks of a portal");
define("_TPL_SIDEBOX_RIGHT","The file contains code HTML which determines appearance of the right blocks of a portal");
define("_TPL_POST","The file contains a code which determines appearance of comments and messages at a forum and in private");
define("_TPL_STYLE","Base for a template of the table of styles - the file is responsible for registration of basic elements HTML of pages of a site.");
define("_DEFAULT_MENU","Tables of styles for the standard menu of a site");
define("_JSCOOK_MENU","Tables of styles for dynamic menu JSCookMenu");
define("_TPL_STYLE_NN","Tables of styles for NN");
define("_DATE_JS","The file comprises a code of show current dates and time");
define("_TPL_REDIRECT","The file determines appearance of page of a redirect");

// tpl_module_edit.php
define("_TE_EDIT_MOD_TPL","Module <font color='#339933'>%s</font>");
define("_TE_MODULE_CSS","CSS of the module");
define("_TE_TPL_OF_MODULE","Templates of the module");

// functions.inc.php
define("_TE_TPL_MOD_LINK","Module %s");

// img_edit.php
define("_TE_DEL_WARNING","You really want to remove a file <font color='#339933'>%s</font> ?");
define("_TE_IMG_DELETED","The file <font color='#339933'>%s</font> is successfully removed");


// remperary delete theme function
define("_TE_DELETE","Delete");

?>
