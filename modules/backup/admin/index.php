<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include ('admin_header.php');

function Choice() {
    global $rcxModule;
        rcx_cp_header();

        OpenTable();

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
  <tr>
    <td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _DB_BACKUP_NAME;?></div><br />
	
	<br />
	<div class="kpicon"><table id="table1"><tr><td>
		<a href="index.php?op=Config"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _DB_CONFIG;?>">
	<br /><?php echo _DB_CONFIG;?></a>
	<a href="backup.php"><img src="<?php echo RCX_URL;?>/images/system/backup.png" alt="<?php echo _DB_BACKUP_BNAME1;?>"/>	
	<br /><?php echo _DB_BACKUP_BNAME1;?></a>
	<a href="index.php?op=optimise"><img src="<?php echo RCX_URL;?>/images/system/systemtest.png" alt="<?php echo _MA_MYSQLTOOLS_OP1;?>"/>
	<br /><?php echo _MA_MYSQLTOOLS_OP1;?></a>
		<br /><br /><br /><br /></td></tr></table>

<?php
        CloseTable();
        rcx_cp_footer();
}

function Config() {

    rcx_cp_header();

    OpenTable();
    include("../cache/config.php");
    echo "<form name='frmconfig' action='index.php?op=SaveConfig' method='post'>";
    
    if($cfgBackupTarget=='download') $cfgBackupTarget2="selected='selected'";
    if($cfgBackupTarget=='email') $cfgBackupTarget1="selected='selected'";
    if($cfgBackupTarget=='cache') $cfgBackupTarget0="selected='selected'";

    if($cfgZipType=='gzip') $cfgZipType3="selected='selected'";
    if($cfgZipType=='bzip') $cfgZipType2="selected='selected'";
    if($cfgZipType=='zip') $cfgZipType1="selected='selected'";
    if($cfgZipType=='sql') $cfgZipType0="selected='selected'";

    if($drop==1) $drop1="selected='selected'";
    else $drop0="selected='selected'";

    if($use_backquotes==1) $use_backquotes1="selected='selected'";
    else $use_backquotes0="selected='selected'";
    
    echo _DB_TARGET.": <select name='cfgBackupTarget'><option value='download' ".$cfgBackupTarget2.">Download</option><option value='email' ".$cfgBackupTarget1.">E-Mail</option><option value='cache' ".$cfgBackupTarget0.">Cache</option></select><br />";
    echo _DB_ALLOWDROP.": <select name='drop'><option value='true' ".$drop1.">"._DB_YES."</option><option value='false' ".$drop0.">"._DB_NO."</option></select><br />";
    echo _DB_ZIPTYPE.": <select name='cfgZipType'><option value='gzip' ".$cfgZipType3.">gzip</option><option value='bzip' ".$cfgZipType2.">bzip</option><option value='zip' ".$cfgZipType1.">zip</option><option value='sql' ".$cfgZipType0.">sql</option></select><br />";
    echo _DB_EXECTIMELIMIT.": <input type='text' value='$cfgExecTimeLimit' name='cfgExecTimeLimit' /><br />";
    echo _DB_ALLOWBACKQUOTES.": <select name='use_backquotes'><option value='true' ".$use_backquotes1.">"._DB_YES."</option><option value='false' ".$use_backquotes0.">"._DB_NO."</option></select><br />";
    echo "<input type='submit' name='submit' value='"._DB_SAVE."' /></form";
    
    CloseTable();
    rcx_cp_footer();
}

function SaveConfig($cfgBackupTarget, $drop, $cfgZipType, $cfgExecTimeLimit, $use_backquotes) {
    global $db;
    
    $fp=fopen("../cache/config.php","w");
    fwrite($fp,'<?php
$cfgBackupTarget=\''.$cfgBackupTarget.'\';
$drop='.$drop.';
$cfgZipType=\''.$cfgZipType.'\';
$cfgExecTimeLimit='.$cfgExecTimeLimit.';
$use_backquotes='.$use_backquotes.';
?>');
    fclose($fp);
    redirect_header("index.php",1,_DB_MODIFSAVE);
}

function optimise() {
global $db, $rcxConfig, $rcxModule;
rcx_cp_header();
OpenTable();
    echo "<center><font class=\"title\">"._MA_MYSQLTOOLS_HEADER."<B> ".$rcxConfig['dbname']."</b></font></center><br><br>"
        ."<table border=1 align=\"center\"><tr><td><div align=center>"._MA_MYSQLTOOLS_TABLE."</div></td><td><div align=center>"._MA_MYSQLTOOLS_GR."</div></td><td><div align=center>"._MA_MYSQLTOOLS_STATUS."</div></td><td><div align=center>"._MA_MYSQLTOOLS_RESULT."</div></td></tr>";
    $db1_clean = $rcxConfig['dbname'];
    $tot_data = 0;
    $tot_idx = 0;
    $tot_all = 0;
    $local_query = 'SHOW TABLE STATUS FROM '.$rcxConfig['dbname'];
    $result = @mysql_query($local_query);
    if (@mysql_num_rows($result)) {
        while ($row = mysql_fetch_array($result)) {
                $tot_data = $row['Data_length'];
            $tot_idx  = $row['Index_length'];
            $total = $tot_data + $tot_idx;
            $total = $total / 1024 ;
            $total = round ($total,3);
            $gain= $row['Data_free'];
            $gain = $gain / 1024 ;
            $total_gain += $gain;
            $gain = round ($gain,3);
            $local_query = 'OPTIMIZE TABLE '.$row[0];
            $resultat  = mysql_query($local_query);
                   if ($gain == 0) {
                       echo "<tr><td>"."$row[0]"."</td>"."<td>"."$total"." Kb"."</td>"."<td>"._MA_MYSQLTOOLS_NOOPTI."</td><td>0 Kb</td></tr>";
                   } else {
                          echo "<tr><td><b>"."$row[0]"."</b></td>"."<td><b>"."$total"." Kb"."</b></td>"."<td><b>"._MA_MYSQLTOOLS_OPTI."</b></td><td><b>"."$gain"." Kb</b></td></tr>";
                   }
        }
    }
    echo "</table>";
    echo "</center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    $total_gain = round ($total_gain,3);
    echo "<center><b>"._MA_MYSQLTOOLS_RESULT1."</b><br><br>"._MA_MYSQLTOOLS_RESULT2.""."$total_gain"." Kb<br>";

    $sql_query = "CREATE TABLE IF NOT EXISTS optimise_gain(gain decimal(10,3))";
    $result = @mysql_query($sql_query);

    $sql_query = "INSERT INTO optimise_gain (gain) VALUES ('$total_gain')";
    $result = @mysql_query($sql_query);

    $sql_query = "SELECT * FROM optimise_gain";
    $result = @mysql_query($sql_query);
    while ($row = mysql_fetch_row($result)) {
        $histo += $row[0];
        $cpt += 1;
    }
    echo "" ._MA_MYSQLTOOLS_ROUND.""."$cpt". ""._MA_MYSQLTOOLS_TIME."<br>";
    echo ""."$histo".""._MA_MYSQLTOOLS_RESULTTOTAL."<br><br>";
    echo "" ._MA_MYSQLTOOLS_MENU."</center>";

    CloseTable();
rcx_cp_footer();
}

switch($op) {
    case "Config":
        Config();
        break;
    case "SaveConfig":
        SaveConfig($_POST["cfgBackupTarget"],$_POST["drop"],$_POST["cfgZipType"], $cfgExecTimeLimit,$_POST["use_backquotes"]);
        break;
    case "optimise":
        optimise();
        break;
    default:
        Choice();
        break;
}
?>
