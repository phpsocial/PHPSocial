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
 * File Name: fck_image.js
 * 	Scripts related to the Image dialog window (see fck_image.html).
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;
var FCKDebug	= oEditor.FCKDebug ;

var bImageButton = ( document.location.search.length > 0 && document.location.search.substr(1) == 'ImageButton' ) ;

//#### Dialog Tabs

// Set the dialog tabs.
window.parent.AddTab( 'Info', FCKLang.DlgImgInfoTab ) ;

// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
}

// Get the selected image (if available).
var oImage = FCK.Selection.GetSelectedElement() ;

if ( oImage && oImage.tagName != 'IMG' && !( oImage.tagName == 'INPUT' && oImage.type == 'image' ) )
	oImage = null ;

// Get the active link.
var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;

var oImageOriginal ;

function UpdateOriginal( resetSize )
{
	if ( !eImgPreview )
		return ;
	
	if ( GetE('txtUrl').value.length == 0 )
	{
		oImageOriginal = null ;
		return ;
	}
		
	oImageOriginal = document.createElement( 'IMG' ) ;	// new Image() ;

	if ( resetSize )
	{
		oImageOriginal.onload = function()
		{
			this.onload = null ;
			ResetSizes() ;
		}
	}

	oImageOriginal.src = eImgPreview.src ;
}

var bPreviewInitialized ;

window.onload = function()
{

	// Load the selected element information (if any).
	LoadSelection() ;

	UpdateOriginal() ;

	// Set upload image action
        if(GetE('frmUpload'))
		GetE('frmUpload').action = FCKConfig.ImageUploadURL ;

	window.parent.SetAutoSize( true ) ;

}

function LoadSelection()
{
	if ( ! oImage ) return ;

	var sUrl = GetAttribute( oImage, '_fcksavedurl', '' ) ;
	if ( sUrl.length == 0 )
		sUrl = GetAttribute( oImage, 'src', '' ) ;

	// TODO: Wait stable version and remove the following commented lines.
//	if ( sUrl.startsWith( FCK.BaseUrl ) )
//		sUrl = sUrl.remove( 0, FCK.BaseUrl.length ) ;

	GetE('txtUrl').value    = sUrl ;
	GetE('txtAlt').value    = GetAttribute( oImage, 'alt', '' ) ;
	GetE('txtBorder').value	= GetAttribute( oImage, 'border', '' ) ;

	var iWidth, iHeight ;

	var regexSize = /^\s*(\d+)px\s*$/i ;

	if ( oImage.style.width )
	{
		var aMatch  = oImage.style.width.match( regexSize ) ;
		if ( aMatch )
		{
			iWidth = aMatch[1] ;
			oImage.style.width = '' ;
		}
	}

	if ( oImage.style.height )
	{
		var aMatch  = oImage.style.height.match( regexSize ) ;
		if ( aMatch )
		{
			iHeight = aMatch[1] ;
			oImage.style.height = '' ;
		}
	}

	GetE('txtWidth').value	= iWidth ? iWidth : GetAttribute( oImage, "width", '' ) ;
	GetE('txtHeight').value	= iHeight ? iHeight : GetAttribute( oImage, "height", '' ) ;

	UpdatePreview() ;
}

//#### The OK button was hit.
function Ok()
{
	if ( GetE('txtUrl').value.length == 0 )
	{
		window.parent.SetSelectedTab( 'Info' ) ;
		GetE('txtUrl').focus() ;

		alert( FCKLang.DlgImgAlertUrl ) ;

		return false ;
	}

	var bHasImage = ( oImage != null ) ;

	if ( bHasImage && bImageButton && oImage.tagName == 'IMG' )
	{
		if ( confirm( 'Do you want to transform the selected image on a image button?' ) )
			oImage = null ;
	}
	else if ( bHasImage && !bImageButton && oImage.tagName == 'INPUT' )
	{
		if ( confirm( 'Do you want to transform the selected image button on a simple image?' ) )
			oImage = null ;
	}

	if ( !bHasImage )
	{
		if ( bImageButton )
		{
			oImage = FCK.EditorDocument.createElement( 'INPUT' ) ;
			oImage.type = 'image' ;
			oImage = FCK.InsertElementAndGetIt( oImage ) ;
		}
		else
			oImage = FCK.CreateElement( 'IMG' ) ;
	}
	else
		oEditor.FCKUndo.SaveUndoStep() ;

	UpdateImage( oImage ) ;

	if ( oLink )
		FCK.ExecuteNamedCommand( 'Unlink' ) ;

	return true ;
}

