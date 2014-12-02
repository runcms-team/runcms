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

var oEditor = window.parent.InnerDialogLoaded() ;
var ES		= oEditor.ES ;

//#### Dialog Tabs

// Set the dialog tabs.
window.parent.AddTab( 'Info', oEditor.ESLang.DlgImgInfoTab ) ;
// TODO : Enable File Upload (1/3).
//window.parent.AddTab( 'Upload', 'Upload', true ) ;
window.parent.AddTab( 'Advanced', oEditor.ESLang.DlgAdvancedTag ) ;

// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
// TODO : Enable File Upload (2/3).
//	ShowE('divUpload'	, ( tabCode == 'Upload' ) ) ;
	ShowE('divAdvanced'	, ( tabCode == 'Advanced' ) ) ;
}

// Get the selected image (if available).
var oImage = ES.Selection.GetSelectedElement( 'IMG' ) ;

var oImageOriginal ;

function UpdateOriginal( resetSize )
{
	oImageOriginal = document.createElement( 'IMG' ) ;	// new Image() ;
	
	if ( resetSize )
	{
		oImageOriginal.onload = function()
		{
			this.onload = null ;
			ResetSizes() ;
		}
	}

	oImageOriginal.src = GetE('imgPreview').src ;
}

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.ESLanguageManager.TranslatePage(document) ;
	
	GetE('btnLockSizes').title = oEditor.ESLang.DlgImgLockRatio ;
	GetE('btnResetSize').title = oEditor.ESLang.DlgBtnResetSize ;

	// Load the selected element information (if any).
	LoadSelection() ;
	
	// Show/Hide the "Browse Server" button.
	GetE('tdBrowse').style.display = oEditor.ESConfig.ImageBrowser ? '' : 'none' ;
	
	UpdateOriginal() ;

	window.parent.SetAutoSize( true ) ;
	
	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
}

function LoadSelection()
{
	if ( ! oImage ) return ;

	var sUrl = GetAttribute( oImage, 'src', '' ) ;
	
	if ( sUrl.startsWith( ES.BaseUrl ) )
		sUrl = sUrl.remove( 0, ES.BaseUrl.length ) ;
	
	GetE('txtUrl').value    = sUrl ;
	GetE('txtAlt').value    = GetAttribute( oImage, 'alt', '' ) ;
	GetE('txtVSpace').value	= GetAttribute( oImage, 'vspace', '' ) ;
	GetE('txtHSpace').value	= GetAttribute( oImage, 'hspace', '' ) ;
	GetE('txtBorder').value	= GetAttribute( oImage, 'border', '' ) ;
	GetE('cmbAlign').value	= GetAttribute( oImage, 'align', '' ) ;

	if ( oImage.style.pixelWidth > 0 )
		GetE('txtWidth').value  = oImage.style.pixelWidth ;
	else
		GetE('txtWidth').value  = GetAttribute( oImage, "width", '' ) ;
		
	if ( oImage.style.pixelHeight > 0 )
		GetE('txtHeight').value  = oImage.style.pixelHeight ;
	else
		GetE('txtHeight').value = GetAttribute( oImage, "height", '' ) ;
	
	// Get Advances Attributes
	GetE('txtAttId').value			= oImage.id ;
	GetE('cmbAttLangDir').value		= oImage.dir ;
	GetE('txtAttLangCode').value	= oImage.lang ;
	GetE('txtAttTitle').value		= oImage.title ;
	GetE('txtAttClasses').value		= oImage.getAttribute('class',2) || '' ;
	GetE('txtLongDesc').value		= oImage.longDesc ;
	
	if ( oEditor.ESBrowserInfo.IsIE ) 
		GetE('txtAttStyle').value	= oImage.style.cssText ;
	else
		GetE('txtAttStyle').value	= oImage.getAttribute('style',2) ;
		
	UpdatePreview() ;
}

//#### The OK button was hit.
function Ok()
{
	if ( GetE('txtUrl').value.length == 0 )
	{
		window.parent.SetSelectedTab( 'Info' ) ;
		GetE('txtUrl').focus() ;
		
		alert( oEditor.ESLang.DlgImgAlertUrl ) ;
		
		return false ;
	}

	var e = ( oImage || ES.EditorDocument.createElement( 'IMG' ) ) ;
	
	UpdateImage( e ) ;

	if ( ! oImage )
		ES.InsertElement( e ) ;

	return true ;
}

