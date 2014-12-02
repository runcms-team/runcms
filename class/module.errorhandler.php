<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/


if (!defined("RCX_ERRORHANDLER_INCLUDED")) {
	define("RCX_ERRORHANDLER_INCLUDED", 1);

/**
* Note: this file will be depracted ..add error handling directly to your modules!
*
* @param type $var description
* @return type description
*/
class ErrorHandler {

	var $display = 1;

	function ErrorHandler($display=1) {
		$this->display = intval($display);
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show($e_code, $pages=1) {
global $db, $myts;

$errmsg = array(
	"0001" =>"Could not connect to the forums database.",
	"0002" => "The forum you selected does not exist. Please go back and try again.",
	"0003" => "Password Incorrect.",
	"0004" => "Could not query the topics database.",
	"0005" => "Error getting messages from the database.",
	"0006" => "Please enter the Nickname and the Password.",
	"0007" => "You are not the Moderator of this forum therefore you can't perform this function.",
	"0008" => "You did not enter the correct password, please go back and try again.",
	"0009" => "Could not remove posts from the database.",
	"0010" => "Could not move selected topic to selected forum. Please go back and try again.",
	"0011" => "Could not lock the selected topic. Please go back and try again.",
	"0012" => "Could not unlock the selected topic. Please go back and try again.",
	"0013" => "Could not query the database. <br />Error: ".$db->error()."",
	"0014" => "No such user or post in the database.",
	"0015" => "Search Engine was unable to query the forums database.",
	"0016" => "That user does not exist. Please go back and search again.",
	"0017" => "You must type a subject to post. You can't post an empty subject. Go back and enter the subject",
	"0018" => "You must choose message icon to post. Go back and choose message icon.",
	"0019" => "You must type a message to post. You can't post an empty message. Go back and enter a message.",
	"0020" => "Could not enter data into the database. Please go back and try again.",
	"0021" => "Can't delete the selected message.",
	"0022" => "An error ocurred while querying the database.",
	"0023" => "Selected message was not found in the forum database.",
	"0024" => "You can't reply to that message. It wasn't sent to you.",
	"0025" => "You can't post a reply to this topic, it has been locked. Contact the administrator if you have any question.",
	"0026" => "The forum or topic you are attempting to post to does not exist. Please try again.",
	"0027" => "You must enter your username and password. Go back and do so.",
	"0028" => "You have entered an incorrect password. Go back and try again.",
	"0029" => "Couldn't update post count.",
	"0030" => "The forum you are attempting to post to does not exist. Please try again.",
	"0031" => "Unknown Error",
	"0035" => "You can't edit a post that's not yours.",
	"0036" => "You do not have permission to edit this post.",
	"0037" => "You did not supply the correct password or do not have permission to edit this post. Please go back and try again.",
	"1001" => "Please enter value for Title.",
	"1002" => "Please enter value for Phone.",
	"1003" => "Please enter value for Summary.",
	"1004" => "Please enter value for Address.",
	"1005" => "Please enter value for City.",
	"1006" => "Please enter value for State/Province.",
	"1007" => "Please enter value for Zipcode.",
	"1008" => "Please enter value for Desctiprion.",
	"1009" => "Vote for the selected resource only once.<br />All votes are logged and reviewed.",
	"1010" => "You cannot vote on the resource you submitted.<br />All votes are logged and reviewed.",
	"1011" => "No rating selected - no vote tallied.",
	"1013" => "Please enter a search query.",
	"1016" => "Please enter value for URL.",
	"9999" => "OOPS! God Knows"
	);

if ( !is_numeric($e_code) ) {
	$errno  = "n/a";
	$errmsg = $e_code;
	} elseif ( empty($errmsg[$e_code]) ) {
		$errno  = "9999";
		$errmsg = $errmsg["9999"];
		} else {
			$errno  = $e_code;
			$errmsg = $errmsg[$e_code];
		}

if ($this->display == 1) {
	include_once(RCX_ROOT_PATH . "/header.php");
	OpenTable();

	?>
	<table align="center" cellpadding="5" cellspacing="0" border="0"><tr>
	<td><b>Error No.</b></td>
	<td><?php echo $errno;?></td>
	</tr><tr>
	<td><b>Error Msg.</b></td>
	<td><?php echo $errmsg;?></td>
	</tr><tr>
	<td colspan="2" align="center">[ <a href="javascript:history.go(-'<?php echo $pages;?>')">Go Back</a> ]</td>
	</tr></table>
	<?php

	CloseTable();
	include_once(RCX_ROOT_PATH . "/footer.php");
	} else {
		redirect_header("javascript:history.go(-'".$pages."')", 5, "<b>Error No</b>: ".$errno."<br /><br /><div align='left'><b>Error Msg</b>:<br />".$errmsg."</div>");
	}

exit();
}
} // END ERROR HANDLER
}
?>
