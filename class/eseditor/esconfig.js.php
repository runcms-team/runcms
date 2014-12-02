<?php
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
$rcxOption['nocommon'] = 1;
include_once ('../../mainfile.php');
?>
ESConfig.CustomConfigurationsPath = '' ;
ESConfig.EditorAreaCSS = ESConfig.BasePath + 'css/es_editorarea.css' ;
ESConfig.DocType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' ;
ESConfig.BaseHref = '' ;
ESConfig.FullPage = false ;
ESConfig.Debug = false ;
ESConfig.AllowQueryStringDebug = true ;
ESConfig.SkinPath = ESConfig.BasePath + 'skins/silver/' ;
ESConfig.PluginsPath = ESConfig.BasePath + 'plugins/' ;
// ESConfig.Plugins.Add( 'placeholder', 'de,en,fr,it,pl' ) ;
ESConfig.ProtectedSource.Add( /<script[\s\S]*?\/script>/gi ) ;	// <SCRIPT> tags.
ESConfig.ProtectedSource.Add( /<\?[\s\S]*?\?>/g ) ;	
ESConfig.AutoDetectLanguage	= true ;
ESConfig.DefaultLanguage	= 'en' ;
ESConfig.ContentLangDirection	= 'ltr' ;
ESConfig.EnableXHTML		= true ;
ESConfig.EnableSourceXHTML	= true ;
ESConfig.ProcessHTMLEntities	= true ;
ESConfig.IncludeLatinEntities	= true ;
ESConfig.IncludeGreekEntities	= true ;
ESConfig.FillEmptyBlocks	= true ;
ESConfig.FormatSource		= true ;
ESConfig.FormatOutput		= true ;
ESConfig.FormatIndentator	= '    ' ;
ESConfig.ForceStrongEm = true ;
ESConfig.GeckoUseSPAN	= true ;
ESConfig.StartupFocus	= false ;
ESConfig.ForcePasteAsPlainText	= false ;
ESConfig.AutoDetectPasteFromWord = true ;	// IE only.
ESConfig.ForceSimpleAmpersand	= false ;
ESConfig.TabSpaces		= 4 ;
ESConfig.ShowBorders	= true ;
ESConfig.UseBROnCarriageReturn	= false ;	// IE only.
ESConfig.ToolbarStartExpanded	= true ;
ESConfig.ToolbarCanCollapse	= true ;
ESConfig.IEForceVScroll = false ;
ESConfig.IgnoreEmptyParagraphValue = true ;
ESConfig.PreserveSessionOnFileBrowser = false ;
ESConfig.FloatingPanelsZIndex = 10000 ;
ESConfig.ToolbarSets["Default"] = [
	['Source','DocProps','-','Save','NewPage','Preview'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Image','Table','Rule','Smiley','SpecialChar','UniversalKey'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor']
] ;
ESConfig.ToolbarSets["rcx"] = [
	['Source','Save'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Image','Table','Rule','Smiley','SpecialChar','UniversalKey'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor']
] ;
ESConfig.ToolbarSets["rcx_lib"] = [
	['Source','Save'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Image','Table','Rule','Smiley','SpecialChar','UniversalKey'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor']
] ;
<?php 
  global $rcxConfig;
	$tag_users = explode('|',$rcxConfig['user_html']);
    in_array('b',$tag_users) ? $bold = "'Bold'":$bold ="'-'";
  in_array('i',$tag_users) && in_array('em',$tag_users) ? $italic = "'Italic'":$italic ="'-'";
  in_array('u',$tag_users) ? $und="'Underline'":$und="'-'";
  in_array('strike',$tag_users) ? $strike = "'StrikeThrough'":$strike = "'-'";
  in_array('sub',$tag_users) ? $sub = "'Subscript'":$sub = "'-'";
  in_array('sup',$tag_users) ? $sup = "'Superscript'":$sup = "'-'";
  in_array('ol',$tag_users)&& in_array('li',$tag_users) ? $ol = "'OrderedList'":$ol = "'-'";
  in_array('ul',$tag_users)&& in_array('li',$tag_users) ? $ul = "'UnorderedList'":$ul = "'-'";
  in_array('blockquote',$tag_users) ? $bloc = "'Outdent','Indent'":$bloc ="'-'";
  in_array('div',$tag_users)? $just = "'JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'":$just="'-'";
  in_array('a',$tag_users)? $a= "'Link','Unlink','Anchor'":$a = "'-'";
  in_array('img',$tag_users)? $img ="'Image'":$img="'-'";
  in_array('table',$tag_users)&& in_array('tr',$tag_users)&& in_array('td',$tag_users)&& in_array('th',$tag_users)&& in_array('thead',$tag_users)&& in_array('tbody',$tag_users)&& in_array('tfoot',$tag_users) ? $table = "'Table'":$table ="'-'";
  in_array('form',$tag_users)&& in_array('input',$tag_users) ? $form = "'Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'":$form = "'-'";
  in_array('hr',$tag_users)? $rul ="'Rule'":$rul="'-'";
  in_array('img',$tag_users)? $smil ="'Smiley'":$smil="'-'";
  in_array('span',$tag_users)&& in_array('em',$tag_users)&& in_array('h3',$tag_users) ? $styl = "'Style'":$styl="'-'";
  in_array('pre',$tag_users)&& in_array('div',$tag_users)&& in_array('address',$tag_users)&& in_array('h1',$tag_users)&& in_array('h2',$tag_users)&& in_array('h3',$tag_users)&& in_array('h4',$tag_users)&& in_array('h5',$tag_users)&& in_array('h6',$tag_users) ? $format = "'FontFormat'":$format="'-'";
  in_array('font',$tag_users)? $font ="'FontName','FontSize','TextColor','BGColor'":$font="'-'";