function UpdateImage( e, skipId )
{
	e.src = GetE('txtUrl').value ;
	SetAttribute( e, "alt"   , GetE('txtAlt').value ) ;		
	SetAttribute( e, "width" , GetE('txtWidth').value ) ;		
	SetAttribute( e, "height", GetE('txtHeight').value ) ;		
	SetAttribute( e, "vspace", GetE('txtVSpace').value ) ;		
	SetAttribute( e, "hspace", GetE('txtHSpace').value ) ;		
	SetAttribute( e, "border", GetE('txtBorder').value ) ;		
	SetAttribute( e, "align" , GetE('cmbAlign').value ) ;
	
	// Advances Attributes
	
	if ( ! skipId )
		SetAttribute( e, 'id', GetE('txtAttId').value ) ;
	
	SetAttribute( e, 'dir'		, GetE('cmbAttLangDir').value ) ;
	SetAttribute( e, 'lang'		, GetE('txtAttLangCode').value ) ;
	SetAttribute( e, 'title'	, GetE('txtAttTitle').value ) ;
	SetAttribute( e, 'class'	, GetE('txtAttClasses').value ) ;
	SetAttribute( e, 'longDesc'	, GetE('txtLongDesc').value ) ;

	if ( oEditor.ESBrowserInfo.IsIE ) 
		e.style.cssText = GetE('txtAttStyle').value ;
	else
		SetAttribute( e, 'style', GetE('txtAttStyle').value ) ;
}

function UpdatePreview()
{
	if ( GetE('txtUrl').value.length == 0 )
		GetE('imgPreview').style.display = 'none' ;
	else
		UpdateImage( GetE('imgPreview'), true ) ;
}

var bLockRatio = true ;

function SwitchLock( lockButton )
{
	bLockRatio = !bLockRatio ;
	lockButton.className = bLockRatio ? 'BtnLocked' : 'BtnUnlocked' ;
	lockButton.title = bLockRatio ? 'Lock sizes' : 'Unlock sizes' ;
	
	if ( bLockRatio )
	{
		if ( GetE('txtWidth').value.length > 0 )
			OnSizeChanged( 'Width', GetE('txtWidth').value ) ;
		else
			OnSizeChanged( 'Height', GetE('txtHeight').value ) ;
	}
}

// Fired when the width or height input texts change
function OnSizeChanged( dimension, value ) 
{
	// Verifies if the aspect ration has to be mantained
	if ( oImageOriginal && bLockRatio )
	{
		if ( value.length == 0 || isNaN( value ) )
		{
			GetE('txtHeight').value = GetE('txtWidth').value = '' ;
			return ;
		}
	
		if ( dimension == 'Width' )
			GetE('txtHeight').value = Math.round( oImageOriginal.height * ( value  / oImageOriginal.width ) ) ;
		else
			GetE('txtWidth').value  = Math.round( oImageOriginal.width  * ( value / oImageOriginal.height ) ) ;
	}
	
	UpdatePreview() ;
}

// Fired when the Reset Size button is clicked
function ResetSizes()
{
	if ( ! oImageOriginal ) return ;

	GetE('txtWidth').value  = oImageOriginal.width ;
	GetE('txtHeight').value = oImageOriginal.height ;
	
	UpdatePreview() ;
}

function BrowseServer()
{
	// Set the browser window feature.
	var iWidth	= oEditor.ESConfig.ImageBrowserWindowWidth ;
	var iHeight	= oEditor.ESConfig.ImageBrowserWindowHeight ;
	
	var iLeft = (screen.width  - iWidth) / 2 ;
	var iTop  = (screen.height - iHeight) / 2 ;

	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
	sOptions += ",width=" + iWidth ; 
	sOptions += ",height=" + iHeight ;
	sOptions += ",left=" + iLeft ;
	sOptions += ",top=" + iTop ;

	// Open the browser window.
	var oWindow = window.open( oEditor.ESConfig.ImageBrowserURL, "ESBrowseWindow", sOptions ) ;
}

function SetUrl( url )
{
	document.getElementById('txtUrl').value = url ;
	GetE('txtHeight').value = GetE('txtWidth').value = '' ;
	UpdatePreview() ;
	UpdateOriginal( true ) ;
}

function UploadImages() {
	var newWindow;
	var props = 'scrollBars=yes,resizable=no,toolbar=no,menubar=no,location=no,directories=no,width=300,height=450,top=180,left=200';
	newWindow = window.open('library.php', 'Upload_Images_to_server', props);
	
};