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
global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = true ;

// Path to user files relative to the document root.
//$Config['UserFilesPath'] = '' ;

// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Usefull if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\UserFiles\\' or '/root/mysite/UserFiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
$Config['UserFilesAbsolutePath'] = '' ;

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php3','php5','phtml','asp','arcx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','php2','php4','pwml','inc') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array('php','php3','php5','phtml','asp','arcx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','php2','php4','pwml','inc') ;

$Config['AllowedExtensions']['library']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['library']	= array('php','php3','php5','phtml','asp','arcx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','php2','php4','pwml','inc') ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array('php','php3','php5','phtml','asp','arcx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','php2','php4','pwml','inc') ;

$Config['AllowedExtensions']['Media']	= array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']	= array('php','php3','php5','phtml','asp','arcx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi','php2','php4','pwml','inc') ;

?>