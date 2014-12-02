<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('../mainfile.php');
include_once('include/functions.php');

// Assign POST_VARS variables.
$ftp_server = $_POST['ftp_server'];
$ftp_user_name = $_POST['ftp_user_name'];
$ftp_user_pass = $_POST['ftp_user_pass'];
$folder = $_POST['folder'];
$do = $_POST['do'];
$chmod = $_POST['chmod'];
 
// Set up basic connection.
$conn_id = @ftp_connect($ftp_server); 
// Login with username and password.
$login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
@ftp_pasv($conn_id,true);

function dochmod() {
	global $_POST;
	// Assign POST_VARS variables.
	$ftp_server = $_POST['ftp_server'];
	$ftp_user_name = $_POST['ftp_user_name'];
	$ftp_user_pass = $_POST['ftp_user_pass'];
	$folder = $_POST['folder'];
	$do = $_POST['do'];
	$chmod = $_POST['chmod'];
	
	// Set up basic connection.
	$conn_id = ftp_connect($ftp_server); 
	// Login with username and password.
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	
	// Check connection.
	if ((!$conn_id) || (!$login_result)) {
		wiz_header();
		echo _MI_DOCHMOD_TITLEERROR."<br />"; 
		echo _MI_DOCHMOD_CONNERROR1."<br />";
		echo $ftp_server."<br />";
		echo _MI_DOCHMOD_CONNERROR2.": ".$ftp_user_name."<br /><br />";
		echo "<div align='center'><form action='install.php' method='post'>
		<input type='hidden' name='op' value='dochmodagain' />
		<input type='hidden' name='ftp_server' value='".$ftp_server."' />
		<input type='hidden' name=ftp_user_name' value='".$ftp_user_name."' />
		<input type='hidden' name='ftp_user_pass' value='".$ftp_user_pass."' />
		<input type='hidden' name='ftp_html_path' value='".$folder."' />
		<input type='submit' class='button' value='"._GOBACK."' />
		</form></div><br />
		";	
		wiz_footer();
	} else { 
		ftp_pasv($conn_id,true);
		$dircontent = ftp_rawlist($conn_id, ".");
	
		// Open, read, and close file.
		$fp = fopen("./cfg/chmodlist.txt", "r");
		$ftp_data = file("./cfg/chmodlist.txt");
		fclose($fp);
		wiz_header();
		echo "<table width='75%' align='center'>";
	
		// Begin for loop.
		for ($n=0; $n<count($ftp_data); $n++) {
			// Read each line and split into path and chmod value.
			$chmod_line = explode(" ", $ftp_data[$n]);
	
			// Correct 'extra space' error.
			$chmod_line[1] = eregi_replace("[[:space:]]", "", $chmod_line[1]);
			
			// Assign variables (for clarity sake).
			$path_value = $folder."/"; 
			$path_value .= $chmod_line[0];
			$chmod_value = $chmod_line[1];
			$chmod_cmd = "CHMOD $chmod_value $path_value";
			
			$errorcount = 0;
			
			// Chmod each line of chmodlist.txt
			if ( ftp_site($conn_id,$chmod_cmd)) { echo"<tr><td>$path_value $chmod_value<img src='images/check.gif' /></td></tr>";
			} else {
				echo "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value <img src='images/failed.gif' /></span></td></tr>";
				$errorcount++;
			}
					
		}
		// End for loop.
		
		echo "<tr><td>";
		if ($errorcount > 0) { 	echo sprintf(_MI_DOCHMOD_ERRORS,$errorcount)."<br />"; 
		} else {
		echo "<br /><br /><div align='center'>"._MI_DOCHMOD_OKTITLE."<br />";
		echo _MI_DOCHMOD_OKDESCRIPTION."<br />";
		echo _INSTALL_F_CONGRAT."<br /><br />";
		
		echo "<a href='".RCX_URL."'>".RCX_URL."</a><br /><br />";
		echo "</div></td></tr></table>";
		}

		wiz_footer();
		// Close the FTP connection.
		ftp_close($conn_id); 
	
	}
}
$yes = _YES;
$no = _NO;