?>
ESConfig.ToolbarSets["UserToolbar"] = [
	['Source','Save'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	[<?php echo "$bold,$italic,$und,$strike,$sub,$sup";?>],
	[<?php echo"$ol,$ul,'-',$bloc";?>],
	[<?php echo"$just";?>],
	[<?php echo"$a";?>],
	[<?php echo"$img,$table,$rul,$smil";?>,'SpecialChar','UniversalKey'],
	[<?php echo"$form";?>],
	[<?php echo"$styl,$format,$font";?>]
] ;
ESConfig.ContextMenu = ['Generic','Link','Anchor','Image','Select','Textarea','Checkbox','Radio','TextField','HiddenField','ImageButton','Button','BulletedList','NumberedList','TableCell','Table','Form'] ;
ESConfig.FontColors = '000000,993300,333300,003300,003366,000080,333399,333333,800000,FF6600,808000,808080,008080,0000FF,666699,808080,FF0000,FF9900,99CC00,339966,33CCCC,3366FF,800080,999999,FF00FF,FFCC00,FFFF00,00FF00,00FFFF,00CCFF,993366,C0C0C0,FF99CC,FFCC99,FFFF99,CCFFCC,CCFFFF,99CCFF,CC99FF,FFFFFF' ;
ESConfig.FontNames		= 'Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana' ;
ESConfig.FontSizes		= '1/xx-small;2/x-small;3/small;4/medium;5/large;6/x-large;7/xx-large' ;
ESConfig.FontFormats	= 'p;div;pre;address;h1;h2;h3;h4;h5;h6' ;
ESConfig.StylesXmlPath		= ESConfig.EditorPath + 'esstyles.xml' ;
ESConfig.TemplatesXmlPath	= ESConfig.EditorPath + 'estemplates.xml' ;
ESConfig.SpellChecker			= 'ieSpell' ;	// 'ieSpell' | 'SpellerPages'
ESConfig.IeSpellDownloadUrl	= 'http://www.iespell.com/rel/ieSpellSetup211325.exe' ;
ESConfig.MaxUndoLevels = 15 ;
ESConfig.DisableImageHandles = false ;
ESConfig.DisableTableHandles = false ;
ESConfig.LinkDlgHideTarget		= false ;
ESConfig.LinkDlgHideAdvanced	= false ;
ESConfig.ImageDlgHideLink		= false ;
ESConfig.ImageDlgHideAdvanced	= false ;
ESConfig.FlashDlgHideAdvanced	= false ;
// The following value defines which File Browser connector and Quick Upload 
// "uploader" to use. It is valid for the default implementaion and it is here
// just to make this configuration file cleaner. 
// It is not possible to change this value using an external file or even 
// inline when creating the editor instance. In that cases you must set the 
// values of LinkBrowserURL, ImageBrowserURL and so on.
// Custom implementations should just ignore it.
var _FileBrowserLanguage	= 'php' ;	// asp | arcx | cfm | lasso | perl | php | py
var _QuickUploadLanguage	= 'php' ;	// asp | arcx | cfm | lasso | php
// Don't care about the following line. It just calculates the correct connector 
// extension to use for the default File Browser (Perl uses "cgi").
var _FileBrowserExtension = _FileBrowserLanguage == 'perl' ? 'cgi' : _FileBrowserLanguage ;
ESConfig.LinkBrowser = false ;
//ESConfig.LinkBrowserURL = ESConfig.BasePath + 'filemanager/browser/default/browser.html?Connector=connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ;
//ESConfig.LinkBrowserWindowWidth	= ESConfig.ScreenWidth * 0.7 ;		// 70%
//ESConfig.LinkBrowserWindowHeight	= ESConfig.ScreenHeight * 0.7 ;	// 70%
<?php
global $rcxConfig, $rcxUser;
$groupid = explode(",", $editorConfig['groupstoupload']);
$usergroup = RcxGroup::getByUser($rcxUser);
  $ret = "false";
  foreach($usergroup as $value) {
    if (in_array($value,$groupid)){
      $ret = "true";       
      }
    }
?>
ESConfig.ImageBrowser = <?php echo "$ret";?>;
ESConfig.ImageBrowserURL = ESConfig.BasePath + 'filemanager/browser/default/browser.html?Type=library&ServerPath=/images/&Connector=connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ;
ESConfig.ImageBrowserWindowWidth  = ESConfig.ScreenWidth * 0.7 ;	// 70% ;
ESConfig.ImageBrowserWindowHeight = ESConfig.ScreenHeight * 0.7 ;	// 70% ;
ESConfig.FlashBrowser = false ;
//ESConfig.FlashBrowserURL = ESConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Flash&Connector=connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ;
//ESConfig.FlashBrowserWindowWidth  = ESConfig.ScreenWidth * 0.7 ;	//70% ;
//ESConfig.FlashBrowserWindowHeight = ESConfig.ScreenHeight * 0.7 ;	//70% ;
ESConfig.LinkUpload = false ;
//ESConfig.LinkUploadURL = ESConfig.BasePath + 'filemanager/upload/' + ESConfig.QuickUploadLanguage + '/upload.' + _QuickUploadLanguage ;
//ESConfig.LinkUploadAllowedExtensions	= "" ;			// empty for all
//ESConfig.LinkUploadDeniedExtensions	= ".(php|php3|php5|phtml|asp|arcx|ascx|jsp|cfm|cfc|pl|bat|exe|dll|reg|cgi)$" ;	// empty for no one
ESConfig.ImageUpload = false ;
ESConfig.ImageUploadURL = ESConfig.BasePath + 'filemanager/upload/' + ESConfig.QuickUploadLanguage + '/upload.' + _QuickUploadLanguage + '?Type=library' ;
ESConfig.ImageUploadAllowedExtensions	= ".(jpg|gif|jpeg|png)$" ;		// empty for all
ESConfig.ImageUploadDeniedExtensions	= "" ;							// empty for no one
ESConfig.FlashUpload = false ;
//ESConfig.FlashUploadURL = ESConfig.BasePath + 'filemanager/upload/' + ESConfig.QuickUploadLanguage + '/upload.' + _QuickUploadLanguage + '?Type=Flash' ;
//ESConfig.FlashUploadAllowedExtensions	= ".(swf|fla)$" ;		// empty for all
//ESConfig.FlashUploadDeniedExtensions	= "" ;					// empty for no one
//grinere rcx
<?php
    include_once(RCX_ROOT_PATH . '/class/rcxlists.php');
    $smiley = RcxLists::getFilesListAsArray(RCX_ROOT_PATH . "/images/smilies");
    foreach ($smiley as $fic) {
	                $tabFichiers .= "'$fic', ";
                }
				?>
ESConfig.SmileyPath = <?php echo '"'.RCX_URL.'/images/smilies/"'; ?> ;
ESConfig.SmileyImages = [<?php echo "$tabFichiers"; ?>] ;
ESConfig.SmileyColumns = 5 ;
ESConfig.SmileyWindowWidth		= 400 ;
ESConfig.SmileyWindowHeight	= 400 ;
if( window.console ) window.console.log( 'Config is loaded!' ) ;