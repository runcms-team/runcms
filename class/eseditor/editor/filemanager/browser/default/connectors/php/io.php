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


function GetUrlFromPath( $resourceType, $folderPath )
{
	if ( $resourceType == '' )
		return RemoveFromEnd( $GLOBALS["UserFilesPath"], '/' ) . $folderPath ;
	else
		return $GLOBALS["UserFilesPath"] . $resourceType . $folderPath ;
}

function RemoveExtension( $fileName )
{
	return substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
}

function ServerMapFolder( $resourceType, $folderPath )
{
	// Get the resource type directory.
	$sResourceTypePath = $GLOBALS["UserFilesDirectory"] . $resourceType . '/' ;

	// Ensure that the directory exists.
	CreateServerFolder( $sResourceTypePath ) ;

	// Return the resource type directory combined with the required path.
	return $sResourceTypePath . RemoveFromStart( $folderPath, '/' ) ;
}

function GetParentFolder( $folderPath )
{
	$sPattern = "-[/\\\\][^/\\\\]+[/\\\\]?$-" ;
	return preg_replace( $sPattern, '', $folderPath ) ;
}

function CreateServerFolder( $folderPath )
{
	$sParent = GetParentFolder( $folderPath ) ;

	// Check if the parent exists, or create it.
	if ( !file_exists( $sParent ) )
	{
		$sErrorMsg = CreateServerFolder( $sParent ) ;
		if ( $sErrorMsg != '' )
			return $sErrorMsg ;
	}

	if ( !file_exists( $folderPath ) )
	{
		// Turn off all error reporting.
		error_reporting( 0 ) ;
		// Enable error tracking to catch the error.
		ini_set( 'track_errors', '1' ) ;

		// To create the folder with 0777 permissions, we need to set umask to zero.
		$oldumask = umask(0) ;
		mkdir( $folderPath, 0777 ) ;
		umask( $oldumask ) ;

		$sErrorMsg = $php_errormsg ;

		// Restore the configurations.
		ini_restore( 'track_errors' ) ;
		ini_restore( 'error_reporting' ) ;

		return $sErrorMsg ;
	}
	else
		return '' ;
}

function GetRootPath()
{
	$sRealPath = realpath( './' ) ;

	$sSelfPath = $_SERVER['PHP_SELF'] ;
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ) ) ;

	return substr( $sRealPath, 0, strlen( $sRealPath ) - strlen( $sSelfPath ) ) ;
}
?>