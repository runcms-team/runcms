<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    if(!defined("RCX_C_ERRORHANDLER_INCLUDED")){
        define("RCX_C_ERRORHANDLER_INCLUDED",1);    
        class ErrorHandler {
            function show($e_code, $form_action=GALL_PAGE, $form_hidden=array(), $form_option="", $pages=1) {
        		global $rcxConfig, $meta;
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
        			"0013" => "Could not query the database. <BR>Error: ".mysql_error()."",
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
        			"0100" => _ADMIN_ERR_0100,
        			"0101" => _ADMIN_ERR_0101,
        			"0102" => _ADMIN_ERR_0102,
        			"0103" => _ADMIN_ERR_0103,
        			"0104" => _ADMIN_ERR_0104,
        			"0105" => _ADMIN_ERR_0105,
        			"0106" => _ADMIN_ERR_0106,
        			"0107" => _ADMIN_ERR_0107,
        			"0108" => _ADMIN_ERR_0108,
        			"0109" => _ADMIN_ERR_0109,
        			"0110" => _ADMIN_ERR_0110,
        			"0111" => _ADMIN_ERR_0111,
        			"0112" => _ADMIN_ERR_0112,
        			"0113" => _ADMIN_ERR_0113,
        			"0114" => _ADMIN_ERR_0114,
        			"0115" => _ADMIN_ERR_0115,
                    "0116" => _ADMIN_ERR_0116,
                    "0117" => _ADMIN_ERR_0117,
        			"0200" => _ADMIN_ERR_0200,
        			"0201" => _ADMIN_ERR_0201,
        			"0202" => _ADMIN_ERR_0202,
        			"1001" => "Please enter value for Title.",
        			"1002" => "Please enter value for Phone.",
        			"1003" => "Please enter value for Summary.",
        			"1004" => "Please enter value for Address.",
        			"1005" => "Please enter value for City.",
        			"1006" => "Please enter value for State/Province.",
        			"1007" => "Please enter value for Zipcode.",
        			"1008" => "Please enter value for Desctiprion.",
        			"1009" => "Vote for the selected resource only once.<br>All votes are logged and reviewed.",
        			"1010" => "You cannot vote on the resource you submitted.<br>All votes are logged and reviewed.",
        			"1011" => "No rating selected - no vote tallied.",
        			"1013" => "Please enter a search query.",
        			"1016" => "Please enter value for URL.",
        			"9999" => "OOPS! God Knows"
        		);
        
        		$errorno = array_keys($errmsg);
        		if (!in_array($e_code, $errorno)) {
        			$e_code = '9999';
        		}
        		gall_cp_header();
        		OpenTable();
                echo "<table width='90%' border='0' cellspacing='0' cellpadding='2' align='center' class='tb_titel'><tr><td>&nbsp;</td></tr><tr>";
                echo "<td align='center'>";
                echo "<h5>".$meta['title']." Error</h5><br><br>";
                echo "Error Code: ".$e_code."<br><br><br>";
                echo "<img src='".IMG_URL."/disconnect.gif' border=0 alt=''>&nbsp;&nbsp;&nbsp;".$errmsg[$e_code]."<br><br><br>";
                echo "</b><br>";
                echo "</font><br>";
                echo "<table border=0><tr><td align='center'>";
                echo "<form method='post' action='".$form_action."'>";
                if ( is_array($form_hidden) && count($form_hidden) > 0 ) {
        			foreach ( $form_hidden as $c ) {
                        echo "<input type='hidden' ".$c."'>";
        			}
        		}                    
                echo $form_option;
                echo "<input type='button' class='button' name='yes' value='"._GOBACK."' onClick='javascript:history.go(-".$pages.")'>";
                echo "</form>";
                echo "</td></tr></table>";
                echo "</td></tr></table>";            
        		CloseTable();
        		gall_cp_footer();
        		die("");
        	}
        
        }
    }
?>