function UpdateImage( e, skipId )
{
	e.src = GetE('txtUrl').value ;
//	if(e.src.length > 0)
//		e.style.display = 'block';
	SetAttribute( e, "_fcksavedurl", GetE('txtUrl').value ) ;
	SetAttribute( e, "alt"   , GetE('txtAlt').value ) ;
	SetAttribute( e, "width" , GetE('txtWidth').value ) ;
	SetAttribute( e, "height", GetE('txtHeight').value ) ;
	SetAttribute( e, "border", GetE('txtBorder').value ) ;
}

var eImgPreview ;
var eImgPreviewLink ;

function SetPreviewElements( imageElement, linkElement )
{
	eImgPreview = imageElement ;
	eImgPreviewLink = linkElement ;

	UpdatePreview() ;
	UpdateOriginal() ;
	
	bPreviewInitialized = true ;
}

function UpdatePreview()
{
	if ( !eImgPreview || !eImgPreviewLink )
		return ;

	eImgPreview.style.display = 'block';

	if ( GetE('txtUrl').value.length == 0 )
		eImgPreviewLink.style.display = 'none' ;
	else
	{
		UpdateImage( eImgPreview, true ) ;
		eImgPreviewLink.style.display = '' ;

	}
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
		var e = dimension == 'Width' ? GetE('txtHeight') : GetE('txtWidth') ;
		
		if ( value.length == 0 || isNaN( value ) )
		{
			e.value = '' ;
			return ;
		}

		if ( dimension == 'Width' )
			value = value == 0 ? 0 : Math.round( oImageOriginal.height * ( value  / oImageOriginal.width ) ) ;
		else
			value = value == 0 ? 0 : Math.round( oImageOriginal.width  * ( value / oImageOriginal.height ) ) ;

		if ( !isNaN( value ) )
			e.value = value ;
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
	OpenServerBrowser(
		'Image',
		FCKConfig.ImageBrowserURL,
		FCKConfig.ImageBrowserWindowWidth,
		FCKConfig.ImageBrowserWindowHeight ) ;
}

function LnkBrowseServer()
{
	OpenServerBrowser(
		'Link',
		FCKConfig.LinkBrowserURL,
		FCKConfig.LinkBrowserWindowWidth,
		FCKConfig.LinkBrowserWindowHeight ) ;
}

function OpenServerBrowser( type, url, width, height )
{
	sActualBrowser = type ;
	OpenFileBrowser( url, width, height ) ;
}

var sActualBrowser ;

function SetUrl( url, width, height, alt )
{
	if ( sActualBrowser == 'Link' )
	{
		GetE('txtLnkUrl').value = url ;
		UpdatePreview() ;
	}
	else
	{
		GetE('txtUrl').value = url ;
		GetE('txtWidth').value = width ? width : '' ;
		GetE('txtHeight').value = height ? height : '' ;

		if ( alt )
			GetE('txtAlt').value = alt;

		UpdatePreview() ;
		UpdateOriginal( true ) ;
	}
	
	window.parent.SetSelectedTab( 'Info' ) ;
}

function OnUploadCompleted(fileUrl, fileName, customMsg )
{
	sActualBrowser = '';
	SetUrl( fileUrl ) ;
	GetE('frmUpload').reset() ;
	GetE('btnUpload').disabled = false;
	GetE('btnUpload').value = 'Upload';
	GetE('iconUpload').style.visibility = 'hidden';
	UpdatePreview() ;
	alert( customMsg ) ;
}

var oUploadAllowedExtRegex	= new RegExp( FCKConfig.ImageUploadAllowedExtensions, 'i' ) ;
var oUploadDeniedExtRegex	= new RegExp( FCKConfig.ImageUploadDeniedExtensions, 'i' ) ;

function CheckUpload()
{
	var sFile = GetE('txtUploadFile').value ;

	if ( sFile.length == 0 )
	{
		alert( 'Please select a file to upload' ) ;
		return false ;
	}

	GetE('btnUpload').disabled = true;
	GetE('btnUpload').value = 'Uploading';
	GetE('iconUpload').style.visibility = 'visible';
	
	return true ;
}