if ($chmod == $yes) {
dochmod();
} else  {

// Check connection.
if ((!$conn_id) || (!$login_result)) {
	wiz_header();
	echo _MI_DOCHMOD_TITLEERROR."<br />"; 
	echo _MI_DOCHMOD_CONNERROR1."<br />";
	echo $ftp_server."<br />";
	echo _MI_DOCHMOD_CONNERROR2.": ".$ftp_user_name."<br /><br />";
	echo "<div align='center'><form action='install.php' method='post'>
	<input type='hidden' name='op' value='dochmodagain' />
	<input type='hidden' name='ftp_server' value='".$ftp_server."' />
	<input type='hidden' name=ftp_user_name' value='".$ftp_user_name."' />
	<input type='hidden' name='ftp_user_pass' value='".$ftp_user_pass."' />
	<input type='submit' class='button' value='"._GOBACK."' />
	</form></div><br />
	";	
	wiz_footer();
} else {

	$listarray0 = array();
	$listarray1 = array();
	if ($do == "cdup") {ftp_cdup($conn_id);}
	if ($do !== NULL ) {
		$changedok = ftp_chdir($conn_id, "/".$folder);
		if ($changedok == FALSE) {unset($folder);}
	}
	$dircontent = ftp_rawlist($conn_id, './');
	 

	foreach ($dircontent as $row) { 
		$arraycontent = preg_split("[ ]", $row, 9, PREG_SPLIT_NO_EMPTY);
		$listarray0[] = substr($arraycontent[0],0,1);
		$listarray1[] = $arraycontent[8];
	}
	$arraysorted = array_multisort($listarray0,SORT_DESC,$listarray1);


	$actualpath = ftp_pwd($conn_id);
	$okmainfile = '';
	$content = '';

	foreach($dircontent as $key => $value) {
		if ($listarray0[$key] == "d" or $listarray0[$key] == "s") {
			$content .= "<tr><td></td>";
			$content .= "<td  width='75%' align='center'><form action='ftp.php' method='post' id='ftpdata".$key."' >\n<input type='hidden' name='ftp_server' value='".$ftp_server."' /><input type='hidden'  name='ftp_user_name' value='".$ftp_user_name."' />\n<input type='hidden' name='ftp_user_pass' value='".$ftp_user_pass."' />\n<input type='submit' name='do' class='buttonlink' value='".$listarray1[$key]."' />\n<input type='hidden' name='folder' value='".$folder."/".$listarray1[$key]."' /></form></td></tr>";
		} elseif ($listarray1[$key] == "mainfile.php") {
			$okmainfile = "<b>".ftp_pwd($conn_id)."<div align='center'></b> "._MI_DOCHMOD_HASMAINFILEPHP."<br /><br /> <form action='ftp.php' method='post' id='chmod' >\n<input type='hidden' name='ftp_server' value='".$ftp_server."' /><input type='hidden'  name='ftp_user_name' value='".$ftp_user_name."' />\n<input type='hidden' name='ftp_user_pass' value='".$ftp_user_pass."' />\n<input type='hidden' name='folder' value='".$folder."' />\n<input type='submit' name='chmod' class='button' value='"._YES."' />&nbsp;<input type='submit' class='button' name='chmod' value='"._NO."' /></form></div>";
			
			$actualpath = "";
		} 
	}
	ftp_close($conn_id);
	
	wiz_header();
	echo "<table width='75%'>";
	if ($actualpath !== "") { echo "<table align='center'><tr><td></td><td>"._MI_DOCHMOD_BROWSETOMAINFILE."</td></tr>";}
	echo "<tr><td></td><td>".$okmainfile.$actualpath."&nbsp;</td></tr>";
	echo $content;
	echo "<tr><td></td><td><br /></td></table>
	";
	wiz_footer();
}
}
?>