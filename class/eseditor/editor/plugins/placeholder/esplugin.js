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

// Register the related command.
ESCommands.RegisterCommand( 'Placeholder', new ESDialogCommand( 'Placeholder', ESLang.PlaceholderDlgTitle, ESPlugins.Items['placeholder'].Path + 'es_placeholder.html', 340, 170 ) ) ;

// Create the "Plaholder" toolbar button.
var oPlaceholderItem = new ESToolbarButton( 'Placeholder', ESLang.PlaceholderBtn ) ;
oPlaceholderItem.IconPath = ESPlugins.Items['placeholder'].Path + 'placeholder.gif' ;
ESToolbarItems.RegisterItem( 'Placeholder', oPlaceholderItem ) ;


// The object used for all Placeholder operations.
var ESPlaceholders = new Object() ;

// Add a new placeholder at the actual selection.
ESPlaceholders.Add = function( name )
{
	var oSpan = ES.CreateElement( 'SPAN' ) ;
	this.SetupSpan( oSpan, name ) ;
}

ESPlaceholders.SetupSpan = function( span, name )
{
	span.innerHTML = '[[ ' + name + ' ]]' ;

	span.style.backgroundColor = '#ffff00' ;
	span.style.color = '#000000' ;

	if ( ESBrowserInfo.IsGecko )
		span.style.cursor = 'default' ;

	span._esplaceholder = name ;
	span.contentEditable = false ;

	// To avoid it to be resized.
	span.onresizestart = function()
	{
		ES.EditorWindow.event.returnValue = false ;
		return false ;
	}
}

// On Gecko we must do this trick so the user select all the SPAN when clicking on it.
ESPlaceholders._SetupClickListener = function()
{
	ESPlaceholders._ClickListener = function( e )
	{
		if ( e.target.tagName == 'SPAN' && e.target._esplaceholder )
			ESSelection.SelectNode( e.target ) ;
	}

	ES.EditorDocument.addEventListener( 'click', ESPlaceholders._ClickListener, true ) ;
}

// Open the Placeholder dialog on double click.
ESPlaceholders.OnDoubleClick = function( span )
{
	if ( span.tagName == 'SPAN' && span._esplaceholder )
		ESCommands.GetCommand( 'Placeholder' ).Execute() ;
}

ES.RegisterDoubleClickHandler( ESPlaceholders.OnDoubleClick, 'SPAN' ) ;

// Check if a Placholder name is already in use.
ESPlaceholders.Exist = function( name )
{
	var aSpans = ES.EditorDocument.getElementsByTagName( 'SPAN' )

	for ( var i = 0 ; i < aSpans.length ; i++ )
	{
		if ( aSpans[i]._esplaceholder == name )
			return true ;
	}
}

if ( ESBrowserInfo.IsIE )
{
	ESPlaceholders.Redraw = function()
	{
		var aPlaholders = ES.EditorDocument.body.innerText.match( /\[\[[^\[\]]+\]\]/g ) ;
		if ( !aPlaholders )
			return ;

		var oRange = ES.EditorDocument.body.createTextRange() ;

		for ( var i = 0 ; i < aPlaholders.length ; i++ )
		{
			if ( oRange.findText( aPlaholders[i] ) )
			{
				var sName = aPlaholders[i].match( /\[\[\s*([^\]]*?)\s*\]\]/ )[1] ;
				oRange.pasteHTML( '<span style="color: #000000; background-color: #ffff00" contenteditable="false" _esplaceholder="' + sName + '">' + aPlaholders[i] + '</span>' ) ;
			}
		}
	}
}
else
{
	ESPlaceholders.Redraw = function()
	{
		var oInteractor = ES.EditorDocument.createTreeWalker( ES.EditorDocument.body, NodeFilter.SHOW_TEXT, ESPlaceholders._AcceptNode, true ) ;

		var	aNodes = new Array() ;

		while ( oNode = oInteractor.nextNode() )
		{
			aNodes[ aNodes.length ] = oNode ;
		}

		for ( var n = 0 ; n < aNodes.length ; n++ )
		{
			var aPieces = aNodes[n].nodeValue.split( /(\[\[[^\[\]]+\]\])/g ) ;

			for ( var i = 0 ; i < aPieces.length ; i++ )
			{
				if ( aPieces[i].length > 0 )
				{
					if ( aPieces[i].indexOf( '[[' ) == 0 )
					{
						var sName = aPieces[i].match( /\[\[\s*([^\]]*?)\s*\]\]/ )[1] ;

						var oSpan = ES.EditorDocument.createElement( 'span' ) ;
						ESPlaceholders.SetupSpan( oSpan, sName ) ;

						aNodes[n].parentNode.insertBefore( oSpan, aNodes[n] ) ;
					}
					else
						aNodes[n].parentNode.insertBefore( ES.EditorDocument.createTextNode( aPieces[i] ) , aNodes[n] ) ;
				}
			}

			aNodes[n].parentNode.removeChild( aNodes[n] ) ;
		}
		
		ESPlaceholders._SetupClickListener() ;
	}

	ESPlaceholders._AcceptNode = function( node )
	{
		if ( /\[\[[^\[\]]+\]\]/.test( node.nodeValue ) )
			return NodeFilter.FILTER_ACCEPT ;
		else
			return NodeFilter.FILTER_SKIP ;
	}
}

ES.Events.AttachEvent( 'OnAfterSetHTML', ESPlaceholders.Redraw ) ;

// The "Redraw" method must be called on startup.
ESPlaceholders.Redraw() ;

// We must process the SPAN tags to replace then with the real resulting value of the placeholder.
ESXHtml.TagProcessors['span'] = function( node, htmlNode )
{
	if ( htmlNode._esplaceholder )
		node = ESXHtml.XML.createTextNode( '[[' + htmlNode._esplaceholder + ']]' ) ;
	else
		ESXHtml._AppendChildNodes( node, htmlNode, false ) ;

	return node ;
}