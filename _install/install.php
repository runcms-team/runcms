<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

ob_start();
include_once('include/functions.php');
function welcome() {
global $_COOKIE;

$lang = $_COOKIE['lang'] ? $_COOKIE['lang'] : 'russian';
?>

<div align="center">
<h4><?php printf(_INSTALL_W_WELCOME, RCX_VERSION);?></h4>
<?php readfile(WIZ_PATH.'/language/'.$lang.'/main.html');?>
<div style='text-align: center;'><li><?php echo _INSTALL_W_CHOOSELANG;?></li></div>
</div>
<br />

<table align="center" width="70%"><tr>
<td align="center">
<form action="install.php" method="post">
<select class="select" name="lang">



<?php
include_once("../class/rcxlists.php");
$langarr = RcxLists::getDirListAsArray("./language/");
foreach ($langarr as $lang) {
	echo "<option ";
	if ($lang == 'russian') echo "selected='selected' ";
	echo "value='".$lang."'>".$lang."</option>";
	}
?>
</select>
<input type="hidden" name="op" value="setupcheck" />
<input type="submit" class="button" value="<?php echo _NEXT;?>" />
</form></td>
</tr></table>




<?php
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setup_check() {

$checks = array();
@chmod("../mainfile.php", 0666);

@is_writable("../mainfile.php") ? $checks[] = _INSTALL_ST_MAINFILE_OK : $checks[] = _INSTALL_ST_MAINFILE_BAD;
if ( !function_exists('mysql_get_client_info') ) {
	$checks[] = sprintf(_INSTALL_ST_MYSQL_BAD2);
	} else {
		version_check('4.1.20', mysql_get_client_info()) ? $checks[] = sprintf(_INSTALL_ST_MYSQL_OK, mysql_get_client_info()) : $checks[] = printf(_INSTALL_ST_MYSQL_BAD, mysql_get_client_info());
	}
version_check('5.1.6', phpversion()) ? $checks[] = sprintf(_INSTALL_ST_PHP_OK, phpversion()) : $checks[] = printf(_INSTALL_ST_PHP_BAD, phpversion());
ini_get('register_globals') ? $checks[] =  _INSTALL_ST_GLOBALS_OK : $checks[] =  _INSTALL_ST_GLOBALS_BAD;
//version_check('4.4.7', phpversion()) ? $checks[] = sprintf(_INSTALL_ST_PHP_OK, phpversion()) : $checks[] = printf(_INSTALL_ST_PHP_BAD, phpversion());
echo "<table width='675' align='center'><tr><td><h3>"._INSTALL_ST_TESTS."</h3></td>";
foreach ($checks as $value) {
	echo "<tr><td class='infa'><li>$value</li></td></tr>";
}
echo "
<tr>
<td align='right'><br />
<li><a href='./include/php_info.php' target='_blank'>"._INSTALL_PHPINFO."</a> ::</li>
</td>
</tr></table>
<form action='./install.php' method='post'>
<input type='hidden' name='op' value='dbform'>
<div align='center'>
"._INSTALL_ST_NEXT."<br /><br /><br />
<input type='submit' class='button' name='submit' value='"._NEXT."'>
</div>
</form>";
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function dbdata() {
global $_POST;
isset($_POST['root_path'])   ? $root_path   = $_POST['root_path']   : $root_path   = RCX_ROOT_PATH;
isset($_POST['rcx_url'])   ? $rcx_url   = $_POST['rcx_url']   : $rcx_url   = RCX_URL;
isset($_POST['dbhost'])      ? $dbhost      = $_POST['dbhost']      : $dbhost      = "localhost";
isset($_POST['dbpass'])      ? $dbpass      = $_POST['dbpass']      : $dbpass      = "";
isset($_POST['dbname'])      ? $dbname      = $_POST['dbname']      : $dbname      = "";
isset($_POST['prefix'])      ? $prefix      = $_POST['prefix']      : $prefix      = rand_string(7)."_"; 
isset($_POST['dbuname'])     ? $dbuname     = $_POST['dbuname']     : $dbuname     = "";
isset($_POST['database'])    ? $database    = $_POST['database']    : $database    = "mysql";
isset($_POST['db_pconnect']) ? $db_pconnect = $_POST['db_pconnect'] : $db_pconnect = 0;
include_once("../class/module.textsanitizer.php");
$myts = new MyTextSanitizer;
$root_path   = $myts->makeTboxData4PreviewInForm($root_path);
$rcx_url   = $myts->makeTboxData4PreviewInForm($rcx_url);
$dbhost      = $myts->makeTboxData4PreviewInForm($dbhost);
$dbpass      = $myts->makeTboxData4PreviewInForm($dbpass);
$dbname      = $myts->makeTboxData4PreviewInForm($dbname);
$prefix      = $myts->makeTboxData4PreviewInForm($prefix);
$dbuname     = $myts->makeTboxData4PreviewInForm($dbuname);
$database    = $myts->makeTboxData4PreviewInForm($database);
$db_pconnect = intval($db_pconnect);
include_once("../class/rcxformloader.php");
include_once("./include/dbform.php");
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function dbconfirm() {
global $_POST;
include_once("../class/module.textsanitizer.php");
$myts = new MyTextSanitizer;
$error = array();
if ( empty($_POST['dbhost']) ) {
	$error[] = sprintf(_INSTALL_DF_PLEASE_ENTER, "<b>"._INSTALL_DF_HOST."</b>");
}
if ( empty($_POST['dbname']) ) {
	$error[] = sprintf(_INSTALL_DF_PLEASE_ENTER, "<b>"._INSTALL_DF_DBNAME."</b>");
}
if ( empty($_POST['prefix']) ) {
	$error[] = sprintf(_INSTALL_DF_PLEASE_ENTER, "<b>"._INSTALL_DF_PREFIX."</b>");
}
if ( empty($_POST['root_path']) || @!is_dir($_POST['root_path']) ) {
	$error[] = sprintf(_INSTALL_DF_PLEASE_ENTER, "<b>"._INSTALL_DF_PATH."</b>");
}
if ( !preg_match("/^http[s]?:\/\/+.{6}/i", $_POST['rcx_url']) ) {
	$error[] = sprintf(_INSTALL_DF_PLEASE_ENTER, "<b>"._INSTALL_DF_URL."</b>");
}
echo "<form action='./install.php' method='post'><table align='center'>";

if (!empty($error)) {
	echo "<tr><td><h4>"._INSTALL_DF_ERRORS."</h4></td></tr>";
	foreach ($error as $err) {
		echo "<tr><td><span style='color:#ff0000;'>".$err."</span></td></tr>";
	}

	$msg    = "&nbsp;";
	$op     = "dbform";
	$submit = _GOBACK;

	} else {
		if (@!is_dir($_POST['root_path'])) {
			$msg    = _INSTALL_DF_BADROOT;
			$op     = "dbform";
			$submit = _GOBACK;

			} elseif(!test_db()) {
				$msg    = _INSTALL_DF_BADDB;
				$op     = "dbform";
				$submit = _GOBACK;

				} else {
					$msg    = _INSTALL_DF_OK;
					$op     = "writemainfile";
					$submit = _NEXT;
				}
		}

echo "
<tr><td><h5>".$msg."</h5></td></tr>
<tr><td>
<input type='hidden' name='op' value='$op'>
<center><input type='submit' class='button' name='submit' value='".$submit."'>
</center><br></td></tr>
</table><input type='hidden' name='database' value='".$myts->makeTboxData4PreviewInForm($_POST['database'])."' />
<input type='hidden' name='dbhost' value='".$myts->makeTboxData4PreviewInForm($_POST['dbhost'])."' />
<input type='hidden' name='dbuname' value='".$myts->makeTboxData4PreviewInForm($_POST['dbuname'])."' />
<input type='hidden' name='dbpass' value='".$myts->makeTboxData4PreviewInForm($_POST['dbpass'])."' />
<input type='hidden' name='dbname' value='".$myts->makeTboxData4PreviewInForm($_POST['dbname'])."' />
<input type='hidden' name='prefix' value='".$myts->makeTboxData4PreviewInForm($_POST['prefix'])."' />
<input type='hidden' name='db_pconnect' value='".intval($_POST['db_pconnect'])."' />
<input type='hidden' name='root_path' value='".$myts->makeTboxData4PreviewInForm($_POST['root_path'])."' />
<input type='hidden' name='rcx_url' value='".$myts->makeTboxData4PreviewInForm($_POST['rcx_url'])."' />
</form>";
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function test_db() {
global $_POST;
if ( !empty($_POST['prefix']) && !empty($_POST['dbname']) ) {
	include_once(RCX_ROOT_PATH . "/class/database/".$_POST['database'].".php");
	$db = new Database();
	$db->setPrefix($_POST['prefix']);

	$db->connect($_POST['dbhost'], $_POST['dbuname'], $_POST['dbpass']);
	if (!$db->select_db($_POST['dbname'])) {
		return $db->query("CREATE DATABASE ".$_POST['dbname']."");
	}
	return true;
	}
}
//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function write_mainfile() {
global $_POST, $_COOKIE;
include_once("../class/module.textsanitizer.php");
$myts = new MyTextSanitizer();
$base_url = $_POST['rcx_url'];
$base_url = str_replace('\\', '/', $base_url);
if ( substr($base_url, -1) == '/') {
	$base_url = substr($base_url, 0, -1);
}
$base_path = $_POST['root_path'];
$base_path = str_replace('\\', '/', $base_path);
if ( substr($base_path, -1) == '/') {
	$base_path = substr($base_path, 0, -1);
}
$language = !empty($_COOKIE['lang']) ? $_COOKIE['lang'] : 'russian';
$content = '<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !defined(\'RCX_MAINFILE_INCLUDED\') ) {
	define(\'RCX_MAINFILE_INCLUDED\', 1);
	define(\'RCX_ROOT_PATH\', \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($base_path)).'\');
	define(\'RCX_URL\', \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($base_url)).'\');
	$rcxConfig[\'database\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['database'])).'\';
	$rcxConfig[\'prefix\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['prefix'])).'\';
	$rcxConfig[\'dbhost\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['dbhost'])).'\';
	$rcxConfig[\'dbuname\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['dbuname'])).'\';
	$rcxConfig[\'dbpass\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['dbpass'])).'\';
	$rcxConfig[\'dbname\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($_POST['dbname'])).'\';
	$rcxConfig[\'db_pconnect\'] = '.intval($_POST['db_pconnect']).';
	$rcxConfig[\'default_language\'] = \''.$myts->oopsHtmlSpecialChars($myts->oopsAddSlashesGPC($language)).'\';
	include_once(RCX_ROOT_PATH.\'/include/common.php\');
}
?>';
if ( !$file = fopen('../mainfile.php', 'w') ) {
	echo _INSTALL_MF_FAILOPEN;
	install_footer();
	exit();
	}
if ( fwrite($file, $content) == -1 ) {
	echo _INSTALL_MF_FAILWRITE;
	fclose($file);
	install_footer();
	exit();
	}
echo "
<form action='./install.php' method='post'>
<input type='hidden' name='op' value='adminsetup'>
<div align='center'>
<h3>"._INSTALL_MF_WRITEOK."</h3><br /><br />
<input type='submit' class='button' name='submit' value='"._NEXT."'>
</div>
</form>";

}
/**
* Description
*
* @param type $var description
* @return type description
*/
function adminsetup() {
global $_POST;
include_once("../class/module.textsanitizer.php");
$myts = new MyTextSanitizer();
?>
<div align='center'>
<h3><?php echo _INSTALL_AD_MSG;?></h3>
</div>
<br />
<form action="./install.php" method="post">
<table align="center"><tr>
<td><?php echo _INSTALL_AD_UNAME;?></td>
<td><input type="text" class="text" name="uname" value="<?php echo $myts->makeTboxData4PreviewInForm($_POST['uname']);?>"></td>
</tr><tr>
<td><?php echo _INSTALL_AD_EMAIL;?></td>
<td><input type="text" class="text" name="email" value="<?php echo $myts->makeTboxData4PreviewInForm($_POST['email']);?>"></td>
</tr><tr>
<td><?php echo _INSTALL_AD_PASS;?></td>
<td><input type="text" class="text" name="password" value="<?php echo $myts->makeTboxData4PreviewInForm($_POST['password']);?>"></td>
</tr><tr>
<td colspan="2" align="center"><br /><br />
<input type="submit" class="button" name="submit" value="<?php echo _NEXT;?>">
<input type="hidden" name="op" value="install_tables">
<td>
</tr></table>
</form>
<?php
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function admincheck() {
global $_POST, $rcxConfig;
if (!checkEmail($_POST['email'])) {
	$errors[] = _INSTALL_AD_BADEMAIL;
	}
if (strlen($_POST['password']) < $rcxConfig['minpass']) {
	$errors[] = sprintf(_INSTALL_AD_BADPASS, $rcxConfig['minpass']);
	}
if ( empty($_POST['uname']) || preg_match("/[^a-z0-9_-]/i", $_POST['uname']) ) {
	$errors[] = _INSTALL_AD_BADUNAME;
	}
if ( is_array($errors) ) {
	foreach ($errors as $val) {
		echo "<br /><b>$val</b>";
		}
	return false;
	}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function install_tables() {
global $_POST, $db, $myts, $rcxConfig;
include_once("../include/sql_parse.php");
$utf8 = "ALTER DATABASE `".$rcxConfig['dbname']."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
if (!$db->query($utf8)) {
	echo "Failed to set utf-8 charset and collation";
}
$sql_file = $rcxConfig['database'].'.sql';
$sql = join('', file('./sql/'.$sql_file));
$sql = remove_remarks($sql);
$sql = split_sql_file($sql, ';');
foreach ($sql as $value) {
	if ( $result = prefixQuery($value, $db->prefix) ) {
		if (!$db->query($result[0])) {
			uninstall_tables();
			return false;
			}
		}
}
$regdate  = time();

$uname    = $myts->makeTboxData4Save($_POST['uname']);
$email    = $myts->makeTboxData4Save($_POST['email']);
$password = md5($myts->makeTboxData4Save($_POST['password']));

$actkey   = substr(md5(makepass()), 0, 8);
$language = !empty($_COOKIE['lang']) ? $_COOKIE['lang'] : 'russian';

$sql1 = "ALTER TABLE ".$db->prefix("users")." MODIFY language varchar(32) NOT NULL DEFAULT '".$language."'";
if (!$db->query($sql1)) {
	echo "The system could not rewrite the table user, please edit the fields language with your data base editor favorite and give your default language.";
}
$sql = "
UPDATE ".$db->prefix("users")." SET
uname='".$uname."',
email='".$email."',
url='".RCX_URL."/',
user_regdate='".$regdate."',
pass='".$password."',
actkey='".$actkey."',
theme='".$rcxConfig['default_theme']."',
last_login=".$regdate.",
language='".$language."' 
 WHERE uid=1";
if (!$db->query($sql)) {
	echo "Failed to create admin account, please login with the default values: Admin/admin";
}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function uninstall_tables() {
global $db;
$tables = file("./cfg/table_list.txt");
$size   = count($tables);
for ($i=0; $i<$size; $i++) {
	$table = trim($tables[$i]);
	if (!empty($table)) {
		$db->query("DROP TABLE IF EXISTS ".$db->prefix($table)."");
		}
	}
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function do_chmod($file, $value, $type='chmod') {
switch ($type) {
	case 'ftp':
		break;
	default:
		@chmod($file, $value);
}
if ($value == 0666 || $value == 0777) {
	if ( !is_writable($file) ) {
		return false;
	}
}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function checkchmod() {

	$errorcount = 0;
	$errors = "<form action='install.php' method='post'>";
	$errors .= "<table><tr><td>"._MI_DOCHMOD_COMPLETE."
	<input type='hidden' name='op' value='dochmodagain' />
	<input type='submit' class='button' value='"._NEXT."' />
	</td></tr>";
	
	// Open, read, and close file.
		$fp = fopen("./cfg/chmodlist.txt", "r");
		$ftp_data = file("./cfg/chmodlist.txt");
	
	// Begin for loop.
	    for ($n=0; $n<count($ftp_data); $n++) {
		// Read each line and split into path and chmod value.
		$chmod_line = explode(" ", $ftp_data[$n]);
		// Correct 'extra space' error.
		$chmod_line[1] = eregi_replace("[[:space:]]", "", $chmod_line[1]);
		
		// Assign variables (for clarity sake).
		$path_value = RCX_ROOT_PATH."/"; 
		$path_value .= $chmod_line[0];
		$chmod_value = $chmod_line[1];
		$write = is_writable($path_value);
		$read = is_readable($path_value);
		$exist = file_exists($path_value);
		
		if ($exist) {
			switch ($chmod_value) {
				case '644':
					if ($write == false && $read == true) { 
					} else { 
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value </span></td></tr>";
						$errorcount++;
					}
				break;
				
				case '755':
					if ($write == false && $read == true) { 
					} else {
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value </span></td></tr>";
						$errorcount++;
					}
				break;
				
				case '666':
					if ($write == true && $read == true) { 
					} else {
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value </span></td></tr>";
						$errorcount++;
					}
				break;
				
				case '777':
					if ($write == true && $read == true) { 
					} else {
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value </span></td></tr>";
						$errorcount++;
					}
				break;
				
				case '444':
					if ($write == false && $read == true) {
					} else { 
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value $chmod_value </span></td></tr>";
						$errorcount++;
					}
				break;
			}
		} else {
						$errors .= "<tr><td><span style='color:#ff0000;'>$path_value "._FILEMISSINGUPLOADTHISAGAIN." </span></td></tr>";
						$errorcount++;
		}
		
}
	// End for loop.
	$errors .= "</table></form>";
	if ($errorcount > 0) {return $errors;} else { return true;}
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function finish() {
global $_POST;

$chmoddone = checkchmod();
$iswindows = strtoupper(PHP_OS);

	if (is_bool($chmoddone) or ($iswindows == "WINDOWS" or $iswindows == "CYGWIN" or $iswindows == "WINNT" or $iswindows == "WIN32")) {
	
		echo "<table class='infa' width='75%' align='center'><tr><td>";
		echo "<br /><br />"._MI_DOCHMOD_OKTITLE."<br />";
		echo _MI_DOCHMOD_OKDESCRIPTION."<br />";
		echo _INSTALL_F_CONGRAT."<br /><br />";
		echo "<a href='".RCX_URL."'>".RCX_URL."</a><br /><br />";
		echo "</td></tr></table>";
	
	} else {
	
		$extensions = get_loaded_extensions();
		if (in_array("ftp", $extensions)) {
		?>
		<table width="75%" align="center"><tr>
		<td colspan="2">
		<div align='center'>
		<div><?php echo _MI_DOCHMOD_TEXT ?></div><br>
		<form action="ftp.php" method="POST">
		<p><?php echo _MI_DOCHMOD_FTPDOMAIN ?><br><input type="text" size="50" name="ftp_server" value="<?php echo $_POST['ftp_server']; ?>" class="text"></p>
		<p><?php echo _MI_DOCHMOD_FTPUSER ?><br><input type="text" size="20" name="ftp_user_name" value="<?php echo $_POST['ftp_user_name']; ?>" class="text"></p>
		<p><?php echo _MI_DOCHMOD_FTPPASS ?><br><input type="password" size="20" name="ftp_user_pass" value="<?php echo $_POST['ftp_user_pass']; ?>" class="text"></p>
		<p><input type="submit" name="login" value="<?php echo _MI_DOCHMOD_BUTTON ?>" class="button"></p></form>
		<p><?php echo "<br />"; ?></p>
		<p><?php echo _MI_DOCHMOD_MANUAL."<br /><br />"; ?></p>
		
		<p><?php echo $chmoddone ?></p>
		</td>
		
		</tr><tr><td colspan=2 ><span style="color:#ff0000;">
		<?php 
		} else {
		echo _MI_DOCHMOD_MANUAL."<br /><br />";
		echo $chmoddone;
		} 
		
		?>
		</div></span></td></tr>
		</table>
		<?php
		
	}
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function dochmod() {
global $_POST;
// Assign POST_VARS variables.
$ftp_server = $_POST['ftp_server'];
$ftp_user_name = $_POST['ftp_user_name'];
$ftp_user_pass = $_POST['ftp_user_pass'];

// Set up basic connection.
$conn_id = ftp_connect($ftp_server); 
// Login with username and password.
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);


// Check connection.
if ((!$conn_id) || (!$login_result)) { 
	echo _MI_DOCHMOD_TITLEERROR."<br />"; 
	echo _MI_DOCHMOD_CONNERROR1."<br />";
	echo $ftp_server."<br />";
	echo _MI_DOCHMOD_CONNERROR2.": ".$ftp_user_name."<br /><br />";
	echo "<form action='install.php' method='post'>
	<input type='hidden' name='op' value='dochmodagain' />
	<input type='hidden' name='ftp_server' value='".$_POST['ftp_server']."' />
	<input type='hidden' name=ftp_user_name' value='".$_POST['ftp_user_name']."' />
	<input type='hidden' name='ftp_user_pass' value='".$_POST['ftp_user_pass']."' />
	<input type='hidden' name='ftp_html_path' value='".$_POST['ftp_html_path']."' />
	<input type='submit' class='button' value='"._GOBACK."' />
	</form><br />
	";	

} else { 
	ftp_pasv($conn_id,true);
	$dircontent = ftp_rawlist($conn_id, ".");

	// Open, read, and close file.
	$fp = fopen("./cfg/chmodlist.txt", "r");
	$ftp_data = file("./cfg/chmodlist.txt");
	fclose($fp);

	// Begin for loop.
	for ($n=0; $n<count($ftp_data); $n++) {
		// Read each line and split into path and chmod value.
		$chmod_line = explode(" ", $ftp_data[$n]);

		// Correct 'extra space' error.
		$chmod_line[1] = eregi_replace("[[:space:]]", "", $chmod_line[1]);
		
		// Assign variables (for clarity sake).
		$path_value = $ftp_html_path; 
		$path_value .= $chmod_line[0];
		$chmod_value = $chmod_line[1];
		$chmod_cmd = "CHMOD $chmod_value $path_value";

		// Chmod each line of chmodlist.txt
		ftp_site($conn_id,$chmod_cmd);
	}
	// End for loop.
		
	echo _MI_DOCHMOD_OKTITLE."<br />";
	echo _MI_DOCHMOD_OKDESCRIPTION."<br />";
	echo _INSTALL_F_CONGRAT."<br /><br />";
	echo "<a href='".RCX_URL."'>".RCX_URL."</a><br /><br />";
	
	// Close the FTP connection.
	ftp_close($conn_id); 

}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
switch($_POST['op']) {
case "setupcheck":
	setcookie("lang", $_POST['lang'], time()+1800, "/");
	wiz_header();
	setup_check();
	wiz_footer();
	break;
case "dbform":
	wiz_header();
	dbdata();
	wiz_footer();
	break;
case "dbconfirm":
	wiz_header();
	dbconfirm();
	wiz_footer();
	break;
case "writemainfile":
	wiz_header();
	write_mainfile();
	wiz_footer();
	break;
case "adminsetup":
	include_once("../mainfile.php");
	wiz_header();
	adminsetup();
	wiz_footer();
	break;
case "install_tables":
	include_once("../mainfile.php");
	wiz_header();
	if ( !admincheck() ) {
		adminsetup();
		} elseif (!install_tables()) {
			echo "<br /><div align='center'><h3>"._INSTALL_DB_DBERROR."</h3>";
			printf(_INSTALL_DB_TRYAGAIN, "install.php");
			echo "</div><br /><br />";
			} else {
				finish();
			}
	wiz_footer();
	break;
		
case "dochmod":
	include_once("../mainfile.php");
	wiz_header();
	dochmod();
	wiz_footer();
	break;
	
case "dochmodagain":
	include_once("../mainfile.php");
	wiz_header();
	finish();
	wiz_footer();
	break;
default:
	wiz_header();
	welcome();
	wiz_footer();
	break;
}
ob_end_flush();
?>
