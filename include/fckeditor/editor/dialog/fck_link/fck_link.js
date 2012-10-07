/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2006 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: fck_link.js
 * 	Scripts related to the Link dialog window (see fck_link.html).
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 * 		Dominik Pesch ?dom? (empty selection patch) (d.pesch@11com7.de)
 */

var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;

//#### Dialog Tabs

// Set the dialog tabs.
window.parent.AddTab( 'Info', FCKLang.DlgLnkInfoTab ) ;


// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;

	window.parent.SetAutoSize( true ) ;
}




//#### Initialization Code

// oLink: The actual selected link in the editor.
var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
if ( oLink )
	FCK.Selection.SelectNode( oLink ) ;

var oLinkName = '';

window.onload = function()
{

	// Load the selected link information (if any).
	LoadSelection() ;

	// Load the selected link text
	if (FCK.EditorDocument.selection)
		GetE('txtUrlName').value = FCK.EditorDocument.selection.createRange().text;

}

function LoadSelection()
{

	if ( !oLink ) return ;

	var sType = 'url' ;

	// Get the actual Link href.
	var sHRef = oLink.getAttribute( '_fcksavedurl' ) ;
	if ( !sHRef || sHRef.length == 0 )
		sHRef = oLink.getAttribute( 'href' , 2 ) + '' ;
	
	// TODO: Wait stable version and remove the following commented lines.
//	if ( sHRef.startsWith( FCK.BaseUrl ) )
//		sHRef = sHRef.remove( 0, FCK.BaseUrl.length ) ;


	sType = 'url' ;
	GetE('txtUrl').value = sHRef ;


	// Get the target.
	var sTarget = oLink.target ;

	// Get Selected Text
	GetE('txtUrlName').value = oLink.innerHTML ;

}




//#### The OK button was hit.
function Ok()
{

	var sUri, sInnerHtml;

	sUri = GetE('txtUrl').value ;

	if ( sUri.length == 0 )
	{
		alert( FCKLang.DlnLnkMsgNoUrl ) ;
		return false ;
	}

	// No link selected, so try to create one.
	if ( !oLink ){
		//alert(sUri+'='+oEditor.FCK.CreateLink( sUri ));
		//oLink = oEditor.FCK.CreateLink( sUri ) ;
		
	}
	
	if ( oLink ){
		sInnerHtml = oLink.innerHTML ;		// Save the innerHTML (IE changes it if it is like a URL).
	}
	else
	{
		// If no selection, use the uri as the link text (by dom, 2006-05-26)
		sInnerHtml = sUri;

		var oLinkPathRegEx = new RegExp("//?([^?\"']+)([?].*)?$");
		var asLinkPath = oLinkPathRegEx.exec( sUri );

		if (asLinkPath != null)
			sInnerHtml = asLinkPath[1];  // use matched path


		// built new anchor and add link text
		oLink = oEditor.FCK.CreateElement( 'a' ) ;

	}

	if (GetE('txtUrlName').value.length > 0){
		sInnerHtml = GetE('txtUrlName').value;
	}
	oEditor.FCKUndo.SaveUndoStep() ;

	oLink.href = sUri ;
	SetAttribute( oLink, '_fcksavedurl', sUri ) ;
	oLink.innerHTML = sInnerHtml ;		// Set (or restore) the innerHTML

	SetAttribute( oLink, 'target', '' ) ;
	// Select the link.
	oEditor.FCKSelection.SelectNode(oLink);

	return true ;
}